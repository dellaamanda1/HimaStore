<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Shop Produk
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse ($products as $product)
                <a href="{{ route('products.show', ['product' => $product->id]) }}"
                   class="rounded-2xl bg-white/5 border border-white/10 backdrop-blur p-4
                          hover:bg-white/10 transition shadow-lg shadow-purple-500/10">

                    {{-- Gambar --}}
                    @if($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}"
                             class="w-full h-48 object-cover rounded-xl mb-3">
                    @else
                        <div class="w-full h-48 bg-white/10 rounded-xl mb-3
                                    flex items-center justify-center text-white/50">
                            No Image
                        </div>
                    @endif

                    {{-- Nama Produk --}}
                    <div class="font-semibold text-lg text-white">
                        {{ $product->name }}
                    </div>

                    {{-- Nama HIMA --}}
                    <div class="text-sm text-white/60">
                        {{ optional($product->hima)->name ?? '-' }}
                    </div>

                    {{-- Harga --}}
                    <div class="mt-2 font-bold text-purple-300">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </div>

                    {{-- Stok --}}
                    <div class="text-sm text-white/60">
                        Stok: {{ $product->stock }}
                    </div>

                    {{-- Badge internal --}}
                    @if($product->is_internal_only)
                        <div class="mt-2 text-xs text-red-400 font-medium">
                            Produk internal
                            @if($product->restricted_angkatan)
                                (Angkatan {{ $product->restricted_angkatan }})
                            @endif
                        </div>
                    @endif

                </a>
            @empty
                <div class="col-span-full text-center text-white/70 py-12">
                    Belum ada produk.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
