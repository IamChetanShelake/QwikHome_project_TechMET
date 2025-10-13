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
        Schema::create('service_frequency_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->enum('frequency_type', ['weekly', 'monthly', 'yearly']);
            $table->integer('no_of_times'); // Number of times per frequency period
            $table->integer('duration')->nullable(); // Duration in hours
            $table->decimal('price_per_time', 10, 2); // Price per service
            $table->timestamps();
            
            // Index for better performance
            $table->index(['service_id', 'frequency_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_frequency_options');
    }
};
