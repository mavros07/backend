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
     * @return array<string, array{label: string, default_title: string, default_description: string, fields: array<int, array{name: string, label: string, type: string, default: string}>}>
     */
    protected function editablePages(): array
    {
        return [
            'home' => [
                'label' => 'Home',
                'default_title' => 'Home',
                'default_description' => 'Lorem ipsum homepage SEO and section copy (white-label defaults, like reference CMS).',
                'fields' => [
                    ['name' => 'hero_title', 'label' => 'Hero Title', 'type' => 'text', 'default' => 'Lorem ipsum dolor sit amet'],
                    ['name' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'type' => 'text', 'default' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt'],
                    ['name' => 'hero_cta_text', 'label' => 'Hero CTA Button Text', 'type' => 'text', 'default' => 'Lorem CTA'],
                    ['name' => 'hero_cta_href', 'label' => 'Hero CTA Link (path or URL)', 'type' => 'text', 'default' => '/inventory'],
                    ['name' => 'home_search_label', 'label' => 'Search Bar Label', 'type' => 'text', 'default' => 'Lorem ipsum — search inventory'],
                    ['name' => 'recent_title', 'label' => 'Featured Listings Title', 'type' => 'text', 'default' => 'Lorem dolor sit amet'],
                    ['name' => 'recent_subtitle', 'label' => 'Featured Listings Intro', 'type' => 'textarea', 'default' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Cards below are live listings.'],
                    ['name' => 'hero_image', 'label' => 'Hero Background Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-hero-main.jpg'],
                    ['name' => 'cta_left_image', 'label' => 'CTA Left Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-cta-left.jpg'],
                    ['name' => 'cta_right_image', 'label' => 'CTA Right Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-cta-right.jpg'],
                    ['name' => 'cta_left_title', 'label' => 'CTA Left Title', 'type' => 'text', 'default' => 'Lorem ipsum dolor'],
                    ['name' => 'cta_left_body', 'label' => 'CTA Left Body', 'type' => 'textarea', 'default' => 'Sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                    ['name' => 'cta_right_title', 'label' => 'CTA Right Title', 'type' => 'text', 'default' => 'Consectetur adipiscing'],
                    ['name' => 'cta_right_body', 'label' => 'CTA Right Body', 'type' => 'textarea', 'default' => 'Elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.'],
                    ['name' => 'feat1_title', 'label' => 'Feature 1 Title', 'type' => 'text', 'default' => 'Lorem ipsum'],
                    ['name' => 'feat1_body', 'label' => 'Feature 1 Body', 'type' => 'textarea', 'default' => 'Dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.'],
                    ['name' => 'feat2_title', 'label' => 'Feature 2 Title', 'type' => 'text', 'default' => 'Dolor sit amet'],
                    ['name' => 'feat2_body', 'label' => 'Feature 2 Body', 'type' => 'textarea', 'default' => 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.'],
                    ['name' => 'feat3_title', 'label' => 'Feature 3 Title', 'type' => 'text', 'default' => 'Consectetur elit'],
                    ['name' => 'feat3_body', 'label' => 'Feature 3 Body', 'type' => 'textarea', 'default' => 'Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.'],
                    ['name' => 'welcome_title', 'label' => 'Welcome Block Title', 'type' => 'text', 'default' => 'Lorem ipsum welcome block'],
                    ['name' => 'welcome_body', 'label' => 'Welcome Block Body', 'type' => 'textarea', 'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.'],
                    ['name' => 'testimonial_name', 'label' => 'Testimonial Name', 'type' => 'text', 'default' => 'Lorem Ipsum'],
                    ['name' => 'testimonial_role', 'label' => 'Testimonial Role', 'type' => 'text', 'default' => 'Lorem role'],
                    ['name' => 'testimonial_quote', 'label' => 'Testimonial Quote', 'type' => 'textarea', 'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl varius dolor, eu consequat erat augue in eros.'],
                ],
            ],
            'inventory' => [
                'label' => 'Inventory',
                'default_title' => 'Inventory',
                'default_description' => 'Inventory page heading and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Inventory Heading', 'type' => 'text', 'default' => 'Vehicles For Sale'],
                    ['name' => 'intro', 'label' => 'Inventory Intro', 'type' => 'textarea', 'default' => 'Browse approved listings. Vehicle cards are dynamic and come from the listings module.'],
                    ['name' => 'fallback_image', 'label' => 'Listing Fallback Image Path', 'type' => 'image', 'default' => 'asset/images/media/inventory-listing-fallback.jpg'],
                ],
            ],
            'contact' => [
                'label' => 'Contact',
                'default_title' => 'Contact Us',
                'default_description' => 'Contact page title and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Contact Heading', 'type' => 'text', 'default' => 'Contact Us'],
                    ['name' => 'intro', 'label' => 'Contact Intro', 'type' => 'textarea', 'default' => 'Reach our team using the form below.'],
                    ['name' => 'hero_image', 'label' => 'Contact Hero Image Path', 'type' => 'image', 'default' => 'asset/images/media/contact-hero-bg.jpg'],
                    ['name' => 'map_image', 'label' => 'Contact Map Image Path', 'type' => 'image', 'default' => 'asset/images/media/contact-map.jpg'],
                ],
            ],
            'about' => [
                'label' => 'About',
                'default_title' => 'About Us',
                'default_description' => 'About page copy and SEO metadata.',
                'fields' => [],
            ],
            'faq' => [
                'label' => 'FAQ',
                'default_title' => 'Frequently Asked Questions',
                'default_description' => 'FAQ page copy and SEO metadata.',
                'fields' => [],
            ],
            'compare' => [
                'label' => 'Compare',
                'default_title' => 'Compare Vehicles',
                'default_description' => 'Compare page heading and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Compare Heading', 'type' => 'text', 'default' => 'Compare Vehicles'],
                    ['name' => 'intro', 'label' => 'Compare Intro', 'type' => 'textarea', 'default' => 'Compare list is dynamic and comes from visitor selections.'],
                ],
            ],
            'listing-detail' => [
                'label' => 'Listing Detail',
                'default_title' => 'Vehicle Detail',
                'default_description' => 'Listing detail page heading and intro copy.',
                'fields' => [
                    ['name' => 'heading', 'label' => 'Listing Detail Heading', 'type' => 'text', 'default' => 'Vehicle Detail'],
                    ['name' => 'intro', 'label' => 'Listing Detail Intro', 'type' => 'textarea', 'default' => 'Vehicle details and gallery are dynamic from listing data.'],
                ],
            ],
        ];
    }

    /**
     * @param  array<int, array{name: string, label: string, type: string, default: string}>  $fields
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
