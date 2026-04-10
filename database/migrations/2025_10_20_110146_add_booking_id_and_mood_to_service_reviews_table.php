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
        Schema::table('service_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('service_id');
            $table->enum('mood', ['happy', 'okay', 'sad'])->nullable()->after('rating');

            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_reviews', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn(['booking_id', 'mood']);
        });
    }
};
