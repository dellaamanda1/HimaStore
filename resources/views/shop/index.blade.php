<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Shop Produk</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                class="border rounded p-4 bg-white shadow hover:shadow-lg transition">

                    {{-- Gambar --}}
                    @if($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}"
                            class="w-full h-48 object-cover rounded mb-2">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded mb-2 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    {{-- Nama Produk --}}
                    <div class="font-semibold text-lg">
                        {{ $product->name }}
                    </div>

                    {{-- Nama HIMA --}}
                    <div class="text-sm text-gray-600">
                        {{ optional($product->hima)->name ?? '-' }}
                    </div>

                    {{-- Harga --}}
                    <div class="mt-1 font-bold">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </div>

                    {{-- Stok --}}
                    <div class="text-sm text-gray-600">
                        Stok: {{ $product->stock }}
                    </div>

                    {{-- Badge internal --}}
                    @if($product->is_internal_only)
                        <div class="mt-2 text-xs text-red-600 font-medium">
                            Produk internal
                            @if($product->restricted_angkatan)
                                (Angkatan {{ $product->restricted_angkatan }})
                            @endif
                        </div>
                    @endif
                </a>
            @empty
                <p class="text-gray-500">Belum ada produk.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>