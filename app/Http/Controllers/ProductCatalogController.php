<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductCatalogController extends Controller
{
    /**
     * Katalog produk untuk PEMBELI
     */
    public function index()
    {
        $products = Product::with('hima')
            ->latest()
            ->get();

        // pakai view shop biar beda dari hima/products
        return view('shop.index', compact('products'));
    }

    /**
     * Detail produk untuk PEMBELI
     */
    public function show(Product $product)
    {
        $product->load('hima');

        return view('shop.show', compact('product'));
    }
}