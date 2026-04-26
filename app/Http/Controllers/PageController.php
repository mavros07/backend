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
            // Homepage "recent cars" should reflect newly approved/added inventory,
            // not last edited listings.
            ->orderByDesc('approved_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $filterOptions = $this->approvedVehicleFilterOptions();
        $filters = $this->defaultInventoryFilters();

        $heroCover = $recentVehicles->first()?->images->first();
        $ogImage = $heroCover ? url(VehicleImageUrl::url($heroCover->path)) : null;

        $homeSections = $this->pageSections('home', [
            'hero_title' => 'Lorem ipsum dolor sit amet',
            'hero_subtitle' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt',
            'hero_cta_text' => 'Lorem CTA',
            'hero_cta_href' => '/inventory',
            'home_search_label' => 'Lorem ipsum — search inventory',
            'recent_title' => 'Lorem dolor sit amet',
            'recent_subtitle' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Cards below are live listings.',
            'hero_image' => 'asset/images/media/home-hero-main.jpg',
            'dealer_cta_bg' => 'asset/images/media/home-cta-left.jpg',
            'dealer_cta_left_icon' => 'directions_car',
            'dealer_cta_right_icon' => 'sell',
            'cta_left_title' => 'Looking for a car?',
            'cta_left_body' => 'Our cars are delivered fully-registered with all requirements completed. We\'ll deliver your car wherever you are.',
            'cta_left_button_text' => 'Inventory',
            'cta_left_button_href' => '/inventory',
            'cta_right_title' => 'Want to sell a car?',
            'cta_right_body' => 'Receive the absolute best value for your trade-in vehicle. We even handle all paperwork. Schedule appointment!',
            'cta_right_button_text' => 'Sell your car',
            'cta_right_button_href' => '/register',
            'feat1_title' => 'Lorem ipsum',
            'feat1_body' => 'Dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.',
            'feat2_title' => 'Dolor sit amet',
            'feat2_body' => 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.',
            'feat3_title' => 'Consectetur elit',
            'feat3_body' => 'Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.',
            'welcome_title' => 'Lorem ipsum welcome block',
            'welcome_body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.',
            'welcome_video_url' => '',
            'stats_metric_1_label' => 'Listings',
            'stats_metric_2_value' => '0',
            'stats_metric_2_label' => 'Metric two',
            'stats_metric_3_value' => '0',
            'stats_metric_3_label' => 'Metric three',
            'stats_metric_4_value' => '0',
            'stats_metric_4_label' => 'Metric four',
            'stats_center_image' => 'asset/images/media/home-stats-car.jpg',
            'testimonial_bg_image' => 'asset/images/media/home-stats-bg.jpg',
            'testimonial_overlay_opacity' => '0.55',
            'testimonial_name' => 'Lorem Ipsum',
            'testimonial_role' => 'Lorem role',
            'testimonial_quote' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl varius dolor, eu consequat erat augue in eros.',
        ]);

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
            'approvedListingCount' => Vehicle::query()->where('status', 'approved')->count(),
            'sections' => $homeSections,
        ]);
    }

    public function about()
    {
        $page = CmsPage::query()->where('slug', 'about')->where('is_active', true)->firstOrFail();
        $siteName = config('app.name');
        $sections = $this->pageSections('about', [
            'kicker' => 'Our Story',
            'heading' => 'About Us',
            'intro' => $page->meta_description ?: 'Learn more about our team and story.',
            'hero_image' => 'asset/images/media/about-hero-bg.jpg',
        ]);

        return view('pages.about', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('about', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('about', [], true),
            'page' => $page,
            'sections' => $sections,
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
        $sections = $this->pageSections('faq', [
            'kicker' => 'Need Help?',
            'heading' => 'Frequently Asked Questions',
            'intro' => $page->meta_description ?: 'Answers to common questions.',
            'hero_image' => 'asset/images/media/faq-hero-bg.jpg',
        ]);

        return view('pages.faq', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('faq', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('faq', [], true),
            'page' => $page,
            'sections' => $sections,
        ]);
    }

    public function inventory(Request $request)
    {
        $page = CmsPage::query()->where('slug', 'inventory')->where('is_active', true)->first();
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
            'title' => ($page?->title ?: 'Inventory'),
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
        // CMS row is optional: do not 404 listings when `listing-detail` is missing or inactive after a DB import.
        $page = CmsPage::query()->where('slug', 'listing-detail')->where('is_active', true)->first();
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
            'title' => (($page?->title ?: $vehicle->title) . ' | ' . $siteName),
            'metaDescription' => $page?->meta_description ?: $plainDesc,
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
        $page = CmsPage::query()->where('slug', 'compare')->where('is_active', true)->first();
        $vehicles = Vehicle::query()
            ->with('images')
            ->whereIn('id', Compare::ids())
            ->get()
            ->sortBy(fn (Vehicle $v) => array_search($v->id, Compare::ids(), true))
            ->values();

        return view('pages.compare', [
            'title' => ($page?->title ?: 'Compare'),
            'vehicles' => $vehicles,
            'page' => $page,
            'sections' => $this->pageSections('compare', [
                'heading' => 'Compare Vehicles',
                'intro' => 'Compare list is dynamic and comes from visitor selections.',
            ]),
        ]);
    }
}

