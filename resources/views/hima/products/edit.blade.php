<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Produk</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            <form method="POST" action="{{ route('hima.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium">Nama Produk</label>
                    <input name="name" class="border rounded w-full p-2" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Harga</label>
                    <input name="price" type="number" class="border rounded w-full p-2" value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Stok</label>
                    <input name="stock" type="number" class="border rounded w-full p-2" value="{{ old('stock', $product->stock) }}" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Deskripsi</label>
                    <textarea name="description" class="border rounded w-full p-2" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_internal_only" value="1" {{ $product->is_internal_only ? 'checked' : '' }}>
                        <span>Produk internal</span>
                    </label>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Restrict Angkatan (opsional)</label>
                    <input name="restricted_angkatan" type="number" class="border rounded w-full p-2"
                        value="{{ old('restricted_angkatan', $product->restricted_angkatan) }}">
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Ganti Gambar (opsional)</label>
                    <input type="file" name="image" class="border rounded w-full p-2">
                </div>

                <button type="submit" class="mt-6 px-4 py-2 bg-black text-white rounded">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>