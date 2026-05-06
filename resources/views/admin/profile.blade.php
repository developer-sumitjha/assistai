<x-admin-layout>
    <div class="space-y-10">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">My Profile</h1>
            <p class="text-sm text-gray-500 mt-2">Manage your personal information and security settings with the same dashboard experience.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="card-black overflow-hidden relative p-8 min-h-[320px]">
                <div class="absolute -right-24 -top-24 w-52 h-52 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -left-20 bottom-10 w-44 h-44 rounded-full bg-primary-purple/20 blur-2xl"></div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center gap-5 mb-8">
                            <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center text-white text-4xl font-black">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-3xl font-black text-white">{{ Auth::user()->name }}</h2>
                                <p class="text-sm text-white/70 mt-1">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="grid gap-4">
                            <div class="rounded-3xl bg-white/10 p-5 border border-white/10">
                                <p class="text-xs uppercase tracking-[0.3em] text-white/60">Status</p>
                                <p class="mt-3 text-lg font-black text-white">Verified Administrator</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-5 border border-white/10">
                                <p class="text-xs uppercase tracking-[0.3em] text-white/60">Account Created</p>
                                <p class="mt-3 text-lg font-black text-white">{{ Auth::user()->created_at?->format('M Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <button class="mt-8 inline-flex items-center justify-center gap-2 rounded-3xl bg-white text-primary-purple px-6 py-3 font-bold shadow-xl shadow-primary-purple/20 hover:scale-[1.01] active:scale-95 transition-all w-full">
                        Edit Profile
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="xl:col-span-2 grid grid-cols-1 gap-8">
                <div class="card-premium border border-gray-100 p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Security & Access</h3>
                            <p class="text-sm text-gray-500 mt-1">Keep your admin account safe with the latest security controls.</p>
                        </div>
                        <button class="bg-primary-purple text-white px-6 py-3 rounded-3xl text-sm font-bold shadow-xl shadow-purple-100 hover:scale-[1.01] active:scale-95 transition-all">
                            Update Authentication
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-3xl bg-slate-50 p-6 border border-gray-100 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Latest password change</p>
                            <p class="mt-4 text-lg font-black text-gray-900">3 days ago</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6 border border-gray-100 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Login method</p>
                            <p class="mt-4 text-lg font-black text-gray-900">Email + 2FA</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6 border border-gray-100 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Session devices</p>
                            <p class="mt-4 text-lg font-black text-gray-900">3 active</p>
                        </div>
                    </div>
                </div>

                <div class="card-premium border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Account Activity</h3>
                            <p class="text-sm text-gray-500 mt-1">Review your recent login sessions and administrative actions.</p>
                        </div>
                        <button class="bg-primary-purple text-white px-6 py-3 rounded-3xl text-sm font-bold uppercase tracking-[0.2em] shadow-xl shadow-purple-100 hover:scale-[1.01] active:scale-95 transition-all">
                            Log Out All Sessions
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="py-4 px-2 w-10"><input type="checkbox" class="rounded border-gray-200"></th>
                                    <th class="py-4 px-4">Action/Event</th>
                                    <th class="py-4 px-4">Timestamp</th>
                                    <th class="py-4 px-4">Location</th>
                                    <th class="py-4 px-4">Device</th>
                                    <th class="py-4 px-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $activities = [
                                        ['action' => 'User Login', 'time' => '10 Minutes Ago', 'loc' => 'Kathmandu, NP', 'device' => 'MacBook Pro / Chrome'],
                                        ['action' => 'Password Changed', 'time' => '3 Days Ago', 'loc' => 'Kathmandu, NP', 'device' => 'MacBook Pro / Chrome'],
                                        ['action' => 'User Login', 'time' => '4 Days Ago', 'loc' => 'Kathmandu, NP', 'device' => 'iPhone 13 / Safari'],
                                        ['action' => 'API Key Generated', 'time' => '1 Week Ago', 'loc' => 'Kathmandu, NP', 'device' => 'MacBook Pro / Chrome'],
                                        ['action' => 'Profile Updated', 'time' => '2 Weeks Ago', 'loc' => 'Kathmandu, NP', 'device' => 'MacBook Pro / Chrome'],
                                    ];
                                @endphp

                                @foreach($activities as $activity)
                                <tr class="bg-slate-50/90 hover:bg-white transition-colors rounded-3xl shadow-sm overflow-hidden">
                                    <td class="py-6 px-2 align-top"><input type="checkbox" class="rounded border-gray-200"></td>
                                    <td class="py-6 px-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-purple-50 rounded-2xl text-primary-purple">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3a9.99 9.99 0 00-4.534 1.08l.094.053m10.948 4.96c.117.495.163.933.163 1.407 0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 21a9.99 9.99 0 00-4.534-1.08l.094.053" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-gray-900 italic">{{ $activity['action'] }}</p>
                                                <p class="text-[10px] text-gray-400 font-black uppercase">System Event</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-4 text-xs font-bold text-gray-500 italic">{{ $activity['time'] }}</td>
                                    <td class="py-6 px-4 text-xs font-bold text-gray-500 italic">{{ $activity['loc'] }}</td>
                                    <td class="py-6 px-4 text-xs font-bold text-gray-500 italic">{{ $activity['device'] }}</td>
                                    <td class="py-6 px-4 text-right">
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-[10px] font-black uppercase">Successful</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
