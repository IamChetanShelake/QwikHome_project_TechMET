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
        Schema::create('service_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('description')->nullable(); // Multi-language descriptions
            $table->decimal('price', 10, 2);
            $table->foreignId('frequency_id')->nullable()->constrained('service_frequencies')->onDelete('set null');
            $table->enum('type', ['material', 'equipment', 'labor', 'premium', 'custom'])->default('custom');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('quantity_limit')->nullable(); // Max quantity allowed, null means unlimited
            $table->json('options')->nullable(); // For add-ons with multiple choices (e.g., different sizes)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_addons');
    }
};
