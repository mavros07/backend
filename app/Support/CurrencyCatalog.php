<?php

namespace App\Support;

final class CurrencyCatalog
{
    /**
     * @return array<string, string>
     */
    public static function supported(): array
    {
        return [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'NGN' => 'Nigerian Naira',
            'CAD' => 'Canadian Dollar',
            'AED' => 'UAE Dirham',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function symbols(): array
    {
        return [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'NGN' => '₦',
            'CAD' => 'C$',
            'AED' => 'AED ',
        ];
    }
}

