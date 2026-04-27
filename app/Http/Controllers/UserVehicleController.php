<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithVehicleForms;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\Mail\OutboundMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
            $subject = 'Listing submitted for approval';
            $html = view('emails.listing-submitted', [
                'user' => $request->user(),
                'vehicle' => $vehicle,
                'adminUrl' => route('dashboard.vehicles.index'),
            ])->render();

            app(OutboundMailService::class)->send($to, 'Admin', $subject, $html);
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

    public function destroyImage(Request $request, Vehicle $vehicle, VehicleImage $image): RedirectResponse
    {
        $this->authorizeVehicleAccess($request, $vehicle);
        abort_unless($image->vehicle_id === $vehicle->id, 404);

        $rel = $this->relativeStoragePathForDelete($image->path);
        if ($rel !== null) {
            Storage::disk('public')->delete($rel);
        }
        $image->delete();
        $this->resequenceImages($vehicle);

        return back()->with('status', 'Image removed.');
    }

    private function authorizeVehicleAccess(Request $request, Vehicle $vehicle): void
    {
        if ($request->user()->hasRole('admin')) {
            return;
        }

        abort_unless($vehicle->user_id === $request->user()->id, 403);
    }
}
