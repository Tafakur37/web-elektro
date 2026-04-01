<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('matkuls', function (Blueprint $table) {
            $table->integer('semester')->after('sks')->default(1);
        });
    }

    public function down()
    {
        Schema::table('matkuls', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
?>

