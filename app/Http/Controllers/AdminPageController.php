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
                'default_description' => 'Homepage content and SEO settings.',
                'fields' => [
                    ['name' => 'hero_title', 'label' => 'Hero Title', 'type' => 'text', 'default' => 'Mercedes-Benz AMG GT 2017'],
                    ['name' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'type' => 'text', 'default' => '$320 /mo for 36 months'],
                    ['name' => 'recent_title', 'label' => 'Recent Cars Title', 'type' => 'text', 'default' => 'Recent Cars'],
                    ['name' => 'recent_subtitle', 'label' => 'Recent Cars Subtitle', 'type' => 'textarea', 'default' => 'Curabitur tellus leo, euismod sit amet gravida at, egestas sed commodo.'],
                    ['name' => 'hero_image', 'label' => 'Hero Background Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-hero-main.jpg'],
                    ['name' => 'cta_left_image', 'label' => 'CTA Left Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-cta-left.jpg'],
                    ['name' => 'cta_right_image', 'label' => 'CTA Right Image Path', 'type' => 'image', 'default' => 'asset/images/media/home-cta-right.jpg'],
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
