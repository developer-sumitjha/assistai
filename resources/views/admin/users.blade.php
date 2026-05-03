<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-primary-purple mb-2">Users Management</h1>
        <p class="text-sm text-gray-500">Manage your team and platform users here.</p>
    </div>

    <!-- Active Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10 text-gray-500">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4 text-gray-900">Total Users</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-gray-800">{{ $users->count() }}</span>
            </div>
            <p class="mt-2 text-xs opacity-70">Total registered members</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4 text-gray-900">Credits Issued</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-indigo-600">{{ number_format($users->sum('credits'), 2) }}</span>
            </div>
            <p class="mt-2 text-xs opacity-70">Total credits currently in circulation</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4 text-gray-900">Active Licenses</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-gray-800">890</span>
                <span class="text-sm font-bold text-green-500">+12%</span>
            </div>
            <p class="mt-2 text-xs opacity-70">Members active in the last 30 days</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 rounded-2xl text-sm font-bold border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-2xl text-sm font-bold border border-rose-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Platform Users</h3>
                <p class="text-sm text-gray-400 mt-1">Manage all accounts, permissions, and credits.</p>
            </div>
            <button class="bg-primary-purple text-white px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-100 transition-all hover:scale-105 active:scale-95">
                Add new user
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="py-4 px-2 w-10"><input type="checkbox" class="rounded border-gray-200"></th>
                        <th class="py-4 px-4">User</th>
                        <th class="py-4 px-4">Role</th>
                        <th class="py-4 px-4 text-gray-800">Credits</th>
                        <th class="py-4 px-4">Joined Date</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="group text-sm font-medium text-gray-600 hover:bg-slate-50/50 transition-colors">
                        <td class="py-6 px-2"><input type="checkbox" class="rounded border-gray-200"></td>
                        <td class="py-6 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-primary-purple' }} flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600' }}">
                                {{ $user->role ?? 'User' }}
                            </span>
                        </td>
                        <td class="py-6 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                <span class="text-gray-900 font-black">{{ number_format($user->credits, 2) }}</span>
                            </div>
                        </td>
                        <td class="py-6 px-4 text-gray-400">{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                        <td class="py-6 px-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button onclick="openPasswordModal({{ $user->id }}, '{{ $user->name }}')" 
                                    class="bg-amber-50 text-amber-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                    Change Password
                                </button>
                                <button onclick="openCreditModal({{ $user->id }}, '{{ $user->name }}', {{ $user->credits }})" 
                                    class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    Manage Credits
                                </button>
                                <button class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-xs font-bold hover:bg-primary-purple hover:text-white transition-all shadow-sm">
                                    Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Credit Management Modal -->
    <div id="creditModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeCreditModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 p-10">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900" id="modal-title">Manage User Credits</h3>
                    <p class="text-sm text-gray-400 mt-2" id="user-name-display"></p>
                </div>

                <form id="creditForm" method="POST" action="">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Current Balance</label>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <span class="text-xl font-black text-indigo-600" id="current-credits-display">0</span>
                                <span class="text-xs font-bold text-gray-400 ml-1">Credits</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Action Type</label>
                                <select name="type" required class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                                    <option value="add">Add Credits</option>
                                    <option value="subtract">Subtract Credits</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Amount</label>
                                <input type="number" name="amount" required min="1" placeholder="e.g. 100" 
                                    class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Reason / Description</label>
                            <input type="text" name="description" required placeholder="e.g. For monthly subscription" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeCreditModal()" class="flex-1 px-6 py-4 bg-gray-50 text-gray-400 rounded-2xl font-bold hover:bg-gray-100 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-primary-purple text-white rounded-2xl font-bold shadow-xl shadow-purple-100 hover:scale-[1.02] active:scale-95 transition-all">
                            Update Balance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Management Modal -->
    <div id="passwordModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closePasswordModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 p-10">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900" id="password-modal-title">Change User Password</h3>
                    <p class="text-sm text-gray-400 mt-2" id="password-user-name-display"></p>
                </div>

                <form id="passwordForm" method="POST" action="">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">New Password</label>
                            <input type="password" name="password" required placeholder="••••••••" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closePasswordModal()" class="flex-1 px-6 py-4 bg-gray-50 text-gray-400 rounded-2xl font-bold hover:bg-gray-100 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-primary-purple text-white rounded-2xl font-bold shadow-xl shadow-purple-100 hover:scale-[1.02] active:scale-95 transition-all">
                            Update Password
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

        function openPasswordModal(userId, userName) {
            const modal = document.getElementById('passwordModal');
            const form = document.getElementById('passwordForm');
            const nameDisplay = document.getElementById('password-user-name-display');

            form.action = "{{ route('admin.users.password', ['user' => ':id']) }}".replace(':id', userId);
            nameDisplay.textContent = `Setting new password for ${userName}`;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-admin-layout>
