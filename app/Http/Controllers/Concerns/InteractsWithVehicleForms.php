<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Vehicle;
use App\Support\VehicleImageUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

trait InteractsWithVehicleForms
{
    /**
     * @return array<string, mixed>
     */
    protected function validateVehicleData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (int) date('Y')],
            'make' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'integer', 'min:0'],
            'msrp' => ['nullable', 'integer', 'min:0'],
            'mileage' => ['nullable', 'integer', 'min:0'],
            'city_mpg' => ['nullable', 'integer', 'min:0', 'max:200'],
            'hwy_mpg' => ['nullable', 'integer', 'min:0', 'max:200'],
            'transmission' => ['nullable', 'string', 'max:255'],
            'fuel_type' => ['nullable', 'string', 'max:255'],
            'drive' => ['nullable', 'string', 'max:255'],
            'body_type' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', Rule::in(['new', 'used'])],
            'engine_size' => ['nullable', 'string', 'max:64'],
            'engine_layout' => ['nullable', 'string', 'max:100'],
            'top_track_speed' => ['nullable', 'string', 'max:100'],
            'zero_to_sixty' => ['nullable', 'string', 'max:100'],
            'number_of_gears' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:64'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'map_location' => ['nullable', 'string', 'max:255'],
            'overview' => ['nullable', 'string', 'max:50000'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'finance_price' => ['nullable', 'integer', 'min:0'],
            'finance_interest_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'finance_term_months' => ['nullable', 'integer', 'min:1', 'max:600'],
            'finance_down_payment' => ['nullable', 'integer', 'min:0'],
            'show_financing_calculator' => ['nullable', 'boolean'],
            'features_text' => ['nullable', 'string', 'max:10000'],
            'exterior_color' => ['nullable', 'string', 'max:255'],
            'interior_color' => ['nullable', 'string', 'max:255'],
            'vin' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'tech_specs' => ['nullable', 'array'],
            'tech_specs.engine_layout' => ['nullable', 'string', 'max:100'],
            'tech_specs.engine_volume' => ['nullable', 'string', 'max:100'],
            'tech_specs.drive_type' => ['nullable', 'string', 'max:100'],
            'tech_specs.top_speed' => ['nullable', 'string', 'max:100'],
            'tech_specs.zero_to_70' => ['nullable', 'string', 'max:100'],
            'tech_specs.transmission_gears' => ['nullable', 'string', 'max:100'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'main_image_path' => ['nullable', 'string', 'max:2048', 'regex:/^(https?:\/\/|\/?(asset|storage)\/).+/i'],
            'images' => ['sometimes', 'array', 'max:12'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_image_paths' => ['sometimes', 'array', 'max:12'],
            'gallery_image_paths.*' => ['string', 'max:2048', 'regex:/^(https?:\/\/|\/?(asset|storage)\/).+/i'],
        ]);

        $data['is_special'] = $request->boolean('is_special');
        $data['show_financing_calculator'] = $request->boolean('show_financing_calculator');

        $data['features'] = $this->parseFeatures($data['features_text'] ?? null);
        unset($data['features_text']);

        $rawTechSpecs = [
            'engine_layout' => (string) ($data['tech_specs']['engine_layout'] ?? $data['engine_layout'] ?? ''),
            'engine_volume' => (string) ($data['tech_specs']['engine_volume'] ?? $data['engine_size'] ?? ''),
            'drive_type' => (string) ($data['tech_specs']['drive_type'] ?? $data['drive'] ?? ''),
            'top_speed' => (string) ($data['tech_specs']['top_speed'] ?? $data['top_track_speed'] ?? ''),
            'zero_to_70' => (string) ($data['tech_specs']['zero_to_70'] ?? $data['zero_to_sixty'] ?? ''),
            'transmission_gears' => (string) ($data['tech_specs']['transmission_gears'] ?? $data['number_of_gears'] ?? ''),
        ];
        $data['tech_specs'] = collect($rawTechSpecs)
            ->map(fn ($value) => trim($value))
            ->filter(fn ($value) => $value !== '')
            ->all();
        if ($data['tech_specs'] === []) {
            $data['tech_specs'] = null;
        }

        return $data;
    }

    /**
     * @return array<int, string>|null
     */
    protected function parseFeatures(?string $text): ?array
    {
        if ($text === null || trim($text) === '') {
            return null;
        }

        $lines = preg_split('/\r\n|\r|\n/', $text) ?: [];
        $out = [];
        foreach ($lines as $line) {
            $line = trim((string) $line);
            if ($line !== '') {
                $out[] = $line;
            }
        }

        if ($out === []) {
            return null;
        }

        return array_values(array_unique($out));
    }

    protected function uniqueSlug(string $title, ?int $ignoreVehicleId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;
        while (Vehicle::query()
            ->where('slug', $slug)
            ->when($ignoreVehicleId, fn ($query) => $query->where('id', '!=', $ignoreVehicleId))
            ->exists()) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    protected function storeUploadedImages(Request $request, Vehicle $vehicle): void
    {
        $nextSortOrder = (int) $vehicle->images()->max('sort_order');

        $mainImagePath = $this->normalizeSelectedImagePath((string) $request->input('main_image_path', ''));
        if ($request->hasFile('main_image') || $mainImagePath !== '') {
            $vehicle->images()->increment('sort_order');
            $vehicle->images()->create([
                'path' => $request->hasFile('main_image')
                    ? 'storage/' . $this->storeImageOnPublicDisk($request->file('main_image'), $vehicle)
                    : $mainImagePath,
                'sort_order' => 1,
            ]);
            $nextSortOrder = (int) $vehicle->images()->max('sort_order');
        }

        $galleryPaths = collect($request->input('gallery_image_paths', []))
            ->map(fn ($path) => $this->normalizeSelectedImagePath((string) $path))
            ->filter(fn ($path) => $path !== '')
            ->values()
            ->all();

        if (! $request->hasFile('images') && $galleryPaths === []) {
            return;
        }

        foreach ($galleryPaths as $galleryPath) {
            $nextSortOrder++;
            $vehicle->images()->create([
                'path' => $galleryPath,
                'sort_order' => $nextSortOrder,
            ]);
        }

        foreach ($request->file('images', []) as $uploadedImage) {
            $nextSortOrder++;
            $stored = $this->storeImageOnPublicDisk($uploadedImage, $vehicle);
            $vehicle->images()->create([
                'path' => 'storage/' . $stored,
                'sort_order' => $nextSortOrder,
            ]);
        }
    }

    protected function normalizeSelectedImagePath(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return ltrim($path, '/');
    }

    protected function storeImageOnPublicDisk(\Illuminate\Http\UploadedFile $uploadedImage, Vehicle $vehicle): string
    {
        $extension = match ($uploadedImage->getMimeType()) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
        $filename = (string) Str::uuid() . '.' . $extension;
        $dir = config('media.listing_photos_directory', 'listings/vehicles').'/'.$vehicle->id;
        $stored = $uploadedImage->storePubliclyAs($dir, $filename, 'public');
        if (!is_string($stored) || $stored === '') {
            throw ValidationException::withMessages([
                'images' => __('An image could not be uploaded. Please try again.'),
            ]);
        }

        return $stored;
    }

    protected function resequenceImages(Vehicle $vehicle): void
    {
        foreach ($vehicle->images()->orderBy('sort_order')->get()->values() as $index => $image) {
            $image->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Relative path under the public disk, or null when the row stores a remote URL (no file to delete).
     */
    protected function relativeStoragePathForDelete(string $publicPath): ?string
    {
        if (VehicleImageUrl::isRemote($publicPath)) {
            return null;
        }

        return ltrim(Str::after($publicPath, 'storage/'), '/');
    }

    protected function deleteLocalVehicleImageFiles(Vehicle $vehicle): void
    {
        foreach ($vehicle->images as $image) {
            $rel = $this->relativeStoragePathForDelete($image->path);
            if ($rel !== null) {
                Storage::disk('public')->delete($rel);
            }
        }
    }
}
