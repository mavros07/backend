<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPagesSeeder extends Seeder
{
    public function run(): void
    {
        $definitions = [
            'home' => [
                'title' => 'Home',
                'meta_description' => 'Browse premium vehicles and find your next car.',
                'file' => 'cms-home-body.html',
            ],
            'about' => [
                'title' => 'About Us',
                'meta_description' => 'Learn about our dealership and team.',
                'file' => 'cms-about-body.html',
            ],
            'faq' => [
                'title' => 'FAQ',
                'meta_description' => 'Frequently asked questions about buying and selling vehicles.',
                'file' => 'cms-faq-body.html',
            ],
            'contact' => [
                'title' => 'Contact Us',
                'meta_description' => 'Get in touch with our sales and service team.',
                'file' => 'cms-contact-intro-body.html',
            ],
        ];

        foreach ($definitions as $slug => $def) {
            $path = database_path('seed-data/' . $def['file']);
            $html = is_file($path) ? (string) file_get_contents($path) : '';

            CmsPage::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $def['title'],
                    'meta_description' => $def['meta_description'],
                    'content_html' => $html,
                ]
            );
        }
    }
}
