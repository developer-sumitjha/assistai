<div id="feature-popup-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[6000]"
    style="display: none; opacity: 0; transition: opacity 0.3s ease;" onclick="toggleFeaturePopup()"></div>

<div id="feature-popup" class="fixed left-0 right-0 bottom-0 z-[6001] flex flex-col"
    style="background: #fafafa; height: 80vh; transform: translateY(110%); transition: transform 0.5s cubic-bezier(0.32, 0.72, 0, 1); box-shadow: 0px 0px 45px rgba(0, 0, 0, 0.2); border-radius: 32px 32px 0px 0px;">

    <!-- Drag Handle -->
    <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mt-4 mb-6 shrink-0" onclick="toggleFeaturePopup()"></div>

    <div class="px-4 pb-32 flex-1 overflow-y-auto">
        <div class="mb-10">
            <h2 class="font-medium text-slate-400 tracking-tight" style="font-size: 24px !important; line-height: 1;">
                Explore</h2>
            <h1 class="font-bold text-slate-900 tracking-tighter mt-2"
                style="font-size: 32px !important; line-height: 1;">AI Features</h1>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Text to Text -->
            <a href="{{ route('user.chat.new') }}"
                class="bg-white rounded-[32px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all block">
                <div class="mb-8 text-slate-200 group-hover:text-slate-900 transition-colors">
                    <i data-lucide="scan" class="w-10 h-10 stroke-[1.5]"></i>
                </div>
                <h3 class="text-[17px] font-bold text-slate-900">Text to Text</h3>
                <p class="text-[12px] text-slate-400 mt-1">Smart AI Chat</p>
            </a>

            <!-- Text to Image -->
            <a href="{{ route('user.image') }}"
                class="bg-white rounded-[32px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all block">
                <div class="mb-8 text-slate-200 group-hover:text-slate-900 transition-colors">
                    <i data-lucide="image" class="w-10 h-10 stroke-[1.5]"></i>
                </div>
                <h3 class="text-[17px] font-bold text-slate-900">Text to Image</h3>
                <p class="text-[12px] text-slate-400 mt-1">AI Generation</p>
            </a>

            <!-- Text to Speech -->
            <div
                class="bg-white rounded-[32px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all opacity-40">
                <div class="mb-8 text-slate-200">
                    <i data-lucide="mic" class="w-10 h-10 stroke-[1.5]"></i>
                </div>
                <h3 class="text-[17px] font-bold text-slate-900">Text to Speech</h3>
                <p class="text-[12px] text-slate-400 mt-1">Coming Soon</p>
            </div>

            <!-- Ask AI -->
            <div
                class="bg-white rounded-[32px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50 group active:scale-95 transition-all opacity-40">
                <div class="mb-8 text-slate-200">
                    <i data-lucide="sparkles" class="w-10 h-10 stroke-[1.5]"></i>
                </div>
                <h3 class="text-[17px] font-bold text-slate-900">Ask AI</h3>
                <p class="text-[12px] text-slate-400 mt-1">Assistant</p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFeaturePopup() {
        const popup = document.getElementById('feature-popup');
        const overlay = document.getElementById('feature-popup-overlay');
        const isHidden = popup.style.transform === 'translateY(110%)' || popup.style.transform === '';

        if (isHidden) {
            overlay.style.display = 'block';
            setTimeout(() => {
                overlay.style.opacity = '1';
                popup.style.transform = 'translateY(0%)';
            }, 10);
            // Re-initialize icons just in case
            if (typeof lucide !== 'undefined') lucide.createIcons();
        } else {
            overlay.style.opacity = '0';
            popup.style.transform = 'translateY(110%)';
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
    }
</script>