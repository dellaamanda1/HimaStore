<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HimaStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Breeze/Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.08) 1px, transparent 0);
            background-size: 18px 18px;
        }
        .noise {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.16'/%3E%3C/svg%3E");
            mix-blend-mode: overlay;
            opacity: .25;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-black via-zinc-950 to-purple-950">
        <!-- background -->
        <div class="absolute inset-0 bg-grid opacity-60"></div>
        <div class="absolute inset-0 noise pointer-events-none"></div>
        <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full bg-purple-600/25 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[620px] w-[620px] rounded-full bg-fuchsia-600/20 blur-3xl"></div>

        <!-- content -->
        <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-md">
                <!-- Brand (tanpa logo Laravel) -->
                <div class="mb-6 flex items-center justify-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-white/10 backdrop-blur border border-white/10 grid place-items-center">
                        <svg class="h-6 w-6 text-purple-200" viewBox="0 0 24 24" fill="none">
                            <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M9 9h6v6H9V9Z" stroke="currentColor" stroke-width="1.6" opacity=".8"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-white font-semibold leading-tight">HimaStore</p>
                        <p class="text-white/60 text-xs">Fashion • Merch • Lifestyle</p>
                    </div>
                </div>

                <!-- Card form -->
                <div class="rounded-3xl bg-white/5 border border-white/10 backdrop-blur p-6 shadow-2xl shadow-purple-500/10">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-white/50 text-xs">
                    © {{ date('Y') }} HimaStore. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
