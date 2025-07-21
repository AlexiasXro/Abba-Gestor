<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @property int $id
 * @property int $venta_id
 * @property int $producto_id
 * @property int $talle_id
 * @property int $cantidad
 * @property \Carbon\Carbon $fecha
 * @property string $tipo
 * @property string $motivo_texto
 * @property string|null $observaciones
 * @property string $estado
 * @property string|null $motivo_anulacion
 * @property int $usuario_id
 * @property \App\Models\Venta $venta
 * @property \App\Models\Producto $producto
 * @property \App\Models\Talle $talle
 * @property \App\Models\User $usuario
 */
class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'talle_id',
        'cantidad',
        'fecha',
        'tipo',
        'motivo_texto',
        'observaciones',
        'estado',
        'motivo_anulacion',
        'usuario_id',
    ];

    // Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Verificar si la garantía está vencida
    public function garantiaVencida($dias = 10)
{
    if ($this->tipo !== 'garantia') {
        return false;
    }

    $fechaVenta = $this->venta ? $this->venta->fecha : null;

    return $fechaVenta ? now()->diffInDays($fechaVenta) > $dias : true;
}

    // Verificar si la devolución está vencida
    public function devolucionVencida($dias = 10)
    {
        $fechaVenta = $this->venta->fecha ?? null;

        return $fechaVenta ? now()->diffInDays($fechaVenta) > $dias : true;
    }


  
}
