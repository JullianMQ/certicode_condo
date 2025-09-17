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
        Schema::create('condos', function (Blueprint $table) {
            $table->id();
            $table->string('condo_id')->unique();
            $table->string('building_name');
            $table->string('address');
            $table->string('developer');
            $table->string('unit_id')->unique();
            $table->string('unit_type');
            $table->float('floor_area_sqm');
            $table->string('current_status');
            $table->string('owner_id')->nullable();
            $table->json('listing_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condos');
    }
};
