<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <!-- Left Side with Background Image -->
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex">
                <!-- Background Image Slider -->
                <div class="absolute inset-0 overflow-hidden">
                    <!-- Slide 1 -->
                    <div class="auth-slide auth-slide-active">
                        <img src="{{ asset('images/pexels-ajaybhargavguduru-939723.jpg') }}"
                             alt="Tent camping in mountains"
                             class="w-full h-full object-cover transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="auth-slide">
                        <img src="{{ asset('images/pexels-cliford-mervil-988071-2398220.jpg') }}"
                             alt="Adventure camping setup"
                             class="w-full h-full object-cover transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="auth-slide">
                        <img src="{{ asset('images/pexels-todd-trapani-488382-2609954.jpg') }}"
                             alt="Camping under starry night"
                             class="w-full h-full object-cover transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="auth-slide">
                        <img src="{{ asset('images/pexels-toulouse-3195757.jpg') }}"
                             alt="Mountain camping experience"
                             class="w-full h-full object-cover transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                </div>

                <!-- Slide Indicators -->
                <div class="absolute bottom-10 left-10 z-30 flex space-x-2">
                    <button class="auth-indicator auth-indicator-active w-3 h-3 rounded-full bg-white/50 transition-all duration-300 hover:bg-white/80" data-slide="0"></button>
                    <button class="auth-indicator w-3 h-3 rounded-full bg-white/30 transition-all duration-300 hover:bg-white/80" data-slide="1"></button>
                    <button class="auth-indicator w-3 h-3 rounded-full bg-white/30 transition-all duration-300 hover:bg-white/80" data-slide="2"></button>
                    <button class="auth-indicator w-3 h-3 rounded-full bg-white/30 transition-all duration-300 hover:bg-white/80" data-slide="3"></button>
                </div>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'PinjemTent') }}
                </a>

                <!-- Quote Section -->
                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-4">
                        <!-- Dynamic Quote Content -->
                        <div class="auth-quote auth-quote-active">
                            <flux:heading size="lg" class="text-white leading-relaxed">
                                &ldquo;Adventure awaits in every tent, and every journey begins with a single step into the wilderness.&rdquo;
                            </flux:heading>
                            <footer>
                                <flux:heading class="text-white/80">PinjemTent Team</flux:heading>
                            </footer>
                        </div>

                        <div class="auth-quote">
                            <flux:heading size="lg" class="text-white leading-relaxed">
                                &ldquo;In the heart of nature, we find our true selves and the peace that urban life cannot provide.&rdquo;
                            </flux:heading>
                            <footer>
                                <flux:heading class="text-white/80">PinjemTent Team</flux:heading>
                            </footer>
                        </div>

                        <div class="auth-quote">
                            <flux:heading size="lg" class="text-white leading-relaxed">
                                &ldquo;Under the stars, every tent becomes a doorway to infinite possibilities and dreams.&rdquo;
                            </flux:heading>
                            <footer>
                                <flux:heading class="text-white/80">PinjemTent Team</flux:heading>
                            </footer>
                        </div>

                        <div class="auth-quote">
                            <flux:heading size="lg" class="text-white leading-relaxed">
                                &ldquo;Mountains teach us that the greatest views come after the most challenging climbs.&rdquo;
                            </flux:heading>
                            <footer>
                                <flux:heading class="text-white/80">PinjemTent Team</flux:heading>
                            </footer>
                        </div>
                    </blockquote>
                </div>
            </div>

            <!-- Right Side with Auth Form -->
            <div class="w-full lg:p-8 bg-white dark:bg-neutral-900">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <!-- Mobile Logo -->
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>
                        <span class="sr-only">{{ config('app.name', 'PinjemTent') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Auth Image Slider Styles & Scripts -->
        <style>
            /* Auth Image Slides */
            .auth-slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1;
            }

            .auth-slide-active {
                opacity: 1;
                z-index: 2;
            }

            .auth-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                filter: brightness(0.72) contrast(1.08);
                will-change: opacity;
                backface-visibility: hidden;
                -webkit-backface-visibility: hidden;
            }

            /* Auth Quotes */
            .auth-quote {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                opacity: 0;
                transform: translateY(15px);
                transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1;
            }

            .auth-quote-active {
                opacity: 1;
                transform: translateY(0);
                z-index: 2;
                position: relative;
            }

            /* Indicators */
            .auth-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                border: 2px solid rgba(255, 255, 255, 0.5);
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(8px);
            }

            .auth-indicator:hover {
                background: rgba(255, 255, 255, 0.6) !important;
                border-color: rgba(255, 255, 255, 0.8);
                transform: scale(1.15);
            }

            .auth-indicator-active {
                background: rgba(255, 255, 255, 0.9) !important;
                border-color: rgba(255, 255, 255, 1);
                transform: scale(1.25);
                box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            }

            /* Quote container */
            blockquote {
                position: relative;
                min-height: 140px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Performance optimizations */
            .auth-slide,
            .auth-quote {
                will-change: opacity, transform;
            }

            /* Responsive adjustments */
            @media (max-width: 1024px) {
                .auth-indicators {
                    bottom: 1.5rem;
                }

                .auth-indicator {
                    width: 10px;
                    height: 10px;
                }

                blockquote {
                    min-height: 100px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slides = document.querySelectorAll('.auth-slide');
                const indicators = document.querySelectorAll('.auth-indicator');
                const quotes = document.querySelectorAll('.auth-quote');
                let currentSlide = 0;
                let slideInterval;

                // Preload all images
                slides.forEach(slide => {
                    const img = slide.querySelector('img');
                    if (img && img.src) {
                        const preloadImg = new Image();
                        preloadImg.src = img.src;
                    }
                });

                function showSlide(index) {
                    // Remove active class from all slides, indicators, and quotes
                    slides.forEach(slide => slide.classList.remove('auth-slide-active'));
                    indicators.forEach(indicator => indicator.classList.remove('auth-indicator-active'));
                    quotes.forEach(quote => quote.classList.remove('auth-quote-active'));

                    // Add active class to current slide, indicator, and quote
                    if (slides[index]) {
                        slides[index].classList.add('auth-slide-active');
                    }
                    if (indicators[index]) {
                        indicators[index].classList.add('auth-indicator-active');
                    }
                    if (quotes[index]) {
                        quotes[index].classList.add('auth-quote-active');
                    }

                    currentSlide = index;
                }

                function nextSlide() {
                    const next = (currentSlide + 1) % slides.length;
                    showSlide(next);
                }

                function startSlideshow() {
                    slideInterval = setInterval(nextSlide, 6000); // Change slide every 6 seconds
                }

                function stopSlideshow() {
                    if (slideInterval) {
                        clearInterval(slideInterval);
                    }
                }

                // Manual control via indicators
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        stopSlideshow();
                        showSlide(index);

                        // Restart slideshow after manual interaction
                        setTimeout(startSlideshow, 12000); // Wait 12 seconds before auto-resume
                    });

                    // Add hover effect
                    indicator.addEventListener('mouseenter', () => {
                        if (!indicator.classList.contains('auth-indicator-active')) {
                            indicator.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
                        }
                    });

                    indicator.addEventListener('mouseleave', () => {
                        if (!indicator.classList.contains('auth-indicator-active')) {
                            indicator.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                        }
                    });
                });

                // Pause slideshow on hover over the left side
                const leftSide = document.querySelector('.relative.hidden.h-full.flex-col.p-10.text-white.lg\\:flex');
                if (leftSide) {
                    leftSide.addEventListener('mouseenter', stopSlideshow);
                    leftSide.addEventListener('mouseleave', startSlideshow);
                }

                // Start the slideshow
                startSlideshow();

                // Keyboard navigation (optional enhancement)
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        stopSlideshow();
                        const prev = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
                        showSlide(prev);
                        setTimeout(startSlideshow, 12000);
                    } else if (e.key === 'ArrowRight') {
                        stopSlideshow();
                        nextSlide();
                        setTimeout(startSlideshow, 12000);
                    }
                });

                // Auto-pause when page is not visible (performance optimization)
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        stopSlideshow();
                    } else {
                        startSlideshow();
                    }
                });
            });
        </script>

        @fluxScripts
    </body>
</html>
