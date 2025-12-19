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

    public function approve(Hima $hima)
    {
        $hima->update(['is_active' => true]);

        $owner = $hima->owner;
        $owner->role = 'hima';
        $owner->save();

        return back()->with('status', 'HIMA approved. User sekarang role = hima.');
    }
}