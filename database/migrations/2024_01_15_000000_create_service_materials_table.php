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
        Schema::create('service_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('material_name');
            $table->text('material_description')->nullable();
            $table->enum('applicable_to', ['onetime', 'weekly', 'monthly', 'yearly', 'all'])->default('onetime');
            $table->decimal('material_price', 10, 2)->default(0);
            $table->string('material_image')->nullable();
            $table->timestamps();

            $table->index(['service_id', 'applicable_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_materials');
    }
};
