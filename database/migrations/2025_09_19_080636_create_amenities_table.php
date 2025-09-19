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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('amenity_id')->unique();
            $table->string('name');
            $table->string('building_name');
            $table->integer('capacity');
            $table->boolean('is_bookable')->default(false);
            $table->decimal('fee_per_hour_php', 10, 2)->default(0);
            $table->time('start_hours');
            $table->time('end_hours');
            $table->integer('advance_booking_days')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
