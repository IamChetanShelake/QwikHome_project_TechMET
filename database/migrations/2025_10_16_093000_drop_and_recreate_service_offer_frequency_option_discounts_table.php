<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        DB::statement('DROP TABLE IF EXISTS service_offer_frequency_option_discounts');

        // Create the table with proper foreign key names
        DB::statement("
            CREATE TABLE service_offer_frequency_option_discounts (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                service_offer_id BIGINT UNSIGNED NOT NULL,
                frequency_option_id BIGINT UNSIGNED NOT NULL,
                discounted_price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                UNIQUE KEY service_offer_freq_option_unique (service_offer_id, frequency_option_id),
                CONSTRAINT fk_so_freq_discounts_offer_id
                    FOREIGN KEY (service_offer_id)
                    REFERENCES service_offers (id)
                    ON DELETE CASCADE,
                CONSTRAINT fk_so_freq_discounts_option_id
                    FOREIGN KEY (frequency_option_id)
                    REFERENCES service_frequency_options (id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_offer_frequency_option_discounts');
    }
};
