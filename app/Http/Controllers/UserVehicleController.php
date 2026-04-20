<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithVehicleForms;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserVehicleController extends Controller
{
    use InteractsWithVehicleForms;

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
        $data = $this->validateVehicleData($request);

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

        $data = $this->validateVehicleData($request);

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

        if (! in_array($vehicle->status, ['draft', 'rejected'], true)) {
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

        $this->deleteLocalVehicleImageFiles($vehicle);
        $vehicle->delete();

        return redirect()
            ->route('dashboard.vehicles.index')
            ->with('status', 'Listing deleted.');
    }

    public function destroyImage(Request $request, Vehicle $vehicle, VehicleImage $image): RedirectResponse
    {
        abort_unless($vehicle->user_id === $request->user()->id, 403);
        abort_unless($image->vehicle_id === $vehicle->id, 404);

        $rel = $this->relativeStoragePathForDelete($image->path);
        if ($rel !== null) {
            Storage::disk('public')->delete($rel);
        }
        $image->delete();
        $this->resequenceImages($vehicle);

        return back()->with('status', 'Image removed.');
    }
}
