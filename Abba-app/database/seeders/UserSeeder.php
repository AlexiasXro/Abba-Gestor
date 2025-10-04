<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Superusuario (Administrador A)
        User::firstOrCreate(
            ['email' => 'admin@super.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperPass123'), // Cambiar por algo seguro
                'tipo_usuario' => 'Administrador A',
                'activo' => true,
            ]
        );

        // Administrador B de prueba
        User::firstOrCreate(
            ['email' => 'adminb@empresa.com'],
            [
                'name' => 'Admin B',
                'password' => Hash::make('AdminB123'),
                'tipo_usuario' => 'Administrador B',
                'activo' => true,
            ]
        );

        // Vendedores de prueba
        User::firstOrCreate(
            ['email' => 'vendedor1@empresa.com'],
            [
                'name' => 'Vendedor 1',
                'password' => Hash::make('Vendedor123'),
                'tipo_usuario' => 'Vendedor',
                'activo' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'vendedor2@empresa.com'],
            [
                'name' => 'Vendedor 2',
                'password' => Hash::make('Vendedor123'),
                'tipo_usuario' => 'Vendedor',
                'activo' => true,
            ]
        );

        $this->command->info('Usuarios de prueba y superusuario creados con éxito.');
    }
}
