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
        Schema::create('service_frequencies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'One-time', 'Weekly', 'Monthly', 'Yearly'
            $table->string('slug')->unique(); // e.g., 'onetime', 'weekly'
            $table->json('description')->nullable(); // Multi-language support
            $table->integer('days_multiplier')->default(1); // How many days this frequency represents
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_frequencies');
    }
};
