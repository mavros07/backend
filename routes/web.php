<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\UserVehicleController;
use App\Http\Controllers\AdminVehicleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\VehicleInquiryController;
use App\Http\Controllers\TemporaryAdminController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminAnalyticsController;
use App\Models\SiteTrafficEvent;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (app()->environment('local')) {
    Route::get('/asset-smoke-test', function () {
        return view('pages.asset-smoke-test');
    });
}

if (config('app.admin_bootstrap_enabled')) {
    Route::middleware('guest')->group(function () {
        Route::get('/bootstrap-admin', [TemporaryAdminController::class, 'create'])->name('bootstrap.admin');
        Route::post('/bootstrap-admin', [TemporaryAdminController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('bootstrap.admin.store');
    });
}

// There is no separate admin login URL; admins use the same session as other users.
Route::redirect('/admin/login', '/login', 302);

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->middleware('throttle:5,1')->name('contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/inventory', [PageController::class, 'inventory'])->name('inventory.index');
Route::post('/inventory/{slug}/inquiry', [VehicleInquiryController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('inventory.inquiry');
Route::get('/inventory/{slug?}', [PageController::class, 'vehicleShow'])->name('inventory.show');
Route::get('/compare', [PageController::class, 'compare'])->name('compare');

Route::post('/compare/add/{vehicle}', [CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove/{vehicle}', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    if ($user->hasRole('admin')) {
        return view('dashboard', [
            'stats' => [
                'total' => Vehicle::query()->count(),
                'pending' => Vehicle::query()->where('status', 'pending')->count(),
                'approved' => Vehicle::query()->where('status', 'approved')->count(),
            ],
            'adminOverview' => true,
        ]);
    }

    return view('dashboard', [
        'stats' => [
            'total' => $user->vehicles()->count(),
            'pending' => $user->vehicles()->where('status', 'pending')->count(),
            'approved' => $user->vehicles()->where('status', 'approved')->count(),
        ],
        'adminOverview' => false,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/favorites', [FavoriteController::class, 'index'])->name('dashboard.favorites.index');
    Route::post('/favorites/{vehicle}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {
        Route::get('/vehicles', [UserVehicleController::class, 'index'])->name('dashboard.vehicles.index');
        Route::get('/vehicles/create', [UserVehicleController::class, 'create'])->name('dashboard.vehicles.create');
        Route::post('/vehicles', [UserVehicleController::class, 'store'])->name('dashboard.vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [UserVehicleController::class, 'edit'])->name('dashboard.vehicles.edit');
        Route::put('/vehicles/{vehicle}', [UserVehicleController::class, 'update'])->name('dashboard.vehicles.update');
        Route::post('/vehicles/{vehicle}/submit', [UserVehicleController::class, 'submit'])->name('dashboard.vehicles.submit');
        Route::delete('/vehicles/{vehicle}', [UserVehicleController::class, 'destroy'])->name('dashboard.vehicles.destroy');
        Route::delete('/vehicles/{vehicle}/images/{image}', [UserVehicleController::class, 'destroyImage'])->name('dashboard.vehicles.images.destroy');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        $analyticsStart = now()->subDays(89)->startOfDay();
        $analyticsEnd = now();
        $analyticsBase = SiteTrafficEvent::query()->betweenDates($analyticsStart, $analyticsEnd);

        return view('admin.dashboard', [
            'stats' => [
                'total_listings' => Vehicle::query()->count(),
                'pending_listings' => Vehicle::query()->where('status', 'pending')->count(),
                'approved_listings' => Vehicle::query()->where('status', 'approved')->count(),
                'users_count' => User::query()->count(),
            ],
            'analyticsSummary' => [
                'range_days' => 90,
                'total_views' => (clone $analyticsBase)->count(),
                'unique_sessions' => (clone $analyticsBase)->whereNotNull('session_id')->distinct('session_id')->count('session_id'),
                'top_page' => (clone $analyticsBase)->selectRaw('path, COUNT(*) as views')->groupBy('path')->orderByDesc('views')->first(),
                'top_listing' => (clone $analyticsBase)->whereNotNull('vehicle_slug')->selectRaw('vehicle_slug, COUNT(*) as views')->groupBy('vehicle_slug')->orderByDesc('views')->first(),
            ],
        ]);
    })->name('admin.dashboard');

    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/analytics/data', [AdminAnalyticsController::class, 'data'])->name('admin.analytics.data');

    Route::redirect('/vehicles', '/dashboard/vehicles')->name('admin.vehicles.index');
    Route::get('/vehicles/{vehicle}/edit', fn (Vehicle $vehicle) => redirect()->route('dashboard.vehicles.edit', $vehicle))->name('admin.vehicles.edit');

    Route::post('/vehicles/{vehicle}/approve', [AdminVehicleController::class, 'approve'])->name('admin.vehicles.approve');
    Route::post('/vehicles/{vehicle}/reject', [AdminVehicleController::class, 'reject'])->name('admin.vehicles.reject');

    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/pages', [AdminPageController::class, 'index'])->name('admin.pages.index');
    Route::get('/pages/{slug}/edit', [AdminPageController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/pages/{slug}', [AdminPageController::class, 'update'])->name('admin.pages.update');
    Route::get('/media', [AdminMediaController::class, 'index'])->name('admin.media.index');
    Route::post('/media', [AdminMediaController::class, 'upload'])->name('admin.media.upload');
    Route::get('/api/media', [AdminMediaController::class, 'list'])->name('admin.media.list');
});

require __DIR__.'/auth.php';
