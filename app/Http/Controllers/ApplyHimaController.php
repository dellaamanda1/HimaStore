<?php

namespace App\Http\Controllers;

use App\Models\Hima;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplyHimaController extends Controller
{
    /**
     * Auto hapus trial yang sudah lewat 7 hari.
     * Trial dihapus -> user wajib daftar ulang (trial/subscription).
     */
    private function cleanupExpiredTrial($user): void
    {
        $hima = $user->hima;
        if (!$hima) return;

        if ($hima->plan === 'trial' && !empty($hima->trial_expires_at)) {
            if (Carbon::parse($hima->trial_expires_at)->isPast()) {
                DB::transaction(function () use ($hima, $user) {
                    $hima->delete();

                    // balikin role kalau sempat jadi hima
                    if ($user->role === 'hima') {
                        $user->role = 'user';
                        $user->save();
                    }
                });
            }
        }
    }

    public function create()
    {
        $user = auth()->user();

        $this->cleanupExpiredTrial($user);
        $user->refresh();

        if ($user->role === 'admin') {
            abort(403, 'Admin inti tidak dapat mengajukan HIMA');
        }

        if ($user->role === 'hima') {
            return redirect()->route('hima.dashboard');
        }

        // Kalau sudah punya HIMA subscription unpaid/pending -> langsung ke halaman QRIS
        if ($user->hima) {
            $h = $user->hima;

            if ($h->plan === 'subscription' && in_array($h->payment_status, ['unpaid', 'pending'])) {
                return redirect()->route('apply-hima.subscription.page', $h);
            }

            // kalau sudah aktif -> status
            if ($h->is_active) {
                return redirect()->route('apply-hima.status');
            }

            // trial/free tapi belum aktif -> tampilkan form + tombol subscription
            return view('hima.apply', [
                'existingHima' => $h,
            ]);
        }

        return view('hima.apply', [
            'existingHima' => null,
        ]);
    }

    /**
     * Submit FREE TRIAL (Kirim Pengajuan)
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $this->cleanupExpiredTrial($user);
        $user->refresh();

        if ($user->role !== 'user') {
            abort(403, 'Hanya user biasa yang dapat mengajukan HIMA');
        }

        // jangan bikin duplikat
        if ($user->hima) {
            return redirect()->route('apply-hima.create')
                ->with('status', 'Kamu sudah punya pengajuan. Gunakan tombol Subscription untuk bayar / cek status.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'university' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        Hima::create([
            'owner_user_id' => $user->id,
            'name' => $data['name'],
            'university' => $data['university'],
            'description' => $data['description'] ?? null,
            'is_active' => false,

            // trial default
            'plan' => 'trial',
            'payment_status' => 'free',
            'trial_expires_at' => now()->addDays(7),
        ]);

        return redirect()->route('apply-hima.status')
            ->with('status', 'Pengajuan HIMA (FREE TRIAL 7 hari) berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function status()
    {
        $user = auth()->user();

        $this->cleanupExpiredTrial($user);
        $user->refresh();

        $hima = $user->hima;
        return view('hima.status', compact('hima'));
    }

    /**
     * Tombol "Subscription (Bayar QRIS)" dari halaman apply.
     * - Kalau belum ada HIMA: wajib isi form dulu.
     * - Kalau sudah ada trial: upgrade jadi subscription + arahkan ke QRIS.
     */
    public function startSubscription(Request $request)
    {
        $user = auth()->user();

        $this->cleanupExpiredTrial($user);
        $user->refresh();

        if ($user->role !== 'user') {
            abort(403);
        }

        // Kalau belum pernah apply sama sekali -> harus isi form dulu (agar ada nama/university)
        if (!$user->hima) {
            return redirect()->route('apply-hima.create')
                ->with('status', 'Isi form pengajuan dulu (Nama HIMA & Universitas), lalu klik Subscription.');
        }

        $h = $user->hima;

        // kalau sudah subscription tapi unpaid/pending -> ke QRIS
        if ($h->plan === 'subscription' && in_array($h->payment_status, ['unpaid', 'pending'])) {
            return redirect()->route('apply-hima.subscription.page', $h);
        }

        // upgrade trial -> subscription
        $h->update([
            'plan' => 'subscription',
            'payment_status' => 'unpaid',
            'trial_expires_at' => null,
            'is_active' => false, // tetap pending sampai verified + approved
        ]);

        return redirect()->route('apply-hima.subscription.page', $h)
            ->with('status', 'Silakan bayar subscription Rp 25.000 via QRIS.');
    }

    public function subscriptionPage(Hima $hima)
    {
        $user = auth()->user();

        if ((int) $hima->owner_user_id !== (int) $user->id) {
            abort(403);
        }

        if ($hima->plan !== 'subscription') {
            return redirect()->route('apply-hima.create');
        }

        return view('apply-hima.subscription', compact('hima'));
    }

    /**
     * Simulasi: user klik "Saya sudah bayar" -> payment_status = pending
     */
    public function subscriptionConfirm(Request $request, Hima $hima)
    {
        $user = auth()->user();

        if ((int) $hima->owner_user_id !== (int) $user->id) {
            abort(403);
        }

        if ($hima->plan !== 'subscription') {
            return redirect()->route('apply-hima.create');
        }

        $hima->update([
            'payment_status' => 'pending',
            'is_active' => false,
        ]);

        return redirect()->route('apply-hima.status')
            ->with('status', 'Konfirmasi diterima. Status pembayaran: PENDING (menunggu verifikasi admin).');
    }
}