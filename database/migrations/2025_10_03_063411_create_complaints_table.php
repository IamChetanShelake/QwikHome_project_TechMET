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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Customer who submitted the complaint
            $table->string('order_id')->nullable(); // Related order ID if applicable
            $table->enum('complainant_type', ['customer', 'service_provider']); // Who filed the complaint
            $table->enum('complaint_type', [
                'late_delivery', 'poor_service', 'payment_issue',
                'fraud', 'product_quality', 'communication', 'other'
            ]);
            $table->text('description');
            $table->enum('status', ['pending', 'in_review', 'resolved', 'rejected'])
                  ->default('pending');
            $table->text('admin_notes')->nullable(); // Admin internal notes
            $table->string('attachment_path')->nullable(); // File path for attachments
            $table->string('original_filename')->nullable(); // Original attachment filename
            $table->unsignedBigInteger('assigned_admin_id')->nullable(); // Admin assigned to handle
            $table->timestamp('resolved_at')->nullable();
            $table->enum('resolution_action', [
                'refund', 'replacement', 'account_blocked',
                'warning', 'none', 'other'
            ])->nullable();
            $table->text('resolution_details')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
