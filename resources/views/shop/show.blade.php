<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Detail Produk</h2>
    </x-slot>

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

    <div class="relative overflow-hidden bg-gradient-to-br from-black via-zinc-950 to-purple-950 min-h-screen">
        <div class="absolute inset-0 bg-grid opacity-60"></div>
        <div class="absolute inset-0 noise pointer-events-none"></div>
        <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full bg-purple-600/25 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[620px] w-[620px] rounded-full bg-fuchsia-600/20 blur-3xl"></div>

        <div class="relative z-10 py-10">
            <div class="max-w-5xl mx-auto px-4">
                <a href="{{ route('shop') }}"
                   class="inline-flex items-center gap-2 text-white/70 hover:text-white transition">
                    ← Kembali ke Shop
                </a>

                <div class="mt-6 grid md:grid-cols-2 gap-6">
                    <!-- Image -->
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur p-4">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 class="w-full h-80 object-cover rounded-2xl border border-white/10">
                        @else
                            <div class="w-full h-80 rounded-2xl flex items-center justify-center bg-white/5 border border-white/10 text-white/60">
                                No Image
                            </div>
                        @endif
                    </div>

                    <!-- Detail -->
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur p-6">
                        <p class="text-white/60 text-sm">
                            {{ optional($product->hima)->name ?? '-' }}
                        </p>

                        <h1 class="text-3xl font-bold text-white mt-2">
                            {{ $product->name }}
                        </h1>

                        <div class="mt-4 text-2xl font-bold text-white">
                            Rp {{ number_format($product->price,0,',','.') }}
                        </div>

                        <div class="mt-2 text-white/60">
                            Stok tersedia: {{ $product->stock }}
                        </div>

                        @if($product->is_internal_only)
                            <div class="mt-4 inline-flex items-center gap-2 text-xs font-semibold
                                        text-red-200 bg-red-500/10 border border-red-500/20 px-3 py-1 rounded-full">
                                Produk internal
                                @if($product->restricted_angkatan)
                                    <span class="text-red-200/80">(Angkatan {{ $product->restricted_angkatan }})</span>
                                @endif
                            </div>
                        @endif

                        @if($product->description)
                            <div class="mt-6 text-white/70 leading-relaxed whitespace-pre-line">
                                {{ $product->description }}
                            </div>
                        @endif

                        <div class="mt-8 flex gap-3">
                            <button class="px-5 py-3 rounded-2xl bg-gradient-to-r from-purple-500 to-fuchsia-500 text-white font-semibold hover:opacity-90 transition shadow-xl shadow-purple-500/25">
                                Tambah ke Keranjang
                            </button>
                            <a href="{{ route('shop') }}"
                               class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white hover:bg-white/15 transition">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
