<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Subscription HIMA (Rp 25.000/bulan)
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        {{-- Wrapper glass mengikuti tema --}}
        <div class="rounded-3xl bg-white/5 border border-white/10 backdrop-blur p-6 shadow-2xl shadow-purple-500/10">
            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-green-500/15 border border-green-500/20 text-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="text-white/80 mb-4">
                Silakan scan QRIS di bawah ini untuk membayar <b class="text-white">Rp 25.000/bulan</b>.
                Setelah bayar, klik tombol <b class="text-white">Saya sudah bayar</b> untuk melanjutkan pengajuan HIMA.
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-start">
                {{-- Kartu QRIS --}}
                <div class="rounded-2xl bg-white p-4 shadow">
                    <div class="font-semibold mb-2 text-gray-900">QRIS Pembayaran</div>

                    <img
                        src="{{ asset('images/qris-subscription.jpg') }}"
                        alt="QRIS Subscription"
                        class="w-full max-w-sm rounded border bg-white"
                    >

                    <div class="text-xs text-gray-600 mt-2">
                        Pastikan nominal sesuai: <b>Rp 25.000</b>
                    </div>
                </div>

                {{-- Kartu Konfirmasi --}}
                <div class="rounded-2xl bg-white p-4 shadow">
                    <div class="font-semibold mb-2 text-gray-900">Konfirmasi</div>
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
