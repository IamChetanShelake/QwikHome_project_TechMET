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
        Schema::table('services', function (Blueprint $table) {
            // Add duration field for one-time service
            $table->string('duration_onetime')->nullable()->after('price_onetime_desc');
        });
        
        // Rename columns in separate operations to avoid conflicts
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_onetime_desc', 'price_onetime_description');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_weekly_desc', 'price_weekly_description');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_monthly_desc', 'price_monthly_description');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_yearly_desc', 'price_yearly_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert column renames in reverse order
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_yearly_description', 'price_yearly_desc');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_monthly_description', 'price_monthly_desc');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_weekly_description', 'price_weekly_desc');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('price_onetime_description', 'price_onetime_desc');
        });
        
        Schema::table('services', function (Blueprint $table) {
            // Drop the duration field
            $table->dropColumn('duration_onetime');
        });
    }
};
