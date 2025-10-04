@extends('layouts.app')
@php
    $productosBajoStock = $productosBajoStock ?? collect();
@endphp


@section('title', 'Panel de Control')

@section('content')

    <div class="container">
        

       <!-- Accesos rápidos -->
<div class="d-flex gap-2 py-2">
    <a href="{{ route('ventas.create') }}" class="btn btn-primary d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-cash-stack" style="font-size: 2rem;"></i>
        <span class="small mt-1">Nueva Venta</span>
    </a>

    <a href="{{ route('productos.index') }}" class="btn btn-success d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
        <span class="small mt-1">Productos</span>
    </a>

    <a href="{{ route('clientes.index') }}" class="btn btn-info d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
        <span class="small mt-1">Clientes</span>
    </a>

    <a href="{{ route('reportes.index') }}" class="btn btn-outline-dark d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-graph-up" style="font-size: 2rem;"></i>
        <span class="small mt-1">Reportes</span>
    </a>

    <a href="{{ route('gastos.index') }}" class="btn btn-warning d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
        <span class="small mt-1">Gastos</span>
    </a>

    <a href="{{ route('cierres.index') }}" class="btn btn-secondary d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-journal-check" style="font-size: 2rem;"></i>
        <span class="small mt-1">Cierre de Caja</span>
    </a>

    <a href="{{ route('proveedores.index') }}" class="btn btn-dark d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-truck" style="font-size: 2rem;"></i>
        <span class="small mt-1">Proveedores</span>
    </a>

    <a href="" class="btn btn-info d-flex flex-column align-items-center justify-content-center text-center flex-fill">
        <i class="bi bi-headset" style="font-size: 2rem;"></i>
        <span class="small mt-1">Soporte Técnico</span>
    </a>
</div>


<div class="row mb-2 w-100" style="min-height: 350px;"> <!-- altura mínima de la sección -->
    <!-- Ventas Hoy -->
    <div class="col-md-3 mb-2 d-flex">
        <div class="card w-100 h-100 d-flex flex-column">
            <div class="card-header bg-primary text-white">Ventas Hoy</div>
            <div class="card-body text-center d-flex flex-column justify-content-center flex-fill">
                <h2>{{ $ventasHoyResumen->cantidad ?? 0 }}</h2>
                <p>ventas realizadas</p>
                <h3 class="text-success">${{ number_format($ventasHoyResumen->monto ?? 0, 2) }}</h3>
                <p>Total acumulado</p>
            </div>
        </div>
    </div>

    <!-- Productos con stock bajo -->
    <div class="col-md-3 mb-2 d-flex">
        <div class="card w-100 h-100 d-flex flex-column">
            <div class="card-header bg-primary text-white">Productos con Stock Bajo</div>
            <div class="card-body p-2 flex-fill">
                @if($productosBajoStock->isEmpty())
                    <div class="alert alert-success">Todo el stock está en orden</div>
                @else
                    <div class="scroll-container">
                        @foreach ($productosBajoStock as $productoId => $items)
                            <div class="mb-1">
                                <a href="{{ route('productos.show', $productoId) }}" class="text-danger">
                                    {{ optional($items[0]->producto)->nombre ?? 'Producto eliminado' }}
                                </a>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($items as $item)
                                        <span class="badge text-dark">
                                            {{ $item->talle->talle }} ({{ $item->stock }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Calendario simplificado -->
    <div class="col-md-3 mb-2 d-flex">
        <div class="card w-100 h-100 d-flex flex-column">
            <div class="card-header bg-primary text-white">📅 Calendario</div>
            <div class="card-body p-2 flex-fill">
                <div class="scroll-container">
                    <table class="table table-sm mb-0">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>Evento</th>
                                <th>Fecha / Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Día del Amigo</td><td>20/07</td></tr>
                            <tr><td>Día del Padre</td><td>3° domingo de junio</td></tr>
                            <tr><td>Día del Maestro</td><td>11/09</td></tr>
                            <tr><td>Día del Profesor</td><td>17/09</td></tr>
                            <tr><td>Día de la Madre</td><td>2° domingo de octubre</td></tr>
                            <tr><td>Black Friday</td><td>Último viernes de noviembre</td></tr>
                            <tr><td>Cyber Monday</td><td>Lunes siguiente a Black Friday</td></tr>
                            <tr><td>Navidad</td><td>25/12</td></tr>
                            <tr><td>Año Nuevo</td><td>01/01</td></tr>
                            <tr><td>Febrero (post vacaciones)</td><td>Todo febrero</td></tr>
                            <tr><td>Marzo (inicio clases)</td><td>Todo marzo</td></tr>
                            <tr><td>Julio (medio invierno)</td><td>Todo julio</td></tr>
                            <tr><td>Agosto (post vacaciones)</td><td>Todo agosto</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor vacío para futura sección -->
    <div class="col-md-3 mb-2 d-flex">
        <div class="card w-100 h-100 d-flex flex-column">
            <div class="card-header bg-primary text-white">Próxima Función</div>
            <div class="card-body d-flex flex-column justify-content-center flex-fill">
                <div class="scroll-container"></div>
                <div class="text-center text-muted mt-auto">
                    Aquí podrás agregar nuevas funcionalidades más adelante.
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scroll uniforme -->
<style>
    .scroll-container {
        max-height: 300px; /* mismo para todas las cards */
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
    }

    .scroll-container:hover {
        overflow-y: auto;
    }

    .scroll-container::-webkit-scrollbar {
        width: 6px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .scroll-container::-webkit-scrollbar-track {
        background-color: transparent;
    }
</style>



            <!-- Últimos ventas -->
            <div class="row ">
                <div class="col-12 mb-3">
                    <div class="card mb-2">
                        <div class="card-header bg-primary text-white">Detalles del día de venta</div>
                        <div class="card-body">
                            @if ($ventasHoyDetalle->isEmpty())
                                <p class="text-muted text-center mb-0">No se realizaron ventas hoy.</p>
                            @else
                                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-striped table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>Total</th>
                                                <th>Pagado</th>
                                                <th>Vuelto</th>
                                                <th>Hora</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ventasHoyDetalle as $venta)
                                                <tr @if($venta->estado === 'anulada') class="table-danger" @endif>
                                                    <td>{{ $venta->id }}</td>
                                                    <td>{{ $venta->cliente->nombre ?? 'Sin nombre' }}</td>
                                                    <td>
                                                        @if($venta->estado === 'anulada')
                                                            <del>${{ number_format($venta->total, 2) }}</del>
                                                        @else
                                                            ${{ number_format($venta->total, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($venta->monto_pagado, 2) }}</td>
                                                    <td>${{ number_format($venta->monto_pagado - $venta->total, 2) }}</td>
                                                    <td>{{ $venta->created_at->format('H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-info"
                                                            title="Ver Detalle">
                                                            Ver
                                                            @if($venta->estado === 'anulada')
                                                                <span class="badge bg-danger ms-1">Anulada</span>
                                                            @endif
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>


                    <!-- Últimos clientes -->
                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">Últimos Clientes Registrados</div>
                                <div class="card-body">
                                    @if($ultimosClientes->isEmpty())
                                        <p>No hay clientes registrados recientemente</p>
                                    @else
                                            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;"></div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                        <th>Email</th>
                                                        <th>Registrado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($ultimosClientes as $cliente)
                                                        <tr>
                                                            <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                                                            <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                                                            <td>{{ $cliente->email ?? 'N/A' }}</td>
                                                            <td>{{ $cliente->created_at->diffForHumans() }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>


@endsection