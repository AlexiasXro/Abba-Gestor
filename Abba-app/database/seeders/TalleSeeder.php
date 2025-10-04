<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Talle;

class TalleSeeder extends Seeder
{
    public function run()
    {
        // Talles de calzado
        $tallesCalzado = range(35, 45); // 35,36,...45
        foreach ($tallesCalzado as $talle) {
            Talle::firstOrCreate(['talle' => $talle]);
        }

        // Talles de ropa
        $tallesRopa = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        foreach ($tallesRopa as $talle) {
            Talle::firstOrCreate(['talle' => $talle]);
        }

        $this->command->info('Talles de calzado y ropa cargados con éxito.');
    }
}
