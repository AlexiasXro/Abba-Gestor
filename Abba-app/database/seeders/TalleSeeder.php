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

            // Brasil
            ['talle' => 'BR 35'],
            ['talle' => 'BR 36'],
            ['talle' => 'BR 37'],
            ['talle' => 'BR 38'],
            ['talle' => 'BR 39'],
            ['talle' => 'BR 40'],

            // Paraguay
            ['talle' => 'PY S'],
            ['talle' => 'PY M'],
            ['talle' => 'PY L'],
            ['talle' => 'PY XL'],

            // Bolivia
            ['talle' => 'BO 6'],
            ['talle' => 'BO 7'],
            ['talle' => 'BO 8'],
            ['talle' => 'BO 9'],
            ['talle' => 'BO 10'],

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
