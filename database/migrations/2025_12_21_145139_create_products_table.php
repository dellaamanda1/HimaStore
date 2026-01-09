<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // produk milik HIMA mana
            $table->foreignId('hima_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->integer('price'); // rupiah
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();

            // aturan pembelian
            $table->boolean('is_internal_only')->default(false); // hanya untuk anggota HIMA tertentu
            $table->integer('restricted_angkatan')->nullable();  // opsional: hanya angkatan X

            // gambar (opsional)
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
