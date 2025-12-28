<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HimaProductController extends Controller
{
    public function index()
    {
        $hima = auth()->user()->hima;
        if (!$hima) abort(403, 'Data HIMA tidak ditemukan.');

        $products = $hima->products()->latest()->get();
        return view('hima.products.index', compact('hima', 'products'));
    }

    public function create()
    {
        return view('hima.products.create');
    }

    public function store(Request $request)
    {
        $hima = auth()->user()->hima;
        if (!$hima) abort(403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],

            'is_internal_only' => ['nullable'], // checkbox
            'restricted_angkatan' => ['nullable', 'integer', 'min:1900', 'max:2100'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_internal_only'] = $request->has('is_internal_only');

        // kalau tidak internal, batalkan restriction angkatan
        if (!$data['is_internal_only']) {
            $data['restricted_angkatan'] = null;
        }

        // upload image (opsional)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $hima->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'is_internal_only' => $data['is_internal_only'],
            'restricted_angkatan' => $data['restricted_angkatan'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('hima.products.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $this->guardOwner($product);
        return view('hima.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->guardOwner($product);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],

            'is_internal_only' => ['nullable'],
            'restricted_angkatan' => ['nullable', 'integer', 'min:1900', 'max:2100'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_internal_only'] = $request->has('is_internal_only');

        if (!$data['is_internal_only']) {
            $data['restricted_angkatan'] = null;
        }

        // update image (opsional)
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'is_internal_only' => $data['is_internal_only'],
            'restricted_angkatan' => $data['restricted_angkatan'] ?? null,
            'image_path' => $product->image_path,
        ]);

        return redirect()->route('hima.products.index')->with('status', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $this->guardOwner($product);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('hima.products.index')->with('status', 'Produk berhasil dihapus.');
    }

    private function guardOwner(Product $product): void
    {
        $hima = auth()->user()->hima;
        if (!$hima || $product->hima_id !== $hima->id) {
            abort(403, 'Tidak boleh akses produk ini.');
        }
    }
}