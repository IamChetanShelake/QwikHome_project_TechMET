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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');

            // Booking details
            $table->string('booking_reference')->unique();
            $table->date('scheduled_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending', 'ongoing', 'completed'])->default('pending');
            $table->decimal('price', 10, 2)->nullable(); // Store the price at booking time

            // Notes and tracking
            $table->text('customer_notes')->nullable();
            $table->text('vendor_notes')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
