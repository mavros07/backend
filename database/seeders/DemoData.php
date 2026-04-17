<?php

namespace Database\Seeders;

final class DemoData
{
    public const ADMIN_EMAIL = 'admin@example.com';
    public const USER_EMAIL = 'demo@example.com';
    public const DEFAULT_PASSWORD = 'password';

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
                'title' => '2016 Mercedes-Benz C-Class C300 4MATIC',
                'year' => 2016,
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'price' => 35000,
                'mileage' => 100,
                'fuel_type' => 'Hybrid',
                'transmission' => 'Automatic',
                'drive' => '4WD',
                'body_type' => 'Sedan',
                'condition' => 'used',
                'engine_size' => '2.0L I4 turbo',
                'location' => 'West Covina, CA',
                'features' => ['Leather seats', 'Sunroof', 'Navigation'],
                'exterior_color' => 'Jet Red',
                'interior_color' => 'Deep Red',
                'images' => [
                    'assets/images/wp-uploads/sites/24/2021/05/motor-1-795x463-1.jpg',
                    'assets/images/wp-uploads/sites/24/2021/05/3_-1109x699-1.jpg',
                    'assets/images/wp-uploads/sites/24/2021/05/4-1109x699-1.jpg',
                    'assets/images/wp-uploads/sites/24/2021/05/5-1109x699-1.jpg',
                    'assets/images/wp-uploads/sites/24/2021/05/6-1109x699-1.jpg',
                    'assets/images/wp-uploads/sites/24/2021/05/7-1109x699-1.jpg',
                ],
            ],
            [
                'title' => '2019 Nissan Altima 2.5 SV',
                'year' => 2019,
                'make' => 'Nissan',
                'model' => 'Altima',
                'price' => 25000,
                'mileage' => 18000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'drive' => 'AWD',
                'body_type' => 'Sedan',
                'condition' => 'used',
                'engine_size' => '2.5L I4',
                'location' => 'Los Angeles, CA',
                'features' => ['Backup camera', 'Apple CarPlay'],
                'exterior_color' => 'Jet Black',
                'interior_color' => 'Rich Black',
                'images' => [
                    'assets/images/wp-uploads/sites/24/2022/09/nissan_altima_1-300x189-1.jpg',
                    'assets/images/wp-uploads/sites/24/2022/09/nissan_altima_1-300x189-1-150x150.jpeg',
                ],
            ],
            [
                'title' => '2021 Tesla Roadster',
                'year' => 2021,
                'make' => 'Tesla',
                'model' => 'Roadster',
                'price' => 121000,
                'mileage' => 130,
                'fuel_type' => 'Electric',
                'transmission' => 'Automatic',
                'drive' => 'AWD',
                'body_type' => 'Roadster',
                'condition' => 'new',
                'engine_size' => 'Electric',
                'location' => 'San Francisco, CA',
                'features' => ['Performance package', 'Glass roof'],
                'exterior_color' => 'Orange Metallic',
                'interior_color' => 'Grey',
                'images' => [
                    'assets/images/wp-uploads/sites/24/2022/10/post_id_2027_ME54t-1917x644-1.jpg',
                    'assets/images/wp-uploads/sites/24/2022/10/post_id_2027_srDqt-999x719-1.jpg',
                ],
            ],
        ];
    }
}
