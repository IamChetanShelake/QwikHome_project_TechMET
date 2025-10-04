<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing coupons to use percentage discount type
        DB::table('coupons')
            ->where('discount_type', '!=', 'percentage')
            ->update(['discount_type' => 'percentage']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only normalizes data, no structural changes to reverse
    }
};
