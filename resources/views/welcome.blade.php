<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <script>
            const testimonials_data = {!! $testimonials ?? [] !!};
            console.log(testimonials_data);
            function testimonialSlider() {
                return {
                    current: 0,
                    testimonials: testimonials_data,
                    init() {
                        this.interval = setInterval(() => {
                            this.next();
                        }, 5000);
                    },
                    prev() {
                        this.current = (this.current - 1 + this.testimonials.length) % this.testimonials.length;
                    },
                    next() {
                        this.current = (this.current + 1) % this.testimonials.length;
                    },
                    goTo(index) {
                        this.current = index;
                    },
                    destroy() {
                        clearInterval(this.interval);
                    }
                }
            }
        </script>
    </head>
    <body x-data="testimonialSlider()" class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth('admin')
                        <a
                            href="{{ url('admin/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('admin.login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            {{-- <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a> --}}
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <section class="max-w-3xl w-full rounded-xl shadow-lg p-8 relative">
                    <!-- Testimonials -->
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div
                            x-show="current === index"
                            x-transition:enter="transition ease-in duration-500"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="text-center space-y-6 px-5"
                            style="display: none;"
                        >
                            <img :src="testimonial.image" alt="" class="mx-auto w-24 h-24 rounded-full object-cover shadow-md" />
                            <p class="text-white text-lg italic">“<span x-text="testimonial.message"></span>”</p>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-300" x-text="testimonial.name"></h3>
                                <p class="text-sm text-gray-600 font-medium" x-text="testimonial.role"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <button
                        @click="prev()"
                        aria-label="Previous testimonial"
                        class="absolute top-1/2 left-4 -translate-y-1/2 bg-gray-600 hover:bg-gray-700 text-white rounded-full p-2 shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6"></path>
                        </svg>
                    </button>

                    <button
                        @click="next()"
                        aria-label="Next testimonial"
                        class="absolute top-1/2 right-4 -translate-y-1/2 bg-gray-600 hover:bg-gray-700 text-white rounded-full p-2 shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </button>

                    <!-- Dots Navigation -->
                    <div class="flex justify-center space-x-3 mt-8">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <button
                        @click="goTo(index)"
                        :class="{'bg-gray-600': current === index, 'bg-gray-300': current !== index}"
                        class="w-3 h-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-gray-500"
                        aria-label="Go to testimonial"
                        type="button"
                        ></button>
                    </template>
                    </div>
                </section>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
