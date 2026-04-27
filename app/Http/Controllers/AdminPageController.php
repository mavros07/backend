<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    /**
     * @return array<string, array{label: string, default_title: string, default_description: string, fields: array<int, array{name: string, label: string, type: string, default: string, group?: string}>}>
     */
    protected function editablePages(): array
    {
        return [
            'home' => [
                'label' => 'Home',
                'default_title' => 'Home',
                'default_description' => 'Lorem ipsum homepage SEO and section copy (white-label defaults, like reference CMS).',
                'fields' => [
                    ['name' => 'hero_title', 'label' => 'Hero Title', 'type' => 'text', 'default' => 'Lorem ipsum dolor sit amet', 'group' => 'Hero & search'],
                    ['name' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'type' => 'text', 'default' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt', 'group' => 'Hero & search'],
                    ['name' => 'hero_cta_text', 'label' => 'Hero CTA Button Text', 'type' => 'text', 'default' => 'Lorem CTA', 'group' => 'Hero & search'],
                    ['name' => 'hero_cta_href', 'label' => 'Hero CTA Link (path or URL)', 'type' => 'text', 'default' => '/inventory', 'group' => 'Hero & search'],
                    ['name' => 'home_search_label', 'label' => 'Search Bar Label', 'type' => 'text', 'default' => 'Lorem ipsum — search inventory', 'group' => 'Hero & search'],
                    ['name' => 'hero_image', 'label' => 'Hero Background Image', 'type' => 'image', 'default' => 'asset/images/media/home-hero-main.jpg', 'group' => 'Hero & search'],
                    ['name' => 'recent_title', 'label' => 'Featured Listings Title', 'type' => 'text', 'default' => 'Lorem dolor sit amet', 'group' => 'Featured listings'],
                    ['name' => 'recent_subtitle', 'label' => 'Featured Listings Intro', 'type' => 'textarea', 'default' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Cards below are live listings.', 'group' => 'Featured listings'],
                    ['name' => 'dealer_cta_bg', 'label' => 'Dealer CTA section background', 'type' => 'image', 'default' => 'asset/images/media/home-cta-left.jpg', 'group' => 'Dealer CTA'],
                    ['name' => 'dealer_cta_left_icon', 'label' => 'Left card Material icon name', 'type' => 'text', 'default' => 'directions_car', 'group' => 'Dealer CTA'],
                    ['name' => 'dealer_cta_right_icon', 'label' => 'Right card Material icon name', 'type' => 'text', 'default' => 'sell', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_left_title', 'label' => 'Left card title', 'type' => 'text', 'default' => 'Looking for a car?', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_left_body', 'label' => 'Left card body', 'type' => 'textarea', 'default' => 'Our cars are delivered fully-registered with all requirements completed. We\'ll deliver your car wherever you are.', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_left_button_text', 'label' => 'Left button text', 'type' => 'text', 'default' => 'Inventory', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_left_button_href', 'label' => 'Left button link (path or URL)', 'type' => 'text', 'default' => '/inventory', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_right_title', 'label' => 'Right card title', 'type' => 'text', 'default' => 'Want to sell a car?', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_right_body', 'label' => 'Right card body', 'type' => 'textarea', 'default' => 'Receive the absolute best value for your trade-in vehicle. We even handle all paperwork. Schedule appointment!', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_right_button_text', 'label' => 'Right button text', 'type' => 'text', 'default' => 'Sell your car', 'group' => 'Dealer CTA'],
                    ['name' => 'cta_right_button_href', 'label' => 'Right button link (path or URL)', 'type' => 'text', 'default' => '/register', 'group' => 'Dealer CTA'],
                    ['name' => 'feat1_title', 'label' => 'Feature 1 Title', 'type' => 'text', 'default' => 'Lorem ipsum', 'group' => 'Feature highlights'],
                    ['name' => 'feat1_body', 'label' => 'Feature 1 Body', 'type' => 'textarea', 'default' => 'Dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.', 'group' => 'Feature highlights'],
                    ['name' => 'feat2_title', 'label' => 'Feature 2 Title', 'type' => 'text', 'default' => 'Dolor sit amet', 'group' => 'Feature highlights'],
                    ['name' => 'feat2_body', 'label' => 'Feature 2 Body', 'type' => 'textarea', 'default' => 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.', 'group' => 'Feature highlights'],
                    ['name' => 'feat3_title', 'label' => 'Feature 3 Title', 'type' => 'text', 'default' => 'Consectetur elit', 'group' => 'Feature highlights'],
                    ['name' => 'feat3_body', 'label' => 'Feature 3 Body', 'type' => 'textarea', 'default' => 'Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.', 'group' => 'Feature highlights'],
                    ['name' => 'welcome_title', 'label' => 'Welcome Block Title', 'type' => 'text', 'default' => 'Lorem ipsum welcome block', 'group' => 'Welcome block'],
                    ['name' => 'welcome_body', 'label' => 'Welcome Block Body', 'type' => 'textarea', 'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.', 'group' => 'Welcome block'],
                    ['name' => 'welcome_video_url', 'label' => 'Welcome video (YouTube URL or ID)', 'type' => 'text', 'default' => '', 'group' => 'Welcome block'],
                    ['name' => 'stats_metric_1_label', 'label' => 'Stat 1 label (count is live approved listings)', 'type' => 'text', 'default' => 'Listings', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_2_value', 'label' => 'Stat 2 number', 'type' => 'text', 'default' => '0', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_2_label', 'label' => 'Stat 2 label', 'type' => 'text', 'default' => 'Metric two', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_3_value', 'label' => 'Stat 3 number', 'type' => 'text', 'default' => '0', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_3_label', 'label' => 'Stat 3 label', 'type' => 'text', 'default' => 'Metric three', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_4_value', 'label' => 'Stat 4 number', 'type' => 'text', 'default' => '0', 'group' => 'Statistics block'],
                    ['name' => 'stats_metric_4_label', 'label' => 'Stat 4 label', 'type' => 'text', 'default' => 'Metric four', 'group' => 'Statistics block'],
                    ['name' => 'stats_center_image', 'label' => 'Statistics block center image', 'type' => 'image', 'default' => 'asset/images/media/home-stats-car.jpg', 'group' => 'Statistics block', 'preview' => 'thumbnail'],
                    ['name' => 'testimonial_bg_image', 'label' => 'Testimonial background image', 'type' => 'image', 'default' => 'asset/images/media/home-stats-bg.jpg', 'group' => 'Testimonial'],
                    ['name' => 'testimonial_overlay_opacity', 'label' => 'Testimonial overlay darkness (0–1, e.g. 0.55)', 'type' => 'text', 'default' => '0.55', 'group' => 'Testimonial'],
                    ['name' => 'testimonial_name', 'label' => 'Testimonial Name', 'type' => 'text', 'default' => 'Lorem Ipsum', 'group' => 'Testimonial'],
                    ['name' => 'testimonial_role', 'label' => 'Testimonial Role', 'type' => 'text', 'default' => 'Lorem role', 'group' => 'Testimonial'],
                    ['name' => 'testimonial_avatar', 'label' => 'Testimonial headshot', 'type' => 'image', 'default' => 'asset/images/media/home-testimonial-avatar.jpg', 'group' => 'Testimonial', 'preview' => 'thumbnail'],
                    ['name' => 'testimonial_quote', 'label' => 'Testimonial Quote', 'type' => 'textarea', 'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl varius dolor, eu consequat erat augue in eros.', 'group' => 'Testimonial'],
                ],
            ],
            'inventory' => [
                'label' => 'Inventory',
                'default_title' => 'Inventory',
                'default_description' => 'Inventory page heading and SEO. Listing cards are always loaded from approved vehicles.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Inventory Heading', 'type' => 'text', 'default' => 'Vehicles For Sale', 'group' => 'Page header'],
                    ['name' => 'fallback_image', 'label' => 'Listing Card Fallback Image', 'type' => 'image', 'default' => 'asset/images/media/inventory-listing-fallback.jpg', 'group' => 'Media'],
                ],
            ],
            'contact' => [
                'label' => 'Contact',
                'default_title' => 'Contact Us',
                'default_description' => 'Contact page title and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Contact Heading', 'type' => 'text', 'default' => 'Contact Us', 'group' => 'Page intro'],
                    ['name' => 'intro', 'label' => 'Contact Intro', 'type' => 'textarea', 'default' => 'Reach our team using the form below.', 'group' => 'Page intro'],
                    ['name' => 'hero_image', 'label' => 'Hero / Header Image', 'type' => 'image', 'default' => 'asset/images/media/contact-hero-bg.jpg', 'group' => 'Media'],
                    ['name' => 'map_image', 'label' => 'Map Image', 'type' => 'image', 'default' => 'asset/images/media/contact-map.jpg', 'group' => 'Media'],
                ],
            ],
            'about' => [
                'label' => 'About',
                'default_title' => 'About Us',
                'default_description' => 'About page copy and SEO metadata.',
                'fields' => [
                    ['name' => 'kicker', 'label' => 'Header Kicker', 'type' => 'text', 'default' => 'Our Story', 'group' => 'Page hero'],
                    ['name' => 'heading', 'label' => 'Header Title', 'type' => 'text', 'default' => 'About Us', 'group' => 'Page hero'],
                    ['name' => 'intro', 'label' => 'Header Intro', 'type' => 'textarea', 'default' => 'Learn more about our team and story.', 'group' => 'Page hero'],
                    ['name' => 'hero_image', 'label' => 'Hero Background Image', 'type' => 'image', 'default' => 'asset/images/media/about-hero-bg.jpg', 'group' => 'Media'],
                ],
            ],
            'faq' => [
                'label' => 'FAQ',
                'default_title' => 'Frequently Asked Questions',
                'default_description' => 'FAQ page copy and SEO metadata.',
                'fields' => [
                    ['name' => 'kicker', 'label' => 'Header Kicker', 'type' => 'text', 'default' => 'Need Help?', 'group' => 'Page hero'],
                    ['name' => 'heading', 'label' => 'Header Title', 'type' => 'text', 'default' => 'Frequently Asked Questions', 'group' => 'Page hero'],
                    ['name' => 'intro', 'label' => 'Header Intro', 'type' => 'textarea', 'default' => 'Answers to common questions.', 'group' => 'Page hero'],
                    ['name' => 'hero_image', 'label' => 'Hero Background Image', 'type' => 'image', 'default' => 'asset/images/media/faq-hero-bg.jpg', 'group' => 'Media'],
                ],
            ],
            'compare' => [
                'label' => 'Compare',
                'default_title' => 'Compare Vehicles',
                'default_description' => 'Compare page heading and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Compare Heading', 'type' => 'text', 'default' => 'Compare Vehicles', 'group' => 'Page intro'],
                    ['name' => 'intro', 'label' => 'Compare Intro', 'type' => 'textarea', 'default' => 'Compare list is dynamic and comes from visitor selections.', 'group' => 'Page intro'],
                ],
            ],
            'listing-detail' => [
                'label' => 'Listing Detail',
                'default_title' => 'Vehicle Detail',
                'default_description' => 'Listing detail page heading and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Listing Detail Heading', 'type' => 'text', 'default' => 'Vehicle Detail', 'group' => 'Page intro'],
                    ['name' => 'intro', 'label' => 'Listing Detail Intro', 'type' => 'textarea', 'default' => 'Vehicle details and gallery are dynamic from listing data.', 'group' => 'Page intro'],
                ],
            ],
        ];
    }

    /**
     * @param  array<int, array{name: string, label: string, type: string, default: string, group?: string}>  $fields
     * @return array<string, string>
     */
    protected function sectionValues(string $slug, array $fields): array
    {
        $stored = PageSection::query()
            ->where('page', $slug)
            ->pluck('content', 'section_key');
        $out = [];

        foreach ($fields as $field) {
            $out[$field['name']] = (string) ($stored[$field['name']] ?? $field['default']);
        }

        return $out;
    }

    public function index(): View
    {
        $editable = $this->editablePages();
        $existing = CmsPage::query()
            ->whereIn('slug', array_keys($editable))
            ->get(['slug', 'updated_at', 'is_active'])
            ->keyBy('slug');

        return view('admin.pages.index', [
            'pages' => $editable,
            'existing' => $existing,
        ]);
    }

    public function edit(string $slug): View
    {
        $editable = $this->editablePages();
        abort_unless(isset($editable[$slug]), 404);

        $defaults = $editable[$slug];
        $page = CmsPage::query()->firstOrCreate(
            ['slug' => $slug],
            [
                'title' => $defaults['default_title'],
                'meta_description' => $defaults['default_description'],
                'content_html' => '',
                'is_active' => true,
            ]
        );

        return view('admin.pages.edit', [
            'slug' => $slug,
            'pageInfo' => $defaults,
            'page' => $page,
            'sectionValues' => $this->sectionValues($slug, $defaults['fields']),
        ]);
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        $editable = $this->editablePages();
        abort_unless(isset($editable[$slug]), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'content_html' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        CmsPage::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $data['title'],
                'meta_description' => $data['meta_description'] ?? null,
                'content_html' => $data['content_html'] ?? '',
                'is_active' => (bool) ($data['is_active'] ?? false),
            ]
        );

        foreach ($editable[$slug]['fields'] as $field) {
            $name = $field['name'];
            $value = $request->input('sections.'.$name, $field['default']);
            PageSection::query()->updateOrCreate(
                [
                    'page' => $slug,
                    'section_key' => $name,
                ],
                [
                    'content_type' => $field['type'],
                    'content' => is_string($value) ? $value : (string) $value,
                ]
            );
        }

        return redirect()
            ->route('admin.pages.edit', ['slug' => $slug])
            ->with('status', 'Page updated successfully.');
    }
}
