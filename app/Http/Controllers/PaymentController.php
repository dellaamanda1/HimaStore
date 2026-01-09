<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class PaymentController extends Controller
{
    /**
     * Init konfigurasi Midtrans (untuk webhook / proses backend)
     */
    private function initMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');
    }

    /**
     * GET /payments/pay/{order}
     * Halaman pembayaran (Snap)
     * NOTE: snap_token sudah dibuat di CheckoutController
     */
    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        return view('payments.pay', [
            'order' => $order,
            'snapToken' => $order->snap_token,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /**
     * POST /payments/midtrans/notification
     * Webhook Midtrans
     */
    public function notification(Request $request)
    {
        $this->initMidtrans();

        $payload = $request->all();

        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans invalid signature', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('midtrans_order_id', $orderId)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? null;

        // Mapping status Midtrans -> status order
        if ($transactionStatus === 'capture') {
            $order->status = ($fraudStatus === 'challenge') ? 'pending' : 'paid';
        } elseif ($transactionStatus === 'settlement') {
            $order->status = 'paid';
        } elseif ($transactionStatus === 'pending') {
            $order->status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $order->status = 'failed';
        } else {
            $order->status = 'failed';
        }

        $order->save();

        return response()->json(['message' => 'OK']);
    }
}