<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Talle;

class TalleSeeder extends Seeder
{
    public function run(): void
    {
        $talles = [
            // Argentina
            ['talle' => 'AR 35'],
            ['talle' => 'AR 36'],
            ['talle' => 'AR 37'],
            ['talle' => 'AR 38'],
            ['talle' => 'AR 39'],
            ['talle' => 'AR 40'],
            ['talle' => 'AR 41'],
            ['talle' => 'AR 42'],

            ,

              // Ropa - Estándar Internacional
            ['talle' => 'XS'],
            ['talle' => 'S'],
            ['talle' => 'M'],
            ['talle' => 'L'],
            ['talle' => 'XL'],
            ['talle' => 'XXL'],
        ];

        foreach ($talles as $talle) {
            Talle::firstOrCreate($talle);
        }
    }
}
