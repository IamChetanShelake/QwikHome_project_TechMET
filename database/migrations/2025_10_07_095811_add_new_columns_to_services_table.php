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
        Schema::table('services', function (Blueprint $table) {
            // Add new columns
            $table->text('short_description')->nullable()->after('description');
            $table->json('whats_include')->nullable()->after('description');

            // One-time price and description
            $table->decimal('price_onetime', 10, 2)->nullable()->after('price');
            $table->text('price_onetime_desc')->nullable()->after('price_onetime');

            // Weekly price and description
            $table->decimal('price_weekly', 10, 2)->nullable()->after('price_onetime_desc');
            $table->text('price_weekly_desc')->nullable()->after('price_weekly');

            // Monthly price and description
            $table->decimal('price_monthly', 10, 2)->nullable()->after('price_weekly_desc');
            $table->text('price_monthly_desc')->nullable()->after('price_monthly');

            // Yearly price and description
            $table->decimal('price_yearly', 10, 2)->nullable()->after('price_monthly_desc');
            $table->text('price_yearly_desc')->nullable()->after('price_yearly');

            $table->boolean('is_arabic')->default(false)->after('price_yearly_desc');

            // Rename existing price column to price_onetime
            $table->renameColumn('price', 'price_onetime');
        });

        // Copy existing price values to price_onetime and set default description
        DB::table('services')->update([
            'price_onetime_desc' => 'One-time service charge'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Reverse the column rename first
            $table->renameColumn('price_onetime', 'price');

            // Drop the added columns
            $table->dropColumn([
                'short_description',
                'whats_include',
                'price_onetime',
                'price_onetime_desc',
                'price_weekly',
                'price_weekly_desc',
                'price_monthly',
                'price_monthly_desc',
                'price_yearly',
                'price_yearly_desc',
                'is_arabic'
            ]);
        });
    }
};
