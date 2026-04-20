<?php

namespace Database\Seeders;

/**
 * Demo listings: six vehicles aligned with the LUXEMOTIVE grid. Gallery images use short
 * `asset/images/...` paths under `public/` so they resolve via VehicleImageUrl
 * and never depend on external CDNs. Keep `vehicle_images.path` as TEXT (see migrations).
 */
final class DemoData
{
    public const ADMIN_EMAIL = 'admin@example.com';

    public const USER_EMAIL = 'demo@example.com';

    public const DEFAULT_PASSWORD = 'password';

    /** Rotating pool of JPGs shipped with the app (`public/asset/images/media/demo/`). */
    public static function localDemoPool(): array
    {
        return [
            'asset/images/media/demo/01-6-1-1.jpg',
            'asset/images/media/demo/01-7-1-1.jpg',
            'asset/images/media/demo/01-10-1.jpg',
            'asset/images/media/demo/01-24-1.jpg',
        ];
    }

    /**
     * Six gallery paths per listing: rotate through {@see localDemoPool()} starting from vehicle index.
     *
     * @param  int  $oneBasedVehicleIndex  Same as previous `cdnGallery(1..6)` usage
     * @return list<string>
     */
    public static function localGallery(int $oneBasedVehicleIndex): array
    {
        $pool = self::localDemoPool();
        $n = count($pool);
        $start = ($oneBasedVehicleIndex - 1) % $n;
        $out = [];
        for ($i = 0; $i < 6; $i++) {
            $out[] = $pool[($start + $i) % $n];
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
                'description' => 'Demo listing: BMW M4 Competition — performance coupe with M carbon accents and adaptive M suspension. Six demo photos per vehicle.',
                'images' => self::localGallery(1),
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
                'description' => 'Demo listing: Audi RS6 Avant — quattro sport differential and dynamic ride control.',
                'images' => self::localGallery(2),
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
                'description' => 'Demo listing: Porsche 911 GT3 — track-focused setup.',
                'images' => self::localGallery(3),
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
                'description' => 'Demo listing: Lexus RX 350 AWD — low mileage luxury SUV.',
                'images' => self::localGallery(4),
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
                'images' => self::localGallery(5),
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
                'description' => 'Demo listing: Lamborghini Urus — high-performance SUV.',
                'images' => self::localGallery(6),
            ],
        ];
    }
}
