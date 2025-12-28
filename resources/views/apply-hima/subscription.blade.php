<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Subscription HIMA (Rp 25.000/bulan)</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            @if (session('status'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="text-gray-700 mb-4">
                Silakan scan QRIS di bawah ini untuk membayar <b>Rp 25.000/bulan</b>.
                Setelah bayar, klik tombol <b>Saya sudah bayar</b> untuk melanjutkan pengajuan HIMA.
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-start">
                <div class="border rounded p-4 bg-gray-50">
                    <div class="font-semibold mb-2">QRIS Pembayaran</div>

                    <img
                        src="{{ asset('images/qris-subscription.jpg') }}"
                        alt="QRIS Subscription"
                        class="w-full max-w-sm rounded border bg-white"
                    >

                    <div class="text-xs text-gray-500 mt-2">
                        Pastikan nominal sesuai: <b>Rp 25.000</b>
                    </div>
                </div>

                <div class="border rounded p-4">
                    <div class="font-semibold mb-2">Konfirmasi</div>
                    <div class="text-sm text-gray-600 mb-4">
                        (Simulasi) Sistem belum verifikasi otomatis. Untuk tugas, tombol ini dianggap sebagai konfirmasi pembayaran.
                    </div>

                    <form method="POST" action="{{ route('apply-hima.subscription.confirm', $hima) }}">
                        @csrf
                        <button class="px-4 py-2 bg-black text-white rounded">
                            Saya sudah bayar
                        </button>
                    </form>

                    <a href="{{ route('apply-hima.create') }}" class="inline-block mt-3 text-sm underline text-gray-700">
                        Kembali ke form pengajuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>