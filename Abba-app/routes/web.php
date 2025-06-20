<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;

Route::get('/panel', function () {
    return view('panel');
});

// Rutas para ventas
Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);

// Rutas para productos
Route::resource('productos', ProductoController::class);

// Rutas para clientes
Route::resource('clientes', ClienteController::class);