<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        // Ventas Diarias (últimos 7 días)
        $ventasDiarias = DB::table('ventas')
            ->select(DB::raw("DATE(created_at) as fecha"), DB::raw("SUM(total) as total"))
            ->where('estado', '!=', 'anulada')
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderByDesc('fecha')
            ->limit(7)
            ->get();

        // Ventas Semanales (últimas 6 semanas)
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

        //Top productos más vendidos
        $topProductos = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.producto_id', '=', 'p.id')
            ->select('p.nombre', DB::raw('SUM(vd.cantidad) as total_vendido'))
            ->join('ventas as v', 'vd.venta_id', '=', 'v.id')
            ->where('v.estado', '!=', 'anulada')
            ->groupBy('vd.producto_id', 'p.nombre')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        //Ventas por cliente
        $ventasPorCliente = DB::table('ventas as v')
            ->join('clientes as c', 'v.cliente_id', '=', 'c.id')
            ->select('c.nombre', DB::raw('SUM(v.total) as total_gastado'))
            ->where('v.estado', '!=', 'anulada')
            ->groupBy('v.cliente_id', 'c.nombre')
            ->orderByDesc('total_gastado')
            ->limit(10)
            ->get();

        //Ventas por método de pago
        $ventasPorMetodo = DB::table('ventas')
            ->select('metodo_pago', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(total) as total'))
            ->where('estado', '!=', 'anulada')
            ->groupBy('metodo_pago')
            ->get();


        return view('reportes.index', compact(
            'ventasDiarias',
            'ventasSemanales',
            'topProductos',
            'ventasPorCliente',
            'ventasPorMetodo'
        ));
    }



}
