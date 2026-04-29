<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class CurrencyRateService
{
    /**
     * @return array<string, float>
     */
    public function ratesFrom(string $baseCurrency): array
    {
        $base = strtoupper(trim($baseCurrency));
        if ($base === '') {
            $base = 'USD';
        }

        return Cache::remember('fx_rates_' . $base, now()->addHour(), function () use ($base): array {
            $fallback = [$base => 1.0];
            $response = Http::timeout(8)->get('https://open.er-api.com/v6/latest/' . $base);
            if (! $response->ok()) {
                return $fallback;
            }

            $json = $response->json();
            if (! is_array($json) || ! isset($json['rates']) || ! is_array($json['rates'])) {
                return $fallback;
            }

            $rates = [];
            foreach ($json['rates'] as $code => $rate) {
                if (! is_string($code) || (! is_numeric($rate))) {
                    continue;
                }
                $rates[strtoupper($code)] = (float) $rate;
            }
            if (! isset($rates[$base])) {
                $rates[$base] = 1.0;
            }

            return $rates;
        });
    }
}

