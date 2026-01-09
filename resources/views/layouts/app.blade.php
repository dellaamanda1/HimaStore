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

        <div class="relative z-10 min-h-screen">
            {{-- NAV (breeze navigation tetap, fitur tetap) --}}
            @include('layouts.navigation')

            {{-- Header (kalau halaman punya header slot) --}}
            @isset($header)
                <header class="mx-auto max-w-7xl px-6 pt-6">
                    <div class="rounded-3xl bg-white/5 border border-white/10 backdrop-blur p-5">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="mx-auto max-w-7xl px-6 py-8">
                <div class="rounded-3xl bg-white/5 border border-white/10 backdrop-blur p-6 shadow-2xl shadow-purple-500/10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
