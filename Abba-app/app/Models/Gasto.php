<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gasto extends Model
{
    use SoftDeletes;

    protected $table = 'gastos';

    protected $fillable = [
        'fecha',
        'monto',
        'descripcion',
        'categoria',
        'metodo_pago',
        
    ];

    protected $dates = ['deleted_at'];
}
