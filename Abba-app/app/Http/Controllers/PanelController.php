<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\ProductoTalle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PanelController extends Controller
{
    public function index()
    {
        // Ventas del día
        $ventasHoy = Venta::whereDate('fecha_venta', today())
                         ->selectRaw('COUNT(*) as cantidad, SUM(total) as monto')
                         ->first();
        
        // Productos con stock bajo (incluyendo relación con talles)
        $productosBajoStock = ProductoTalle::with(['producto', 'talle'])
            ->where('stock', '<=', 1)
            ->orderBy('stock')
            ->get()
            ->groupBy('producto_id');
        
        // Últimos clientes agregados
        $ultimosClientes = Cliente::latest()
                                 ->take(5)
                                 ->get();
        
        return view('panel', compact(
            'ventasHoy',
            'productosBajoStock',
            'ultimosClientes'
        ));
    }
}