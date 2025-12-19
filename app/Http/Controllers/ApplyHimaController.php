<?php

namespace App\Http\Controllers;

use App\Models\Hima;
use Illuminate\Http\Request;

class ApplyHimaController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // ❌ ADMIN INTI TIDAK BOLEH APPLY
        if ($user->role === 'admin') {
            abort(403, 'Admin inti tidak dapat mengajukan HIMA');
        }

        // ❌ USER YANG SUDAH MENJADI HIMA
        if ($user->role === 'hima') {
            return redirect()->route('hima.dashboard');
        }

        // ❌ USER SUDAH PERNAH APPLY
        if ($user->hima) {
            return redirect()->route('apply-hima.status');
        }

        return view('hima.apply');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // ❌ HANYA ROLE USER YANG BOLEH APPLY
        if ($user->role !== 'user') {
            abort(403, 'Hanya user biasa yang dapat mengajukan HIMA');
        }

        if ($user->hima) {
            return redirect()->route('apply-hima.status');
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
        ]);

        return redirect()->route('apply-hima.status')
            ->with('status', 'Pengajuan HIMA berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function status()
    {
        $hima = auth()->user()->hima;
        return view('hima.status', compact('hima'));
    }
}