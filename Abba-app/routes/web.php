<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TalleController;
use App\Http\Controllers\PanelController;


Route::get('/', function () {
    return view('panel');
});

// Redireccionar / a /panel (o directamente llamar al método)
Route::get('/', [PanelController::class, 'index'])->name('panel');

// Rutas para ventas
Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
//modal
Route::post('/clientes/rapido', [ClienteController::class, 'rapido'])->name('clientes.rapido');
//buscar cliente
Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
//historial cliente
Route::get('clientes/historial', [ClienteController::class, 'historial'])->name('clientes.historial');





// Rutas para productos_____________________________________________________
Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/eliminados', [ProductoController::class, 'eliminados'])->name('eliminados');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{producto}', [ProductoController::class, 'show'])->name('show');
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');

    // Ruta para restaurar
    Route::post('/{id}/restaurar', [ProductoController::class, 'restaurar'])->name('restaurar');
});
//________________________________________________________________________________


//Rutas para alertas y logueo?------------------------------------------
Route::get('/alertas/stock', [AlertaController::class, 'stockBajo'])->name('alertas.stock');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//----------------------------------------------


// Rutas para clientes____________________________________________________________________
Route::resource('clientes', ClienteController::class);

// Extra: vistas de eliminados y restauración
Route::get('clientes-eliminados', [ClienteController::class, 'eliminados'])->name('clientes.eliminados');
Route::post('clientes/{id}/restaurar', [ClienteController::class, 'restaurar'])->name('clientes.restaurar');

// Rutas para talles__________________________________________________________________________
Route::resource('talles', TalleController::class);
