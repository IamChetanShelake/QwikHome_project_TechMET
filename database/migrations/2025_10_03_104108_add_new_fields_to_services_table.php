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
            $table->text('short_description')->nullable()->after('name');
            $table->json('whats_include')->nullable()->after('description');
            $table->decimal('price_onetime', 10, 2)->after('whats_include');
            $table->decimal('price_weekly', 10, 2)->nullable()->after('price_onetime');
            $table->decimal('price_monthly', 10, 2)->nullable()->after('price_weekly');
            $table->decimal('price_yearly', 10, 2)->nullable()->after('price_monthly');
            $table->boolean('is_arabic')->default(0)->after('price_yearly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('short_description');
            $table->dropColumn('whats_include');
            $table->dropColumn('price_onetime');
            $table->dropColumn('price_weekly');
            $table->dropColumn('price_monthly');
            $table->dropColumn('price_yearly');
            $table->dropColumn('is_arabic');
        });
    }
};
