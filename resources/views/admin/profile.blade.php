<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-primary-purple mb-2">My Profile_</h1>
        <p class="text-sm text-gray-400">Manage your personal information and security settings.</p>
    </div>

    <!-- Profile Header/Summary (Style matched to Basic plan card) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Personal Information Card -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl bg-purple-100 flex items-center justify-center text-primary-purple text-3xl font-black shadow-inner">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-400 italic">{{ Auth::user()->email }}</p>
                        <span class="mt-2 inline-block px-3 py-1 rounded-full bg-green-100 text-green-600 text-[10px] font-black uppercase">Verified Administrator</span>
                    </div>
                </div>
            </div>
            
            <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Account Created: {{ Auth::user()->created_at?->format('M Y') ?? 'N/A' }}</p>
                <button class="flex items-center gap-2 text-primary-purple font-bold text-sm uppercase tracking-widest hover:underline transition-all">
                    Edit Profile
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Security & Access Card (Style matched to Payment method card) -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Security_Settings</h3>
                <p class="text-xs text-gray-400 italic mb-8">Maintain the security of your administrative account.</p>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 italic">Authentication Key</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Last Changed 3 Days Ago</p>
                    </div>
                </div>
                <button class="bg-primary-purple text-white px-6 py-2 rounded-xl text-xs font-bold shadow-md shadow-purple-100">
                    Update_
                </button>
            </div>
        </div>
    </div>

    <!-- Account Activity (Style matched to Billing history table) -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-10 text-gray-500">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Account Activity</h3>
                <p class="text-sm text-gray-400 mt-1 italic">Review your recent login sessions and administrative actions.</p>
            </div>
            <button class="bg-primary-purple text-white px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-purple-200">
                Log Out All Sessions
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 text-gray-500">
                        <th class="py-4 px-2 w-10"><input type="checkbox" class="rounded border-gray-200"></th>
                        <th class="py-4 px-4">Action/Event</th>
                        <th class="py-4 px-4">Timestamp</th>
                        <th class="py-4 px-4">Location</th>
                        <th class="py-4 px-4">Device</th>
                        <th class="py-4 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
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
                    <tr class="group hover:bg-gray-50 transition-colors text-gray-500">
                        <td class="py-6 px-2"><input type="checkbox" class="rounded border-gray-200"></td>
                        <td class="py-6 px-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-50 rounded-lg text-primary-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3a9.99 9.99 0 00-4.534 1.08l.094.053m10.948 4.96c.117.495.163.933.163 1.407 0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 21a9.99 9.99 0 00-4.534-1.08l.094.053" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 italic">{{ $activity['action'] }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">System Event</p>
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
</x-admin-layout>
