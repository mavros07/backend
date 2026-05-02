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
            if (request()->hasSession()) {
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
