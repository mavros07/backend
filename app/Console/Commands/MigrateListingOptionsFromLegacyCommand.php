<?php

namespace App\Console\Commands;

use App\Models\ListingOption;
use App\Models\Vehicle;
use App\Support\ListingOptionCatalogSync;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class MigrateListingOptionsFromLegacyCommand extends Command
{
    protected $signature = 'listing-options:migrate-legacy
                            {--dry-run : For pre-FK databases: show distinct value counts only (no writes)}
                            {--verify : After FK migration: fail if any vehicle references invalid or mismatched options}';

    protected $description = 'Before FK migration: sync listing_options from legacy vehicle string columns. After migration: verify FK integrity (non-zero exit on failure).';

    public function handle(): int
    {
        if (! Schema::hasTable('listing_options') || ! Schema::hasTable('listing_option_categories')) {
            $this->error('Listing option tables are missing. Run migrations first.');

            return self::FAILURE;
        }

        $dry = (bool) $this->option('dry-run');

        if (Schema::hasColumn('vehicles', 'make')) {
            return $this->handlePreForeignKey($dry);
        }

        if ((bool) $this->option('verify')) {
            return $this->handlePostForeignKeyVerify();
        }

        $this->info('Nothing to do. If the database still has legacy vehicles.make columns, run this command (without --verify) to sync listing_options, then migrate. After FK migration, use --verify to audit.');

        return self::SUCCESS;
    }

    private function handlePreForeignKey(bool $dry): int
    {
        if ($dry) {
            $this->info('Dry run (legacy string columns present): would sync listing_options from distinct vehicle values.');
            $rows = \Illuminate\Support\Facades\DB::table('vehicles')->get([
                'make', 'model', 'condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country',
            ]);
            $this->line('  vehicles scanned: '.$rows->count());

            return self::SUCCESS;
        }

        ListingOptionCatalogSync::syncOptionsFromLegacyVehicleColumns();
        $this->info('Listing options synced from legacy vehicle string columns. Run `php artisan migrate` to apply the vehicles FK migration.');

        return self::SUCCESS;
    }

    private function handlePostForeignKeyVerify(): int
    {
        if (! Schema::hasColumn('vehicles', 'make_listing_option_id')) {
            $this->error('vehicles.make_listing_option_id is missing. Run migrations.');

            return self::FAILURE;
        }

        $failures = [];
        Vehicle::query()->orderBy('id')->chunkById(200, function ($rows) use (&$failures) {
            foreach ($rows as $v) {
                $mid = (int) ($v->make_listing_option_id ?? 0);
                $moid = (int) ($v->model_listing_option_id ?? 0);
                if ($mid > 0 && ! ListingOption::query()->whereKey($mid)->whereNull('parent_id')->exists()) {
                    $failures[] = "vehicle {$v->id}: invalid make_listing_option_id {$mid}";
                }
                if ($moid > 0) {
                    $parent = (int) (ListingOption::query()->whereKey($moid)->value('parent_id') ?? 0);
                    if ($parent <= 0) {
                        $failures[] = "vehicle {$v->id}: model_listing_option_id {$moid} has no parent make";
                    } elseif ($mid > 0 && $parent !== $mid) {
                        $failures[] = "vehicle {$v->id}: model_listing_option_id {$moid} parent {$parent} does not match make_listing_option_id {$mid}";
                    }
                }
                foreach (
                    [
                        'condition_listing_option_id',
                        'body_type_listing_option_id',
                        'transmission_listing_option_id',
                        'fuel_type_listing_option_id',
                        'drive_listing_option_id',
                        'country_listing_option_id',
                    ] as $col
                ) {
                    $id = (int) ($v->{$col} ?? 0);
                    if ($id > 0 && ! ListingOption::query()->whereKey($id)->exists()) {
                        $failures[] = "vehicle {$v->id}: invalid {$col} {$id}";
                    }
                }
            }
        });

        $countryCatalog = ListingOptionCatalogSync::activeRootOptionCount('country');
        if ($countryCatalog > 0) {
            foreach (Vehicle::query()->whereNull('country_listing_option_id')->cursor() as $v) {
                $failures[] = "vehicle {$v->id}: country_listing_option_id is null but country catalog has {$countryCatalog} options";
            }
        }

        if ($failures !== []) {
            $this->error('Listing option FK verification failed:');
            foreach (array_slice($failures, 0, 40) as $line) {
                $this->line('  '.$line);
            }
            if (count($failures) > 40) {
                $this->line('  ... and '.(count($failures) - 40).' more');
            }

            return self::FAILURE;
        }

        $this->info('All vehicles passed listing_option foreign key verification.');

        return self::SUCCESS;
    }
}
