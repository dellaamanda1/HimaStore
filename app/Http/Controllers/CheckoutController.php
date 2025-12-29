<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * GET /checkout/{product}
     * Halaman checkout (qty, review)
     */
    public function create(Product $product)
    {
        $product->load('hima');
        return view('checkout.create', compact('product'));
    }

    /**
     * POST /checkout/{product}
     * 1) Transaction DB: lock stok + buat order + order_item + kurangi stok
     * 2) Di luar transaction: call Midtrans -> simpan snap_token
     */
    public function store(Request $request, Product $product, MidtransService $midtrans)
    {
        $user = $request->user();

        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $qty = (int) $data['qty'];

        // =========================
        // 1) TRANSACTION DB (CEPAT)
        // =========================
        try {
            $order = DB::transaction(function () use ($user, $product, $qty) {

                // lock row product biar stok aman
                $p = Product::lockForUpdate()->findOrFail($product->id);

                if ($qty > (int) $p->stock) {
                    throw new \RuntimeException('Qty melebihi stok');
                }

                // RULE internal-only
                if ($p->is_internal_only) {
                    if (empty($user->nim)) {
                        throw new \RuntimeException('NIM wajib diisi');
                    }

                    if (!empty($p->restricted_angkatan)) {
                        if (empty($user->angkatan)) {
                            throw new \RuntimeException('Angkatan wajib diisi');
                        }

                        if ((int) $user->angkatan !== (int) $p->restricted_angkatan) {
                            throw new \DomainException('Produk ini hanya untuk angkatan tertentu.');
                        }
                    }
                }

                $total = (int) ($p->price * $qty);

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total,
                    'status' => 'pending',
                    'midtrans_order_id' => 'HS-' . time() . '-' . $user->id . '-' . $p->id,
                    'snap_token' => null,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'qty' => $qty,
                    'price' => (int) $p->price,
                ]);

                // kurangi stok saat order dibuat (opsional, tapi kamu sudah pakai)
                $p->decrement('stock', $qty);

                return $order;
            }, 3);

        } catch (\DomainException $e) {
            abort(403, $e->getMessage());
        } catch (Throwable $e) {
            $msg = $e->getMessage();

            if ($msg === 'Qty melebihi stok') {
                return back()->withErrors(['qty' => 'Qty melebihi stok'])->withInput();
            }

            if ($msg === 'NIM wajib diisi') {
                return redirect()->route('profile.edit')
                    ->with('status', 'Isi NIM dulu untuk membeli produk internal.');
            }

            if ($msg === 'Angkatan wajib diisi') {
                return redirect()->route('profile.edit')
                    ->with('status', 'Isi angkatan dulu untuk membeli produk internal angkatan tertentu.');
            }

            return back()->withErrors(['qty' => 'Gagal membuat order: ' . $msg])->withInput();
        }

        // =========================
        // 2) MIDTRANS DI LUAR TRANSACTION (PENTING!)
        // =========================
        try {
            $p = Product::findOrFail($product->id);

            $payload = [
                'transaction_details' => [
                    'order_id' => $order->midtrans_order_id,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $user->name ?? 'Pembeli',
                    'email' => $user->email ?? '',
                    'phone' => $user->phone ?? '',
                ],
                'item_details' => [[
                    'id' => (string) $p->id,
                    'price' => (int) $p->price,
                    'quantity' => (int) $qty,
                    'name' => Str::limit($p->name, 50, ''),
                ]],
            ];

            $snapToken = $midtrans->createSnapToken($payload);

            $order->update([
                'snap_token' => $snapToken,
            ]);

        } catch (Throwable $e) {
            // Midtrans gagal -> order tetap ada, snap_token kosong
            return redirect()
                ->route('payments.pay', $order)
                ->with('status', 'Order dibuat, tapi gagal ambil Snap Token. Coba refresh halaman bayar.');
        }

        return redirect()->route('payments.pay', $order);
    }
}