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
    Schema::table('productos', function (Blueprint $table) {
        $table->decimal('precio_base', 10, 2)->nullable()->after('precio');
        $table->decimal('precio_venta', 10, 2)->nullable()->after('precio_base');
        $table->decimal('precio_reventa', 10, 2)->nullable()->after('precio_venta');
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn(['precio_base', 'precio_venta', 'precio_reventa']);
    });
}

};
