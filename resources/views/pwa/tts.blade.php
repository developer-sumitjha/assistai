<x-pwa-layout>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col min-h-screen bg-[#F2F2F2]" x-data="ttsGenerator()">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.dashboard') }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-900"></i>
                    </a>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-800 tracking-tight">Text to Speech</h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">AI Voice</p>
                    </div>
                </div>
            </x-slot:left>
            <x-slot:right>
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center space-x-1.5 px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 shadow-sm">
                        <div class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]"></div>
                        <span id="header-credits"
                            class="text-xs font-black text-amber-600">{{ number_format(auth()->user()->credits, 2) }}</span>
                    </div>
                </div>
            </x-slot:right>
        </x-pwa.top-nav>

        <main class="flex-1 p-6 space-y-6 pb-32 overflow-y-auto" style="padding-top: 120px !important;">
            <!-- Generate Tool -->
            <div class="bg-white rounded-[32px] p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
                <div class="space-y-4">
                    <!-- Text Input -->
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Enter
                            Text</label>
                        <textarea x-model="inputText"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-blue-500 min-h-[120px] placeholder:text-slate-300"
                            placeholder="Hello, I am your AI assistant. How can I help you today?"></textarea>
                        
                        <div class="mt-2 flex justify-end">
                            <button @click="openScriptHelper = true"
                                class="text-[10px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-600 flex items-center space-x-1 transition-colors">
                                <i data-lucide="sparkles" class="w-3 h-3"></i>
                                <span>Generate Text</span>
                            </button>
                        </div>
                    </div>

                    <!-- Model and Voice Selectors -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">AI
                                Model</label>
                            <select x-model="selectedModel"
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-blue-500 truncate">
                                @foreach($models as $model)
                                    <option value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Voice</label>
                            <select x-model="selectedVoice"
                                class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-blue-500 truncate">
                                @foreach($voices as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Advanced Options (Collapsible) -->
                    <div x-data="{ expanded: false }">
                        <button @click="expanded = !expanded"
                            class="flex items-center space-x-2 text-[10px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-600">
                            <span x-text="expanded ? 'Hide Options' : 'Show Advanced Options'"></span>
                            <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="expanded ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="expanded" x-collapse x-cloak class="pt-4 space-y-4">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block flex justify-between">
                                    <span>Speed</span>
                                    <span x-text="speed + 'x'"></span>
                                </label>
                                <input type="range" x-model="speed" min="0.25" max="4.0" step="0.25"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Format</label>
                                <select x-model="responseFormat"
                                    class="w-full bg-slate-50 border-none rounded-xl py-2 px-3 text-[10px] font-bold text-slate-600 focus:ring-2 focus:ring-blue-500">
                                    <option value="mp3">MP3 (Best Compatibility)</option>
                                    <option value="pcm">PCM (Raw Audio)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button @click="generateAudio()" :disabled="loading || !inputText.trim()"
                        class="w-full text-white rounded-2xl py-4 font-black uppercase tracking-widest active:scale-[0.98] transition-all disabled:opacity-50 disabled:active:scale-100 flex items-center justify-center space-x-2"
                        style="background-color: #000 !important; box-shadow: 0_8px_30px_rgba(0,0,0,0.1);">
                        <template x-if="!loading">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="mic" class="w-5 h-5"></i>
                                <span>Generate Speech</span>
                            </div>
                        </template>
                        <template x-if="loading">
                            <div class="flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span>Synthesizing...</span>
                            </div>
                        </template>
                    </button>
                </div>
            </div>

            <!-- Result Display -->
            <div x-show="generatedAudio" x-transition x-cloak class="space-y-4">
                <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-slate-100 p-8">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-4">Latest Result</h3>
                    <audio x-ref="audioPlayer" controls class="w-full rounded-xl" :src="generatedAudio"></audio>
                </div>
            </div>

            <!-- History Section -->
            <div class="space-y-4 pt-4 pb-8">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Recent Generations</h3>
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ count($generations) }}
                        Items</span>
                </div>

                <div class="space-y-4">
                    @foreach($generations as $gen)
                        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm relative group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex gap-2 flex-wrap items-center">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-bold uppercase">{{ explode('/', $gen->model)[1] ?? $gen->model }}</span>
                                    <span class="px-2 py-1 bg-slate-50 border border-slate-200 text-slate-500 rounded-lg text-[8px] font-medium uppercase tracking-wider">{{ $gen->voice }}</span>
                                </div>
                                <button @click="reuseSettings('{{ addslashes($gen->input_text) }}', '{{ $gen->model }}', '{{ $gen->voice }}', '{{ $gen->speed }}', '{{ $gen->response_format }}')"
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-blue-500 transition-colors flex items-center gap-1">
                                    <i data-lucide="copy" class="w-3 h-3"></i> Modify
                                </button>
                            </div>
                            <p class="text-xs text-slate-600 italic line-clamp-2 mb-4">"{{ $gen->input_text }}"</p>
                            @if($gen->audio_url)
                                <audio controls class="w-full h-10 rounded-xl" src="{{ $gen->audio_url }}"></audio>
                            @else
                                <div class="w-full h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[10px] text-slate-400 uppercase font-bold">File Missing</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Premium Bottom Navigation -->
        <x-pwa.bottom-nav active="home" />

        <!-- AI Script Helper Modal -->
        <div x-show="openScriptHelper" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[7000] flex items-end sm:items-center justify-center">
            <div x-show="openScriptHelper" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="transform translate-y-full sm:translate-y-4 opacity-0" 
                 x-transition:enter-end="transform translate-y-0 opacity-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="transform translate-y-0 opacity-100" 
                 x-transition:leave-end="transform translate-y-full sm:translate-y-4 opacity-0" 
                 @click.away="if(!scriptLoading) openScriptHelper = false"
                 class="bg-white w-full sm:w-[400px] rounded-t-[32px] sm:rounded-[32px] p-6 shadow-2xl flex flex-col max-h-[90vh]">
                
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg">Generate Script</h3>
                        <p class="text-xs text-slate-400">Let AI write the perfect script.</p>
                    </div>
                    <button @click="openScriptHelper = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 active:scale-95">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto mb-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">What should the audio say?</label>
                    <textarea x-model="scriptPrompt"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-blue-500 min-h-[100px] placeholder:text-slate-300"
                        placeholder="e.g., A short enthusiastic intro for my travel vlog..."></textarea>
                    
                    <button @click="generateScript()" :disabled="scriptLoading || !scriptPrompt.trim()"
                        class="w-full mt-4 text-white rounded-2xl py-3 text-xs font-black uppercase tracking-widest active:scale-[0.98] transition-all disabled:opacity-50 disabled:active:scale-100 flex items-center justify-center space-x-2"
                        style="background-color: #3b82f6 !important; box-shadow: 0_4px_15px_rgba(59,130,246,0.3);">
                        <template x-if="!scriptLoading">
                            <span>Draft Script</span>
                        </template>
                        <template x-if="scriptLoading">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                    </button>

                    <div x-show="generatedScript" class="mt-6 pt-6 border-t border-slate-100">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block text-green-500">Draft Result</label>
                        <div class="bg-slate-50 rounded-2xl p-4 text-sm font-medium text-slate-700 max-h-[150px] overflow-y-auto mb-4" x-text="generatedScript"></div>
                        
                        <button @click="insertScript()"
                            class="w-full text-slate-900 bg-white border-2 border-slate-900 rounded-2xl py-3 text-xs font-black uppercase tracking-widest active:scale-[0.98] transition-all">
                            Insert Into Input
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Toast Notification -->
        <div x-show="toast.show" x-transition.opacity class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999] max-w-sm w-[90%] pointer-events-none">
            <div class="bg-slate-900 text-white rounded-2xl p-4 shadow-2xl flex items-center space-x-3" :class="toast.type === 'error' ? 'bg-red-500' : 'bg-slate-900'">
                <template x-if="toast.type === 'success'">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-green-400"></i>
                </template>
                <template x-if="toast.type === 'error'">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                </template>
                <p class="text-sm font-medium" x-text="toast.message"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });

        function ttsGenerator() {
            return {
                inputText: '',
                selectedModel: '{{ count($models) > 0 ? $models[0]["id"] : "openai/tts-1" }}',
                selectedVoice: 'alloy',
                responseFormat: 'mp3',
                speed: 1.0,
                loading: false,
                generatedAudio: null,
                
                openScriptHelper: false,
                scriptPrompt: '',
                scriptLoading: false,
                generatedScript: '',

                toast: { show: false, message: '', type: 'success' },

                showToast(message, type = 'success') {
                    this.toast = { show: true, message, type };
                    setTimeout(() => { this.toast.show = false; }, 4000);
                },

                reuseSettings(text, model, voice, speed, format) {
                    this.inputText = text;
                    this.selectedModel = model;
                    this.selectedVoice = voice;
                    this.speed = parseFloat(speed) || 1.0;
                    this.responseFormat = format || 'mp3';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    this.showToast('Settings applied. Ready to generate.');
                },

                async generateAudio() {
                    if (!this.inputText.trim()) {
                        this.showToast('Please enter some text', 'error');
                        return;
                    }

                    this.loading = true;
                    this.generatedAudio = null;

                    try {
                        const response = await fetch('{{ route("user.tts.generate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                input_text: this.inputText,
                                model: this.selectedModel,
                                voice: this.selectedVoice,
                                response_format: this.responseFormat,
                                speed: this.speed
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.generatedAudio = data.audio_url;
                            this.showToast('Speech synthesized successfully!');
                            
                            // Let the DOM update with the audio element, then play it
                            this.$nextTick(() => {
                                if (this.$refs.audioPlayer) {
                                    this.$refs.audioPlayer.play().catch(e => console.log('Autoplay prevented', e));
                                }
                            });
                            
                            // Refresh after delay to show history
                            setTimeout(() => window.location.reload(), 4000);
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

                async generateScript() {
                    if (!this.scriptPrompt.trim()) return;

                    this.scriptLoading = true;
                    this.generatedScript = '';

                    try {
                        const response = await fetch('{{ route("user.tts.generateScript") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                prompt: this.scriptPrompt
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.generatedScript = data.text;
                            this.showToast('Script drafted successfully!');
                        } else {
                            this.showToast(data.error || 'Failed to generate script', 'error');
                        }
                    } catch (error) {
                        this.showToast('An unexpected error occurred', 'error');
                        console.error(error);
                    } finally {
                        this.scriptLoading = false;
                    }
                },

                insertScript() {
                    this.inputText = this.generatedScript;
                    this.openScriptHelper = false;
                    this.showToast('Script inserted!');
                }
            }
        }
    </script>
</x-pwa-layout>
