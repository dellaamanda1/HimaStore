<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');

        // Tambahan: timeout (biar gak nge-hang kelamaan)
        Config::$curlOptions = [
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
        ];
    }

    public function createSnapToken(array $payload): string
    {
        $transaction = Snap::createTransaction($payload);
        return $transaction->token;
    }
}