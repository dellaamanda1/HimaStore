<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // siapa pembelinya
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // total pembayaran
            $table->integer('total_price');

            // pending | paid | failed
            $table->string('status')->default('pending');

            // order id dari midtrans
            $table->string('midtrans_order_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};