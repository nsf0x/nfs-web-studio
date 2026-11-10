<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class SupabaseStorage
{
    public function upload(UploadedFile $file, string $directory): string
    {
        if (! $this->hasSupabaseConfiguration()) {
            if (app()->environment('production')) {
                throw new RuntimeException(
                    'Logo upload needs SUPABASE_URL, SUPABASE_SERVICE_ROLE_KEY, and SUPABASE_STORAGE_BUCKET configured.'
                );
            }

            $path = $file->store($directory, 'public');

            if ($path === false) {
                throw new RuntimeException('Unable to store the uploaded image.');
            }

            return $path;
        }

        $config = $this->configuration();
        $extension = $file->guessExtension();

        if (! $extension) {
            throw new RuntimeException('Unable to determine the uploaded image type.');
        }

        $path = trim($directory, '/').'/'.Str::uuid().'.'.$extension;
        $content = file_get_contents($file->getRealPath());

        if ($content === false) {
            throw new RuntimeException('Unable to read the uploaded image.');
        }

        $this->request($config)
            ->withBody($content, $file->getMimeType() ?: 'application/octet-stream')
            ->withHeaders(['x-upsert' => 'true'])
            ->post($this->objectUrl($config, $path))
            ->throw();

        return $this->publicUrl($config, $path);
    }

    public function delete(string $url): void
    {
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            Storage::disk('public')->delete($url);

            return;
        }

        $config = $this->configuration(false);
        $path = $this->managedPath($url, $config);

        if ($path === null) {
            return;
        }

        $config = $this->configuration();
        $this->request($config)
            ->delete($config['url'].'/storage/v1/object/'.$this->encodePath($config['bucket']), [
                'prefixes' => [$path],
            ])
            ->throw();
    }

    public function manages(string $url): bool
    {
        if (! $this->hasSupabaseConfiguration(false)) {
            return false;
        }

        return $this->managedPath($url, $this->configuration(false)) !== null;
    }

    private function hasSupabaseConfiguration(bool $requireKey = true): bool
    {
        return (string) config('services.supabase.url') !== ''
            && (string) config('services.supabase.storage_bucket') !== ''
            && (! $requireKey || (string) config('services.supabase.service_role_key') !== '');
    }

    private function configuration(bool $requireKey = true): array
    {
        $url = rtrim((string) config('services.supabase.url'), '/');
        $key = (string) config('services.supabase.service_role_key');
        $bucket = trim((string) config('services.supabase.storage_bucket'));

        if ($url === '' || $bucket === '' || ($requireKey && $key === '')) {
            throw new RuntimeException(
                'Supabase Storage is not configured. Set SUPABASE_URL, SUPABASE_SERVICE_ROLE_KEY, and SUPABASE_STORAGE_BUCKET.'
            );
        }

        return compact('url', 'key', 'bucket');
    }

    private function request(array $config): PendingRequest
    {
        return Http::timeout(30)
            ->acceptJson()
            ->withToken($config['key'])
            ->withHeaders(['apikey' => $config['key']]);
    }

    private function objectUrl(array $config, string $path): string
    {
        return $config['url'].'/storage/v1/object/'.$this->encodePath($config['bucket'].'/'.$path);
    }

    private function publicUrl(array $config, string $path): string
    {
        return $config['url'].'/storage/v1/object/public/'.$this->encodePath($config['bucket'].'/'.$path);
    }

    private function managedPath(string $url, array $config): ?string
    {
        $baseHost = parse_url($config['url'], PHP_URL_HOST);
        $urlHost = parse_url($url, PHP_URL_HOST);
        $prefix = '/storage/v1/object/public/'.$config['bucket'].'/';
        $urlPath = parse_url($url, PHP_URL_PATH);

        if ($baseHost !== $urlHost || ! is_string($urlPath) || ! str_starts_with($urlPath, $prefix)) {
            return null;
        }

        return rawurldecode(substr($urlPath, strlen($prefix)));
    }

    private function encodePath(string $path): string
    {
        return implode('/', array_map('rawurlencode', explode('/', $path)));
    }
}
