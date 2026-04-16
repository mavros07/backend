<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::query()->where('email', 'test@example.com')->first();

        if (!$owner) {
            return;
        }

        $seedVehicles = [
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

        foreach ($seedVehicles as $v) {
            $slug = Str::slug($v['title']);

            $vehicle = Vehicle::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $owner->id,
                    'title' => $v['title'],
                    'slug' => $slug,
                    'status' => 'approved',
                    'year' => $v['year'],
                    'make' => $v['make'],
                    'model' => $v['model'],
                    'price' => $v['price'],
                    'mileage' => $v['mileage'],
                    'fuel_type' => $v['fuel_type'],
                    'transmission' => $v['transmission'],
                    'drive' => $v['drive'],
                    'body_type' => $v['body_type'],
                    'condition' => $v['condition'] ?? null,
                    'engine_size' => $v['engine_size'] ?? null,
                    'location' => $v['location'] ?? null,
                    'features' => $v['features'] ?? null,
                    'exterior_color' => $v['exterior_color'],
                    'interior_color' => $v['interior_color'],
                    'description' => 'Seed vehicle for UI placeholder. Replace with real content later.',
                    'submitted_at' => now(),
                    'approved_at' => now(),
                    'approved_by' => $owner->id,
                ]
            );

            VehicleImage::query()->where('vehicle_id', $vehicle->id)->delete();
            foreach ($v['images'] as $idx => $path) {
                VehicleImage::query()->create([
                    'vehicle_id' => $vehicle->id,
                    'path' => $path,
                    'sort_order' => $idx,
                ]);
            }
        }
    }
}
