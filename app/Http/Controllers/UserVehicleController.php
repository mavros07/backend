<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithVehicleForms;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class UserVehicleController extends Controller
{
    use InteractsWithVehicleForms;

    public function index(Request $request): View
    {
        $isAdmin = $request->user()->hasRole('admin');

        $query = Vehicle::query()
            ->with(['user.roles'])
            ->latest();

        if (! $isAdmin) {
            $query->where('user_id', $request->user()->id);
        } else {
            $status = $request->query('status');
            if (is_string($status) && in_array($status, ['pending', 'approved', 'draft', 'rejected'], true)) {
                $query->where('status', $status);
            }
        }

        $vehicles = $query->paginate(15)->withQueryString();

        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
            'isAdminList' => $isAdmin,
            'statusFilter' => $isAdmin ? (string) $request->query('status', '') : '',
            'stats' => $isAdmin ? [
                'total' => Vehicle::query()->count(),
                'pending' => Vehicle::query()->where('status', 'pending')->count(),
                'approved' => Vehicle::query()->where('status', 'approved')->count(),
            ] : null,
        ]);
    }

    public function create(): View
    {
        return view('dashboard.vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $this->validateVehicleData($request);

            $vehicle = DB::transaction(function () use ($request, $data) {
                $vehicle = Vehicle::query()->create([
                    ...$data,
                    'user_id' => $request->user()->id,
                    'slug' => $this->uniqueSlug($data['title']),
                    'status' => 'draft',
                ]);

                $this->storeUploadedImages($request, $vehicle);
                return $vehicle;
            });

            if ($request->user()->hasRole('admin') && $request->boolean('approve_listing')) {
                $vehicle->refresh();
                $vehicle->status = 'approved';
                $vehicle->approved_at = now();
                $vehicle->approved_by = $request->user()->id;
                $vehicle->rejection_reason = null;
                $vehicle->save();
                $this->notifyOwnerListingApproved($vehicle);
            }

            return redirect()->route('dashboard.vehicles.edit', $vehicle);
        } catch (QueryException $exception) {
            if (str_contains(strtolower($exception->getMessage()), 'is_special')) {
                return back()
                    ->withInput()
                    ->withErrors(['is_special' => __('Listing schema is out of date. Run migrations and try again.')]);
            }
            throw $exception;
        }
    }

    public function edit(Request $request, Vehicle $vehicle): View
    {
        $this->authorizeVehicleAccess($request, $vehicle);

        $vehicle->load(['images', 'user']);

        return view('dashboard.vehicles.edit', [
            'vehicle' => $vehicle,
            'isAdminEdit' => $request->user()->hasRole('admin'),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $this->authorizeVehicleAccess($request, $vehicle);
        try {
            $data = $this->validateVehicleData($request);

            DB::transaction(function () use ($request, $vehicle, $data) {
                $vehicle->fill($data);
                if ($vehicle->isDirty('title')) {
                    $vehicle->slug = $this->uniqueSlug($data['title'], $vehicle->id);
                }
                $vehicle->save();
                $this->storeUploadedImages($request, $vehicle);
            });

            if (
                $request->user()->hasRole('admin')
                && $request->boolean('approve_listing')
                && in_array($vehicle->status, ['pending', 'draft', 'rejected'], true)
            ) {
                $vehicle->status = 'approved';
                $vehicle->approved_at = now();
                $vehicle->approved_by = $request->user()->id;
                $vehicle->rejection_reason = null;
                $vehicle->save();
                $this->notifyOwnerListingApproved($vehicle);
            }

            return back()->with('status', 'Listing updated.');
        } catch (QueryException $exception) {
            if (str_contains(strtolower($exception->getMessage()), 'is_special')) {
                return back()
                    ->withInput()
                    ->withErrors(['is_special' => __('Listing schema is out of date. Run migrations and try again.')]);
            }
            throw $exception;
        }
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
            try {
                $subject = 'Listing submitted for approval';
                $html = view('emails.listing-submitted', [
                    'user' => $request->user(),
                    'vehicle' => $vehicle,
                    'adminUrl' => route('dashboard.vehicles.index'),
                ])->render();

                app(OutboundMailService::class)->send($to, 'Admin', $subject, $html);
            } catch (Throwable $e) {
                Log::warning('Listing submitted but admin notification email failed', [
                    'vehicle_id' => $vehicle->id,
                    'exception' => $e,
                ]);
            }
        }

        return back();
    }

    public function destroy(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $this->authorizeVehicleAccess($request, $vehicle);

        $this->deleteLocalVehicleImageFiles($vehicle);
        $vehicle->delete();

        return redirect()
            ->route('dashboard.vehicles.index')
            ->with('status', 'Listing deleted.');
    }

    public function destroyImage(Request $request, Vehicle $vehicle, VehicleImage $image): RedirectResponse|JsonResponse
    {
        // #region agent log
        try {
            $payload = json_encode([
                'sessionId' => 'c47fa5',
                'runId' => 'remove-image',
                'hypothesisId' => 'H5',
                'location' => 'UserVehicleController.php:destroyImage:entry',
                'message' => 'Controller reached for image unlink',
                'data' => [
                    'vehicleId' => (int) $vehicle->id,
                    'imageId' => (int) $image->id,
                    'path' => (string) $request->path(),
                    'method' => (string) $request->method(),
                ],
                'timestamp' => (int) round(microtime(true) * 1000),
            ], JSON_UNESCAPED_SLASHES);
            if (is_string($payload)) {
                @file_put_contents(base_path('debug-c47fa5.log'), $payload . PHP_EOL, FILE_APPEND);
            }
        } catch (\Throwable) {
            // swallow debug logging errors
        }
        // #endregion
        $this->authorizeVehicleAccess($request, $vehicle);
        abort_unless($image->vehicle_id === $vehicle->id, 404);

        // Editor "remove" detaches image from this listing only.
        // It must not delete the underlying media asset/site file.
        $image->delete();
        $this->resequenceImages($vehicle);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Image removed.',
            ]);
        }

        return back()->with('status', 'Image removed.');
    }

    public function destroyImageById(Request $request, Vehicle $vehicle): RedirectResponse|JsonResponse
    {
        $this->authorizeVehicleAccess($request, $vehicle);
        $data = $request->validate([
            'image_id' => ['required', 'integer', 'min:1'],
        ]);

        $image = $vehicle->images()->whereKey((int) $data['image_id'])->first();
        if (! $image) {
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Image not found on this listing.',
                ], 404);
            }
            return back()->withErrors(['image' => 'Image not found on this listing.']);
        }

        $image->delete();
        $this->resequenceImages($vehicle);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Image removed.',
            ]);
        }

        return back()->with('status', 'Image removed.');
    }

    private function authorizeVehicleAccess(Request $request, Vehicle $vehicle): void
    {
        if ($request->user()->hasRole('admin')) {
            return;
        }

        abort_unless($vehicle->user_id === $request->user()->id, 403);
    }

    private function notifyOwnerListingApproved(Vehicle $vehicle): void
    {
        $vehicle->loadMissing('user');
        if (empty($vehicle->user?->email) || $vehicle->isStaffListing()) {
            return;
        }

        try {
            $subject = 'Your listing was approved';
            $html = view('emails.listing-approved', [
                'user' => $vehicle->user,
                'vehicle' => $vehicle,
                'publicUrl' => route('inventory.show', ['slug' => $vehicle->slug]),
            ])->render();

            app(OutboundMailService::class)->send($vehicle->user->email, $vehicle->user->name ?? 'User', $subject, $html);
        } catch (Throwable $e) {
            Log::warning('Listing approved but owner notification email failed', [
                'vehicle_id' => $vehicle->id,
                'exception' => $e,
            ]);
        }
    }
}
