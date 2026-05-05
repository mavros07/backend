<?php

namespace App\View\Composers;

use App\Models\User;
use App\Services\CurrencyRateService;
use App\Support\CurrencyCatalog;
use Illuminate\View\View;

/**
 * Binds currency UI after the session is started (unlike View::share in AppServiceProvider::boot).
 */
class SiteCurrencyComposer
{
    public function compose(View $view): void
    {
        $site = is_array($view->offsetGet('site') ?? null) ? $view->offsetGet('site') : [];

        $defaultCurrency = strtoupper(trim((string) ($site['currency_code'] ?? 'USD')));
        if (! array_key_exists($defaultCurrency, CurrencyCatalog::supported())) {
            $defaultCurrency = 'USD';
        }

        $selectedCurrency = $defaultCurrency;
        $promptDismissed = false;

        try {
            $cookieRaw = request()->cookie('site_currency_pref');
            $cookieCurrency = strtoupper(trim((string) ($cookieRaw ?? '')));
            if ($cookieCurrency !== '' && ! array_key_exists($cookieCurrency, CurrencyCatalog::supported())) {
                $cookieCurrency = '';
            }

            /** @var User|null $authUser */
            $authUser = request()->user();
            $userCurrency = $authUser ? strtoupper(trim((string) ($authUser->preferred_currency ?? ''))) : '';
            if ($userCurrency !== '' && ! array_key_exists($userCurrency, CurrencyCatalog::supported())) {
                $userCurrency = '';
            }

            if (request()->hasSession()) {
                $promptDismissed = (bool) request()->session()->get('currency_selection_prompt_dismissed', false);
            }

            if ($authUser) {
                $promptDismissed = (bool) $authUser->currency_selection_prompt_dismissed;
            }

            // Logged-in users: DB preference wins when set; otherwise session, then cookie.
            if ($userCurrency !== '') {
                $selectedCurrency = $userCurrency;
                if (request()->hasSession()) {
                    request()->session()->put('site_currency', $userCurrency);
                }
            } elseif (request()->hasSession()) {
                if (request()->session()->has('site_currency')) {
                    $sessionCurrency = strtoupper(trim((string) request()->session()->get('site_currency')));
                    if ($sessionCurrency !== '' && array_key_exists($sessionCurrency, CurrencyCatalog::supported())) {
                        $selectedCurrency = $sessionCurrency;
                    }
                } elseif ($cookieCurrency !== '') {
                    $selectedCurrency = $cookieCurrency;
                    request()->session()->put('site_currency', $cookieCurrency);
                }
            } elseif ($cookieCurrency !== '') {
                $selectedCurrency = $cookieCurrency;
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

        $view->with('currencyUi', [
            'default' => $defaultCurrency,
            'selected' => $selectedCurrency,
            'supported' => CurrencyCatalog::supported(),
            'symbols' => CurrencyCatalog::symbols(),
            'rates' => $rates,
            'promptDismissed' => $promptDismissed,
        ]);
    }
}
