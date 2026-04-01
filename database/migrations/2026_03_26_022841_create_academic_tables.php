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
    // Tabel Bahan Ajar (Materi Kuliah)
    Schema::create('bahan_ajars', function (Blueprint $table) {
        $table->id();
        $table->string('nama_matkul');
        $table->string('file_path')->nullable(); // Link materi/PDF
        $table->integer('cohort'); // Target Cohort (misal: 6)
        $table->foreignId('dosen_id')->constrained('users');
        $table->timestamps();
    });

    // Tabel Nilai (Individu)
    Schema::create('nilais', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // ID Kadet
        $table->string('nama_matkul');
        $table->decimal('tugas', 5, 2)->default(0);
        $table->decimal('uts', 5, 2)->default(0);
        $table->boolean('remedial_uts')->default(false);
        $table->decimal('uas', 5, 2)->default(0);
        $table->boolean('remedial_uas')->default(false);
        $table->decimal('total_nilai', 5, 2);
        $table->string('grade', 2);
        $table->foreignId('dosen_id')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_tables');
    }
};
