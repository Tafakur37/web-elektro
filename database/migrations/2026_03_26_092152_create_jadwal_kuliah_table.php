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
        Schema::create('jadwal_kuliah', function (Blueprint $table) {
            $table->id();
            $table->integer('semester'); // 1-14
            $table->string('mata_kuliah');
            $table->string('dosen');
            $table->string('hari'); // Senin, Selasa, etc
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruang');
            $table->integer('cohort')->nullable(); // Filter by cohort
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kuliah');
    }
};
