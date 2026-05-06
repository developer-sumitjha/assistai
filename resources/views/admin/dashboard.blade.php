<x-admin-layout>
    <div class="space-y-10">
        <!-- Top Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                    Hello {{ explode(' ', Auth::user()->name)[0] }} 👋
                </h2>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="relative flex items-center">
                    <select class="bg-gray-50 border-none text-sm font-bold text-gray-500 rounded-full px-6 py-2 appearance-none pr-10 focus:ring-0">
                        <option>Choose Account</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div class="flex items-center gap-2">
                    @foreach(['search', 'bell', 'chat-alt-2', 'cog'] as $icon)
                        <button class="w-10 h-10 rounded-full border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($icon == 'search') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                @elseif($icon == 'bell') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                @elseif($icon == 'chat-alt-2') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                @elseif($icon == 'cog') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                @endif
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- My Card Section -->
        <div class="card-black">
            <div class="flex justify-between items-start mb-12">
                <div>
                    <h3 class="text-xl font-bold opacity-80">My Card</h3>
                    <p class="text-huge mt-4">$1,43,899.00</p>
                </div>
                <div class="text-right">
                    <div class="flex items-center gap-2 text-green-400 font-bold bg-green-400/10 px-3 py-1 rounded-full text-xs">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        10%
                    </div>
                    <div class="w-32 h-16 mt-2 opacity-50">
                        <canvas id="sparkline-main"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button class="btn-deposit flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Deposit
                </button>
                <button class="btn-withdraw flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m-7 7l7-7 7 7"></path></svg>
                    Withdraw
                </button>
            </div>

            <!-- Card Background Elements -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Financial Record -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-black text-gray-900">Financial Record</h3>
                <select class="bg-transparent border-none text-sm font-bold text-gray-500 focus:ring-0">
                    <option>Month</option>
                </select>
            </div>
            <div class="grid grid-cols-3 gap-6">
                @foreach([
                    ['label' => 'Total Income', 'amount' => '$85,992', 'change' => '17%', 'color' => 'green', 'bg' => 'card-income'],
                    ['label' => 'Total Expense', 'amount' => '$38,160', 'change' => '44%', 'color' => 'orange', 'bg' => 'card-expense'],
                    ['label' => 'Total Saving', 'amount' => '$47,832', 'change' => '45%', 'color' => 'blue', 'bg' => 'card-saving'],
                ] as $record)
                    <div class="card-premium {{ $record['bg'] }} border-none p-6">
                        <div class="flex justify-between mb-6">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $record['label'] }}</p>
                            <button class="text-gray-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></button>
                        </div>
                        <div class="w-full h-12 mb-4">
                            <canvas id="sparkline-{{ $loop->index }}"></canvas>
                        </div>
                        <div class="flex items-end justify-between">
                            <p class="text-2xl font-black text-gray-900">{{ $record['amount'] }}</p>
                            <span class="text-xs font-bold text-{{ $record['color'] }}-500 flex items-center gap-1 mb-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                {{ $record['change'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Money Flow Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-black text-gray-900">Money Flow</h3>
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-black"></div>
                            <span class="text-xs font-bold text-gray-400">Total Saving</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                            <span class="text-xs font-bold text-gray-400">Total Expense</span>
                        </div>
                    </div>
                    <select class="bg-gray-50 border-none text-xs font-bold text-gray-500 rounded-lg px-4 py-2 focus:ring-0">
                        <option>Weekly</option>
                    </select>
                </div>
            </div>
            <div class="card-premium p-8 h-[350px]">
                <canvas id="moneyFlowChart"></canvas>
            </div>
        </div>

        <!-- Bottom Grid: Send Money & Scheduled Payments -->
        <div class="grid grid-cols-2 gap-8 pb-10">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-black text-gray-900">Send Money To</h3>
                    <button class="text-gray-400"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></button>
                </div>
                <div class="card-premium flex items-center gap-4 py-4 px-6">
                    <button class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center shrink-0 hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                    <div class="flex -space-x-4">
                        @foreach([1, 2, 3] as $i)
                            <img src="https://i.pravatar.cc/100?u={{ $i }}" class="w-12 h-12 rounded-full border-4 border-white object-cover">
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-black text-gray-900">Scheduled Payments</h3>
                    <button class="text-gray-400"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></button>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['name' => 'Discord', 'price' => '$34.99/m'],
                        ['name' => 'Wattpad', 'price' => '$14.99/m'],
                        ['name' => 'Netflix', 'price' => '$9.99/m'],
                    ] as $pay)
                        <div class="card-premium border border-gray-50 flex flex-col items-center justify-center py-4 text-center">
                            <p class="text-[10px] font-bold text-gray-400 mb-1">{{ $pay['name'] }}</p>
                            <p class="text-xs font-black text-gray-900">{{ $pay['price'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Money Flow Chart
            const ctx = document.getElementById('moneyFlowChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['04 Se, Mo', '05 Se, Tu', '06 Se, We', '07 Se, Th', '08 Se, Fr', '09 Se, Sa', '10 Se, Su'],
                    datasets: [{
                        label: 'Total Saving',
                        data: [1200, 1900, 1000, 2289, 1100, 2100, 1500],
                        borderColor: '#111827',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: false,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#111827',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }, {
                        label: 'Total Expense',
                        data: [1500, 1400, 1800, 1300, 1700, 1200, 1400],
                        borderColor: '#FB923C',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [5, 5], color: '#F1F5F9' },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#94A3B8' }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#94A3B8' }
                        }
                    }
                }
            });

            // Sparklines
            const sparklineConfigs = [
                { id: 'sparkline-main', color: '#10B981', data: [10, 25, 15, 35, 20, 45, 30] },
                { id: 'sparkline-0', color: '#10B981', data: [5, 10, 8, 15, 12, 18, 15] },
                { id: 'sparkline-1', color: '#F97316', data: [15, 12, 18, 10, 15, 8, 12] },
                { id: 'sparkline-2', color: '#3B82F6', data: [8, 12, 10, 18, 15, 20, 18] }
            ];

            sparklineConfigs.forEach(config => {
                const sctx = document.getElementById(config.id).getContext('2d');
                new Chart(sctx, {
                    type: 'line',
                    data: {
                        labels: ['', '', '', '', '', '', ''],
                        datasets: [{
                            data: config.data,
                            borderColor: config.color,
                            borderWidth: 2,
                            tension: 0.4,
                            fill: false,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { x: { display: false }, y: { display: false } }
                    }
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
