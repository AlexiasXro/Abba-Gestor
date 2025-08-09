<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Configuracion.php
class Configuracion extends Model
{
    protected $table = 'configuraciones';
    protected $fillable = ['clave', 'valor'];
    public $timestamps = true;

    public static function getValor($clave, $default = null)
    {
        return optional(static::where('clave', $clave)->first())->valor ?? $default;
    }

    public static function getNumero($clave, $default = 0)
    {
        $valor = static::getValor($clave, $default);
        return is_numeric($valor) ? floatval($valor) : $default;
    }
}
