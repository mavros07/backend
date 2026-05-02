<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Support\ListingOptionCatalogSync;
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
            ListingOptionCatalogSync::ensureOptionValuesFromArray($v);
        }

        foreach ($seedVehicles as $v) {
            $slug = Str::slug($v['title']);
            $fk = ListingOptionCatalogSync::resolveLegacyRowToForeignKeys((object) $v);

            $vehicle = Vehicle::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $owner->id,
                    'title' => $v['title'],
                    'slug' => $slug,
                    'status' => 'approved',
                    'year' => $v['year'],
                    'make_listing_option_id' => $fk['make_listing_option_id'],
                    'model_listing_option_id' => $fk['model_listing_option_id'],
                    'condition_listing_option_id' => $fk['condition_listing_option_id'],
                    'body_type_listing_option_id' => $fk['body_type_listing_option_id'],
                    'transmission_listing_option_id' => $fk['transmission_listing_option_id'],
                    'fuel_type_listing_option_id' => $fk['fuel_type_listing_option_id'],
                    'drive_listing_option_id' => $fk['drive_listing_option_id'],
                    'country_listing_option_id' => $fk['country_listing_option_id'],
                    'price' => $v['price'],
                    'mileage' => $v['mileage'],
                    'engine_size' => $v['engine_size'] ?? null,
                    'street_address' => $v['street_address'] ?? null,
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
