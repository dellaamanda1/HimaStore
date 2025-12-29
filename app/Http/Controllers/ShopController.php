<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        // WAJIB dari database, BUKAN array
        $products = Product::with('hima')->latest()->get();

        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('hima');

        return view('shop.show', compact('product'));
    }
}
