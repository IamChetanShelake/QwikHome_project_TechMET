<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, migrate existing image data to media column
        $services = DB::table('services')->whereNotNull('image')->where('image', '!=', '')->get();

        foreach ($services as $service) {
            $existingMedia = $service->media ? json_decode($service->media, true) : [];

            // If there's image data and it's not already in media, add it
            if (!empty($service->image) && !in_array($service->image, $existingMedia)) {
                $existingMedia[] = $service->image;
                DB::table('services')
                    ->where('id', $service->id)
                    ->update(['media' => json_encode($existingMedia)]);
            }
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        // Note: This is a destructive operation - we can't easily reverse the migration
        // of image data to media array without knowing the original structure
    }
};
