<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('pharmacy_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Penjualan', 'Pembelian']);
            $table->date('date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_transactions');
    }
};
