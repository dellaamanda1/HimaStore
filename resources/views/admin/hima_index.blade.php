<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Admin - Pengajuan HIMA</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            @if (session('status'))
                <div class="mb-3 text-green-700">{{ session('status') }}</div>
            @endif

            <h3 class="font-semibold text-lg mb-2">Pending</h3>
            @forelse ($pending as $h)
                <div class="border rounded p-4 mb-3">
                    <div><b>{{ $h->name }}</b> — {{ $h->university }}</div>
                    <div class="text-sm text-gray-600">Owner: {{ $h->owner->email }}</div>
                    <form method="POST" action="{{ route('admin.himas.approve', $h) }}" class="mt-2">
                        @csrf
                        <button class="px-3 py-2 bg-black text-white rounded">Approve</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-600">Tidak ada pending.</p>
            @endforelse

            <h3 class="font-semibold text-lg mt-8 mb-2">Active</h3>
            @forelse ($active as $h)
                <div class="border rounded p-4 mb-3">
                    <div><b>{{ $h->name }}</b> — {{ $h->university }}</div>
                    <div class="text-sm text-gray-600">Owner: {{ $h->owner->email }}</div>
                </div>
            @empty
                <p class="text-gray-600">Belum ada yang aktif.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>