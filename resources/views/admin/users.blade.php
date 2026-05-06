<x-admin-layout>
    <div class="space-y-10">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Users Management</h1>
                <p class="text-sm text-gray-500 mt-2">Manage your team, platform users, and credit flow from one place.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative w-full sm:w-auto">
                    <input type="search" placeholder="Search users, email, role..." class="w-full sm:w-80 px-5 py-3 rounded-2xl border border-gray-200 bg-white text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2m0 0A7.5 7.5 0 103.8 3.8a7.5 7.5 0 0011.999 11.999z"></path></svg>
                </div>
                <button type="button" onclick="openNewUserModal()" class="bg-black text-white px-6 py-3 rounded-2xl text-sm font-bold hover:scale-[1.01] active:scale-95 transition-all" style="background-color: #000;">
                    Add New User
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-premium border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Total Users</p>
                        <h2 class="mt-4 text-4xl font-black text-gray-900">{{ $users->count() }}</h2>
                    </div>
                    <div class="rounded-3xl bg-primary-purple/10 p-4 text-primary-purple">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0V7M7 20V4"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total registered members on the platform.</p>
            </div>

            <div class="card-premium border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Credits Issued</p>
                        <h2 class="mt-4 text-4xl font-black text-indigo-600">{{ number_format($users->sum('credits'), 2) }}</h2>
                    </div>
                    <div class="rounded-3xl bg-indigo-100 p-4 text-indigo-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c.667 0 1.334.333 1.667.833L16 11h3l-5 5-5-5h3l2.333-2.167A1.667 1.667 0 0112 8z"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Total credits currently in circulation.</p>
            </div>

            <div class="card-premium border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Active Licenses</p>
                        <h2 class="mt-4 text-4xl font-black text-gray-900">890</h2>
                    </div>
                    <div class="rounded-3xl bg-green-100 p-4 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Members active in the last 30 days.</p>
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
                    <h3 class="text-2xl font-black text-gray-900">Platform Users</h3>
                    <p class="text-sm text-gray-500 mt-1">View and manage accounts, roles, and balances.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="bg-primary-purple text-white px-5 py-3 rounded-2xl text-sm font-bold shadow-xl shadow-purple-100 hover:scale-[1.01] active:scale-95 transition-all">
                        Export CSV
                    </button>
                    <button class="bg-white border border-gray-200 text-gray-700 px-5 py-3 rounded-2xl text-sm font-bold hover:bg-gray-50 transition-all">
                        Bulk Actions
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <th class="py-4 px-2 w-10"><input type="checkbox" class="rounded border-gray-200"></th>
                            <th class="py-4 px-4">User</th>
                            <th class="py-4 px-4">Role</th>
                            <th class="py-4 px-4 text-gray-800">Credits</th>
                            <th class="py-4 px-4">Joined Date</th>
                            <th class="py-4 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="bg-slate-50/80 hover:bg-white transition-colors rounded-3xl shadow-sm overflow-hidden">
                            <td class="py-6 px-2 align-top"><input type="checkbox" class="rounded border-gray-200"></td>
                            <td class="py-6 px-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-full {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-600' : 'bg-purple-50 text-primary-purple' }} flex items-center justify-center font-black text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-gray-900 font-black">{{ $user->name }}</p>
                                        <p class="text-[11px] text-gray-400 uppercase tracking-[0.3em]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-4 align-top">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $user->role ?? 'User' }}
                                </span>
                            </td>
                            <td class="py-6 px-4 align-top">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                    <span class="text-gray-900 font-black">{{ number_format($user->credits, 2) }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-4 align-top text-gray-400">{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="py-6 px-4 align-top text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <button onclick="openPasswordModal({{ $user->id }}, '{{ $user->name }}')" 
                                        class="bg-amber-50 text-amber-600 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                        Password
                                    </button>
                                    <button onclick="openCreditModal({{ $user->id }}, '{{ $user->name }}', {{ $user->credits }})" 
                                        class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                        Credits
                                    </button>
                                </div>
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
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Amount</label>
                                <input type="number" name="amount" required min="1" placeholder="e.g. 100" 
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

    <!-- Password Management Modal -->
    <div id="passwordModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closePasswordModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 p-10">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-gray-900" id="password-modal-title">Change User Password</h3>
                    <p class="text-sm text-gray-400 mt-2" id="password-user-name-display"></p>
                </div>

                <form id="passwordForm" method="POST" action="">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">New Password</label>
                            <input type="password" name="password" required placeholder="••••••••" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-3xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" 
                                class="w-full px-5 py-4 bg-slate-50 rounded-3xl text-sm font-bold border-transparent focus:bg-white focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all outline-none">
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closePasswordModal()" class="flex-1 px-6 py-4 bg-gray-50 text-gray-400 rounded-3xl font-bold hover:bg-gray-100 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-primary-purple text-white rounded-3xl font-bold shadow-xl shadow-purple-100 hover:scale-[1.02] active:scale-95 transition-all">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="newUserModal" class="hidden fixed inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:flex sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeNewUserModal()" style="z-index: 9998;"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 p-10" style="z-index: 9999;">
                <div class="mb-8 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900" id="modal-title">Add New User</h3>
                        <p class="text-sm text-gray-500 mt-2">Create a new administrator or standard user account.</p>
                    </div>
                    <button type="button" onclick="closeNewUserModal()" class="text-gray-400 hover:text-gray-700 transition-colors">Close</button>
                </div>

                @if($errors->hasAny(['name','email','role','credits','new_password']))
                    <div class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-3xl text-sm font-bold border border-rose-100">
                        Please correct the errors in the form below.
                    </div>
                @endif

                <form id="newUserForm" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <input type="hidden" name="new_user" value="1" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Jane Cooper" class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                            @error('name')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="jane@example.com" class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                            @error('email')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                            <select name="role" required class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all">
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Starting Credits</label>
                            <input type="number" name="credits" value="{{ old('credits', 0) }}" min="0" step="0.01" placeholder="0.00" class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                            @error('credits')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input type="password" name="new_password" required placeholder="••••••••" class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                            @error('new_password')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" name="new_password_confirmation" required placeholder="••••••••" class="w-full px-5 py-4 rounded-3xl border border-gray-200 bg-slate-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-purple/20 focus:border-primary-purple transition-all" />
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4 flex-col sm:flex-row">
                        <button type="button" onclick="closeNewUserModal()" class="w-full sm:w-auto px-6 py-4 rounded-3xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-all">Cancel</button>
                        <button type="submit" class="w-full sm:w-auto px-6 py-4 rounded-3xl bg-primary-purple text-white font-bold shadow-xl shadow-purple-100 hover:scale-[1.01] active:scale-95 transition-all">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openNewUserModal() {
            document.getElementById('newUserModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeNewUserModal() {
            document.getElementById('newUserModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        @if(old('new_user'))
            openNewUserModal();
        @endif

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
