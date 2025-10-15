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
        // Use raw SQL to modify ENUM column to include 'onetime'
        DB::statement("ALTER TABLE service_frequency_options MODIFY COLUMN frequency_type ENUM('onetime', 'weekly', 'monthly', 'yearly') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM without 'onetime'
        DB::statement("ALTER TABLE service_frequency_options MODIFY COLUMN frequency_type ENUM('weekly', 'monthly', 'yearly') NOT NULL");
    }
};
