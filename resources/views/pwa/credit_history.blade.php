<x-pwa-layout>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col min-h-screen bg-[#F2F2F2]">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.profile') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-900"></i>
                    </a>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-800 tracking-tight">Credit History</h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">Transactions</p>
                    </div>
                </div>
            </x-slot:left>
            <x-slot:right>
                <div class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 flex items-center space-x-1">
                    <i data-lucide="coins" class="w-4 h-4"></i>
                    <span class="text-xs font-black">{{ number_format(Auth::user()->credits, 2) }}</span>
                </div>
            </x-slot:right>
        </x-pwa.top-nav>

        <main class="flex-1 p-6 space-y-6 pb-16 overflow-y-auto" style="padding-top: 100px !important;">
            
            <div class="space-y-4">
                @forelse($transactions as $transaction)
                <div class="bg-white p-5 rounded-[24px] shadow-sm border border-slate-50 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $transaction->type === 'add' ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                            @if($transaction->type === 'add')
                                <i data-lucide="arrow-down-left" class="w-6 h-6"></i>
                            @else
                                <i data-lucide="arrow-up-right" class="w-6 h-6"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $transaction->description }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $transaction->created_at->format('M d, Y') }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $transaction->created_at->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black {{ $transaction->type === 'add' ? 'text-emerald-500' : 'text-slate-800' }}">
                            {{ $transaction->type === 'add' ? '+' : '-' }}{{ number_format($transaction->amount, 4) }}
                        </p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">CR</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="inbox" class="w-10 h-10 text-slate-300"></i>
                    </div>
                    <p class="text-slate-500 font-medium">No transactions found.</p>
                    <p class="text-xs text-slate-400 mt-1">Your credit history will appear here.</p>
                </div>
                @endforelse
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</x-pwa-layout>
