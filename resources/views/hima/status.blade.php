<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Status Pengajuan HIMA</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            @if (session('status'))
                <div class="mb-3 text-green-700">{{ session('status') }}</div>
            @endif

            @if (!$hima)
                <p>Belum ada pengajuan.</p>
                <a class="underline text-blue-600" href="{{ route('apply-hima.create') }}">Ajukan sekarang</a>
            @else
                <p><b>{{ $hima->name }}</b> — {{ $hima->university }}</p>
                <p class="mt-2">
                    Status:
                    @if ($hima->is_active)
                        <span class="text-green-700">Disetujui ✅</span>
                    @else
                        <span class="text-orange-700">Menunggu persetujuan ⏳</span>
                    @endif
                </p>
            @endif
        </div>
    </div>
</x-app-layout>