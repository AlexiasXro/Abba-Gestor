<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Talle;

class TalleSeeder extends Seeder
{
    public function run(): void
    {
        // Solo talles de calzado (del 35 al 45)
        $tallesCalzado = range(35, 45);

        foreach ($tallesCalzado as $numero) {
            Talle::create([
                'talle' => $numero
            ]);
        }
    }
}
