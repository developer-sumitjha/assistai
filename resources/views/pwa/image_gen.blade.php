<x-pwa-layout>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col min-h-screen bg-[#F2F2F2]" x-data="imageGenerator()">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-900"></i>
                    </a>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-800 tracking-tight">Image Gen</h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">AI Creation</p>
                    </div>
                </div>
            </x-slot:left>
            <x-slot:right>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-1.5 px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 shadow-sm">
                        <div class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]"></div>
                        <span id="header-credits" class="text-xs font-black text-amber-600">{{ number_format(auth()->user()->credits, 2) }}</span>
                    </div>
                </div>
            </x-slot:right>
        </x-pwa.top-nav>

        <main class="flex-1 p-6 space-y-6 pb-32 overflow-y-auto" style="padding-top: 120px !important;">
            <!-- Generate Tool -->
            <div class="bg-white rounded-[32px] p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
                <div class="space-y-4">
                    <!-- Prompt Input -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Enter Your Prompt</label>
                        <textarea 
                            x-model="prompt"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-blue-500 min-h-[100px] placeholder:text-slate-300"
                            placeholder="A majestic lion wearing a golden crown, digital art, high detail..."
                        ></textarea>
                    </div>

                    <!-- Model Selector -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">AI Model</label>
                            <select x-model="selectedModel" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-blue-500">
                                @foreach($allowedModels as $model)
                                    <option value="{{ $model }}">{{ $modelNames[$model] ?? $model }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Advanced Options (Collapsible) -->
                    <div x-data="{ expanded: false }">
                        <button @click="expanded = !expanded" class="flex items-center space-x-2 text-[10px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-600">
                            <span x-text="expanded ? 'Hide Options' : 'Show Advanced Options'"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="expanded" x-collapse x-cloak class="pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Aspect Ratio</label>
                                <select x-model="aspectRatio" class="w-full bg-slate-50 border-none rounded-xl py-2 px-3 text-[10px] font-bold text-slate-600 focus:ring-2 focus:ring-blue-500">
                                    <option value="1:1">1:1 Square</option>
                                    <option value="16:9">16:9 Cinema</option>
                                    <option value="9:16">9:16 Portrait</option>
                                    <option value="4:3">4:3 Photo</option>
                                    <option value="3:2">3:2 Classic</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Quality</label>
                                <select x-model="imageSize" class="w-full bg-slate-50 border-none rounded-xl py-2 px-3 text-[10px] font-bold text-slate-600 focus:ring-2 focus:ring-blue-500">
                                    <option value="1K">Standard (1K)</option>
                                    <option value="2K">High (2K)</option>
                                    <option value="4K">Ultra (4K)</option>
                                    <option value="0.5K">Draft (0.5K)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button 
                        @click="generateImage()"
                        :disabled="loading || !prompt"
                        class="w-full text-white rounded-2xl py-4 font-black uppercase tracking-widest active:scale-[0.98] transition-all disabled:opacity-50 disabled:active:scale-100 flex items-center justify-center space-x-2"
                        style="background-color: #000 !important; box-shadow: 0_8px_30px_rgba(0,0,0,0.1);"
                    >
                        <template x-if="!loading">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Generate Image</span>
                                <span class="bg-white/20 px-2 py-0.5 rounded text-[10px]">-5 Credits</span>
                            </div>
                        </template>
                        <template x-if="loading">
                            <div class="flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Dreaming...</span>
                            </div>
                        </template>
                    </button>
                    
                    <button @click="surpriseMe()" class="w-full text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-blue-500 transition-colors">
                        Surprise Me (Random Prompt)
                    </button>
                </div>
            </div>

            <!-- Result Display -->
            <div x-show="generatedImage" x-transition x-cloak class="space-y-4">
                <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-slate-100 p-2">
                    <img :src="generatedImage" class="w-full rounded-[26px] shadow-inner" alt="Generated Image">
                    <div class="p-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 italic truncate max-w-[200px]" x-text="'\"' + prompt + '\"'"></p>
                        <div class="flex space-x-2">
                            <button @click="downloadImage()" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div class="space-y-4 pt-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Recent Generations</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ count($generations) }} Items</span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @foreach($generations as $gen)
                    <div class="aspect-square bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm relative group cursor-pointer" @click="viewHistory('{{ $gen->imageUrl }}', '{{ addslashes($gen->prompt) }}')">
                        <img src="{{ $gen->imageUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="History">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                            <p class="text-[8px] font-bold text-white line-clamp-2 italic">"{{ $gen->prompt }}"</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Premium Bottom Navigation -->
        <x-pwa.bottom-nav active="image" />

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });

        function imageGenerator() {

            return {
                prompt: '',
                selectedModel: '{{ $allowedModels[0] ?? "google/gemini-3.1-flash-image-preview" }}',
                aspectRatio: '1:1',
                imageSize: '1K',
                loading: false,
                generatedImage: null,
                toast: { show: false, message: '', type: 'success' },
                
                showToast(message, type = 'success') {
                    this.toast = { show: true, message, type };
                    setTimeout(() => { this.toast.show = false; }, 4000);
                },

                surpriseMe() {
                    const prompts = [
                        "A futuristic neon-drenched Tokyo street at night, rain reflections, 8k resolution, cinematic lighting",
                        "A majestic mountain landscape with a crystal clear lake, sunset colors, hyper-realistic, 4k",
                        "Cyberpunk samurai cat wearing high-tech armor, standing rooftop, dramatic lighting, digital art",
                        "Underwater lost city of Atlantis, bioluminescent plants, glowing jellyfish, mythical, epic scale",
                        "A cozy cottage in a magical forest with giant mushrooms and fireflies, Studio Ghibli style"
                    ];
                    this.prompt = prompts[Math.floor(Math.random() * prompts.length)];
                },

                async generateImage() {
                    if (!this.prompt) return;
                    
                    this.loading = true;
                    this.generatedImage = null;

                    try {
                        const response = await fetch('{{ route("user.image.generate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                prompt: this.prompt,
                                model: this.selectedModel,
                                aspect_ratio: this.aspectRatio,
                                image_size: this.imageSize
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.generatedImage = data.image_url;
                            this.showToast('Image generated successfully!');
                            // Simple way to refresh credits display if needed (or we can just reload)
                            setTimeout(() => window.location.reload(), 3000);
                        } else {
                            this.showToast(data.error || 'Generation failed', 'error');
                        }
                    } catch (error) {
                        this.showToast('An unexpected error occurred', 'error');
                        console.error(error);
                    } finally {
                        this.loading = false;
                    }
                },

                downloadImage() {
                    if (!this.generatedImage) return;
                    const link = document.createElement('a');
                    link.href = this.generatedImage;
                    link.download = `assistai-gen-${Date.now()}.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },

                viewHistory(data, prompt) {
                    this.generatedImage = data;
                    this.prompt = prompt;
                    // Scroll to top to see it
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }
    </script>
</x-pwa-layout>
