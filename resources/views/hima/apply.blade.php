<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar sebagai HIMA</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            <form method="POST" action="{{ route('apply-hima.store') }}">
                @csrf

                <div>
                    <label class="block font-medium">Nama HIMA</label>
                    <input name="name" class="border rounded w-full p-2" value="{{ old('name') }}" required>
                    @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Universitas</label>
                    <input name="university" class="border rounded w-full p-2" value="{{ old('university') }}" required>
                    @error('university') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Deskripsi (opsional)</label>
                    <textarea name="description" class="border rounded w-full p-2" rows="4">{{ old('description') }}</textarea>
                </div>

                <button class="mt-6 px-4 py-2 bg-black text-white rounded">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</x-app-layout>