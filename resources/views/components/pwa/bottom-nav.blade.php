@props(['active' => 'home'])

<div
    style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 5000; padding: 12px 24px 12px; background: linear-gradient(to top, #F2F2F2, rgba(242, 242, 242, 0.95), transparent); pointer-events: none; margin-bottom: 0px">
    <div class="max-w-md mx-auto flex justify-between items-center pointer-events-auto">
        <!-- Left Pill -->
        <div class="flex items-center space-x-1 p-2 bg-black rounded-full shadow-2xl gap-2"
            style="background-color: black !important;">
            <a href="{{ route('user.dashboard') }}"
                class="w-[52px] h-[52px] flex items-center justify-center rounded-full transition-all active:scale-90 {{ $active === 'home' ? 'bg-white/10' : '' }}">
                <i data-lucide="home" class="w-5 h-5 text-white"></i>
            </a>
            <a href="{{ route('user.chat') }}"
                class="w-[52px] h-[52px] flex items-center justify-center rounded-full transition-all active:scale-90 {{ $active === 'chat' ? 'bg-white/10' : '' }}">
                <i data-lucide="message-circle" class="w-5 h-5 text-white"></i>
            </a>
            <a href="{{ route('user.profile') }}"
                class="w-[52px] h-[52px] flex items-center justify-center rounded-full transition-all active:scale-90 {{ $active === 'profile' ? 'bg-white/10' : '' }}">
                <i data-lucide="user" class="w-5 h-5 text-white"></i>
            </a>
        </div>

        <!-- Right FAB (Hidden on Homepage) -->
        @if($active !== 'home')
            <button onclick="toggleFeaturePopup()"
                class="w-[64px] h-[64px] flex items-center justify-center bg-black text-white rounded-full shadow-2xl transition-transform active:scale-90"
                style="background-color: black !important; width: 40px; height: 40px;">
                <i data-lucide="plus" class="w-8 h-8"></i>
            </button>
        @endif
    </div>
</div>

<!-- Feature Popup Component -->
@if($active !== 'home')
    <x-pwa.feature-popup />
@endif