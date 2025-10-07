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
        Schema::table('users', function (Blueprint $table) {
            // Document fields
            $table->string('application_document')->nullable()->after('address');
            $table->string('trade_license_document')->nullable()->after('application_document');
            $table->string('vat_certificate_document')->nullable()->after('trade_license_document');
            $table->string('staff_documents')->nullable()->after('vat_certificate_document');
            $table->string('contract_document')->nullable()->after('staff_documents');

            // Payment terms fields
            $table->enum('payment_type', ['fixed_rate', 'commission', 'revenue_share'])->default('commission')->after('contract_document');
            $table->decimal('fixed_rate_amount', 10, 2)->nullable()->after('payment_type');
            $table->decimal('commission_rate', 5, 2)->nullable()->after('fixed_rate_amount'); // percentage
            $table->string('revenue_share_ratio')->nullable()->after('commission_rate'); // e.g., "40:60"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'application_document',
                'trade_license_document',
                'vat_certificate_document',
                'staff_documents',
                'contract_document',
                'payment_type',
                'fixed_rate_amount',
                'commission_rate',
                'revenue_share_ratio'
            ]);
        });
    }
};
