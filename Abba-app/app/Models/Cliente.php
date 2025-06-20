<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //Modelo Cliente (app/Models/Cliente.php)
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellido', 'telefono', 'email', 'direccion'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}