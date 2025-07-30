<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // En SQLite, para cambiar columna, hay que recrear tabla
    Schema::table('productos', function (Blueprint $table) {
        $table->decimal('precio', 8, 2)->nullable()->change();
    });
}


    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->decimal('precio', 8, 2)->nullable(false)->change();
    });
}

};
