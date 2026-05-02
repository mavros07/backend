<?php

namespace App\Support;

use App\Models\ListingOption;
use App\Models\ListingOptionCategory;
use Illuminate\Support\Facades\DB;

/**
 * Ensures listing_options rows exist from legacy vehicle string columns and resolves strings to FK ids.
 * Used by migrations and `listing-options:migrate-legacy`.
 */
final class ListingOptionCatalogSync
{
    /**
     * Upsert root and model (child) options from current vehicles.* string columns.
     */
    /**
     * Ensures listing_option rows exist for one seed/demo array (make, model, condition, …).
     *
     * @param  array<string, mixed>  $data
     */
    public static function ensureOptionValuesFromArray(array $data): void
    {
        if (! self::tablesExist()) {
            return;
        }

        $catIds = ListingOptionCategory::query()->pluck('id', 'slug')->all();

        foreach (['condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country'] as $slug) {
            $raw = ListingOptionNormalizer::canonical($slug, (string) ($data[$slug] ?? ''));
            if ($raw === '') {
                continue;
            }
            $cid = (int) ($catIds[$slug] ?? 0);
            if ($cid) {
                self::ensureRootOption($cid, $raw);
            }
        }

        $makeCatId = (int) ($catIds['make'] ?? 0);
        $modelCatId = (int) ($catIds['model'] ?? 0);
        if (! $makeCatId || ! $modelCatId) {
            return;
        }

        $mk = ListingOptionNormalizer::canonical('make', (string) ($data['make'] ?? ''));
        $md = ListingOptionNormalizer::canonical('model', (string) ($data['model'] ?? ''));
        if ($mk !== '') {
            self::ensureRootOption($makeCatId, $mk);
        }
        if ($mk !== '' && $md !== '') {
            $makeRow = ListingOption::query()
                ->where('category_id', $makeCatId)
                ->whereNull('parent_id')
                ->where('value', $mk)
                ->first();
            if ($makeRow) {
                self::ensureChildOption($modelCatId, (int) $makeRow->id, $md);
            }
        }
    }

    public static function syncOptionsFromLegacyVehicleColumns(): void
    {
        if (! self::tablesExist()) {
            return;
        }

        $rows = DB::table('vehicles')->get([
            'id', 'make', 'model', 'condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country',
        ]);

        $catIds = ListingOptionCategory::query()->pluck('id', 'slug')->all();

        $byCat = [
            'make' => collect(),
            'model' => [],
            'condition' => collect(),
            'body_type' => collect(),
            'transmission' => collect(),
            'fuel_type' => collect(),
            'drive' => collect(),
            'country' => collect(),
        ];

        foreach ($rows as $v) {
            $mk = ListingOptionNormalizer::canonical('make', (string) ($v->make ?? ''));
            $md = ListingOptionNormalizer::canonical('model', (string) ($v->model ?? ''));
            if ($mk !== '') {
                $byCat['make']->push($mk);
            }
            if ($mk !== '' && $md !== '') {
                $byCat['model'][] = ['make' => $mk, 'model' => $md];
            }
            foreach (['condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country'] as $col) {
                $raw = ListingOptionNormalizer::canonical($col, (string) ($v->{$col} ?? ''));
                if ($raw === '') {
                    continue;
                }
                $byCat[$col]->push($raw);
            }
        }

        $byCat['make'] = $byCat['make']->unique()->sort()->values();
        foreach (['condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country'] as $col) {
            $byCat[$col] = $byCat[$col]->unique()->sort()->values();
        }

        foreach (['condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country'] as $slug) {
            $cid = (int) ($catIds[$slug] ?? 0);
            if (! $cid) {
                continue;
            }
            foreach ($byCat[$slug] as $value) {
                self::ensureRootOption($cid, (string) $value);
            }
        }

        $makeCatId = (int) ($catIds['make'] ?? 0);
        $modelCatId = (int) ($catIds['model'] ?? 0);
        if (! $makeCatId || ! $modelCatId) {
            return;
        }

        foreach ($byCat['make'] as $makeLabel) {
            self::ensureRootOption($makeCatId, (string) $makeLabel);
        }

        $makeRows = ListingOption::query()
            ->where('category_id', $makeCatId)
            ->whereNull('parent_id')
            ->get(['id', 'value'])
            ->keyBy(fn ($o) => mb_strtolower($o->value));

        foreach ($byCat['model'] as $pair) {
            $makeKey = mb_strtolower($pair['make']);
            $parent = $makeRows->get($makeKey);
            if (! $parent) {
                continue;
            }
            $modelVal = ListingOptionNormalizer::canonical('model', $pair['model']);
            if ($modelVal === '') {
                $modelVal = $pair['model'];
            }
            self::ensureChildOption($modelCatId, (int) $parent->id, $modelVal);
        }
    }

    /**
     * @return array<string, int|null>
     */
    public static function resolveLegacyRowToForeignKeys(object $row): array
    {
        $out = [
            'make_listing_option_id' => null,
            'model_listing_option_id' => null,
            'condition_listing_option_id' => null,
            'body_type_listing_option_id' => null,
            'transmission_listing_option_id' => null,
            'fuel_type_listing_option_id' => null,
            'drive_listing_option_id' => null,
            'country_listing_option_id' => null,
        ];

        $catIds = ListingOptionCategory::query()->pluck('id', 'slug')->all();

        $slugToFk = [
            'condition' => 'condition_listing_option_id',
            'body_type' => 'body_type_listing_option_id',
            'transmission' => 'transmission_listing_option_id',
            'fuel_type' => 'fuel_type_listing_option_id',
            'drive' => 'drive_listing_option_id',
            'country' => 'country_listing_option_id',
        ];
        foreach ($slugToFk as $slug => $fkColumn) {
            $raw = (string) ($row->{$slug} ?? '');
            $canon = ListingOptionNormalizer::canonical($slug, $raw);
            if ($canon === '') {
                continue;
            }
            $cid = (int) ($catIds[$slug] ?? 0);
            if (! $cid) {
                continue;
            }
            $out[$fkColumn] = self::findRootOptionId($cid, $canon);
        }

        $mkRaw = (string) ($row->make ?? '');
        $mkCanon = ListingOptionNormalizer::canonical('make', $mkRaw);
        if ($mkCanon !== '') {
            $makeCatId = (int) ($catIds['make'] ?? 0);
            $makeId = $makeCatId ? self::findRootOptionId($makeCatId, $mkCanon) : null;
            $out['make_listing_option_id'] = $makeId;

            $mdRaw = (string) ($row->model ?? '');
            $mdCanon = ListingOptionNormalizer::canonical('model', $mdRaw);
            if ($mdCanon !== '' && $makeId) {
                $modelCatId = (int) ($catIds['model'] ?? 0);
                if ($modelCatId) {
                    $out['model_listing_option_id'] = self::findChildOptionId($modelCatId, $makeId, $mdCanon);
                }
            }
        }

        return $out;
    }

    /**
     * @return list<string> Human-readable problems
     */
    public static function unresolvedLegacyProblems(object $row): array
    {
        $problems = [];
        $mkRaw = trim((string) ($row->make ?? ''));
        $mdRaw = trim((string) ($row->model ?? ''));
        if ($mdRaw !== '' && $mkRaw === '' && isset($row->id)) {
            $problems[] = "vehicle {$row->id}: model is set but make is empty";
        }

        $resolved = self::resolveLegacyRowToForeignKeys($row);

        if ($mkRaw !== '' && isset($row->id) && $resolved['make_listing_option_id'] === null) {
            $problems[] = "vehicle {$row->id}: make ".json_encode($mkRaw).' has no matching listing_option';
        }
        if ($mdRaw !== '' && $mkRaw !== '' && isset($row->id) && $resolved['model_listing_option_id'] === null) {
            $problems[] = "vehicle {$row->id}: model ".json_encode($mdRaw).' not found under make for listing_option tree';
        }

        foreach (['condition', 'body_type', 'transmission', 'fuel_type', 'drive', 'country'] as $slug) {
            $raw = trim((string) ($row->{$slug} ?? ''));
            if ($raw === '') {
                continue;
            }
            $key = match ($slug) {
                'body_type' => 'body_type_listing_option_id',
                'fuel_type' => 'fuel_type_listing_option_id',
                default => $slug.'_listing_option_id',
            };
            if (($resolved[$key] ?? null) === null) {
                $problems[] = "vehicle {$row->id}: {$slug} ".json_encode($raw).' unresolved';
            }
        }

        $countryCount = self::activeRootOptionCount('country');
        if ($countryCount > 0 && isset($row->id)) {
            $cRaw = trim((string) ($row->country ?? ''));
            if ($cRaw === '') {
                $problems[] = "vehicle {$row->id}: country is required (catalog has {$countryCount} countries) but value is empty";
            } elseif ($resolved['country_listing_option_id'] === null) {
                $problems[] = "vehicle {$row->id}: country ".json_encode($cRaw).' unresolved';
            }
        }

        return $problems;
    }

    public static function activeRootOptionCount(string $slug): int
    {
        if (! self::tablesExist()) {
            return 0;
        }
        $catId = ListingOptionCategory::query()->where('slug', $slug)->value('id');
        if (! $catId) {
            return 0;
        }

        return (int) ListingOption::query()
            ->where('category_id', $catId)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->count();
    }

    private static function tablesExist(): bool
    {
        try {
            return \Illuminate\Support\Facades\Schema::hasTable('listing_options')
                && \Illuminate\Support\Facades\Schema::hasTable('listing_option_categories')
                && \Illuminate\Support\Facades\Schema::hasTable('vehicles');
        } catch (\Throwable) {
            return false;
        }
    }

    private static function ensureRootOption(int $categoryId, string $value): void
    {
        $value = trim($value);
        if ($value === '') {
            return;
        }
        $exists = ListingOption::query()
            ->where('category_id', $categoryId)
            ->whereNull('parent_id')
            ->where('value', $value)
            ->exists();
        if ($exists) {
            return;
        }
        $max = (int) ListingOption::query()->where('category_id', $categoryId)->whereNull('parent_id')->max('sort_order');
        ListingOption::query()->create([
            'category_id' => $categoryId,
            'parent_id' => null,
            'value' => $value,
            'sort_order' => $max + 1,
            'is_active' => true,
        ]);
    }

    private static function ensureChildOption(int $categoryId, int $parentId, string $value): void
    {
        $value = trim($value);
        if ($value === '') {
            return;
        }
        $exists = ListingOption::query()
            ->where('category_id', $categoryId)
            ->where('parent_id', $parentId)
            ->where('value', $value)
            ->exists();
        if ($exists) {
            return;
        }
        $max = (int) ListingOption::query()->where('category_id', $categoryId)->where('parent_id', $parentId)->max('sort_order');
        ListingOption::query()->create([
            'category_id' => $categoryId,
            'parent_id' => $parentId,
            'value' => $value,
            'sort_order' => $max + 1,
            'is_active' => true,
        ]);
    }

    private static function findRootOptionId(int $categoryId, string $canonicalValue): ?int
    {
        $canonicalValue = trim($canonicalValue);
        if ($canonicalValue === '') {
            return null;
        }
        $lower = mb_strtolower($canonicalValue);
        $id = ListingOption::query()
            ->where('category_id', $categoryId)
            ->whereNull('parent_id')
            ->where(function ($q) use ($canonicalValue, $lower) {
                $q->where('value', $canonicalValue)->orWhereRaw('LOWER(value) = ?', [$lower]);
            })
            ->value('id');

        return $id ? (int) $id : null;
    }

    private static function findChildOptionId(int $categoryId, int $parentId, string $canonicalValue): ?int
    {
        $canonicalValue = trim($canonicalValue);
        if ($canonicalValue === '') {
            return null;
        }
        $lower = mb_strtolower($canonicalValue);
        $id = ListingOption::query()
            ->where('category_id', $categoryId)
            ->where('parent_id', $parentId)
            ->where(function ($q) use ($canonicalValue, $lower) {
                $q->where('value', $canonicalValue)->orWhereRaw('LOWER(value) = ?', [$lower]);
            })
            ->value('id');

        return $id ? (int) $id : null;
    }
}
