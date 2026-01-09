<?php

namespace App\Http\Controllers;

use App\Models\Hima;

class AdminHimaController extends Controller
{
    public function index()
    {
        $pending = Hima::with('owner')->where('is_active', false)->latest()->get();
        $active  = Hima::with('owner')->where('is_active', true)->latest()->get();

        return view('admin.hima_index', compact('pending', 'active'));
    }

    /**
     * Admin approve:
     * - Trial: boleh langsung approve
     * - Subscription: harus payment_status = verified
     */
    public function approve(Hima $hima)
    {
        if ($hima->plan === 'subscription' && $hima->payment_status !== 'verified') {
            return back()->with('status', 'Gagal approve: Subscription belum VERIFIED. (Status sekarang: '.$hima->payment_status.')');
        }

        $hima->update(['is_active' => true]);

        $owner = $hima->owner;
        $owner->role = 'hima';
        $owner->save();

        return back()->with('status', 'HIMA approved. User sekarang role = hima.');
    }

    /**
     * Admin verifikasi pembayaran subscription (simulasi)
     */
    public function verifyPayment(Hima $hima)
    {
        if ($hima->plan !== 'subscription') {
            return back()->with('status', 'Ini bukan subscription.');
        }

        $hima->update([
            'payment_status' => 'verified',
        ]);

        return back()->with('status', 'Pembayaran subscription VERIFIED. Sekarang bisa di-approve.');
    }
}