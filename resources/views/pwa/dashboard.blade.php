<x-pwa-layout>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col h-screen overflow-hidden bg-[#F2F2F2]">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <button
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                    <i data-lucide="help-circle" class="w-6 h-6 text-slate-900"></i>
                </button>
            </x-slot:left>
            <x-slot:right>
                <button
                    class="relative w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                    <i data-lucide="bell" class="w-6 h-6 text-slate-900"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-[#F2F2F2]">5</span>
                </button>
            </x-slot:right>
        </x-pwa.top-nav>

        <!-- Main Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-6 pb-32">
            <!-- Greeting Section -->
            <div class="mb-10" style="margin-top: 25vh !important;">
                <h2 class="font-medium text-slate-400 tracking-tight"
                    style="font-size: 18px !important; line-height: 1;">Hi {{ auth()->user()->name }},</h2>
                <h1 class="font-bold text-slate-900 tracking-tighter mt-2"
                    style="font-size: 24px !important; line-height: 1;">How can I help you today?</h1>
            </div>

            <!-- Action Cards Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <!-- Text to Text (Chat) -->
                <a href="{{ route('user.chat.new') }}"
                    class="bg-white rounded-[32px] p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all block">
                    <div class="mb-8 text-slate-200 group-hover:text-slate-900 transition-colors">
                        <i data-lucide="scan" class="w-10 h-10 stroke-[1.5]"></i>
                    </div>
                    <h3 class="text-[16px] font-bold text-slate-900">Text to Text</h3>
                    <p class="text-[13px] text-slate-400 mt-1">Smart AI Chat</p>
                </a>

                <!-- Text to Image -->
                <a href="{{ route('user.image') }}"
                    class="bg-white rounded-[32px] p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all block">
                    <div class="mb-8 text-slate-200 group-hover:text-slate-900 transition-colors">
                        <i data-lucide="image" class="w-10 h-10 stroke-[1.5]"></i>
                    </div>
                    <h3 class="text-[16px] font-bold text-slate-900">Text to Image</h3>
                    <p class="text-[13px] text-slate-400 mt-1">AI Generation</p>
                </a>

                <!-- Image to Image -->
                <a href="{{ route('user.image_to_image') }}"
                    class="bg-white rounded-[32px] p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all block">
                    <div class="mb-8 text-slate-200 group-hover:text-slate-900 transition-colors">
                        <i data-lucide="image-plus" class="w-10 h-10 stroke-[1.5]"></i>
                    </div>
                    <h3 class="text-[16px] font-bold text-slate-900">Image to Image</h3>
                    <p class="text-[13px] text-slate-400 mt-1">AI Transformation</p>
                </a>

                <!-- Ask AI -->
                <div
                    class="bg-white rounded-[32px] p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all">
                    <div class="mb-8 text-slate-200">
                        <i data-lucide="sparkles" class="w-10 h-10 stroke-[1.5]"></i>
                    </div>
                    <h3 class="text-[16px] font-bold text-slate-900">Ask AI</h3>
                    <p class="text-[13px] text-slate-400 mt-1">Your Assistant</p>
                </div>

            </div>
        </div>

        <!-- Fixed Bottom Navigation Bar -->
        <x-pwa.bottom-nav active="home" />
    </div>

    <script>
        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</x-pwa-layout>