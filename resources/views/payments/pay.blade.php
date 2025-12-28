<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Pembayaran</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded">
            <div class="mb-2">
                Order: <b>#{{ $order->id }}</b>
            </div>

            <div class="mb-2">
                Status: <b>{{ $order->status }}</b>
            </div>

            <div class="mb-4">
                Total: <b>Rp {{ number_format($order->total_price, 0, ',', '.') }}</b>
            </div>

            {{-- ✅ MODE MIDTRANS (kalau snap token ada) --}}
            @if(!empty($snapToken))
                <button id="pay-button" class="px-4 py-2 bg-black text-white rounded">
                    Bayar Sekarang (Midtrans)
                </button>

            {{-- ✅ FALLBACK QRIS (kalau snap token belum terbentuk) --}}
            @else
                <div class="text-red-600 mb-4">
                    Snap token belum terbentuk. Silakan bayar via QRIS di bawah (sementara).
                </div>

                <div class="border rounded p-4 bg-gray-50">
                    <div class="font-semibold mb-2">Bayar via QRIS</div>
                    <img
                        src="{{ asset('images/qris.png') }}"
                        alt="QRIS"
                        class="w-full max-w-sm mx-auto rounded border"
                    >
                    <div class="text-sm text-gray-600 mt-2 text-center">
                        Scan QRIS ini dengan aplikasi bank / e-wallet kamu.
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ✅ SCRIPT MIDTRANS TETAP (tidak berubah) --}}
    @if(!empty($snapToken))
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ $clientKey }}"></script>

        <script>
            document.getElementById('pay-button')?.addEventListener('click', function () {
                window.snap.pay(@json($snapToken), {
                    onSuccess: function(result){
                        console.log('success', result);
                        window.location.href = @json(route('dashboard'));
                    },
                    onPending: function(result){
                        console.log('pending', result);
                        window.location.href = @json(route('dashboard'));
                    },
                    onError: function(result){
                        console.log('error', result);
                        alert("Pembayaran gagal");
                    },
                    onClose: function(){
                        alert("Popup pembayaran ditutup");
                    }
                });
            });
        </script>
    @endif
</x-app-layout>