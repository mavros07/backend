<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'home' => [
                ['section_key' => 'hero_title', 'content_type' => 'text', 'content' => 'Lorem ipsum dolor sit amet'],
                ['section_key' => 'hero_subtitle', 'content_type' => 'text', 'content' => 'Consectetur adipiscing elit, sed do eiusmod'],
                ['section_key' => 'recent_title', 'content_type' => 'text', 'content' => 'Recent Cars'],
                ['section_key' => 'recent_subtitle', 'content_type' => 'textarea', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                ['section_key' => 'hero_image', 'content_type' => 'image', 'content' => 'asset/images/media/home-hero-main.jpg'],
                ['section_key' => 'cta_left_image', 'content_type' => 'image', 'content' => 'asset/images/media/home-cta-left.jpg'],
                ['section_key' => 'cta_right_image', 'content_type' => 'image', 'content' => 'asset/images/media/home-cta-right.jpg'],
            ],
            'inventory' => [
                ['section_key' => 'heading', 'content_type' => 'text', 'content' => 'Vehicles For Sale'],
                ['section_key' => 'intro', 'content_type' => 'textarea', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Inventory cards are dynamic and loaded from vehicle records.'],
                ['section_key' => 'fallback_image', 'content_type' => 'image', 'content' => 'asset/images/media/inventory-listing-fallback.jpg'],
            ],
            'contact' => [
                ['section_key' => 'heading', 'content_type' => 'text', 'content' => 'Contact Us'],
                ['section_key' => 'intro', 'content_type' => 'textarea', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
                ['section_key' => 'hero_image', 'content_type' => 'image', 'content' => 'asset/images/media/contact-hero-bg.jpg'],
                ['section_key' => 'map_image', 'content_type' => 'image', 'content' => 'asset/images/media/contact-map.jpg'],
            ],
            'compare' => [
                ['section_key' => 'heading', 'content_type' => 'text', 'content' => 'Compare Vehicles'],
                ['section_key' => 'intro', 'content_type' => 'textarea', 'content' => 'Lorem ipsum dolor sit amet. Compare list remains dynamic from selected inventory records.'],
            ],
            'listing-detail' => [
                ['section_key' => 'heading', 'content_type' => 'text', 'content' => 'Vehicle Detail'],
                ['section_key' => 'intro', 'content_type' => 'textarea', 'content' => 'Lorem ipsum dolor sit amet. Gallery and specifications are loaded from listing data.'],
            ],
        ];

        foreach ($sections as $page => $items) {
            foreach ($items as $item) {
                PageSection::query()->updateOrCreate(
                    [
                        'page' => $page,
                        'section_key' => $item['section_key'],
                    ],
                    [
                        'content_type' => $item['content_type'],
                        'content' => $item['content'],
                    ]
                );
            }
        }
    }
}

