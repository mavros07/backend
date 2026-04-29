<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Support\SiteSettingDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminSiteSettingsController extends Controller
{
    /** @var array<string, string> */
    private const SUPPORTED_CURRENCIES = [
        'USD' => 'US Dollar ($)',
        'EUR' => 'Euro (€)',
        'GBP' => 'British Pound (£)',
        'NGN' => 'Nigerian Naira (NGN)',
        'CAD' => 'Canadian Dollar (C$)',
        'AED' => 'UAE Dirham (AED)',
    ];

    public function edit(Request $request): View
    {
        $settings = SiteSettingDefaults::mergeWithDatabase(SiteSetting::allKeyed());

        return view('admin.settings.edit', [
            'title' => __('Site settings'),
            'settings' => $settings,
            'supportedCurrencies' => self::SUPPORTED_CURRENCIES,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_display_name' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:2048'],
            'logo_light_path' => ['nullable', 'string', 'max:2048'],
            'favicon_path' => ['nullable', 'string', 'max:2048'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'logo_light_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'favicon_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,ico', 'max:2048'],
            'currency_code' => ['nullable', 'string', 'in:' . implode(',', array_keys(self::SUPPORTED_CURRENCIES))],
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

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = $this->storeBrandAsset($request->file('logo_file'), 'logo');
        }
        if ($request->hasFile('logo_light_file')) {
            $validated['logo_light_path'] = $this->storeBrandAsset($request->file('logo_light_file'), 'logo-light');
        }
        if ($request->hasFile('favicon_file')) {
            $validated['favicon_path'] = $this->storeBrandAsset($request->file('favicon_file'), 'favicon');
        }

        $currencyCode = strtoupper(trim((string) ($validated['currency_code'] ?? 'USD')));
        $validated['currency_code'] = array_key_exists($currencyCode, self::SUPPORTED_CURRENCIES) ? $currencyCode : 'USD';
        $validated['currency_label'] = 'Currency (' . $validated['currency_code'] . ')';

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

    private function storeBrandAsset(\Illuminate\Http\UploadedFile $file, string $prefix): string
    {
        $safePrefix = Str::slug($prefix);
        $filename = $safePrefix . '-' . Str::uuid() . '.' . strtolower($file->getClientOriginalExtension() ?: 'png');
        $stored = $file->storePubliclyAs('site-settings', $filename, 'public');

        return 'storage/' . ltrim((string) $stored, '/');
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
