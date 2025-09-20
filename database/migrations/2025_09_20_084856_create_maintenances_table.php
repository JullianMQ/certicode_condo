<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('unit_id');
            $table->string('user_id'); 
            $table->string('category');
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('pending'); 
            $table->string('urgency')->nullable();
            $table->string('assigned_to_user_id')->nullable(); 
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
