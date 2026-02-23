<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->date('registration_date');
            $table->foreignId('medical_staff_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', [
                'Antrian Poli',
                'Panggilan Poli',
                'Farmasi',
                'Kasir',
                'Selesai',
                'Batal',
            ])->default('Antrian Poli');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
