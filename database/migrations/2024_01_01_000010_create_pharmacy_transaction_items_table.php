<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('pharmacy_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_transaction_id')->constrained('pharmacy_transactions')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_transaction_items');
    }
};
