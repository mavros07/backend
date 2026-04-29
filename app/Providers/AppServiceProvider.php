<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\User;
use App\Services\CurrencyRateService;
use App\Support\CurrencyCatalog;
use App\Support\SiteSettingDefaults;
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
        Password::defaults(function () {
            return Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        $fromDb = [];
        try {
            if (Schema::hasTable('site_settings')) {
                $fromDb = SiteSetting::allKeyed();
            }
        } catch (\Throwable) {
            $fromDb = [];
        }

        $site = SiteSettingDefaults::mergeWithDatabase($fromDb);
        View::share('site', $site);

        $defaultCurrency = strtoupper(trim((string) ($site['currency_code'] ?? 'USD')));
        if (! array_key_exists($defaultCurrency, CurrencyCatalog::supported())) {
            $defaultCurrency = 'USD';
        }
        $selectedCurrency = $defaultCurrency;
        $promptDismissed = false;
        try {
            if (! app()->runningInConsole() && request()->hasSession()) {
                $sessionCurrency = strtoupper((string) request()->session()->get('site_currency', $defaultCurrency));
                if (array_key_exists($sessionCurrency, CurrencyCatalog::supported())) {
                    $selectedCurrency = $sessionCurrency;
                }
                $promptDismissed = (bool) request()->session()->get('currency_selection_prompt_dismissed', false);

                /** @var User|null $authUser */
                $authUser = request()->user();
                if ($authUser) {
                    $userCurrency = strtoupper((string) ($authUser->preferred_currency ?? ''));
                    if (array_key_exists($userCurrency, CurrencyCatalog::supported())) {
                        $selectedCurrency = $userCurrency;
                        request()->session()->put('site_currency', $userCurrency);
                    }
                    $promptDismissed = (bool) $authUser->currency_selection_prompt_dismissed;
                }
            }
        } catch (\Throwable) {
            $selectedCurrency = $defaultCurrency;
        }

        $rates = [$defaultCurrency => 1.0];
        try {
            $rates = app(CurrencyRateService::class)->ratesFrom($defaultCurrency);
        } catch (\Throwable) {
            $rates = [$defaultCurrency => 1.0];
        }

        View::share('currencyUi', [
            'default' => $defaultCurrency,
            'selected' => $selectedCurrency,
            'supported' => CurrencyCatalog::supported(),
            'symbols' => CurrencyCatalog::symbols(),
            'rates' => $rates,
            'promptDismissed' => $promptDismissed,
        ]);
    }
}
