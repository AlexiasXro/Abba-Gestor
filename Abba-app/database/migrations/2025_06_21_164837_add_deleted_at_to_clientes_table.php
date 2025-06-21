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
    Schema::table('clientes', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->softDeletes(); // crea la columna deleted_at
    });
}

public function down()
{
    Schema::table('clientes', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
};
