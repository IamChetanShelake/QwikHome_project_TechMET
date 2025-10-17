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
        Schema::table('cart_items', function (Blueprint $table) {
            Schema::table('cart_items', function (Blueprint $table) {
                // Step 1: Drop the existing incorrect foreign key
                $table->dropForeign(['service_frequency_id']);

                // Step 2: Recreate correct foreign key pointing to service_frequency_options
                $table->foreign('service_frequency_id')
                    ->references('id')
                    ->on('service_frequency_options')
                    ->onDelete('set null');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Revert to old foreign key (for rollback safety)
            $table->dropForeign(['service_frequency_id']);

            $table->foreign('service_frequency_id')
                ->references('id')
                ->on('service_frequencies')
                ->onDelete('set null');
        });
    }
};
