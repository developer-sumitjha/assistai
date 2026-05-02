<x-admin-layout>
    <div class="max-w-4xl">
        <div class="mb-12">
            <h2 class="text-4xl font-black text-gray-900 mb-4">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            <p class="text-lg text-gray-500 leading-relaxed">
                Your administrative control panel is ready. From here, you can manage users, monitor system performance, and configure your AI Hub settings.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Functional Quick Link: Users -->
            <a href="{{ route('admin.users') }}" class="group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-purple-100 hover:border-primary-purple transition-all flex h-full">
                <div class="flex-1">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center text-primary-purple group-hover:bg-primary-purple group-hover:text-white transition-all mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Manage Users</h3>
                    <p class="text-sm text-gray-500">View and manage all system accounts.</p>
                </div>
            </a>

            <!-- Credits Statistics -->
            <div class="group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-indigo-100 hover:border-indigo-600 transition-all flex h-full">
                <div class="flex-1">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Credits Issued</p>
                    <h3 class="text-3xl font-black text-gray-900 mb-2">{{ number_format(\App\Models\User::sum('credits'), 2) }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">In Circulation</p>
                </div>
            </div>

            <!-- Functional Quick Link: Profile -->
            <a href="{{ route('admin.profile') }}" class="group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-blue-100 hover:border-blue-600 transition-all flex h-full">
                <div class="flex-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Admin Profile</h3>
                    <p class="text-sm text-gray-500">Update your security settings.</p>
                </div>
            </a>
        </div>

        <!-- Optional: System Status (Clean/Minimal) -->
        <div class="mt-12 bg-gray-50 rounded-3xl p-8 border border-gray-100 italic">
            <div class="flex items-center gap-4 text-gray-500">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold uppercase tracking-widest">All Systems Operational</span>
            </div>
        </div>
    </div>
</x-admin-layout>
