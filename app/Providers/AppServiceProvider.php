<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // #region agent log
        $p = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'debug-c150e5.log';
        @file_put_contents($p, json_encode([
            'sessionId' => 'c150e5',
            'timestamp' => (int) round(microtime(true) * 1000),
            'hypothesisId' => 'H4',
            'location' => 'AppServiceProvider::boot',
            'message' => 'boot_enter',
            'data' => [],
        ], JSON_UNESCAPED_SLASHES)."\n", FILE_APPEND);
        // #endregion

        Password::defaults(function () {
            return Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        $site = [];
        try {
            if (Schema::hasTable('site_settings')) {
                $site = SiteSetting::allKeyed();
            }
        } catch (\Throwable) {
            $site = [];
        }

        View::share('site', $site);
    }
}
