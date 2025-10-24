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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['credit_card', 'debit_card', 'bank_transfer', 'digital_wallet', 'cash', 'other']);
            $table->enum('provider', ['stripe', 'paypal', 'square', 'bank_transfer', 'cash', 'other']);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);

            // Credit/Debit Card fields
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_brand', 50)->nullable();
            $table->tinyInteger('card_exp_month')->nullable();
            $table->smallInteger('card_exp_year')->nullable();
            $table->string('card_token', 255)->nullable(); // Encrypted token

            // Bank Transfer fields
            $table->string('bank_name', 255)->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('routing_number', 255)->nullable();
            $table->string('iban', 255)->nullable();

            // Digital Wallet fields
            $table->string('wallet_type', 50)->nullable(); // apple_pay, google_pay, etc.
            $table->string('wallet_identifier', 255)->nullable();

            // Billing Address
            $table->string('billing_name', 255)->nullable();
            $table->string('billing_email', 255)->nullable();
            $table->string('billing_phone', 255)->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city', 255)->nullable();
            $table->string('billing_state', 255)->nullable();
            $table->string('billing_zip', 20)->nullable();
            $table->string('billing_country', 100)->nullable();

            $table->json('metadata')->nullable(); // Additional provider-specific data
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};