@props(['active' => 'home'])

<div x-data="{ showMenu: false }" @keydown.escape.window="showMenu = false" class="relative">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .chat-menu-popup {
            height: 90vh;
            border-top-right-radius: 30px;
            border-top-left-radius: 30px;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 20px;
        }
    </style>

    <!-- Dark Overlay -->
    <div x-show="showMenu" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="showMenu = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[99998]">
    </div>

    <!-- Bottom Sheet Popup -->
    <div x-show="showMenu" x-cloak x-transition:enter="transition ease-out duration-500 transform"
        x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="fixed bottom-0 left-0 right-0 chat-menu-popup bg-slate-50 rounded-t-[45px] shadow-[0_-25px_80px_-15px_rgba(0,0,0,0.3)] z-[99999] flex flex-col overflow-hidden border-t border-white/20">

        <!-- Handle Bar (Dismissal Handle) -->
        <div class="w-full flex justify-center py-4 cursor-grab active:cursor-grabbing" @click="showMenu = false">
            <div class="w-12 h-1.5 bg-slate-300 rounded-full opacity-60"></div>
        </div>

        <!-- Header -->
        <div class="px-6 pb-6 pt-2 mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Create New</h3>
                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest mt-1">Select AI Power</p>
            </div>
            <button @click="showMenu = false"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-slate-400 shadow-sm border border-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Options List (Scrollable) -->
        <div class="flex-1 overflow-y-auto min-h-0 px-6 space-y-4 pb-32 custom-scrollbar" style="touch-action: pan-y;">
            <!-- Text to Text -->
            <a href="{{ route('user.chat.new') }}" class="block group">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all hover:border-blue-100 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-black text-slate-700 group-hover:text-blue-600 transition-colors uppercase tracking-tight">
                                    Text to Text</h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">AI chatbot
                                    assistant</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-300 group-hover:text-blue-400 transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Text to Speech -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15L4 14a1 1 0 010-3l1.586-1a2 2 0 00.828-1.586V8a2 2 0 012-2h2a2 2 0 012 2v1.414a2 2 0 00.828 1.586L15 11v2l-1.586 1a2 2 0 00-.828 1.586V16a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.414a2 2 0 00-.828-1.586z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Text to Speech
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                        <span
                            class="px-2 py-0.5 bg-slate-50 text-[8px] font-black text-slate-400 rounded-md uppercase tracking-tighter">Disabled</span>
                    </div>
                </div>
            </div>

            <!-- Text to Image -->
            <a href="{{ route('user.image') }}" class="block group">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all hover:border-amber-100 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-black text-slate-700 group-hover:text-amber-600 transition-colors uppercase tracking-tight">
                                    Text to Image</h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">High Quality AI
                                    Art</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-300 group-hover:text-amber-400 transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Image to Image -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Image to Image
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text to Video -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Text to Video
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image to Video -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Image to Video
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Image -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Template Image
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Video -->
            <div class="block group opacity-75">
                <div
                    class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm group-active:scale-[0.98] transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-tight">Template Video
                                </h3>
                                <p class="text-[10px] text-slate-400 font-semibold capitalize mt-0.5">Coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 z-[1001] px-6 pb-8 pt-4 pointer-events-none">
        <div
            class="max-w-md mx-auto relative flex items-end justify-between bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-[35px] px-2 py-2 pointer-events-auto">

            <!-- Home -->
            <a href="{{ route('user.dashboard') }}" class="flex-1 group">
                <div
                    class="flex flex-col items-center justify-center py-2 px-1 transition-all duration-300 {{ $active === 'home' ? 'bg-blue-600 rounded-[24px] text-white' : 'text-slate-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span
                        class="text-[10px] font-bold mt-1 {{ $active === 'home' ? '' : 'text-slate-400 font-medium' }}">Home</span>
                </div>
            </a>

            <!-- Chat History -->
            <a href="{{ route('user.chat') }}" class="flex-1 group">
                <div
                    class="flex flex-col items-center justify-center py-2 px-1 transition-all duration-300 {{ $active === 'chat' ? 'bg-blue-600 rounded-[24px] text-white' : 'text-slate-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span
                        class="text-[10px] font-bold mt-1 {{ $active === 'chat' ? '' : 'text-slate-400 font-medium' }}">Chat</span>
                </div>
            </a>

            <!-- Plus Button -->
            <div class="flex-none -translate-y-8 px-2">
                <button @click="showMenu = !showMenu"
                    class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-[0_10px_25px_rgba(37,99,235,0.4)] border-4 border-white active:scale-90 transition-all duration-500 z-[10002]"
                    :class="showMenu ? 'rotate-[135deg] bg-rose-500 shadow-[0_10px_25px_rgba(244,63,94,0.4)]' : ''">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

            <!-- Calendar -->
            <a href="#" class="flex-1 group">
                <div
                    class="flex flex-col items-center justify-center py-2 px-1 transition-all duration-300 {{ $active === 'calendar' ? 'bg-blue-600 rounded-[24px] text-white' : 'text-slate-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span
                        class="text-[10px] font-bold mt-1 {{ $active === 'calendar' ? '' : 'text-slate-400 font-medium' }}">History</span>
                </div>
            </a>

            <!-- Profile -->
            <a href="{{ route('user.profile') }}" class="flex-1 group">
                <div
                    class="flex flex-col items-center justify-center py-2 px-1 transition-all duration-300 {{ $active === 'profile' ? 'bg-blue-600 rounded-[24px] text-white' : 'text-slate-400' }}">
                    <div
                        class="w-6 h-6 rounded-full overflow-hidden border-2 {{ $active === 'profile' ? 'border-white' : 'border-slate-200' }}">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Profile"
                            class="w-full h-full object-cover">
                    </div>
                    <span
                        class="text-[10px] font-bold mt-1 {{ $active === 'profile' ? '' : 'text-slate-400 font-medium' }}">Account</span>
                </div>
            </a>

        </div>
    </nav>
</div>