<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Assist AI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-main: #F3F4F6;
            --sidebar-bg: #FFFFFF;
            --card-black: #111827;
            --primary-purple: #7C3AED;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
        }

        body {
            background-color: var(--bg-main);
            font-family: 'Inter', sans-serif;
            color: #111827;
            margin: 0;
            overflow: hidden;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
            width: 100vw;
        }

        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        .main-wrapper {
            display: grid;
            grid-template-columns: 1fr 380px;
            background: #FFFFFF;
            overflow: hidden;
            box-shadow: -20px 0 50px rgba(0,0,0,0.03);
        }

        .main-content {
            overflow-y: auto;
            padding: 2.5rem 3rem;
            height: 100vh;
        }

        .right-sidebar {
            background: #F9FAFB;
            border-left: 1px solid #F1F5F9;
            padding: 2.5rem 2rem;
            overflow-y: auto;
            height: 100vh;
        }

        /* Sidebar Specifics */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            color: #64748B;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background: #F1F5F9;
            color: #1E293B;
        }

        .nav-link.active {
            color: #1E293B;
            font-weight: 600;
        }

        .user-profile-card {
            text-align: center;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .avatar-main {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 4px solid #F1F5F9;
            padding: 4px;
        }

        .avatar-main img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Toggle Theme */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input { display: none; }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #E2E8F0;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px; width: 18px;
            left: 3px; bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider { background-color: var(--primary-purple); }
        input:checked + .slider:before { transform: translateX(20px); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="antialiased">
    <div class="dashboard-container">
        <!-- Left Sidebar -->
        <aside class="sidebar">
            <!-- <div class="flex items-center gap-3 mb-10 px-2">
                <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center text-white">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                </div>
                <span class="text-2xl font-black tracking-tight">iBanKo</span>
            </div> -->

            <div class="user-profile-card">
                <div class="avatar-main">
                    <img src="{{ asset('resources/images/steward_avatar.png') }}" alt="Profile">
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-gray-400 font-medium">UIUX Designer</p>
            </div>

            <div class="space-y-6 flex-1">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest px-4 mb-4">Overview</p>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <!-- <a href="#" class="nav-link">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Cards
                        </a> -->
                        <!-- <a href="#" class="nav-link">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Payments
                        </a> -->
                        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Users
                        </a>
                        <a href="{{ route('admin.credits') }}" class="nav-link {{ request()->routeIs('admin.credits') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Credit Management
                        </a>
                        <!-- <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Settings
                        </a> -->
                    </nav>
                </div>

                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest px-4 mb-4">Support</p>
                    <nav class="space-y-1">
                        
                        <a href="{{ route('admin.models') }}" class="nav-link {{ request()->routeIs('admin.models') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                            Models
                        </a>
                        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Settings
                        </a>
                        <div class="flex items-center justify-between px-4 py-2">
                            <span class="text-gray-500 font-medium">Theme</span>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 text-gray-500 font-bold hover:text-red-600 transition-colors w-full text-left">
                        Sign out
                        <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <main class="main-content">
                {{ $slot }}
            </main>

            <!-- Right Sidebar (Rendered via stack or direct injection) -->
            <aside class="right-sidebar">
                @isset($rightSidebar)
                    {{ $rightSidebar }}
                @else
                    <div class="flex flex-col gap-8">
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Transactions</h3>
                                <select class="bg-transparent border-none text-sm font-bold text-gray-500 focus:ring-0">
                                    <option>Month</option>
                                </select>
                            </div>
                            <div class="space-y-6">
                                @foreach([
                                    ['name' => 'Jane Cooper', 'date' => '08 Sep, 2022', 'amount' => '$1200', 'icon' => 'bg-green-100 text-green-600'],
                                    ['name' => 'Leslie Alexander', 'date' => '08 Sep, 2022', 'amount' => '$1750', 'icon' => 'bg-green-100 text-green-600'],
                                    ['name' => 'Flight Ticket', 'date' => '08 Sep, 2022', 'amount' => '$500', 'icon' => 'bg-orange-100 text-orange-600'],
                                    ['name' => 'Robert Fox', 'date' => '08 Sep, 2022', 'amount' => '$4300', 'icon' => 'bg-green-100 text-green-600'],
                                    ['name' => 'KFC', 'date' => '08 Sep, 2022', 'amount' => '$189', 'icon' => 'bg-red-100 text-red-600'],
                                ] as $tx)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 {{ $tx['icon'] }} rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-900">{{ $tx['name'] }}</h4>
                                                <p class="text-[11px] text-gray-400 font-medium">{{ $tx['date'] }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm font-black text-gray-900">{{ $tx['amount'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Available Card</h3>
                                <a href="#" class="text-sm font-bold text-gray-400 hover:text-gray-900">View all</a>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-blue-50 p-6 rounded-3xl relative overflow-hidden">
                                    <div class="flex justify-between items-start mb-10">
                                        <div>
                                            <p class="text-2xl font-black text-gray-900">$3,736</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Card Number</p>
                                            <p class="text-sm font-bold text-gray-900">7283 2323 7319 ****</p>
                                        </div>
                                        <div class="text-2xl font-black italic text-blue-800">VISA</div>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Exp</p>
                                            <p class="text-sm font-bold text-gray-900">**/**</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                    <div class="flex justify-between items-start mb-10">
                                        <div>
                                            <p class="text-2xl font-black text-gray-900">$21,426</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Card Number</p>
                                            <p class="text-sm font-bold text-gray-900">3253 8243 1100 ****</p>
                                        </div>
                                        <div class="w-12 h-8 bg-gray-200 rounded flex items-center justify-center text-[8px] font-black italic">AMEX</div>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Exp</p>
                                            <p class="text-sm font-bold text-gray-900">**/**</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </aside>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
