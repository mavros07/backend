<?php

use App\Support\ListingOptionCatalogSync;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vehicles')) {
            return;
        }

        if (! Schema::hasTable('listing_options') || ! Schema::hasTable('listing_option_categories')) {
            throw new RuntimeException('Migration 2026_05_02_120200 requires listing_option tables. Run earlier migrations first.');
        }

        if (! Schema::hasColumn('vehicles', 'make')) {
            if (Schema::hasColumn('vehicles', 'make_listing_option_id')) {
                return;
            }
            throw new RuntimeException('vehicles table is missing legacy make column and make_listing_option_id; cannot migrate.');
        }

        if (! Schema::hasColumn('vehicles', 'make_listing_option_id')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->foreignId('make_listing_option_id')->nullable()->after('year')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('model_listing_option_id')->nullable()->after('make_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('condition_listing_option_id')->nullable()->after('model_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('body_type_listing_option_id')->nullable()->after('condition_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('transmission_listing_option_id')->nullable()->after('body_type_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('fuel_type_listing_option_id')->nullable()->after('transmission_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('drive_listing_option_id')->nullable()->after('fuel_type_listing_option_id')->constrained('listing_options')->restrictOnDelete();
                $table->foreignId('country_listing_option_id')->nullable()->after('drive_listing_option_id')->constrained('listing_options')->restrictOnDelete();
            });
        }

        if (Schema::hasColumn('vehicles', 'contact_address') || Schema::hasColumn('vehicles', 'location')) {
            DB::table('vehicles')->orderBy('id')->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    $street = trim((string) ($row->street_address ?? ''));
                    if ($street !== '') {
                        continue;
                    }
                    $ca = Schema::hasColumn('vehicles', 'contact_address') ? trim((string) ($row->contact_address ?? '')) : '';
                    $loc = Schema::hasColumn('vehicles', 'location') ? trim((string) ($row->location ?? '')) : '';
                    $merged = $ca !== '' ? $ca : ($loc !== '' ? $loc : '');
                    if ($merged !== '') {
                        DB::table('vehicles')->where('id', $row->id)->update(['street_address' => $merged]);
                    }
                }
            });
        }

        ListingOptionCatalogSync::syncOptionsFromLegacyVehicleColumns();
        ListingOptionCatalogSync::ensureFallbackCountryForEmptyLegacyVehicleRows();

        $failures = [];
        DB::table('vehicles')->orderBy('id')->chunkById(200, function ($rows) use (&$failures) {
            foreach ($rows as $row) {
                $problems = ListingOptionCatalogSync::unresolvedLegacyProblems($row);
                if ($problems !== []) {
                    array_push($failures, ...$problems);
                }
            }
        });

        if ($failures !== []) {
            throw new RuntimeException("Cannot migrate vehicles to listing_option FKs:\n".implode("\n", array_slice($failures, 0, 50))
                .(count($failures) > 50 ? "\n... and ".(count($failures) - 50).' more' : ''));
        }

        DB::table('vehicles')->orderBy('id')->chunkById(200, function ($rows) {
            foreach ($rows as $row) {
                $fk = ListingOptionCatalogSync::resolveLegacyRowToForeignKeys($row);
                DB::table('vehicles')->where('id', $row->id)->update($fk);
            }
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'make',
                'model',
                'condition',
                'body_type',
                'transmission',
                'fuel_type',
                'drive',
                'country',
                'location',
                'contact_address',
            ]);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('vehicles')) {
            return;
        }

        if (! Schema::hasColumn('vehicles', 'make_listing_option_id')) {
            return;
        }

        if (Schema::hasColumn('vehicles', 'make')) {
            return;
        }

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['make_listing_option_id']);
            $table->dropForeign(['model_listing_option_id']);
            $table->dropForeign(['condition_listing_option_id']);
            $table->dropForeign(['body_type_listing_option_id']);
            $table->dropForeign(['transmission_listing_option_id']);
            $table->dropForeign(['fuel_type_listing_option_id']);
            $table->dropForeign(['drive_listing_option_id']);
            $table->dropForeign(['country_listing_option_id']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'make_listing_option_id',
                'model_listing_option_id',
                'condition_listing_option_id',
                'body_type_listing_option_id',
                'transmission_listing_option_id',
                'fuel_type_listing_option_id',
                'drive_listing_option_id',
                'country_listing_option_id',
            ]);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('make', 255)->nullable()->after('year');
            $table->string('model', 255)->nullable()->after('make');
            $table->string('condition', 64)->nullable()->after('mileage');
            $table->string('body_type', 64)->nullable()->after('condition');
            $table->string('transmission', 64)->nullable()->after('body_type');
            $table->string('fuel_type', 64)->nullable()->after('transmission');
            $table->string('drive', 64)->nullable()->after('fuel_type');
            $table->string('location', 255)->nullable()->after('engine_size');
            $table->string('country', 191)->nullable()->after('location');
            $table->string('contact_address', 255)->nullable()->after('contact_phone');
        });
    }
};
