<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->string('user_id');
            $table->string('unit_id');
            $table->string('payment_type');
            $table->decimal('amount_php', 10, 2);
            $table->date('due_date');
            $table->enum('status', ['Pending', 'Paid', 'Overdue'])->default('Pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};