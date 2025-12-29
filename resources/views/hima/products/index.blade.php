<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard HIMA - {{ $hima->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            @if (session('status'))
                <div class="mb-4 text-green-700">{{ session('status') }}</div>
            @endif

            <a href="{{ route('hima.products.create') }}" class="inline-block mb-4 px-4 py-2 bg-black text-white rounded">
                + Tambah Produk
            </a>

            @forelse ($products as $p)
                <div class="border rounded p-4 mb-3">
                    <div class="font-semibold">{{ $p->name }}</div>
                    <div>Harga: Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                    <div>Stok: {{ $p->stock }}</div>

                    @if ($p->is_internal_only)
                        <div class="mt-2 text-sm text-orange-700">
                            Internal only
                            @if ($p->restricted_angkatan)
                                (angkatan {{ $p->restricted_angkatan }})
                            @endif
                        </div>
                    @endif

                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('hima.products.edit', $p) }}" class="px-3 py-2 bg-gray-700 text-white rounded">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('hima.products.destroy', $p) }}"
                            onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 bg-red-600 text-white rounded">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Belum ada produk.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>