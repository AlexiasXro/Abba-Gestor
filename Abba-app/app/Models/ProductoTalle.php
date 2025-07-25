<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductoTalle extends Pivot
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


