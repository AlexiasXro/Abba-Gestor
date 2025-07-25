<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TalleController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\CierreCajaController;




Route::get('/', function () {
    return view('panel');
});

// Redireccionar / a /panel (o directamente llamar al método)
Route::get('/', [PanelController::class, 'index'])->name('panel');

// Rutas para ventas____________________________________________________
Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');

//modal_-_-_-_-
Route::post('/clientes/rapido', [ClienteController::class, 'rapido'])->name('clientes.rapido');

//buscar cliente______________________________________
Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');

//historial cliente___________________________________________
Route::get('clientes/historial', [ClienteController::class, 'historial'])->name('clientes.historial');

//anular venta______________________________________________ 
Route::patch('/ventas/{venta}/anular', [VentaController::class, 'anular'])->name('ventas.anular');


//Gestion de cuotas_____________________________________________________________________________________________
Route::get('/cuotas', [CuotaController::class, 'index'])->name('cuotas.index');
Route::post('/cuotas/pagar/{id}', [CuotaController::class, 'pagar'])->name('cuotas.pagar');




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

    // Ruta para restaurar___
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


// Rutas para REPORTES__________________________________________________________________________

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');



// Rutas para CONFIGURACION__________________________________________________________________________
Route::post('/configuracion/aspecto', [ConfiguracionController::class, 'actualizarAspecto'])->name('configuracion.aspecto')->middleware('auth');


//Finanzas gastos
Route::resource('gastos', GastoController::class);
// Rutas para cierre de caja (resource completo si querés todas las acciones)
Route::resource('cierres', CierreCajaController::class);


use App\Http\Controllers\DevolucionController;

Route::get('/devoluciones/crear', [DevolucionController::class, 'create'])->name('devoluciones.create');
Route::post('/devoluciones', [DevolucionController::class, 'store'])->name('devoluciones.store');
Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index');
Route::put('/devoluciones/{devolucion}/anular', [DevolucionController::class, 'anular'])->name('devoluciones.anular');
Route::get('/devoluciones/{devolucion}', [DevolucionController::class, 'show'])->name('devoluciones.show');
Route::get('devoluciones/crear', [DevolucionController::class, 'create'])->name('devoluciones.create');
