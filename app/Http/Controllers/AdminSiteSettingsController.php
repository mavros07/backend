<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Support\SiteSettingDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSiteSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $settings = SiteSettingDefaults::mergeWithDatabase(SiteSetting::allKeyed());

        return view('admin.settings.edit', [
            'title' => __('Site settings'),
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_display_name' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:2048'],
            'logo_light_path' => ['nullable', 'string', 'max:2048'],
            'favicon_path' => ['nullable', 'string', 'max:2048'],
            'currency_label' => ['nullable', 'string', 'max:100'],
            'dealer_phone' => ['nullable', 'string', 'max:64'],
            'dealer_sales_phone' => ['nullable', 'string', 'max:64'],
            'dealer_address' => ['nullable', 'string', 'max:500'],
            'dealer_hours_label' => ['nullable', 'string', 'max:120'],
            'dealer_sales_hours' => ['nullable', 'string', 'max:5000'],
            'dealer_service_hours' => ['nullable', 'string', 'max:5000'],
            'dealer_parts_hours' => ['nullable', 'string', 'max:5000'],
            'social_facebook' => ['nullable', 'string', 'max:500'],
            'social_instagram' => ['nullable', 'string', 'max:500'],
            'social_linkedin' => ['nullable', 'string', 'max:500'],
            'social_youtube' => ['nullable', 'string', 'max:500'],
            'copyright_line' => ['nullable', 'string', 'max:255'],
            'footer_tagline' => ['nullable', 'string', 'max:2000'],
            'footer_blog_title' => ['nullable', 'string', 'max:255'],
            'footer_blog_entries_json' => ['nullable', 'string', 'max:20000'],
            'newsletter_note' => ['nullable', 'string', 'max:500'],
            'footer_privacy_url' => ['nullable', 'string', 'max:500'],
            'footer_terms_url' => ['nullable', 'string', 'max:500'],
            'contact_notify_email' => ['nullable', 'email', 'max:255'],
            'contact_from_name' => ['nullable', 'string', 'max:255'],
            'dealer_public_email' => ['nullable', 'email', 'max:255'],
        ]);

        $blogJson = (string) ($validated['footer_blog_entries_json'] ?? '');
        if (trim($blogJson) !== '') {
            $decoded = json_decode($blogJson, true);
            if (! is_array($decoded)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['footer_blog_entries_json' => __('Blog entries must be valid JSON.')]);
            }
            foreach ($decoded as $row) {
                if (! is_array($row)) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['footer_blog_entries_json' => __('Each blog entry must be an object.')]);
                }
            }
            $validated['footer_blog_entries_json'] = json_encode($decoded);
        } else {
            $validated['footer_blog_entries_json'] = '[]';
        }

        $validated['newsletter_enabled'] = $request->boolean('newsletter_enabled') ? '1' : '0';

        foreach (SiteSettingDefaults::managedKeys() as $key) {
            $value = $validated[$key] ?? '';
            if (! is_string($value)) {
                $value = (string) $value;
            }
            $value = trim($value);
            $this->persistKey($key, $value);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', __('Site settings saved.'));
    }

    private function persistKey(string $key, string $value): void
    {
        if ($value === '') {
            SiteSetting::query()->where('key', $key)->delete();

            return;
        }
        SiteSetting::setValue($key, $value);
    }
}
