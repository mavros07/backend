<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoUsers = DemoData::users();
        $owner = User::query()->firstOrCreate(
            ['email' => DemoData::USER_EMAIL],
            [
                'name' => $demoUsers['user']['name'],
                'password' => Hash::make(DemoData::DEFAULT_PASSWORD),
                'email_verified_at' => now(),
            ]
        );
        $approver = User::query()->firstOrCreate(
            ['email' => DemoData::ADMIN_EMAIL],
            [
                'name' => $demoUsers['admin']['name'],
                'password' => Hash::make(DemoData::DEFAULT_PASSWORD),
                'email_verified_at' => now(),
            ]
        );

        if (! $owner->hasRole('user')) {
            $owner->assignRole('user');
        }
        if (! $approver->hasRole('admin')) {
            $approver->assignRole('admin');
        }

        $seedVehicles = DemoData::vehicles();

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
                    'description' => $v['description'] ?? 'Seed vehicle for UI placeholder. Replace with real content later.',
                    'submitted_at' => now(),
                    'approved_at' => now(),
                    'approved_by' => $approver->id,
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
