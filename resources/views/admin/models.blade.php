<x-admin-layout>
    <div class="space-y-10">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">AI Models</h1>
            <p class="text-sm text-gray-500 mt-2">Configure allowed AI engines across different use cases. Each category has its own independent fleet and default starting point.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.models.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Text Generation Category -->
            <div class="card-premium">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Text Generation</h3>
                        <p class="text-sm text-gray-400 font-medium">Chatbots, assistants, and content writing</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Allowed Models</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($availableModels['text'] as $id => $name)
                                <label class="flex items-center p-4 rounded-2xl border border-gray-50 hover:border-purple-200 hover:bg-purple-50/30 cursor-pointer transition-all group">
                                    <input type="checkbox" name="allowed_text_models[]" value="{{ $id }}" class="w-5 h-5 rounded text-purple-600 focus:ring-purple-500 border-gray-300 mr-4" {{ in_array($id, $allowedTextModels) ? 'checked' : '' }} onchange="syncDefaults('text')">
                                    <span class="font-bold text-gray-700 group-hover:text-purple-700 transition-colors">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label for="default_text_model" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Primary Default</label>
                        <select name="default_text_model" id="default_text_model" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 font-bold text-gray-700 focus:ring-2 focus:ring-purple-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            @foreach($availableModels['text'] as $id => $name)
                                <option value="{{ $id }}" {{ $defaultTextModel == $id ? 'selected' : '' }} {{ !in_array($id, $allowedTextModels) ? 'disabled style=display:none' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Image Generation Category -->
            <div class="card-premium">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Image Generation</h3>
                        <p class="text-sm text-gray-400 font-medium">AI artwork, photos, and design</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Allowed Models</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($availableModels['image'] as $id => $name)
                                <label class="flex items-center p-4 rounded-2xl border border-gray-50 hover:border-indigo-200 hover:bg-indigo-50/30 cursor-pointer transition-all group">
                                    <input type="checkbox" name="allowed_image_models[]" value="{{ $id }}" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 mr-4" {{ in_array($id, $allowedImageModels) ? 'checked' : '' }} onchange="syncDefaults('image')">
                                    <span class="font-bold text-gray-700 group-hover:text-indigo-700 transition-colors">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label for="default_image_model" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Primary Default</label>
                        <select name="default_image_model" id="default_image_model" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            @foreach($availableModels['image'] as $id => $name)
                                <option value="{{ $id }}" {{ $defaultImageModel == $id ? 'selected' : '' }} {{ !in_array($id, $allowedImageModels) ? 'disabled style=display:none' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Video Generation Category -->
            <div class="card-premium opacity-80 hover:opacity-100 transition-opacity">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Video Generation</h3>
                        <p class="text-sm text-gray-400 font-medium">Text-to-Video and animation</p>
                    </div>
                </div>
                
                <div class="p-6 bg-amber-50/50 rounded-2xl border border-dashed border-amber-200 mb-8">
                     <p class="text-amber-700 text-sm font-bold flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Feature Expansion: Select models to prepare your dashboard for future video-gen tools.
                     </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Allowed Models</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($availableModels['video'] as $id => $name)
                                <label class="flex items-center p-4 rounded-2xl border border-gray-50 hover:border-amber-200 hover:bg-amber-50/30 cursor-pointer transition-all group">
                                    <input type="checkbox" name="allowed_video_models[]" value="{{ $id }}" class="w-5 h-5 rounded text-amber-600 focus:ring-amber-500 border-gray-300 mr-4" {{ in_array($id, $allowedVideoModels) ? 'checked' : '' }} onchange="syncDefaults('video')">
                                    <span class="font-bold text-gray-700 group-hover:text-amber-700 transition-colors">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label for="default_video_model" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Primary Default</label>
                        <select name="default_video_model" id="default_video_model" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 font-bold text-gray-700 focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">None Selected</option>
                            @foreach($availableModels['video'] as $id => $name)
                                <option value="{{ $id }}" {{ $defaultVideoModel == $id ? 'selected' : '' }} {{ !in_array($id, $allowedVideoModels) ? 'disabled style=display:none' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-8">
                <button type="submit" class="bg-gray-900 text-white px-16 py-6 rounded-3xl font-black text-xl shadow-2xl shadow-gray-200 hover:shadow-gray-300 hover:-translate-y-1 transition-all active:scale-95">
                    Save Fleet Configuration
                </button>
            </div>
        </form>
    </div>

    <script>
        function syncDefaults(category) {
            const allowedCheckboxes = document.querySelectorAll(`input[name="allowed_${category}_models[]"]`);
            const defaultSelect = document.getElementById(`default_${category}_model`);
            const options = defaultSelect.options;

            const selectedModels = Array.from(allowedCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === "" && category === 'video') continue; // Always allow "None" for video for now

                if (selectedModels.includes(option.value)) {
                    option.disabled = false;
                    option.style.display = 'block';
                } else {
                    option.disabled = true;
                    option.style.display = 'none';
                    if (option.selected) {
                        option.selected = false;
                    }
                }
            }

            // Fallback selection if current became disabled
            if (defaultSelect.selectedIndex === -1 || (options[defaultSelect.selectedIndex].disabled && options[defaultSelect.selectedIndex].value !== "")) {
                for (let i = 0; i < options.length; i++) {
                    if (!options[i].disabled) {
                        options[i].selected = true;
                        break;
                    }
                }
            }
        }

        // Initialize on load for all categories
        window.addEventListener('load', () => {
            ['text', 'image', 'video'].forEach(syncDefaults);
        });
    </script>
</x-admin-layout>
