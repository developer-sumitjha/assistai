<x-admin-layout>
    <div class="space-y-10" x-data="{ activeTab: 'general' }">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">System Settings</h1>
            <p class="text-sm text-gray-500 mt-2">Configure system-wide settings, privacy controls, and application preferences.</p>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'border-primary-purple text-primary-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    General
                </button>
                <button @click="activeTab = 'privacy'"
                        :class="activeTab === 'privacy' ? 'border-primary-purple text-primary-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Privacy
                </button>
                <button @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'border-primary-purple text-primary-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Security
                </button>
                <button @click="activeTab = 'ai'"
                        :class="activeTab === 'ai' ? 'border-primary-purple text-primary-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    AI Models
                </button>
                <button @click="activeTab = 'billing'"
                        :class="activeTab === 'billing' ? 'border-primary-purple text-primary-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Billing
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="mt-8">

            <!-- General Tab -->
            <div x-show="activeTab === 'general'" x-transition>
                <div class="card-premium border border-gray-100 p-8">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">General Settings</h3>

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                                <input type="text" name="app_name" value="{{ config('app.name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Language</label>
                                <select name="default_language" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                                    <option value="en" {{ config('app.locale') === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ config('app.locale') === 'es' ? 'selected' : '' }}>Spanish</option>
                                    <option value="fr" {{ config('app.locale') === 'fr' ? 'selected' : '' }}>French</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                                <select name="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                                    <option value="UTC" {{ config('app.timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ config('app.timezone') === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                    <option value="Europe/London" {{ config('app.timezone') === 'Europe/London' ? 'selected' : '' }}>London</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Maintenance Mode</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                                           class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                    <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                                        Enable maintenance mode
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-white px-6 py-2 rounded-md hover:bg-primary-purple/90 transition-colors" style="background-color: #000;">
                                Save General Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Privacy Tab -->
            <div x-show="activeTab === 'privacy'" x-transition>
                <div class="card-premium border border-gray-100 p-8">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">Privacy Settings</h3>

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data Retention Period (days)</label>
                                <input type="number" name="data_retention_days" value="{{ \App\Models\Setting::get('data_retention_days', 365) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">How long to keep user data before automatic deletion</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Analytics Tracking</label>
                                <div class="flex items-center space-x-6">
                                    <div class="flex items-center">
                                        <input type="radio" name="analytics_enabled" value="1" id="analytics_on"
                                               {{ \App\Models\Setting::get('analytics_enabled', '0') === '1' ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300">
                                        <label for="analytics_on" class="ml-2 block text-sm text-gray-900">Enabled</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="analytics_enabled" value="0" id="analytics_off"
                                               {{ \App\Models\Setting::get('analytics_enabled', '0') === '0' ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300">
                                        <label for="analytics_off" class="ml-2 block text-sm text-gray-900">Disabled</label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">User Data Export</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="allow_data_export" id="allow_data_export"
                                           {{ \App\Models\Setting::get('allow_data_export', '1') === '1' ? 'checked' : '' }}
                                           class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                    <label for="allow_data_export" class="ml-2 block text-sm text-gray-900">
                                        Allow users to export their data
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-white px-6 py-2 rounded-md hover:bg-primary-purple/90 transition-colors" style="background-color: #000;">
                                Save Privacy Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tab -->
            <div x-show="activeTab === 'security'" x-transition>
                <div class="card-premium border border-gray-100 p-8">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">Security Settings</h3>

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                                <input type="number" name="session_timeout" value="{{ \App\Models\Setting::get('session_timeout', 60) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Requirements</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="require_special_chars" id="require_special_chars"
                                               {{ \App\Models\Setting::get('require_special_chars', '1') === '1' ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                        <label for="require_special_chars" class="ml-2 block text-sm text-gray-900">
                                            Require special characters
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="require_numbers" id="require_numbers"
                                               {{ \App\Models\Setting::get('require_numbers', '1') === '1' ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                        <label for="require_numbers" class="ml-2 block text-sm text-gray-900">
                                            Require numbers
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Two-Factor Authentication</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="force_2fa" id="force_2fa"
                                           {{ \App\Models\Setting::get('force_2fa', '0') === '1' ? 'checked' : '' }}
                                           class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                    <label for="force_2fa" class="ml-2 block text-sm text-gray-900">
                                        Force 2FA for all users
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-white px-6 py-2 rounded-md hover:bg-primary-purple/90 transition-colors" style="background-color: #000;">
                                Save Security Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- AI Models Tab -->
            <div x-show="activeTab === 'ai'" x-transition>
                <div class="card-premium border border-gray-100 p-8">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">AI Model Configuration</h3>

                    <form method="POST" action="{{ route('admin.models.update') }}" class="space-y-6">
                        @csrf

                        <!-- Text Generation Models -->
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Text Generation Models</h4>
                            <div class="space-y-3">
                                @php
                                    $textModels = json_decode(\App\Models\Setting::get('allowed_text_models', '["gpt-4","claude-3"]'), true) ?: ['gpt-4','claude-3'];
                                @endphp
                                @foreach(['gpt-4', 'gpt-3.5-turbo', 'claude-3', 'claude-3-haiku', 'gemini-pro'] as $model)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="allowed_text_models[]" value="{{ $model }}" id="text_{{ $model }}"
                                               {{ in_array($model, $textModels) ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                        <label for="text_{{ $model }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $model }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Image Generation Models -->
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Image Generation Models</h4>
                            <div class="space-y-3">
                                @php
                                    $imageModels = json_decode(\App\Models\Setting::get('allowed_image_models', '["google/gemini-3.1-flash-image-preview"]'), true) ?: ['google/gemini-3.1-flash-image-preview'];
                                @endphp
                                @foreach(['google/gemini-3.1-flash-image-preview', 'google/gemini-3-pro-image-preview', 'openai/dall-e-3'] as $model)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="allowed_image_models[]" value="{{ $model }}" id="image_{{ str_replace('/', '_', $model) }}"
                                               {{ in_array($model, $imageModels) ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-purple focus:ring-primary-purple border-gray-300 rounded">
                                        <label for="image_{{ str_replace('/', '_', $model) }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $model }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-purple text-white px-6 py-2 rounded-md hover:bg-primary-purple/90 transition-colors">
                                Save AI Model Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Billing Tab -->
            <div x-show="activeTab === 'billing'" x-transition>
                <div class="card-premium border border-gray-100 p-8">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">Billing & Pricing</h3>

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Text Generation Cost (per 1000 tokens)</label>
                                <input type="number" step="0.01" name="text_cost_per_1000" value="{{ \App\Models\Setting::get('text_cost_per_1000', '0.02') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image Generation Cost (per image)</label>
                                <input type="number" step="0.01" name="image_cost_per_generation" value="{{ \App\Models\Setting::get('image_cost_per_generation', '5.00') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Free Credits for New Users</label>
                                <input type="number" step="0.01" name="free_credits_new_user" value="{{ \App\Models\Setting::get('free_credits_new_user', '10.00') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select name="currency" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-purple focus:border-transparent">
                                    <option value="USD" {{ \App\Models\Setting::get('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ \App\Models\Setting::get('currency', 'USD') === 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ \App\Models\Setting::get('currency', 'USD') === 'GBP' ? 'selected' : '' }}>GBP</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-purple text-white px-6 py-2 rounded-md hover:bg-primary-purple/90 transition-colors">
                                Save Billing Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alpine.js is already initialized globally
        });
    </script>
</x-admin-layout>