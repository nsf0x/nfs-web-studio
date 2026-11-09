<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminGuest;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->append(SecurityHeaders::class);

        // Named middleware aliases
        $middleware->alias([
            'admin'       => AdminAuthenticate::class,
            'admin.guest' => AdminGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->view('errors.404', [], 404);
        });
    })->create();

$app->register(ViewServiceProvider::class);

if (env('VERCEL')) {
    $storagePath = sys_get_temp_dir().'/nfs-web-studio/storage';

    foreach (['app/private', 'app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $directory) {
        $path = $storagePath.'/'.$directory;

        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException("Unable to create Laravel runtime directory: {$path}");
        }
    }

    $app->useStoragePath($storagePath);
}

return $app;
