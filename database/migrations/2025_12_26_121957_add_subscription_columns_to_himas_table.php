<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('himas', function (Blueprint $table) {
            // plan: trial | subscription
            $table->string('plan')->default('trial')->after('is_active');

            // payment_status: free | unpaid | pending | verified
            $table->string('payment_status')->default('free')->after('plan');

            // batas trial 7 hari
            $table->timestamp('trial_expires_at')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('himas', function (Blueprint $table) {
            $table->dropColumn([
                'plan',
                'payment_status',
                'trial_expires_at',
            ]);
        });
    }
};