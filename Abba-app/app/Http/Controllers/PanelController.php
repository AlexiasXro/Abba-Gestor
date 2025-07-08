<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\ProductoTalle;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        // 1. Ventas del día (resumen)
        $ventasHoyResumen = Venta::whereDate('fecha_venta', today())
            ->where('estado', '!=', 'anulada')
            ->selectRaw('COUNT(*) as cantidad, SUM(total) as monto')
            ->first();

        // 2. Ventas del día (detalle últimas 5)
        $ventasHoyDetalle = Venta::with('cliente')
            ->whereDate('fecha_venta', today())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Productos con stock bajo
        $productosBajoStock = ProductoTalle::with(['producto', 'talle'])
            ->where('stock', '<=', 1)
            ->orderBy('stock')
            ->get()
            ->groupBy('producto_id');

        // 4. Últimos clientes agregados
        $ultimosClientes = Cliente::latest()
            ->take(3)
            ->get();

        // Retornamos la vista sin gráficos
        return view('panel', [
            'ventasHoyResumen' => $ventasHoyResumen,
            'ventasHoyDetalle' => $ventasHoyDetalle,
            'productosBajoStock' => $productosBajoStock,
            'ultimosClientes' => $ultimosClientes,
            'mostrarAlertaStock' => true,
        ]);
    }
}
