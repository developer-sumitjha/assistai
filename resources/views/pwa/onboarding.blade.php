<x-pwa-layout>
    <div class="flex-1 flex flex-col relative overflow-hidden bg-white">
        <!-- Onboarding Carousel -->
        <div id="carousel" class="flex-1 flex transition-transform duration-500 ease-out h-full" style="width: 300%;">
            <!-- Slide 1 -->
            <div class="w-screen h-full flex flex-col items-center justify-center p-8 text-center shrink-0">
                <div class="relative w-full max-w-[280px] aspect-square mb-10 transform transition-all duration-700 delay-100 slide-element opacity-0 translate-y-10">
                    <div class="absolute inset-0 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
                    <img src="/onboarding-1.png" alt="AI Insights" class="relative z-10 w-full h-full object-contain drop-shadow-2xl">
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 slide-element opacity-0 translate-y-10 delay-200">Unlock AI Insights</h2>
                <p class="text-slate-500 leading-relaxed max-w-[280px] slide-element opacity-0 translate-y-10 delay-300">Discover the hidden potential of your data with our advanced AI analysis tools.</p>
            </div>

            <!-- Slide 2 -->
            <div class="w-screen h-full flex flex-col items-center justify-center p-8 text-center shrink-0">
                <div class="relative w-full max-w-[280px] aspect-square mb-10 transform transition-all slide-element">
                    <div class="absolute inset-0 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
                    <img src="/onboarding-2.png" alt="Data Management" class="relative z-10 w-full h-full object-contain drop-shadow-2xl">
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 slide-element">Seamless Control</h2>
                <p class="text-slate-500 leading-relaxed max-w-[280px] slide-element">Manage your projects and teams with an intuitive, glass-modern interface designed for speed.</p>
            </div>

            <!-- Slide 3 -->
            <div class="w-screen h-full flex flex-col items-center justify-center p-8 text-center shrink-0">
                <div class="relative w-full max-w-[280px] aspect-square mb-10 transform transition-all slide-element">
                    <div class="absolute inset-0 bg-indigo-500/10 rounded-full blur-3xl animate-pulse"></div>
                    <img src="/onboarding-3.png" alt="Mobile Ready" class="relative z-10 w-full h-full object-contain drop-shadow-2xl">
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 slide-element">App-Like Experience</h2>
                <p class="text-slate-500 leading-relaxed max-w-[280px] slide-element">Install AssistAI on your home screen for a fast, native-feeling experience anywhere, anytime.</p>
            </div>
        </div>

        <!-- Footer Controls -->
        <div class="p-10 flex flex-col items-center space-y-8 relative z-20">
            <!-- Pagination Dots -->
            <div class="flex space-x-2" id="dots">
                <div class="w-2 h-2 rounded-full bg-blue-600 transition-all duration-300" data-idx="0"></div>
                <div class="w-2 h-2 rounded-full bg-slate-200 transition-all duration-300" data-idx="1"></div>
                <div class="w-2 h-2 rounded-full bg-slate-200 transition-all duration-300" data-idx="2"></div>
            </div>

            <!-- Actions -->
            <div class="w-full flex flex-col space-y-4">
                <button id="nextBtn" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-bold shadow-xl shadow-slate-200 active:scale-95 transition-all">
                    Next Step
                </button>
                <a href="{{ route('user.login') }}" id="skipLink" class="text-center py-2 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                    Skip onboarding
                </a>
            </div>
        </div>
    </div>

    <script>
        const carousel = document.getElementById('carousel');
        const nextBtn = document.getElementById('nextBtn');
        const dots = document.querySelectorAll('#dots div');
        let currentSlide = 0;

        function updateSlide() {
            // Update Carousel Position
            carousel.style.transform = `translateX(-${currentSlide * 100 / 3}%)`;
            
            // Update Dots
            dots.forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.classList.replace('bg-slate-200', 'bg-blue-600');
                    dot.style.width = '24px';
                } else {
                    dot.classList.replace('bg-blue-600', 'bg-slate-200');
                    dot.style.width = '8px';
                }
            });

            // Update Elements Animation
            const slides = document.querySelectorAll('#carousel > div');
            slides.forEach((slide, idx) => {
                const elements = slide.querySelectorAll('.slide-element');
                if (idx === currentSlide) {
                    elements.forEach(el => el.classList.replace('opacity-0', 'opacity-100'));
                    elements.forEach(el => el.classList.replace('translate-y-10', 'translate-y-0'));
                } else {
                     // Optionally hide others if you want them to re-animate
                }
            });

            // Final Slide CTA
            if (currentSlide === 2) {
                nextBtn.innerText = 'Get Started';
                nextBtn.classList.replace('bg-slate-900', 'bg-blue-600');
                nextBtn.classList.add('shadow-blue-200');
            } else {
                nextBtn.innerText = 'Next Step';
                nextBtn.classList.replace('bg-blue-600', 'bg-slate-900');
            }
        }

        nextBtn.addEventListener('click', () => {
            if (currentSlide < 2) {
                currentSlide++;
                updateSlide();
            } else {
                window.location.href = "{{ route('user.login') }}";
            }
        });

        // Initialize First Slide
        setTimeout(updateSlide, 100);
    </script>

    <style>
        /* Force no horizontal scroll */
        html, body { overflow-x: hidden; }
        .slide-element { transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</x-pwa-layout>
