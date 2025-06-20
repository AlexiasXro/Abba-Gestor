<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 2. Migración para la tabla talles (database/migrations/xxxx_create_talles_table.php)
     */
    public function up()
    {
        Schema::create('talles', function (Blueprint $table) {
            $table->id();
            $table->string('talle');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('talles');
    }
};
