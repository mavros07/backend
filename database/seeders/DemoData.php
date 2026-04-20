<?php

namespace Database\Seeders;

/**
 * Demo listings: six vehicles aligned with the LUXEMOTIVE grid. Gallery images use absolute
 * https://lh3.googleusercontent.com/... URLs from the design reference so they load without
 * stored as full URLs (see `vehicle_images.path` TEXT migration). Keep `database/migrations/*_change_vehicle_images_path_to_text`
 * applied — URLs exceed varchar(255).
 */
final class DemoData
{
    public const ADMIN_EMAIL = 'admin@example.com';

    public const USER_EMAIL = 'demo@example.com';

    public const DEFAULT_PASSWORD = 'password';

    /** Hero + six card images from the LUXEMOTIVE reference (same order as the HTML grid). */
    public static function luxemotiveCdnPool(): array
    {
        return [
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE',
        ];
    }

    /**
     * Six gallery URLs per listing: own card image first, then rotate through the pool.
     *
     * @return list<string>
     */
    public static function cdnGallery(int $primaryIndex): array
    {
        $pool = self::luxemotiveCdnPool();
        $n = count($pool);
        $primaryIndex = max(0, min($n - 1, $primaryIndex));
        $out = [];
        for ($i = 0; $i < 6; $i++) {
            $out[] = $pool[($primaryIndex + $i) % $n];
        }

        return $out;
    }

    /**
     * @return array<string, array{name: string, email: string, role: string}>
     */
    public static function users(): array
    {
        return [
            'admin' => [
                'name' => 'Demo Admin',
                'email' => self::ADMIN_EMAIL,
                'role' => 'admin',
            ],
            'user' => [
                'name' => 'Demo User',
                'email' => self::USER_EMAIL,
                'role' => 'user',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function vehicles(): array
    {
        return [
            [
                'title' => '2021 BMW M4 Competition',
                'year' => 2021,
                'make' => 'BMW',
                'model' => 'M4',
                'price' => 89900,
                'mileage' => 12500,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'RWD',
                'body_type' => 'Coupe',
                'condition' => 'used',
                'engine_size' => '3.0L I6 twin-turbo',
                'location' => 'Miami, FL',
                'features' => ['M Sport package', 'Carbon roof', 'Live Cockpit Professional', 'Harman Kardon', 'Head-up display'],
                'exterior_color' => 'Isle of Man Green',
                'interior_color' => 'Silverstone',
                'description' => 'Demo listing: BMW M4 Competition — performance coupe with M carbon accents and adaptive M suspension. Images: LUXEMOTIVE reference CDN set (six photos per vehicle).',
                'images' => self::cdnGallery(1),
            ],
            [
                'title' => '2022 Audi RS6 Avant',
                'year' => 2022,
                'make' => 'Audi',
                'model' => 'RS6 Avant',
                'price' => 112000,
                'mileage' => 5200,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'AWD',
                'body_type' => 'Wagon',
                'condition' => 'used',
                'engine_size' => '4.0L V8 twin-turbo',
                'location' => 'Austin, TX',
                'features' => ['RS sport exhaust', 'Matrix LED', 'Bang & Olufsen', 'Adaptive air suspension', 'Tour assist'],
                'exterior_color' => 'Nardo Grey',
                'interior_color' => 'Black',
                'description' => 'Demo listing: Audi RS6 Avant — quattro sport differential and dynamic ride control. Full gallery from the LUXEMOTIVE reference image set.',
                'images' => self::cdnGallery(2),
            ],
            [
                'title' => '2023 Porsche 911 GT3',
                'year' => 2023,
                'make' => 'Porsche',
                'model' => '911 GT3',
                'price' => 185500,
                'mileage' => 850,
                'fuel_type' => 'Petrol',
                'transmission' => 'PDK',
                'drive' => 'RWD',
                'body_type' => 'Coupe',
                'condition' => 'used',
                'engine_size' => '4.0L flat-6',
                'location' => 'Scottsdale, AZ',
                'features' => ['Clubsport package', 'PCCB', 'Front axle lift', 'LED-Matrix headlights', 'Track Precision app'],
                'exterior_color' => 'Shark Blue',
                'interior_color' => 'Black',
                'description' => 'Demo listing: Porsche 911 GT3 — track-focused setup. Six reference CDN images for gallery and detail pages.',
                'images' => self::cdnGallery(3),
            ],
            [
                'title' => '2023 Lexus RX 350',
                'year' => 2023,
                'make' => 'Lexus',
                'model' => 'RX 350',
                'price' => 62000,
                'mileage' => 2000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'AWD',
                'body_type' => 'SUV',
                'condition' => 'used',
                'engine_size' => '3.5L V6',
                'location' => 'Dallas, TX',
                'features' => ['Premium package', 'Panoramic roof', 'Mark Levinson', 'Hands-free liftgate', 'Safety System+ 3.0'],
                'exterior_color' => 'Atomic Silver',
                'interior_color' => 'Rioja Red',
                'description' => 'Demo listing: Lexus RX 350 AWD — low mileage luxury SUV. Gallery uses the same CDN pool as the homepage cards.',
                'images' => self::cdnGallery(4),
            ],
            [
                'title' => '2022 Lexus ES 350',
                'year' => 2022,
                'make' => 'Lexus',
                'model' => 'ES 350',
                'price' => 45900,
                'mileage' => 15000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'FWD',
                'body_type' => 'Sedan',
                'condition' => 'used',
                'engine_size' => '3.5L V6',
                'location' => 'San Diego, CA',
                'features' => ['Ultra Luxury', 'Adaptive variable suspension', 'Panoramic monitor', 'Heated/ventilated seats'],
                'exterior_color' => 'Obsidian',
                'interior_color' => 'Acorn',
                'description' => 'Demo listing: Lexus ES 350 — comfort-focused sedan. All metadata editable in dashboard or admin.',
                'images' => self::cdnGallery(5),
            ],
            [
                'title' => '2023 Lamborghini Urus',
                'year' => 2023,
                'make' => 'Lamborghini',
                'model' => 'Urus',
                'price' => 305000,
                'mileage' => 1200,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'AWD',
                'body_type' => 'SUV',
                'condition' => 'used',
                'engine_size' => '4.0L V8 twin-turbo',
                'location' => 'Los Angeles, CA',
                'features' => ['ANIMA drive modes', 'Carbon ceramic brakes', 'Bang & Olufsen 3D', 'Night vision', 'Rear-wheel steering'],
                'exterior_color' => 'Giallo Auge',
                'interior_color' => 'Nero Ade',
                'description' => 'Demo listing: Lamborghini Urus — high-performance SUV. Six gallery URLs from the LUXEMOTIVE reference.',
                'images' => self::cdnGallery(6),
            ],
        ];
    }
}
