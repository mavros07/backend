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
                'default_description' => 'About page SEO and section content',
                'fields' => [
                    ['name' => 'hero_image', 'label' => 'Hero Background Image', 'type' => 'image', 'default' => 'asset/images/media/about-hero-bg.jpg', 'group' => 'Hero'],
                    ['name' => 'established_year', 'label' => 'Established Year Text', 'type' => 'text', 'default' => '1999', 'group' => 'Hero'],
                    ['name' => 'hero_stat_value', 'label' => 'Hero Stat Value (e.g. 25+)', 'type' => 'text', 'default' => '25+', 'group' => 'Hero'],
                    ['name' => 'hero_stat_label', 'label' => 'Hero Stat Label (e.g. Years of Excellence)', 'type' => 'text', 'default' => 'Years of Excellence', 'group' => 'Hero'],
                    ['name' => 'heading', 'label' => 'Hero Heading', 'type' => 'text', 'default' => 'WELCOME TO THE MOTORS', 'group' => 'Hero'],
                    ['name' => 'intro', 'label' => 'Hero Paragraph', 'type' => 'textarea', 'default' => 'Experience the pinnacle of automotive engineering and white-glove service. We curate the world\'s most exceptional vehicles for the discerning driver who demands nothing less than absolute mechanical perfection.', 'group' => 'Hero'],
                    ['name' => 'hero_primary_cta_text', 'label' => 'Hero Button Text', 'type' => 'text', 'default' => 'Learn Our History', 'group' => 'Hero'],
                    ['name' => 'hero_primary_cta_href', 'label' => 'Hero Button Link', 'type' => 'text', 'default' => '/about', 'group' => 'Hero'],

                    ['name' => 'values_title', 'label' => 'Core Values Heading', 'type' => 'text', 'default' => 'CORE VALUES', 'group' => 'Core values'],
                    ['name' => 'val_1_title', 'label' => 'Value 1 Title', 'type' => 'text', 'default' => 'Integrity First', 'group' => 'Core values'],
                    ['name' => 'val_1_body', 'label' => 'Value 1 Body', 'type' => 'textarea', 'default' => 'Transparent pricing and rigorous history checks for every vehicle in our showroom.', 'group' => 'Core values'],
                    ['name' => 'val_2_title', 'label' => 'Value 2 Title', 'type' => 'text', 'default' => 'Mechanical Excellence', 'group' => 'Core values'],
                    ['name' => 'val_2_body', 'label' => 'Value 2 Body', 'type' => 'textarea', 'default' => 'Our master technicians conduct a 200-point inspection ensuring performance meets factory standards.', 'group' => 'Core values'],
                    ['name' => 'val_3_title', 'label' => 'Value 3 Title', 'type' => 'text', 'default' => 'Client Concierge', 'group' => 'Core values'],
                    ['name' => 'val_3_body', 'label' => 'Value 3 Body', 'type' => 'textarea', 'default' => 'Dedicated advisors providing personalized acquisition strategies and lifelong maintenance support.', 'group' => 'Core values'],
                    ['name' => 'values_grid_1', 'label' => 'Values Grid Image 1', 'type' => 'image', 'default' => 'asset/images/media/about-values-1.jpg', 'group' => 'Core values'],
                    ['name' => 'values_grid_2', 'label' => 'Values Grid Image 2', 'type' => 'image', 'default' => 'asset/images/media/about-values-2.jpg', 'group' => 'Core values'],
                    ['name' => 'values_grid_3', 'label' => 'Values Grid Image 3', 'type' => 'image', 'default' => 'asset/images/media/about-values-3.jpg', 'group' => 'Core values'],
                    ['name' => 'values_grid_4', 'label' => 'Values Grid Image 4', 'type' => 'image', 'default' => 'asset/images/media/about-values-4.jpg', 'group' => 'Core values'],

                    ['name' => 'gallery_title', 'label' => 'Gallery title', 'type' => 'text', 'default' => 'Media Gallery', 'group' => 'Gallery'],
                    ['name' => 'gallery_image_1', 'label' => 'Gallery image 1', 'type' => 'image', 'default' => 'asset/images/media/about-gallery-1.jpg', 'group' => 'Gallery', 'preview' => 'thumbnail'],
                    ['name' => 'gallery_image_2', 'label' => 'Gallery image 2', 'type' => 'image', 'default' => 'asset/images/media/about-gallery-2.jpg', 'group' => 'Gallery', 'preview' => 'thumbnail'],
                    ['name' => 'gallery_image_3', 'label' => 'Gallery image 3', 'type' => 'image', 'default' => 'asset/images/media/about-gallery-3.jpg', 'group' => 'Gallery', 'preview' => 'thumbnail'],
                    ['name' => 'gallery_image_4', 'label' => 'Gallery image 4', 'type' => 'image', 'default' => 'asset/images/media/about-gallery-4.jpg', 'group' => 'Gallery', 'preview' => 'thumbnail'],

                    ['name' => 'advantages_title', 'label' => 'Quick Links title', 'type' => 'text', 'default' => 'Quick Links', 'group' => 'Quick Links'],
                    ['name' => 'adv_1_icon', 'label' => 'Card 1 Icon', 'type' => 'text', 'default' => 'sell', 'group' => 'Quick Links'],
                    ['name' => 'adv_1_title', 'label' => 'Card 1 Title', 'type' => 'text', 'default' => 'Do you want to sell a car?', 'group' => 'Quick Links'],
                    ['name' => 'adv_1_body', 'label' => 'Card 1 Body', 'type' => 'textarea', 'default' => 'Get a competitive appraisal and same-day payment from our acquisition team.', 'group' => 'Quick Links'],
                    ['name' => 'adv_1_href', 'label' => 'Card 1 Link', 'type' => 'text', 'default' => '/sell', 'group' => 'Quick Links'],
                    ['name' => 'adv_2_icon', 'label' => 'Card 2 Icon', 'type' => 'text', 'default' => 'directions_car', 'group' => 'Quick Links'],
                    ['name' => 'adv_2_title', 'label' => 'Card 2 Title', 'type' => 'text', 'default' => 'Looking for a new car?', 'group' => 'Quick Links'],
                    ['name' => 'adv_2_body', 'label' => 'Card 2 Body', 'type' => 'textarea', 'default' => 'Browse our curated collection of premium inventory and certified pre-owned units.', 'group' => 'Quick Links'],
                    ['name' => 'adv_2_href', 'label' => 'Card 2 Link', 'type' => 'text', 'default' => '/inventory', 'group' => 'Quick Links'],
                    ['name' => 'adv_3_icon', 'label' => 'Card 3 Icon', 'type' => 'text', 'default' => 'build', 'group' => 'Quick Links'],
                    ['name' => 'adv_3_title', 'label' => 'Card 3 Title', 'type' => 'text', 'default' => 'Schedule a service?', 'group' => 'Quick Links'],
                    ['name' => 'adv_3_body', 'label' => 'Card 3 Body', 'type' => 'textarea', 'default' => 'Book an appointment with our specialist mechanics for maintenance or tuning.', 'group' => 'Quick Links'],
                    ['name' => 'adv_3_href', 'label' => 'Card 3 Link', 'type' => 'text', 'default' => '/service', 'group' => 'Quick Links'],

                    ['name' => 'testimonials_title', 'label' => 'Testimonials title', 'type' => 'text', 'default' => 'Customer Testimonials', 'group' => 'Testimonials'],
                    ['name' => 'testimonial_1_body', 'label' => 'Featured Testimonial Quote', 'type' => 'textarea', 'default' => 'The acquisition process for my vintage collection was handled with unparalleled professionalism. Velocity Motors doesn\'t just sell cars; they curate legacies.', 'group' => 'Testimonials'],
                    ['name' => 'testimonial_1_author', 'label' => 'Testimonial Author', 'type' => 'text', 'default' => 'John Doe', 'group' => 'Testimonials'],
                    ['name' => 'testimonial_1_brand', 'label' => 'Testimonial Author Role/Location', 'type' => 'text', 'default' => 'Private Collector, London', 'group' => 'Testimonials'],

                    ['name' => 'team_title', 'label' => 'Team title', 'type' => 'text', 'default' => 'Our Team', 'group' => 'Team'],
                    ['name' => 'team_1_photo', 'label' => 'Team member 1 photo', 'type' => 'image', 'default' => 'asset/images/media/team-1.jpg', 'group' => 'Team'],
                    ['name' => 'team_1_name', 'label' => 'Team member 1 name', 'type' => 'text', 'default' => 'Lennox Wardell', 'group' => 'Team'],
                    ['name' => 'team_1_role', 'label' => 'Team member 1 role', 'type' => 'text', 'default' => 'Founder & CEO', 'group' => 'Team'],
                    ['name' => 'team_2_photo', 'label' => 'Team member 2 photo', 'type' => 'image', 'default' => 'asset/images/media/team-2.jpg', 'group' => 'Team'],
                    ['name' => 'team_2_name', 'label' => 'Team member 2 name', 'type' => 'text', 'default' => 'Sarah Odegard', 'group' => 'Team'],
                    ['name' => 'team_2_role', 'label' => 'Team member 2 role', 'type' => 'text', 'default' => 'Head of Acquisition', 'group' => 'Team'],
                    ['name' => 'team_3_photo', 'label' => 'Team member 3 photo', 'type' => 'image', 'default' => 'asset/images/media/team-3.jpg', 'group' => 'Team'],
                    ['name' => 'team_3_name', 'label' => 'Team member 3 name', 'type' => 'text', 'default' => 'Lars Jakuba', 'group' => 'Team'],
                    ['name' => 'team_3_role', 'label' => 'Team member 3 role', 'type' => 'text', 'default' => 'Chief Engineer', 'group' => 'Team'],
                    ['name' => 'team_4_photo', 'label' => 'Team member 4 photo', 'type' => 'image', 'default' => 'asset/images/media/team-4.jpg', 'group' => 'Team'],
                    ['name' => 'team_4_name', 'label' => 'Team member 4 name', 'type' => 'text', 'default' => 'Mikey Diokles', 'group' => 'Team'],
                    ['name' => 'team_4_role', 'label' => 'Team member 4 role', 'type' => 'text', 'default' => 'Client Concierge', 'group' => 'Team'],
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

        // About is section-fields only: never persist arbitrary HTML dumps.
        if ($slug === 'about') {
            $data['content_html'] = '';
        }

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
