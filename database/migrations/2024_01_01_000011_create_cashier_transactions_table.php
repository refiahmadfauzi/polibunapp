<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('cashier_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->nullable()->constrained('registrations')->nullOnDelete();
            $table->enum('payment_method', ['Tunai', 'BPJS', 'Transfer', 'Lainnya'])->default('Tunai');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashier_transactions');
    }
};
