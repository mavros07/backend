<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleInquiry;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleInquiryController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $vehicle = Vehicle::query()
            ->with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        if ($vehicle->status !== 'approved') {
            abort(404);
        }

        $data = $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        VehicleInquiry::query()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => Auth::id(),
            'sender_name' => $data['sender_name'],
            'sender_email' => $data['sender_email'],
            'message' => $data['message'],
        ]);

        $seller = $vehicle->user;
        if ($seller && $seller->email) {
            $subject = 'New inquiry: ' . $vehicle->title;
            $html = view('emails.vehicle-inquiry', [
                'vehicle' => $vehicle,
                'seller' => $seller,
                'senderName' => $data['sender_name'],
                'senderEmail' => $data['sender_email'],
                'body' => $data['message'],
                'listingUrl' => route('inventory.show', ['slug' => $vehicle->slug]),
            ])->render();

            app(OutboundMailService::class)->send(
                $seller->email,
                $seller->name ?? 'Seller',
                $subject,
                $html,
                $data['sender_email'],
                $data['sender_name']
            );
        }

        return back()->with('status', 'Your message was sent to the seller.');
    }
}
