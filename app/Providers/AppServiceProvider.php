<?php

namespace App\Providers;

use App\View\Composers\SiteSettingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->booted(static function (): void {
            View::composer('*', SiteSettingComposer::class);
        });
    }
}
