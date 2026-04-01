<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->decimal('remedial_uts', 5, 2)->nullable()->change();
            $table->decimal('remedial_uas', 5, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->decimal('remedial_uts', 5, 2)->change();
            $table->decimal('remedial_uas', 5, 2)->change();
        });
    }
};

