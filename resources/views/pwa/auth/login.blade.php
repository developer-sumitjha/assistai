<x-pwa-layout>
    <div class="relative flex flex-col flex-1 items-center justify-center p-6 sm:p-10">
        <!-- Background Banner -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-20" style="background-image: url('/login-banner.png');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-transparent to-slate-50"></div>

        <div class="relative z-10 w-full max-w-sm space-y-8 glass-card p-8 rounded-3xl shadow-2xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Welcome Back</h1>
                <p class="text-slate-500 mt-2 text-sm font-medium">Log in to your AssistAI account</p>
            </div>

            <form action="{{ route('user.login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 px-1">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" required autofocus 
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
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                        <span class="text-xs font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Remember me</span>
                    </label>
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Forgot Pwd?</a>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-blue-500/20 transform active:scale-[0.98] transition-all">
                    Sign In
                </button>
            </form>

            <div class="pt-6 border-t border-slate-100">
                <p class="text-center text-xs font-medium text-slate-400">
                    Don't have an account? <a href="#" class="text-blue-600 font-bold hover:underline">Register</a>
                </p>
            </div>
        </div>
    </div>
</x-pwa-layout>
