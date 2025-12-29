<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('himas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('university');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false); // pending/approved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('himas');
    }
};