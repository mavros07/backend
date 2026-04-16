<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\Vehicle;
use App\Support\Compare;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function home()
    {
        $page = CmsPage::query()->where('slug', 'home')->firstOrFail();
        $siteName = config('app.name');

        $filterOptions = $this->approvedVehicleFilterOptions();
        $filters = $this->defaultInventoryFilters();

        return view('pages.home', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('home', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('home', [], true),
            'vendorCss' => 'assets/css/vendor-autoptimize.css',
            'bodyClass' => 'page-template-default page page-id-6123 theme-motors stm-hoverable-interactive-galleries stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-6123',
            'page' => $page,
            'homeInventorySearchHtml' => view('pages.partials.home-inventory-search', [
                'filterOptions' => $filterOptions,
                'filters' => $filters,
            ])->render(),
        ]);
    }

    public function about()
    {
        $page = CmsPage::query()->where('slug', 'about')->firstOrFail();
        $siteName = config('app.name');

        return view('pages.about', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('about', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('about', [], true),
            'vendorCss' => 'assets/css/vendor-autoptimize-about-us.css',
            'bodyClass' => 'page-template-default page page-id-4205 theme-motors stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-4205',
            'page' => $page,
        ]);
    }

    public function contact()
    {
        $page = CmsPage::query()->where('slug', 'contact')->firstOrFail();
        $siteName = config('app.name');

        return view('pages.contact', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('contact', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('contact', [], true),
            'vendorCss' => 'assets/css/vendor-autoptimize-contact-us.css',
            'bodyClass' => 'page-template-default page page-id-4430 theme-motors stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-4430',
            'page' => $page,
        ]);
    }

    public function faq()
    {
        $page = CmsPage::query()->where('slug', 'faq')->firstOrFail();
        $siteName = config('app.name');

        return view('pages.faq', [
            'title' => $page->title . ' | ' . $siteName,
            'metaDescription' => $page->meta_description,
            'canonicalUrl' => route('faq', [], true),
            'ogTitle' => $page->title,
            'ogDescription' => $page->meta_description,
            'ogUrl' => route('faq', [], true),
            'vendorCss' => 'assets/css/vendor-autoptimize-faq.css',
            'bodyClass' => 'page-template-default page page-id-4431 theme-motors stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-4431',
            'page' => $page,
        ]);
    }

    public function inventory(Request $request)
    {
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
            'title' => 'Inventory',
            'vendorCss' => 'assets/css/vendor-autoptimize-inventory.css',
            'bodyClass' => 'page-template-default page page-id-1058 theme-motors stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-1058',
            'vehicles' => $vehicles,
            'filters' => array_merge($this->defaultInventoryFilters(), $filters),
            'filterOptions' => $this->approvedVehicleFilterOptions(),
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

    public function vehicleShow(Request $request, string $slug = '2016-mercedes-benz-c-class-c300-4matic')
    {
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
        $ogImage = $cover ? url(asset($cover->path)) : null;

        $isFavorited = $user && $user->favoriteVehicles()->whereKey($vehicle->id)->exists();

        return view('pages.inventory.show', [
            'title' => $vehicle->title . ' | ' . $siteName,
            'metaDescription' => $plainDesc,
            'canonicalUrl' => $listingUrl,
            'ogTitle' => $vehicle->title,
            'ogDescription' => $plainDesc,
            'ogUrl' => $listingUrl,
            'ogImage' => $ogImage,
            'vendorCss' => 'assets/css/vendor-autoptimize-listing-2016-mercedes-benz-c-class-c300-4matic.css',
            'bodyClass' => 'stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two single single-listings postid-3191 theme-motors stm-hoverable-interactive-galleries stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-layout-listing stm-inventory-page stm-inventory-detail-page has-breadcrumb_navxt elementor-default elementor-kit-3904',
            'slug' => $slug,
            'vehicle' => $vehicle,
            'isFavorited' => $isFavorited,
        ]);
    }

    public function compare()
    {
        $vehicles = Vehicle::query()
            ->with('images')
            ->whereIn('id', Compare::ids())
            ->get()
            ->sortBy(fn (Vehicle $v) => array_search($v->id, Compare::ids(), true))
            ->values();

        return view('pages.compare', [
            'title' => 'Compare',
            'vendorCss' => 'assets/css/vendor-autoptimize-compare.css',
            'bodyClass' => 'page-template-default page page-id-4296 theme-motors stm-user-not-logged-in woocommerce-no-js no_margin title-box-hide breadcrumbs-hide stm-template-car_dealer_two_elementor stm-layout-header-car_dealer_two has-breadcrumb_navxt elementor-default elementor-kit-3904 elementor-page elementor-page-4296',
            'vehicles' => $vehicles,
        ]);
    }
}

