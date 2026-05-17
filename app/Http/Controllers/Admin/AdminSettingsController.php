<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('admin.settings');
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'default_language' => 'nullable|string|in:en,es,fr',
            'timezone' => 'nullable|string',
            'maintenance_mode' => 'nullable|boolean',
            'data_retention_days' => 'nullable|integer|min:1|max:3650',
            'analytics_enabled' => 'nullable|boolean',
            'allow_data_export' => 'nullable|boolean',
            'session_timeout' => 'nullable|integer|min:5|max:1440',
            'require_special_chars' => 'nullable|boolean',
            'require_numbers' => 'nullable|boolean',
            'force_2fa' => 'nullable|boolean',
            'text_cost_per_1000' => 'nullable|numeric|min:0',
            'image_cost_per_generation' => 'nullable|numeric|min:0',
            'free_credits_new_user' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|in:USD,EUR,GBP',
        ]);

        // Update settings
        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        // Clear relevant caches
        Cache::forget('settings');

        return back()->with('success', 'Settings updated successfully!');
    }
}