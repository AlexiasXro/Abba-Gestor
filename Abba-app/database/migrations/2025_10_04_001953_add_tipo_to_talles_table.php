<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('talles', function (Blueprint $table) {
            $table->string('tipo')->default('calzado')->after('talle'); 
            // puedes usar: calzado, ropa, niño
        });
    }

    public function down(): void
    {
        Schema::table('talles', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};

