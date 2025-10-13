<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_services', function (Blueprint $table) {
            $table->enum('payment_type', ['fixed_rate', 'commission', 'revenue_share'])->nullable();
            $table->decimal('fixed_rate_amount', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable(); // 0.00 to 999.99, allows up to 2 decimal places
            $table->string('revenue_share_ratio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_services', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'fixed_rate_amount', 'commission_rate', 'revenue_share_ratio']);
        });
    }
};
