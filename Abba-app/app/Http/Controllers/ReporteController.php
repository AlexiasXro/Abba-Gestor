<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $ventasDiarias = DB::table('ventas')
            ->select(DB::raw("DATE(created_at) as fecha"), DB::raw("SUM(total) as total"))
            ->where('estado', '!=', 'anulada')
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderByDesc('fecha')
            ->limit(7)
            ->get();

        $ventasSemanales = DB::table('ventas')
            ->selectRaw("
            strftime('%Y', created_at) as anio,
            strftime('%W', created_at) as semana,
            MIN(DATE(created_at)) as desde,
            MAX(DATE(created_at)) as hasta,
            SUM(total) as total
        ")
            ->where('estado', '!=', 'anulada')
            ->groupBy('anio', 'semana')
            ->orderByDesc('anio')
            ->orderByDesc('semana')
            ->limit(6)
            ->get();

        $topProductos = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.producto_id', '=', 'p.id')
            ->join('ventas as v', 'vd.venta_id', '=', 'v.id')
            ->where('v.estado', '!=', 'anulada')
            ->select('p.nombre', DB::raw('SUM(vd.cantidad) as total_vendido'))
            ->groupBy('vd.producto_id', 'p.nombre')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        $ventasPorCliente = DB::table('ventas as v')
            ->join('clientes as c', 'v.cliente_id', '=', 'c.id')
            ->select('c.nombre', DB::raw('SUM(v.total) as total_gastado'))
            ->where('v.estado', '!=', 'anulada')
            ->groupBy('v.cliente_id', 'c.nombre')
            ->orderByDesc('total_gastado')
            ->limit(10)
            ->get();

        $ventasPorMetodo = DB::table('ventas')
            ->select('metodo_pago', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(total) as total'))
            ->where('estado', '!=', 'anulada')
            ->groupBy('metodo_pago')
            ->get();

        $gananciaTotal = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.producto_id', '=', 'p.id')
            ->select(DB::raw('SUM((vd.precio_unitario - p.precio_base) * vd.cantidad) as total'))
            ->value('total');


        // Opción 1 (si NO usás producto_talle_id):
        $productosRentabilidad = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.producto_id', '=', 'p.id')
            ->select('p.nombre', DB::raw('SUM((vd.precio_unitario - p.precio_base) * vd.cantidad) as ganancia_total'))
            ->groupBy('p.id', 'p.nombre')
            ->orderByDesc('ganancia_total')
            ->take(10)
            ->get();

        // Si también tenés otras variables (como ventasDiarias, etc.), asegurate de definirlas antes de este return:
        return view('reportes.index', compact(
            'ventasDiarias',
            'ventasSemanales',
            'topProductos',
            'ventasPorCliente',
            'ventasPorMetodo',
            'gananciaTotal',
            'productosRentabilidad'
        ));
    }
}



