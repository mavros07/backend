<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminVehicleController extends Controller
{
    public function approve(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->status = 'approved';
        $vehicle->approved_at = now();
        $vehicle->approved_by = $request->user()->id;
        $vehicle->rejection_reason = null;
        $vehicle->save();

        if (! empty($vehicle->user?->email)) {
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

        if (! empty($vehicle->user?->email)) {
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
}
