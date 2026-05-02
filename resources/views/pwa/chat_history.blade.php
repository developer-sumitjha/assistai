<x-pwa-layout title="Chat History">
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col h-screen overflow-hidden bg-[#F2F2F2]">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                    <i data-lucide="help-circle" class="w-6 h-6 text-slate-900"></i>
                </button>
            </x-slot:left>
            <x-slot:center>
                <div class="flex items-center space-x-1.5 px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]"></div>
                    <span class="text-xs font-black text-amber-600">{{ number_format(auth()->user()->credits, 2) }}</span>
                </div>
            </x-slot:center>
            <x-slot:right>
                <button class="relative w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                    <i data-lucide="bell" class="w-6 h-6 text-slate-900"></i>
                    <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-[#F2F2F2]">5</span>
                </button>
            </x-slot:right>
        </x-pwa.top-nav>

        <!-- Main Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-6 pb-32">
            <!-- Header Section -->
            <div class="mb-10" style="margin-top: 10vh !important;">
                <h1 class="font-bold text-slate-900 tracking-tighter mt-2"
                    style="font-size: 32px !important; line-height: 1;">Chat History</h1>
            </div>

            <!-- History List -->
            <div class="space-y-4">
                @forelse($conversations as $conversation)
                    <a href="{{ route('user.chat.show', $conversation) }}" class="block group">
                        <div class="p-5 bg-white border border-slate-50 rounded-[28px] shadow-[0_4px_20px_rgba(0,0,0,0.03)] group-active:scale-[0.98] transition-all"
                            style="padding: 10px;border-radius: 10px;">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                        <i data-lucide="message-square" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-[15px] font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                            {{ $conversation->title }}
                                        </h3>
                                        <p class="text-[11px] text-slate-400 mt-1 font-medium">
                                            {{ $conversation->messages_count }} messages •
                                            {{ $conversation->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <i data-lucide="chevron-right"
                                    class="w-5 h-5 text-slate-200 group-hover:text-blue-400 transition-colors"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div
                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-200 mb-4 shadow-sm">
                            <i data-lucide="message-circle-off" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-slate-500 font-bold">No chats yet</h3>
                        <p class="text-slate-400 text-[11px] mt-1 px-10">Start your first conversation by clicking the +
                            button below.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Fixed Bottom Navigation Bar -->
        <x-pwa.bottom-nav active="chat" />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</x-pwa-layout>