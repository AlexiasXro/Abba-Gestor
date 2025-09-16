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
        'user_id', // si lo estás asociando a un usuario
        'metodo_pago',
    ];

    protected $dates = ['deleted_at'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
