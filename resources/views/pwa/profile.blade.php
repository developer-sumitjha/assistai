<x-pwa-layout>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="flex flex-col min-h-screen bg-[#F2F2F2]">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-900"></i>
                    </a>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-800 tracking-tight">Profile</h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">Settings</p>
                    </div>
                </div>
            </x-slot:left>
            <x-slot:right>
                <form action="{{ route('user.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-full bg-rose-50 border border-rose-100 shadow-sm active:scale-95 transition-transform text-rose-500">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </x-slot:right>
        </x-pwa.top-nav>

        <main class="flex-1 p-6 space-y-8 pb-16 overflow-y-auto" style="padding-top: 120px !important;">
        <!-- Profile Avatar Section -->
        <section class="flex flex-col items-center">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-xl overflow-hidden shadow-blue-200">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Profile" class="w-full h-full object-cover rounded-full bg-white">
                </div>
                <button class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-white shadow-lg border-2 border-white flex items-center justify-center text-blue-600 hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-xl font-bold text-slate-800">{{ $user->name }}</h3>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">{{ $user->role }} ACCOUNT</p>
            </div>
        </section>

        <!-- Account Details Form -->
        <section class="space-y-4">
            <div class="flex items-center space-x-2 px-1">
                <div class="w-1 h-4 bg-blue-600 rounded-full"></div>
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Account Details</h4>
            </div>
            <div class="p-6 bg-white rounded-[32px] border border-slate-50 shadow-sm space-y-6">
                @if (session('status') === 'profile-updated')
                    <div class="p-3 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-2xl flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Profile updated successfully!</span>
                    </div>
                @endif
                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-medium border-transparent focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-medium border-transparent focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-100 active:scale-95 transition-all">
                        Save Changes
                    </button>
                </form>
            </div>
        </section>

        <!-- Security / Password Section -->
        <section class="space-y-4">
            <div class="flex items-center space-x-2 px-1">
                <div class="w-1 h-4 bg-indigo-600 rounded-full"></div>
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Security & Privacy</h4>
            </div>
            <div class="p-6 bg-white rounded-[32px] border border-slate-50 shadow-sm space-y-6">
                @if (session('status') === 'password-updated')
                    <div class="p-3 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-2xl flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Password changed successfully.</span>
                    </div>
                @endif
                <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1.5">Current Password</label>
                        <input type="password" name="current_password" required
                            class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-medium border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                        @error('current_password')
                            <p class="text-rose-500 text-[10px] mt-1.5 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1.5">New Password</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-medium border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-5 py-4 bg-slate-50 rounded-2xl text-sm font-medium border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                    </div>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-xl shadow-blue-100 active:scale-95 transition-all">
                        Update Password
                    </button>
                </form>
            </div>
        </section>

        <!-- Premium Bottom Navigation -->
        <x-pwa.bottom-nav active="profile" />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</x-pwa-layout>
