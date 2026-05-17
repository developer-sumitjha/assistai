<x-pwa-layout>
    <div class="relative flex flex-col flex-1 items-center justify-center p-6 sm:p-10">
        <!-- Background Banner -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-20" style="background-image: url('/login-banner.png');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-transparent to-slate-50"></div>

        <div class="relative z-10 w-full max-w-sm space-y-8 glass-card p-8 rounded-3xl shadow-2xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Create Account</h1>
                <p class="text-slate-500 mt-2 text-sm font-medium">Join AssistAI today</p>
            </div>

            <form action="{{ route('user.register') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 px-1">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input type="text" name="name" id="name" required autofocus value="{{ old('name') }}"
                            class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm placeholder-slate-400"
                            placeholder="John Doe">
                    </div>
                    @error('name')
                        <p class="mt-2 text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 px-1">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                            class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm placeholder-slate-400"
                            placeholder="user@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required 
                            class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm placeholder-slate-400"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 px-1">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                            class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm placeholder-slate-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-blue-500/20 transform active:scale-[0.98] transition-all">
                    Register
                </button>
            </form>

            <div class="pt-6 border-t border-slate-100">
                <p class="text-center text-xs font-medium text-slate-400">
                    Already have an account? <a href="{{ route('user.login') }}" class="text-blue-600 font-bold hover:underline">Log in</a>
                </p>
            </div>
        </div>
    </div>
</x-pwa-layout>
