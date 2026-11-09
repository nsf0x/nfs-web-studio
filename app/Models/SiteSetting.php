<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    public $timestamps = false;

    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    /**
     * Get a setting value by key (cached).
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return static::all()->pluck('setting_value', 'setting_key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value and clear cache.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrInsert(['setting_key' => $key], ['setting_value' => $value]);
        Cache::forget('site_settings');
    }

    /**
     * Get all settings as array (cached).
     */
    public static function allCached(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::all()->pluck('setting_value', 'setting_key')->toArray();
        });
    }
}
