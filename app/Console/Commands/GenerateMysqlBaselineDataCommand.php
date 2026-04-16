<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

/**
 * Regenerates the DATA section appended to database/myauto_torque_db_data.sql
 * and documents merging into myauto_torque_db.sql — run after changing seed HTML.
 */
class GenerateMysqlBaselineDataCommand extends Command
{
    protected $signature = 'db:generate-mysql-baseline-data';

    protected $description = 'Write MySQL INSERTs for cms_pages + site_settings from seed-data/ (for manual SQL import)';

    public function handle(): int
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

        $siteDefaults = [
            'dealer_phone' => '+1 212-226-3126',
            'dealer_address' => '1840 E Garvey Ave South West Covina, CA 91791',
            'dealer_hours_label' => 'Work Hours',
            'dealer_sales_phone' => '(888) 354-1781',
            'dealer_sales_hours' => "Mon – Fri: 09:00AM – 09:00PM\nSaturday: 09:00AM – 07:00PM\nSunday: Closed",
            'footer_about' => 'Fusce interdum ipsum egestas urna amet fringilla, et placerat ex venenatis. Aliquet luctus pharetra. Proin sed fringilla lectus… ar sit amet tellus in mollis. Proin nec egestas nibh, eget egestas urna. Phasellus sit amet vehicula nunc. In hac habitasse platea dictumst.',
            'copyright_line' => 'MyAutoTorque',
            'social_facebook' => 'https://www.facebook.com/',
            'social_instagram' => 'https://www.instagram.com/',
            'social_linkedin' => 'https://www.linkedin.com/',
            'social_youtube' => 'https://www.youtube.com/',
        ];

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $lines = [];
        $lines[] = '-- =============================================================================';
        $lines[] = '-- Auto-generated: php artisan db:generate-mysql-baseline-data';
        $lines[] = '-- Public CMS pages (home, about, faq, contact) + site_settings defaults';
        $lines[] = '-- Import AFTER structure section of myauto_torque_db.sql (same database).';
        $lines[] = '-- =============================================================================';
        $lines[] = '';
        $lines[] = 'SET NAMES utf8mb4;';
        $lines[] = 'SET FOREIGN_KEY_CHECKS = 0;';
        $lines[] = '';

        $lines[] = '-- Spatie roles (same DB as Laravel auth: users + model_has_roles for admin)';
        $lines[] = "INSERT IGNORE INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES";
        $lines[] = "  ('admin', 'web', '{$now}', '{$now}'),";
        $lines[] = "  ('user', 'web', '{$now}', '{$now}');";
        $lines[] = '';

        $lines[] = '-- Site settings (header/footer/contact — same keys as SiteSettingsSeeder)';
        $lines[] = 'INSERT IGNORE INTO `site_settings` (`key`, `value`, `created_at`, `updated_at`) VALUES';
        $rows = [];
        foreach ($siteDefaults as $key => $value) {
            $rows[] = '  ('.$this->sqlString($key).', '.$this->sqlString($value).", '{$now}', '{$now}')";
        }
        $lines[] = implode(",\n", $rows).';';
        $lines[] = '';

        $lines[] = '-- CMS pages (public routes: /, /about, /faq, /contact)';
        foreach ($definitions as $slug => $def) {
            $path = database_path('seed-data/'.$def['file']);
            $html = is_file($path) ? (string) file_get_contents($path) : '';
            $lines[] = 'INSERT INTO `cms_pages` (`slug`, `title`, `meta_description`, `content_html`, `created_at`, `updated_at`) VALUES (';
            $lines[] = '  '.$this->sqlString($slug).', '.$this->sqlString($def['title']).', '.$this->sqlString($def['meta_description']).', ';
            $lines[] = '  '.$this->sqlString($html).", '{$now}', '{$now}'";
            $lines[] = ') ON DUPLICATE KEY UPDATE `title` = VALUES(`title`), `meta_description` = VALUES(`meta_description`), `content_html` = VALUES(`content_html`), `updated_at` = VALUES(`updated_at`);';
            $lines[] = '';
        }

        $lines[] = 'SET FOREIGN_KEY_CHECKS = 1;';

        $dataPath = database_path('myauto_torque_db_data.sql');
        file_put_contents($dataPath, implode("\n", $lines));

        $this->info('Wrote: '.$dataPath);

        $structurePath = database_path('myauto_torque_db.sql');
        if (is_file($structurePath)) {
            $fullPath = database_path('myauto_torque_db_full.sql');
            file_put_contents(
                $fullPath,
                rtrim((string) file_get_contents($structurePath))."\n\n".trim(implode("\n", $lines))."\n"
            );
            $this->info('Wrote combined import: '.$fullPath);
        }

        return self::SUCCESS;
    }

    private function sqlString(string $value): string
    {
        return "'".str_replace(["\\", "'", "\n", "\r", "\x1a"], ["\\\\", "\\'", "\\n", "\\r", "\\Z"], $value)."'";
    }
}
