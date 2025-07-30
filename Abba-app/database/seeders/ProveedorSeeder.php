<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    public function run()
    {
        Proveedor::truncate(); // limpia tabla para pruebas

        $proveedores = [
            ['nombre' => 'Proveedor A', 'cuit' => '20-11111111-1', 'email' => 'contacto1@proveedora.com', 'telefono' => '111111111', 'direccion' => 'Calle Falsa 1', 'observaciones' => ''],
            ['nombre' => 'Proveedor B', 'cuit' => '20-22222222-2', 'email' => 'contacto2@proveedorb.com', 'telefono' => '222222222', 'direccion' => 'Calle Falsa 2', 'observaciones' => ''],
            ['nombre' => 'Proveedor C', 'cuit' => '20-33333333-3', 'email' => 'contacto3@proveedorc.com', 'telefono' => '333333333', 'direccion' => 'Calle Falsa 3', 'observaciones' => ''],
            ['nombre' => 'Proveedor D', 'cuit' => '20-44444444-4', 'email' => 'contacto4@proveedord.com', 'telefono' => '444444444', 'direccion' => 'Calle Falsa 4', 'observaciones' => ''],
            ['nombre' => 'Proveedor E', 'cuit' => '20-55555555-5', 'email' => 'contacto5@proveedore.com', 'telefono' => '555555555', 'direccion' => 'Calle Falsa 5', 'observaciones' => ''],
            ['nombre' => 'Proveedor F', 'cuit' => '20-66666666-6', 'email' => 'contacto6@proveedorf.com', 'telefono' => '666666666', 'direccion' => 'Calle Falsa 6', 'observaciones' => ''],
            ['nombre' => 'Proveedor G', 'cuit' => '20-77777777-7', 'email' => 'contacto7@proveedorg.com', 'telefono' => '777777777', 'direccion' => 'Calle Falsa 7', 'observaciones' => ''],
            ['nombre' => 'Proveedor H', 'cuit' => '20-88888888-8', 'email' => 'contacto8@proveedorh.com', 'telefono' => '888888888', 'direccion' => 'Calle Falsa 8', 'observaciones' => ''],
            ['nombre' => 'Proveedor I', 'cuit' => '20-99999999-9', 'email' => 'contacto9@proveedori.com', 'telefono' => '999999999', 'direccion' => 'Calle Falsa 9', 'observaciones' => ''],
            ['nombre' => 'Proveedor J', 'cuit' => '20-10101010-0', 'email' => 'contacto10@proveedorj.com', 'telefono' => '1010101010', 'direccion' => 'Calle Falsa 10', 'observaciones' => ''],
            ['nombre' => 'Proveedor K', 'cuit' => '20-11121314-1', 'email' => 'contacto11@proveedork.com', 'telefono' => '1112131411', 'direccion' => 'Calle Falsa 11', 'observaciones' => ''],
            ['nombre' => 'Proveedor L', 'cuit' => '20-15161718-2', 'email' => 'contacto12@proveedorl.com', 'telefono' => '1516171812', 'direccion' => 'Calle Falsa 12', 'observaciones' => ''],
            ['nombre' => 'Proveedor M', 'cuit' => '20-19202122-3', 'email' => 'contacto13@proveedorm.com', 'telefono' => '1920212213', 'direccion' => 'Calle Falsa 13', 'observaciones' => ''],
            ['nombre' => 'Proveedor N', 'cuit' => '20-23242526-4', 'email' => 'contacto14@proveedorn.com', 'telefono' => '2324252614', 'direccion' => 'Calle Falsa 14', 'observaciones' => ''],
            ['nombre' => 'Proveedor O', 'cuit' => '20-27282930-5', 'email' => 'contacto15@proveedoro.com', 'telefono' => '2728293015', 'direccion' => 'Calle Falsa 15', 'observaciones' => ''],
            ['nombre' => 'Proveedor P', 'cuit' => '20-31323334-6', 'email' => 'contacto16@proveedorp.com', 'telefono' => '3132333416', 'direccion' => 'Calle Falsa 16', 'observaciones' => ''],
            ['nombre' => 'Proveedor Q', 'cuit' => '20-35363738-7', 'email' => 'contacto17@proveedorq.com', 'telefono' => '3536373817', 'direccion' => 'Calle Falsa 17', 'observaciones' => ''],
            ['nombre' => 'Proveedor R', 'cuit' => '20-39404142-8', 'email' => 'contacto18@proveedorr.com', 'telefono' => '3940414218', 'direccion' => 'Calle Falsa 18', 'observaciones' => ''],
            ['nombre' => 'Proveedor S', 'cuit' => '20-43444546-9', 'email' => 'contacto19@proveedors.com', 'telefono' => '4344454619', 'direccion' => 'Calle Falsa 19', 'observaciones' => ''],
            ['nombre' => 'Proveedor T', 'cuit' => '20-47484950-0', 'email' => 'contacto20@proveedort.com', 'telefono' => '4748495000', 'direccion' => 'Calle Falsa 20', 'observaciones' => ''],
        ];

        foreach ($proveedores as $prov) {
            Proveedor::create($prov);
        }
    }
}
