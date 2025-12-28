<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Detail Produk</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow grid md:grid-cols-2 gap-6">

            {{-- Gambar --}}
            <div>
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}"
                        class="w-full h-72 object-cover rounded border">
                @else
                    <div class="w-full h-72 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif
            </div>

            {{-- Detail --}}
            <div>
                <div class="text-sm text-gray-600 mb-1">
                    {{ optional($product->hima)->name ?? '-' }}
                </div>

                <div class="text-2xl font-bold mb-2">
                    {{ $product->name }}
                </div>

                <div class="text-xl font-semibold mb-2">
                    Rp {{ number_format($product->price,0,',','.') }}
                </div>

                <div class="text-sm text-gray-600 mb-3">
                    Stok tersedia: {{ $product->stock }}
                </div>

                {{-- Info internal --}}
                @if($product->is_internal_only)
                    <div class="mb-3 text-sm text-red-600 font-medium">
                        Produk internal kampus
                        @if($product->restricted_angkatan)
                            (Angkatan {{ $product->restricted_angkatan }})
                        @endif
                    </div>
                @endif

                {{-- Deskripsi --}}
                @if($product->description)
                    <p class="mb-4 whitespace-pre-line text-gray-700">
                        {{ $product->description }}
                    </p>
                @endif

                {{-- Tombol --}}
                <div class="flex gap-2">
                    <a href="{{ route('checkout.create', $product) }}"
                    class="px-4 py-2 bg-black text-white rounded">
                        Beli
                    </a>

                    <a href="{{ route('products.index') }}"
                    class="px-4 py-2 border rounded">
                        Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>