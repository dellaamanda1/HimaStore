<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HimaStore</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        fig: ["Figtree", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <style>
        /* background pattern */
        .bg-grid {
            background-image:
                radial-gradient(circle at 1px 1px, rgba(255,255,255,.08) 1px, transparent 0);
            background-size: 18px 18px;
        }
        .noise {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.16'/%3E%3C/svg%3E");
            mix-blend-mode: overlay;
            opacity: .25;
        }
    </style>
</head>

<body class="font-fig antialiased">
<div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-black via-zinc-950 to-purple-950">

    <!-- background -->
    <div class="absolute inset-0 bg-grid opacity-60"></div>
    <div class="absolute inset-0 noise pointer-events-none"></div>
    <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full bg-purple-600/25 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 h-[620px] w-[620px] rounded-full bg-fuchsia-600/20 blur-3xl"></div>

    <!-- NAVBAR -->
    <header class="relative z-10">
        <nav class="mx-auto max-w-7xl px-6 py-6">
            <div class="flex items-center justify-between">

                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-white/10 backdrop-blur border border-white/10 grid place-items-center">
                        <svg class="h-6 w-6 text-purple-200" viewBox="0 0 24 24" fill="none">
                            <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M9 9h6v6H9V9Z" stroke="currentColor" stroke-width="1.6" opacity=".8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">HimaStore</p>
                        <p class="text-white/60 text-xs">Fashion • Merch • Lifestyle</p>
                    </div>
                </div>

                <!-- LOGIN & REGISTER (SELALU MUNCUL) -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-xl bg-white/10 text-white border border-white/10 hover:bg-white/15 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 rounded-xl bg-gradient-to-r from-purple-500 to-fuchsia-500 text-white font-semibold hover:opacity-90 transition shadow-lg shadow-purple-500/20">
                                Register
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </nav>
    </header>

    <!-- MAIN -->
    <main class="relative z-10">
        <div class="mx-auto max-w-7xl px-6 pb-16 pt-6">

            <!-- HERO -->
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-white/80 text-sm">
                        <span class="h-2 w-2 rounded-full bg-purple-400 animate-pulse"></span>
                        Toko kampus vibes — look premium ✨
                    </div>

                    <h1 class="mt-5 text-4xl md:text-5xl font-bold text-white">
                        Belanja di
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-fuchsia-300">
                            HimaStore
                        </span>
                        <br class="hidden md:block">
                        lebih modern, lebih mudah.
                    </h1>

                    <p class="mt-4 text-white/70 max-w-xl">
                        Temukan merch, fashion, dan kebutuhan lifestyle dengan tampilan dark modern gradasi ungu.
                    </p>

                    <div class="mt-7 flex gap-3">
                        <a href="{{ route('shop') }}"
                           class="px-5 py-3 rounded-2xl bg-gradient-to-r from-purple-500 to-fuchsia-500 text-white font-semibold shadow-xl shadow-purple-500/25 hover:opacity-90 transition">
                            Mulai Belanja
                        </a>
                        <a href="#kategori"
                           class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white hover:bg-white/15 transition">
                            Lihat Kategori Populer
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-3 gap-3 max-w-md">
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                            <p class="text-white font-semibold text-lg">100+</p>
                            <p class="text-white/60 text-xs">Produk</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                            <p class="text-white font-semibold text-lg">Fast</p>
                            <p class="text-white/60 text-xs">Checkout</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                            <p class="text-white font-semibold text-lg">Secure</p>
                            <p class="text-white/60 text-xs">Payment</p>
                        </div>
                    </div>
                </div>

                <!-- FEATURED CARD -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-purple-500/20 to-fuchsia-500/20 blur-2xl"></div>

                    <div class="relative rounded-3xl bg-white/5 border border-white/10 backdrop-blur p-6">
                        <p class="text-white font-semibold mb-4">Featured</p>

                        @php
                            $items = ['Hoodie Hima','Tote Bag','T-Shirt'];
                        @endphp

                        @foreach ($items as $item)
                            <div class="mb-4 rounded-2xl bg-white/5 border border-white/10 p-4">
                                <p class="text-white font-semibold">{{ $item }}</p>
                                <p class="text-white/60 text-sm">Produk pilihan terbaik</p>
                            </div>
                        @endforeach

            <!-- KATEGORI -->
            <section id="kategori" class="mt-16">
                <h2 class="text-white text-2xl font-bold">Kategori Populer</h2>
                <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach (['Hoodie','T-Shirt','Aksesoris','Bundle'] as $cat)
                        <div class="rounded-3xl bg-white/5 border border-white/10 p-5 text-white">
                            {{ $cat }}
                        </div>
                    @endforeach
                </div>
            </section>

            <footer class="mt-16 border-t border-white/10 pt-8 text-white/60 text-sm">
                © {{ date('Y') }} HimaStore. All rights reserved.
            </footer>

        </div>
    </main>
</div>
</body>
</html>
