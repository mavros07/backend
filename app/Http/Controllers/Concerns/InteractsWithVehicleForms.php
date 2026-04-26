<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Vehicle;
use App\Support\VehicleImageUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'mileage' => ['nullable', 'integer', 'min:0'],
            'transmission' => ['nullable', 'string', 'max:255'],
            'fuel_type' => ['nullable', 'string', 'max:255'],
            'drive' => ['nullable', 'string', 'max:255'],
            'body_type' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', Rule::in(['new', 'used'])],
            'engine_size' => ['nullable', 'string', 'max:64'],
            'location' => ['nullable', 'string', 'max:255'],
            'features_text' => ['nullable', 'string', 'max:10000'],
            'exterior_color' => ['nullable', 'string', 'max:255'],
            'interior_color' => ['nullable', 'string', 'max:255'],
            'vin' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'images' => ['sometimes', 'array', 'max:12'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['is_special'] = $request->boolean('is_special');

        $data['features'] = $this->parseFeatures($data['features_text'] ?? null);
        unset($data['features_text']);

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
        if (! $request->hasFile('images')) {
            return;
        }

        $nextSortOrder = (int) $vehicle->images()->max('sort_order');

        foreach ($request->file('images', []) as $uploadedImage) {
            $nextSortOrder++;
            $extension = match ($uploadedImage->getMimeType()) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                default => 'jpg',
            };
            $filename = (string) Str::uuid() . '.' . $extension;
            $dir = config('media.listing_photos_directory', 'listings/vehicles').'/'.$vehicle->id;
            $stored = $uploadedImage->storePubliclyAs(
                $dir,
                $filename,
                'public'
            );

            $vehicle->images()->create([
                'path' => 'storage/' . $stored,
                'sort_order' => $nextSortOrder,
            ]);
        }
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
