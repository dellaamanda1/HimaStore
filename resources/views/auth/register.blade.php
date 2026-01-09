<x-guest-layout>
    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-black via-zinc-950 to-purple-950 flex items-center justify-center px-4">

        {{-- pattern + noise --}}
        <div class="absolute inset-0 opacity-60"
             style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.08) 1px, transparent 0); background-size: 18px 18px;">
        </div>

        <div class="absolute inset-0 pointer-events-none"
             style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%22.8%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22200%22 height=%22200%22 filter=%22url(%23n)%22 opacity=%22.16%22/%3E%3C/svg%3E');
                    mix-blend-mode: overlay; opacity:.25;">
        </div>

        {{-- glow --}}
        <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full bg-purple-600/25 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[620px] w-[620px] rounded-full bg-fuchsia-600/20 blur-3xl"></div>

        {{-- Card --}}
        <div class="relative w-full max-w-md">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-purple-500/20 to-fuchsia-500/20 blur-2xl"></div>

            <div class="relative rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-6">
                {{-- Logo --}}
                <div class="flex flex-col items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-2xl bg-white/10 border border-white/10 grid place-items-center">
                            <svg class="h-7 w-7 text-purple-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M9 9h6v6H9V9Z" stroke="currentColor" stroke-width="1.6" opacity=".8"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold leading-tight">HimaStore</p>
                            <p class="text-white/60 text-xs -mt-0.5">Buat akun baru</p>
                        </div>
                    </a>
                </div>

                {{-- ERROR MESSAGE (tanpa x-validation-errors) --}}
                @if ($errors->any())
                    <div class="mt-5 rounded-2xl border border-red-500/30 bg-red-500/10 p-4">
                        <p class="text-sm font-semibold text-red-200 mb-2">Ada yang perlu diperbaiki:</p>
                        <ul class="list-disc list-inside text-sm text-red-100/90 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form (FITUR TETAP SAMA) --}}
                <form method="POST" action="{{ route('register') }}" class="mt-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-white/80" />
                        <x-text-input id="name"
                                      class="block mt-1 w-full !bg-white/10 !border-white/10 !text-white placeholder:!text-white/40 focus:!border-purple-400 focus:!ring-purple-400/30 rounded-xl"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="text-white/80" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full !bg-white/10 !border-white/10 !text-white placeholder:!text-white/40 focus:!border-purple-400 focus:!ring-purple-400/30 rounded-xl"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="text-white/80" />
                        <x-text-input id="password"
                                      class="block mt-1 w-full !bg-white/10 !border-white/10 !text-white placeholder:!text-white/40 focus:!border-purple-400 focus:!ring-purple-400/30 rounded-xl"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white/80" />
                        <x-text-input id="password_confirmation"
                                      class="block mt-1 w-full !bg-white/10 !border-white/10 !text-white placeholder:!text-white/40 focus:!border-purple-400 focus:!ring-purple-400/30 rounded-xl"
                                      type="password"
                                      name="password_confirmation"
                                      required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-white/70 hover:text-white transition"
                           href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button type="submit"
                                class="ms-4 px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-500 to-fuchsia-500 text-white font-semibold hover:opacity-90 transition shadow-lg shadow-purple-500/20">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <p class="mt-5 text-center text-xs text-white/50">
                    Dengan daftar, kamu setuju dengan kebijakan HimaStore.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
