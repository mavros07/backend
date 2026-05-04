<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        foreach (DemoData::users() as $demoUser) {
            $user = User::query()->firstOrCreate(
                ['email' => $demoUser['email']],
                User::factory()->make([
                    'name' => $demoUser['name'],
                    'email' => $demoUser['email'],
                ])->toArray()
            );

            if (! $user->hasRole($demoUser['role'])) {
                $user->assignRole($demoUser['role']);
            }
        }

        $this->call(VehiclesSeeder::class);
        $this->call(SiteSettingsSeeder::class);
        $this->call(CmsPagesSeeder::class);
        $this->call(PageSectionsSeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(ListingOptionCountriesSeeder::class);
    }
}
