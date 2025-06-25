<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            ['nombre' => 'Juan', 'apellido' => 'Pérez', 'telefono' => '3412345678', 'email' => 'juan.perez@example.com', 'direccion' => 'Calle Falsa 123'],
            ['nombre' => 'María', 'apellido' => 'González', 'telefono' => '3412345679', 'email' => 'maria.gonzalez@example.com', 'direccion' => 'Avenida Siempre Viva 742'],
            ['nombre' => 'Carlos', 'apellido' => 'Ramírez', 'telefono' => '3412345680', 'email' => 'carlos.ramirez@example.com', 'direccion' => 'Boulevard Central 456'],
            ['nombre' => 'Lucía', 'apellido' => 'Fernández', 'telefono' => '3412345681', 'email' => 'lucia.fernandez@example.com', 'direccion' => 'Plaza Mayor 789'],
            ['nombre' => 'Miguel', 'apellido' => 'Sánchez', 'telefono' => '3412345682', 'email' => 'miguel.sanchez@example.com', 'direccion' => 'Ruta 9 km 123'],
            ['nombre' => 'Sofía', 'apellido' => 'López', 'telefono' => '3412345683', 'email' => 'sofia.lopez@example.com', 'direccion' => 'Calle Luna 456'],
            ['nombre' => 'Javier', 'apellido' => 'Torres', 'telefono' => '3412345684', 'email' => 'javier.torres@example.com', 'direccion' => 'Avenida Sol 321'],
            ['nombre' => 'Valentina', 'apellido' => 'Martínez', 'telefono' => '3412345685', 'email' => 'valentina.martinez@example.com', 'direccion' => 'Calle Estrella 654'],
            ['nombre' => 'Diego', 'apellido' => 'Ruiz', 'telefono' => '3412345686', 'email' => 'diego.ruiz@example.com', 'direccion' => 'Pasaje Norte 987'],
            ['nombre' => 'Camila', 'apellido' => 'Vega', 'telefono' => '3412345687', 'email' => 'camila.vega@example.com', 'direccion' => 'Barrio Nuevo 135'],
        ];

        foreach ($clientes as $cliente) {
            Cliente::firstOrCreate(['email' => $cliente['email']], $cliente);
        }
    }
}


