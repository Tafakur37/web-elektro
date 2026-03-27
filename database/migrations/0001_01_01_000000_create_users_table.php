<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Utama User
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Identifier untuk NIM (Kadet) atau NIP (Dosen/Staf)
            $table->string('identifier')->unique(); 
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            // Definisi Role sesuai kebutuhan Web Elektro
            $table->enum('role', [
                'admin', 
                'kaprodi', 
                'sesprodi', 
                'staf', 
                'dosen', 
                'kadet'
            ])->default('kadet');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Reset Password (Bawaan Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel Session (Bawaan Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};