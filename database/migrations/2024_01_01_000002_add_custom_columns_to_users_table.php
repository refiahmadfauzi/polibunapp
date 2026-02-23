<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik_karyawan')->nullable()->after('name');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete()->after('nik_karyawan');
            $table->boolean('is_active')->default(true)->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropColumn(['nik_karyawan', 'division_id', 'is_active']);
        });
    }
};
