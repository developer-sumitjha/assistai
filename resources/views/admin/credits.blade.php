<x-admin-layout>
    <div class="space-y-10">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between" style="justify-content: space-between;">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Credit Management</h1>
                <p class="text-sm text-gray-500 mt-2">Manage user credits, add or subtract balances.</p>
            </div>
            <div class="flex sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative w-full sm:w-auto">
                    <input type="search" placeholder="Search users by name or email..." class="w-full sm:w-80 px-5 py-3 rounded-2xl border border-gray-200 bg-white text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="right:12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2m0 0A7.5 7.5 0 103.8 3.8a7.5 7.5 0 0011.999 11.999z"></path></svg>
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

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <th class="py-4 px-4">User</th>
                            <th class="py-4 px-4">Email</th>
                            <th class="py-4 px-4 text-gray-800">Current Credits</th>
                            <th class="py-4 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="bg-slate-50/80 hover:bg-white transition-colors rounded-3xl shadow-sm overflow-hidden">
                            <td class="py-6 px-4 align-top">
                                <a href="{{ route('admin.credits.user', $user->id) }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                                    <div class="w-11 h-11 rounded-full {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-primary-purple' }} flex items-center justify-center font-black text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-gray-900 font-black hover:text-primary-purple transition-colors">{{ $user->name }}</p>
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600' }}">
                                            {{ $user->role ?? 'User' }}
                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td class="py-6 px-4 align-middle">
                                <p class="text-sm text-gray-500 font-medium">{{ $user->email }}</p>
                            </td>
                            <td class="py-6 px-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                    <span class="text-gray-900 font-black text-lg">{{ number_format($user->credits, 2) }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-4 align-middle text-right">
                                <button onclick="openCreditModal({{ $user->id }}, '{{ $user->name }}', {{ $user->credits }})" 
                                    class="bg-indigo-50 text-indigo-600 px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    Manage Credits
                                </button>
                            </td>
                        </tr>
                        @endforeach
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
