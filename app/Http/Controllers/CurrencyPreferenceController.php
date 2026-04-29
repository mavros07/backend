<?php

namespace App\Http\Controllers;

use App\Support\CurrencyCatalog;
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

        return response()->json([
            'success' => true,
            'currency' => $currency,
        ]);
    }
}

