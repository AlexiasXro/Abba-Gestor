<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoTalle extends Model
{

    //
    use HasFactory;

    protected $table = 'producto_talle';
    
    protected $fillable = [
        'producto_id',
        'talle_id',
        'stock'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }
}


