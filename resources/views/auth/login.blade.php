<x-guest-layout>
    {{-- Background (tema sama seperti welcome) --}}
    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-black via-zinc-950 to-purple-950">
        <div class="absolute inset-0 [background-image:radial-gradient(circle_at_1px_1px,rgba(255,255,255,.08)_1px,transparent_0)] [background-size:18px_18px] opacity-60"></div>
        <div class="absolute inset-0 pointer-events-none opacity-25 mix-blend-overlay"
             style="background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.16'/%3E%3C/svg%3E&quot;);">
        </div>
        <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full bg-purple-600/25 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[620px] w-[620px] rounded-full bg-fuchsia-600/20 blur-3xl"></div>

        {{-- Header mini (cuma logo + brand, TANPA tombol login/register) --}}
        <header class="relative z-10">
            <nav class="mx-auto max-w-6xl px-6 py-6">
                <a href="{{ url('/') }}" class="flex items-center gap-3 w-fit">
                    <div class="h-10 w-10 rounded-2xl bg-white/10 backdrop-blur border border-white/10 grid place-items-center">
                        <svg class="h-6 w-6 text-purple-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M9 9h6v6H9V9Z" stroke="currentColor" stroke-width="1.6" opacity=".8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold leading-tight">HimaStore</p>
                        <p class="text-white/60 text-xs -mt-0.5">Fashion • Merch • Lifestyle</p>
                    </div>
                </a>
            </nav>
        </header>

        {{-- Form --}}
        <main class="relative z-10">
            <div class="min-h-[calc(100vh-96px)] flex items-center justify-center px-6 pb-10">
                <div class="w-full max-w-md">
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 shadow-2xl">
                        <div class="mb-6">
                            <h1 class="text-white text-2xl font-bold">Log in</h1>
                            <p class="text-white/60 text-sm mt-1">Masuk untuk mulai belanja di HimaStore.</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-white/80" />
                                <x-text-input
                                    id="email"
                                    class="block mt-1 w-full bg-white/10 border-white/10 text-white placeholder-white/40 focus:border-purple-400 focus:ring-purple-400"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required autofocus
                                    autocomplete="username"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-white/80" />
                                <x-text-input
                                    id="password"
                                    class="block mt-1 w-full bg-white/10 border-white/10 text-white placeholder-white/40 focus:border-purple-400 focus:ring-purple-400"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me + Forgot -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input
                                        id="remember_me"
                                        type="checkbox"
                                        class="rounded border-white/20 bg-white/10 text-purple-500 shadow-sm focus:ring-purple-400"
                                        name="remember"
                                    >
                                    <span class="ms-2 text-sm text-white/70">{{ __('Remember me') }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="text-sm text-purple-200 hover:text-purple-100 transition"
                                       href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="pt-2 flex items-center justify-end">
                                <x-primary-button class="bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:opacity-90">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>

                            <div class="pt-2 text-center text-sm text-white/60">
                                Belum punya akun?
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-purple-200 hover:text-purple-100 transition font-semibold">
                                        Register
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <p class="mt-6 text-center text-xs text-white/50">
                        © {{ date('Y') }} HimaStore
                    </p>
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>
