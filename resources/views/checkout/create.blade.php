<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Checkout</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 shadow rounded">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex gap-6">
                <div class="w-48">
                    @if($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}"
                            class="w-48 h-48 object-cover rounded border" alt="">
                    @else
                        <div class="w-48 h-48 bg-gray-200 rounded flex items-center justify-center text-gray-600">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="text-xl font-semibold">{{ $product->name }}</div>
                    <div class="text-gray-600 text-sm">{{ optional($product->hima)->name ?? '-' }}</div>

                    @if($product->is_internal_only)
                        <div class="mt-2 text-sm text-red-600 font-medium">
                            Produk internal kampus
                            @if($product->restricted_angkatan)
                                (Angkatan {{ $product->restricted_angkatan }})
                            @endif
                        </div>
                    @endif

                    <div class="mt-3">
                        Harga:
                        <b id="unitPriceText">Rp {{ number_format($product->price,0,',','.') }}</b>
                    </div>

                    <div class="mt-1 text-sm text-gray-600">
                        Stok tersedia: {{ $product->stock }}
                    </div>

                    <div class="mt-3 border-t pt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Subtotal</span>
                            <b id="subtotalText">Rp {{ number_format($product->price,0,',','.') }}</b>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Subtotal = harga × qty
                        </div>
                    </div>

                    <form method="POST" action="{{ route('checkout.store', $product) }}" class="mt-5">
                        @csrf

                        <label class="block font-medium mb-1">Jumlah (Qty)</label>
                        <input
                            id="qtyInput"
                            type="number"
                            name="qty"
                            min="1"
                            max="{{ $product->stock }}"
                            value="{{ old('qty', 1) }}"
                            class="border rounded p-2 w-32"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                        >

                        <div class="mt-4 flex gap-2">
                            <button
                                id="payBtn"
                                class="px-4 py-2 bg-black text-white rounded disabled:opacity-50"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}
                            >
                                Lanjut Bayar
                            </button>

                            <a href="{{ route('products.show', $product) }}"
                               class="px-4 py-2 border rounded">
                                Kembali
                            </a>
                        </div>
                    </form>

                    <p class="mt-4 text-sm text-gray-500">
                        Setelah klik <b>Lanjut Bayar</b>, sistem akan membuat order dan kamu akan masuk ke halaman pembayaran Midtrans.
                    </p>

                    @if($product->stock <= 0)
                        <p class="mt-2 text-sm text-red-600 font-medium">
                            Stok habis. Kamu tidak bisa checkout produk ini.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        (function () {
            const unitPrice = Number(@json((int) $product->price));
            const maxStock = Number(@json((int) $product->stock));

            const qtyInput = document.getElementById('qtyInput');
            const subtotalText = document.getElementById('subtotalText');
            const payBtn = document.getElementById('payBtn');

            function formatRupiah(n) {
                return 'Rp ' + (n || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function clampQty(q) {
                if (!Number.isFinite(q) || q < 1) q = 1;
                if (maxStock > 0 && q > maxStock) q = maxStock;
                return q;
            }

            function updateSubtotal() {
                if (!qtyInput) return;

                let qty = parseInt(qtyInput.value || '1', 10);
                qty = clampQty(qty);
                qtyInput.value = qty;

                const subtotal = unitPrice * qty;
                if (subtotalText) subtotalText.textContent = formatRupiah(subtotal);

                // disable tombol kalau stok habis
                if (payBtn && maxStock <= 0) payBtn.disabled = true;
            }

            if (qtyInput) {
                qtyInput.addEventListener('input', updateSubtotal);
                qtyInput.addEventListener('change', updateSubtotal);
            }

            updateSubtotal();
        })();
    </script>
</x-app-layout>