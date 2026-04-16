<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminVehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::query()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.vehicles.index', [
            'vehicles' => $vehicles,
            'stats' => [
                'total' => Vehicle::query()->count(),
                'pending' => Vehicle::query()->where('status', 'pending')->count(),
                'approved' => Vehicle::query()->where('status', 'approved')->count(),
            ],
        ]);
    }

    public function approve(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->status = 'approved';
        $vehicle->approved_at = now();
        $vehicle->approved_by = $request->user()->id;
        $vehicle->rejection_reason = null;
        $vehicle->save();

        if (!empty($vehicle->user?->email)) {
            $subject = 'Your listing was approved';
            $html = view('emails.listing-approved', [
                'user' => $vehicle->user,
                'vehicle' => $vehicle,
                'publicUrl' => route('inventory.show', ['slug' => $vehicle->slug]),
            ])->render();

            app(OutboundMailService::class)->send($vehicle->user->email, $vehicle->user->name ?? 'User', $subject, $html);
        }

        return back();
    }

    public function reject(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:2000'],
        ]);

        $vehicle->status = 'rejected';
        $vehicle->approved_at = null;
        $vehicle->approved_by = $request->user()->id;
        $vehicle->rejection_reason = $data['rejection_reason'] ?? 'Rejected';
        $vehicle->save();

        if (!empty($vehicle->user?->email)) {
            $subject = 'Your listing was rejected';
            $html = view('emails.listing-rejected', [
                'user' => $vehicle->user,
                'vehicle' => $vehicle,
                'reason' => (string) $vehicle->rejection_reason,
                'editUrl' => route('dashboard.vehicles.edit', $vehicle),
            ])->render();

            app(OutboundMailService::class)->send($vehicle->user->email, $vehicle->user->name ?? 'User', $subject, $html);
        }

        return back();
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete(ltrim(\Illuminate\Support\Str::after($image->path, 'storage/'), '/'));
        }

        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('status', 'Listing deleted.');
    }
}

