<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
     public function stockBajo()
    {
        $productos = Producto::with(['talles' => function ($query) {
            $query->wherePivot('stock', '<', DB::raw('stock_minimo'));
        }])
        ->whereHas('talles', function ($query) {
            $query->wherePivot('stock', '<', DB::raw('stock_minimo'));
        })
        ->get();

        return view('alertas.stock', compact('productos'));
    }
}

