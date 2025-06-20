<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    //Modelo Talle (app/Models/Talle.php)
    use HasFactory;

    protected $fillable = ['talle'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_talle')
                    ->withPivot('stock')
                    ->withTimestamps();
    }

    public function ventasDetalle()
    {
        return $this->hasMany(VentaDetalle::class);
    }
}