<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\CurrencyRateService;
use App\Support\CurrencyCatalog;
use App\Support\SiteSettingDefaults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyPreferenceController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'currency' => ['required', 'string', 'size:3'],
            'markAsShown' => ['sometimes', 'boolean'],
        ]);

        $currency = strtoupper($data['currency']);
        if (! array_key_exists($currency, CurrencyCatalog::supported())) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported currency.',
            ], 422);
        }

        $request->session()->put('site_currency', $currency);
        if ($request->user()) {
            $request->user()->forceFill([
                'preferred_currency' => $currency,
                'currency_selection_prompt_dismissed' => (bool) ($data['markAsShown'] ?? false),
            ])->save();
        } elseif (($data['markAsShown'] ?? false) === true) {
            $request->session()->put('currency_selection_prompt_dismissed', true);
        }

        $site = SiteSettingDefaults::mergeWithDatabase(SiteSetting::allKeyed());
        $base = strtoupper(trim((string) ($site['currency_code'] ?? 'USD')));
        if (! array_key_exists($base, CurrencyCatalog::supported())) {
            $base = 'USD';
        }
        try {
            $rates = app(CurrencyRateService::class)->ratesFrom($base);
        } catch (\Throwable) {
            $rates = [$base => 1.0];
        }

        $currencyUi = [
            'default' => $base,
            'selected' => $currency,
            'supported' => CurrencyCatalog::supported(),
            'symbols' => CurrencyCatalog::symbols(),
            'rates' => $rates,
            'promptDismissed' => (bool) $request->session()->get('currency_selection_prompt_dismissed', false),
        ];

        return response()->json([
            'success' => true,
            'currency' => $currency,
            'currency_ui' => $currencyUi,
        ]);
    }
}

