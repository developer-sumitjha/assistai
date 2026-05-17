<x-admin-layout>
    <div class="space-y-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.credits') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $user->name }}'s Credit Details</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Current Balance</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black text-indigo-600">{{ number_format($user->credits, 2) }}</span>
                    <span class="text-sm font-bold text-gray-400">CR</span>
                </div>
            </div>
            
            <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Total Credits Spent</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black text-rose-500">{{ number_format($totalSpent, 2) }}</span>
                    <span class="text-sm font-bold text-gray-400">CR</span>
                </div>
            </div>

            <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Total Credits Added</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black text-emerald-500">{{ number_format($totalAdded, 2) }}</span>
                    <span class="text-sm font-bold text-gray-400">CR</span>
                </div>
            </div>
        </div>

        <div class="card-premium border border-gray-100 p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 rounded-3xl text-sm font-bold border border-emerald-100">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-3xl text-sm font-bold border border-rose-100">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900">Transaction History</h3>
                    <p class="text-sm text-gray-500 mt-1">Detailed log of all credit additions and deductions.</p>
                </div>
                <button onclick="openCreditModal({{ $user->id }}, '{{ $user->name }}', {{ $user->credits }})" class="bg-primary-purple text-white px-5 py-3 rounded-2xl text-sm font-bold hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-purple-100">
                    Manage Credits
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <th class="py-4 px-4">Date</th>
                            <th class="py-4 px-4">Type</th>
                            <th class="py-4 px-4">Credits</th>
                            <th class="py-4 px-4">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="bg-slate-50/80 hover:bg-white transition-colors rounded-3xl shadow-sm overflow-hidden">
                            <td class="py-5 px-4 align-middle">
                                <p class="text-sm font-bold text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="py-5 px-4 align-middle">
                                @if($transaction->type === 'add')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">Addition</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-700">Deduction</span>
                                @endif
                            </td>
                            <td class="py-5 px-4 align-middle">
                                <span class="text-lg font-black {{ $transaction->type === 'add' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $transaction->type === 'add' ? '+' : '-' }}{{ number_format($transaction->amount, 4) }}
                                </span>
                            </td>
                            <td class="py-5 px-4 align-middle">
                                <p class="text-sm font-medium text-gray-700">{{ $transaction->description }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-500 font-medium bg-slate-50 rounded-3xl">
                                No transactions found for this user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Credit Management Modal -->
    <div id="creditModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeCreditModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 p-10">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-gray-900" id="modal-title">Manage User Credits</h3>
                    <p class="text-sm text-gray-400 mt-2" id="user-name-display"></p>
                </div>

                <form id="creditForm" method="POST" action="">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Current Balance</label>
                            <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <span class="text-xl font-black text-indigo-600" id="current-credits-display">0</span>
                                <span class="text-xs font-bold text-gray-400 ml-1">Credits</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Action Type</label>
                                <select name="type" required class="w-full px-5 py-4 bg-slate-50 rounded-3xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                                    <option value="add">Add Credits</option>
                                    <option value="subtract">Subtract Credits</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Credits</label>
                                <input type="number" name="amount" required min="1" step="0.01" placeholder="e.g. 100" 
                                    class="w-full px-5 py-4 bg-slate-50 rounded-3xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Reason / Description</label>
                            <input type="text" name="description" required placeholder="e.g. For monthly subscription" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-3xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeCreditModal()" class="flex-1 px-6 py-4 bg-gray-50 text-gray-400 rounded-3xl font-bold hover:bg-gray-100 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-primary-purple text-white rounded-3xl font-bold shadow-xl shadow-purple-100 hover:scale-[1.02] active:scale-95 transition-all">
                            Update Balance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreditModal(userId, userName, currentCredits) {
            const modal = document.getElementById('creditModal');
            const form = document.getElementById('creditForm');
            const nameDisplay = document.getElementById('user-name-display');
            const creditDisplay = document.getElementById('current-credits-display');

            form.action = "{{ route('admin.users.credits', ['user' => ':id']) }}".replace(':id', userId);
            nameDisplay.textContent = `Adjusting credits for ${userName}`;
            creditDisplay.textContent = parseFloat(currentCredits).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreditModal() {
            const modal = document.getElementById('creditModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-admin-layout>
