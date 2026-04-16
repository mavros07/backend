<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserVehicleController extends Controller
{
    public function index(Request $request): View
    {
        $vehicles = Vehicle::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }

    public function create(): View
    {
        return view('dashboard.vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateVehicle($request);

        $vehicle = Vehicle::query()->create([
            ...$data,
            'user_id' => $request->user()->id,
            'slug' => $this->uniqueSlug($data['title']),
            'status' => 'draft',
        ]);

        $this->storeUploadedImages($request, $vehicle);

        return redirect()->route('dashboard.vehicles.edit', $vehicle);
    }

    public function edit(Request $request, Vehicle $vehicle): View
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);

        $vehicle->load('images');

        return view('dashboard.vehicles.edit', [
            'vehicle' => $vehicle,
        ]);
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);

        $data = $this->validateVehicle($request);

        $vehicle->fill($data);
        if ($vehicle->isDirty('title')) {
            $vehicle->slug = $this->uniqueSlug($data['title'], $vehicle->id);
        }
        $vehicle->save();

        $this->storeUploadedImages($request, $vehicle);

        return back()->with('status', 'Listing updated.');
    }

    public function submit(Request $request, Vehicle $vehicle): RedirectResponse
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);

        if (!in_array($vehicle->status, ['draft', 'rejected'], true)) {
            return back();
        }

        $vehicle->status = 'pending';
        $vehicle->submitted_at = now();
        $vehicle->rejection_reason = null;
        $vehicle->save();

        $to = (string) config('mail.outbound.admin_to');
        if ($to !== '') {
            $subject = 'Listing submitted for approval';
            $html = view('emails.listing-submitted', [
                'user' => $request->user(),
                'vehicle' => $vehicle,
                'adminUrl' => route('admin.vehicles.index'),
            ])->render();

            app(OutboundMailService::class)->send($to, 'Admin', $subject, $html);
        }

        return back();
    }

    public function destroy(Request $request, Vehicle $vehicle): RedirectResponse
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);

        $this->deleteVehicleFiles($vehicle);
        $vehicle->delete();

        return redirect()
            ->route('dashboard.vehicles.index')
            ->with('status', 'Listing deleted.');
    }

    public function destroyImage(Request $request, Vehicle $vehicle, VehicleImage $image): RedirectResponse
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);
        abort_unless($image->vehicle_id === $vehicle->id, 404);

        Storage::disk('public')->delete($this->relativeStoragePath($image->path));
        $image->delete();
        $this->resequenceImages($vehicle);

        return back()->with('status', 'Image removed.');
    }

    private function validateVehicle(Request $request): array
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

        $data['features'] = $this->parseFeatures($data['features_text'] ?? null);
        unset($data['features_text']);

        return $data;
    }

    /**
     * @return array<int, string>|null
     */
    private function parseFeatures(?string $text): ?array
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

    private function uniqueSlug(string $title, ?int $ignoreVehicleId = null): string
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

    private function storeUploadedImages(Request $request, Vehicle $vehicle): void
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
            $filename = (string) Str::uuid().'.'.$extension;
            $stored = $uploadedImage->storePubliclyAs(
                'vehicles/'.$vehicle->id,
                $filename,
                'public'
            );

            $vehicle->images()->create([
                'path' => 'storage/'.$stored,
                'sort_order' => $nextSortOrder,
            ]);
        }
    }

    private function deleteVehicleFiles(Vehicle $vehicle): void
    {
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($this->relativeStoragePath($image->path));
        }
    }

    private function resequenceImages(Vehicle $vehicle): void
    {
        foreach ($vehicle->images()->orderBy('sort_order')->get()->values() as $index => $image) {
            $image->update(['sort_order' => $index + 1]);
        }
    }

    private function relativeStoragePath(string $publicPath): string
    {
        return ltrim(Str::after($publicPath, 'storage/'), '/');
    }
}

