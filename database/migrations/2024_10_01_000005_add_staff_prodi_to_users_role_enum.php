<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN `role` ENUM('admin', 'kaprodi', 'sesprodi', 'staf', 'dosen', 'kadet', 'staff_prodi') NOT NULL DEFAULT 'kadet'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN `role` ENUM('admin', 'kaprodi', 'sesprodi', 'staf', 'dosen', 'kadet') NOT NULL DEFAULT 'kadet'");
    }
};
?>

