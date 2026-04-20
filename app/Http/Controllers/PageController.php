<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\PageSection;
use App\Models\SiteSetting;
use App\Models\Vehicle;
use App\Support\Compare;
use App\Support\VehicleImageUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * @param  array<string, string>  $defaults
     * @return array<string, string>
     */
    protected function pageSections(string $slug, array $defaults): array
    {
        $stored = PageSection::query()
            ->where('page', $slug)
            ->pluck('content', 'section_key');
        $out = [];
        foreach ($defaults as $key => $default) {
            $out[$key] = (string) ($stored[$key] ?? SiteSetting::getValue('page_'.$slug.'_'.$key, $default) ?? $default);
        }

        return $out;
    }

    public function home()
    {
        $page = CmsPage::query()->where('slug', 'home')->where('is_active', true)->firstOrFail();
        $siteName = config('app.name');
        $recentVehicles = Vehicle::query()
            ->with('images')
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        $filterOptions = $this->approvedVehicleFilterOptions();
        $filters = $this->defaultInventoryFilters();

        $heroCover = $recentVehicles->first()?->images->first();
        $ogImage = $heroCover ? url(VehicleImageUrl::url($heroCover->path)) : null;

        return view('pages.home-luxemotive', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('home', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('home', [], true),
            'ogImage' => $ogImage,
            'page' => $page,
            'heroVehicle' => $recentVehicles->first(),
            'recentVehicles' => $recentVehicles,
            'filterOptions' => $filterOptions,
            'filters' => $filters,
            'dealerPhone' => SiteSetting::getValue('dealer_phone', '+1 878-9674-4455'),
            'sections' => $this->pageSections('home', [
                'hero_title' => 'Mercedes-Benz AMG GT 2017',
                'hero_subtitle' => '$320 /mo for 36 months',
                'recent_title' => 'Recent Cars',
                'recent_subtitle' => 'Curabitur tellus leo, euismod sit amet gravida at, egestas sed commodo.',
                'hero_image' => 'asset/images/media/home-hero-main.jpg',
                'cta_left_image' => 'asset/images/media/home-cta-left.jpg',
                'cta_right_image' => 'asset/images/media/home-cta-right.jpg',
            ]),
        ]);
    }

    public function about()
    {
        $page = CmsPage::query()->where('slug', 'about')->where('is_active', true)->firstOrFail();
        $siteName = config('app.name');

        return view('pages.about', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('about', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('about', [], true),
            'page' => $page,
        ]);
    }

    public function contact()
    {
        $page = CmsPage::query()->where('slug', 'contact')->where('is_active', true)->firstOrFail();
        $siteName = config('app.name');

        return view('pages.contact', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('contact', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('contact', [], true),
            'page' => $page,
            'sections' => $this->pageSections('contact', [
                'heading' => 'Contact Us',
                'intro' => 'Reach our team using the form below.',
                'hero_image' => 'asset/images/media/contact-hero-bg.jpg',
                'map_image' => 'asset/images/media/contact-map.jpg',
            ]),
        ]);
    }

    public function faq()
    {
        $page = CmsPage::query()->where('slug', 'faq')->where('is_active', true)->firstOrFail();
        $siteName = config('app.name');

        return view('pages.faq', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('faq', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('faq', [], true),
            'page' => $page,
        ]);
    }

    public function inventory(Request $request)
    {
        $page = CmsPage::query()->where('slug', 'inventory')->where('is_active', true)->firstOrFail();
        $yearUpper = (int) date('Y') + 1;

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string', Rule::in(['', 'new', 'used'])],
            'location' => ['nullable', 'string', 'max:255'],
            'make' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'fuel_type' => ['nullable', 'string', 'max:255'],
            'transmission' => ['nullable', 'string', 'max:255'],
            'body_type' => ['nullable', 'string', 'max:255'],
            'year_min' => ['nullable', 'integer', 'min:1900', 'max:'.$yearUpper],
            'year_max' => ['nullable', 'integer', 'min:1900', 'max:'.$yearUpper],
            'price_min' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'price_max' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'sort' => ['nullable', 'string', Rule::in(['newest', 'price_low', 'price_high', 'year_new', 'year_old'])],
        ]);

        $query = Vehicle::query()
            ->with('images')
            ->where('status', 'approved')
            ->latest();

        $search = isset($filters['q']) ? trim((string) $filters['q']) : '';
        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('make', 'like', '%' . $search . '%')
                    ->orWhere('model', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $condition = isset($filters['condition']) ? trim((string) $filters['condition']) : '';
        if ($condition !== '') {
            $query->where('condition', $condition);
        }

        $location = isset($filters['location']) ? trim((string) $filters['location']) : '';
        if ($location !== '') {
            $query->where('location', $location);
        }

        foreach (['make', 'model', 'fuel_type', 'transmission', 'body_type'] as $field) {
            $value = isset($filters[$field]) ? trim((string) $filters[$field]) : '';
            if ($value !== '') {
                $query->where($field, $value);
            }
        }

        $yearMin = (int) ($filters['year_min'] ?? 0);
        if ($yearMin > 0) {
            $query->where('year', '>=', $yearMin);
        }

        $yearMax = (int) ($filters['year_max'] ?? 0);
        if ($yearMax > 0) {
            $query->where('year', '<=', $yearMax);
        }

        $priceMin = (int) ($filters['price_min'] ?? 0);
        if ($priceMin > 0) {
            $query->where('price', '>=', $priceMin);
        }

        $priceMax = (int) ($filters['price_max'] ?? 0);
        if ($priceMax > 0) {
            $query->where('price', '<=', $priceMax);
        }

        $sort = (string) ($filters['sort'] ?? 'newest');
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'year_new' => $query->orderByDesc('year'),
            'year_old' => $query->orderBy('year'),
            default => $query->latest(),
        };

        $vehicles = $query->paginate(9)->withQueryString();

        return view('pages.inventory.index', [
            'title' => ($page->title ?: 'Inventory'),
            'vehicles' => $vehicles,
            'filters' => array_merge($this->defaultInventoryFilters(), $filters),
            'filterOptions' => $this->approvedVehicleFilterOptions(),
            'page' => $page,
            'sections' => $this->pageSections('inventory', [
                'heading' => 'Vehicles For Sale',
                'intro' => 'Browse approved listings. Vehicle cards are dynamic and come from the listings module.',
                'fallback_image' => 'asset/images/media/inventory-listing-fallback.jpg',
            ]),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultInventoryFilters(): array
    {
        return [
            'q' => '',
            'make' => '',
            'model' => '',
            'fuel_type' => '',
            'transmission' => '',
            'body_type' => '',
            'condition' => '',
            'location' => '',
            'year_min' => '',
            'year_max' => '',
            'price_min' => '',
            'price_max' => '',
            'sort' => 'newest',
        ];
    }

    /**
     * Distinct filter values from approved listings (same logic as inventory page).
     *
     * @return array<string, \Illuminate\Support\Collection>
     */
    protected function approvedVehicleFilterOptions(): array
    {
        $optionQuery = Vehicle::query()->where('status', 'approved');

        return [
            'makes' => (clone $optionQuery)->whereNotNull('make')->where('make', '!=', '')->distinct()->orderBy('make')->pluck('make'),
            'models' => (clone $optionQuery)->whereNotNull('model')->where('model', '!=', '')->distinct()->orderBy('model')->pluck('model'),
            'fuel_types' => (clone $optionQuery)->whereNotNull('fuel_type')->where('fuel_type', '!=', '')->distinct()->orderBy('fuel_type')->pluck('fuel_type'),
            'transmissions' => (clone $optionQuery)->whereNotNull('transmission')->where('transmission', '!=', '')->distinct()->orderBy('transmission')->pluck('transmission'),
            'body_types' => (clone $optionQuery)->whereNotNull('body_type')->where('body_type', '!=', '')->distinct()->orderBy('body_type')->pluck('body_type'),
            'locations' => (clone $optionQuery)->whereNotNull('location')->where('location', '!=', '')->distinct()->orderBy('location')->pluck('location'),
        ];
    }

    public function vehicleShow(Request $request, string $slug = '2021-bmw-m4-competition')
    {
        $page = CmsPage::query()->where('slug', 'listing-detail')->where('is_active', true)->firstOrFail();
        $user = $request->user();

        $vehicle = Vehicle::query()
            ->with('images')
            ->where('slug', $slug)
            ->when(!($user && $user->hasRole('admin')), function ($query) use ($user) {
                $query->where(function ($visibility) use ($user) {
                    $visibility->where('status', 'approved');

                    if ($user) {
                        $visibility->orWhere('user_id', $user->id);
                    }
                });
            })
            ->firstOrFail();

        $siteName = config('app.name');
        $plainDesc = $vehicle->description
            ? Str::limit(strip_tags($vehicle->description), 160)
            : Str::limit(trim(($vehicle->title ?? '') . ' ' . ($vehicle->make ?? '') . ' ' . ($vehicle->model ?? '')), 160);

        $cover = $vehicle->images->first();
        $listingUrl = route('inventory.show', ['slug' => $vehicle->slug], true);
        $ogImage = $cover ? url(VehicleImageUrl::url($cover->path)) : null;

        $isFavorited = $user && $user->favoriteVehicles()->whereKey($vehicle->id)->exists();

        return view('pages.inventory.show', [
            'title' => (($page->title ?: $vehicle->title) . ' | ' . $siteName),
            'metaDescription' => $plainDesc,
            'canonicalUrl' => $listingUrl,
            'ogTitle' => $vehicle->title,
            'ogDescription' => $plainDesc,
            'ogUrl' => $listingUrl,
            'ogImage' => $ogImage,
            'slug' => $slug,
            'vehicle' => $vehicle,
            'isFavorited' => $isFavorited,
            'page' => $page,
            'sections' => $this->pageSections('listing-detail', [
                'heading' => 'Vehicle Detail',
                'intro' => 'Vehicle details and gallery are dynamic from listing data.',
            ]),
        ]);
    }

    public function compare()
    {
        $page = CmsPage::query()->where('slug', 'compare')->where('is_active', true)->firstOrFail();
        $vehicles = Vehicle::query()
            ->with('images')
            ->whereIn('id', Compare::ids())
            ->get()
            ->sortBy(fn (Vehicle $v) => array_search($v->id, Compare::ids(), true))
            ->values();

        return view('pages.compare', [
            'title' => ($page->title ?: 'Compare'),
            'vehicles' => $vehicles,
            'page' => $page,
            'sections' => $this->pageSections('compare', [
                'heading' => 'Compare Vehicles',
                'intro' => 'Compare list is dynamic and comes from visitor selections.',
            ]),
        ]);
    }
}

