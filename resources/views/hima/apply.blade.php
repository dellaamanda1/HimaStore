<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar sebagai HIMA</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded">

            @if(session('status'))
                <div class="mb-4 p-3 bg-blue-50 text-blue-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- FORM FREE TRIAL --}}
            <form method="POST" action="{{ route('apply-hima.store') }}">
                @csrf

                <div>
                    <label class="block font-medium">Nama HIMA</label>
                    <input name="name" class="border rounded w-full p-2" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Universitas</label>
                    <input name="university" class="border rounded w-full p-2" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Deskripsi (opsional)</label>
                    <textarea name="description" class="border rounded w-full p-2"></textarea>
                </div>

                <button class="mt-6 px-4 py-2 bg-black text-white rounded">
                    Kirim Pengajuan (Free Trial 7 hari)
                </button>
            </form>

            {{-- GARIS --}}
            <hr class="my-6">

            {{-- SUBSCRIPTION --}}
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Mau langsung Subscription? Rp 25.000/bulan via QRIS
                </div>

                {{-- INI YANG BENAR --}}
                <form method="POST" action="{{ route('apply-hima.subscription.start') }}">
                    @csrf
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Subscription (Bayar QRIS)
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>