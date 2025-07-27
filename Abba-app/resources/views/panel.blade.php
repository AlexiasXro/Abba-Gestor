@extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="container-fluid">
    <h1>Panel de Control</h1>

    <!-- Accesos rápidos -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-lg w-100 py-3">
                Nueva Venta
            </a>
        </div>
        
        <div class="col-md-3 mb-3">
            <a href="{{ route('productos.index') }}" class="btn btn-success btn-lg w-100 py-3">
                Productos
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('clientes.index') }}" class="btn btn-info btn-lg w-100 py-3">
                Clientes
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-dark w-100 py-3">📊 Ver Reportes</a>
        </div>
    </div>

    <!-- Resumen de ventas -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Ventas Hoy</div>
                <div class="card-body text-center">
                    <h2>{{ $ventasHoyResumen->cantidad ?? 0 }}</h2>
                    <p>ventas realizadas</p>
                    <h3 class="text-success">${{ number_format($ventasHoyResumen->monto ?? 0, 2) }}</h3>
                    <p>Total acumulado</p>
                </div>
            </div>
        </div>
        

      <!-- Productos con stock bajo -->
<div class="col-md-6 mb-3">
    <div class="card">
        <div class="card-header bg-warning text-white">Productos con Stock Bajo</div>
        <div class="card-body p-2">

            @if($productosBajoStock->isEmpty())
                <div class="alert alert-success">Todo el stock está en orden</div>
            @else
                <div class="scroll-container">
                    <table class="table table-sm mb-0">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>Producto</th>
                                <th>Talle</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productosBajoStock as $productoId => $items)
                                @foreach ($items as $index => $item)
                                    <tr class="{{ $item->stock == 0 ? 'table-danger' : '' }}">
                                        @if ($index === 0)
                                            <td rowspan="{{ $items->count() }}">
                                                <a href="{{ route('productos.show', $item->producto_id) }}">
                                                    {{ optional($item->producto)->nombre ?? 'Producto eliminado' }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>{{ $item->talle->talle }}</td>
                                        <td>{{ $item->stock }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .scroll-container {
        max-height: 180px; /* altura máxima del contenedor */
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
     <div class="row mb-3">
        <div class="col-12 mb-3">
            <div class="card">
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
                <div class="card-header bg-info text-white">Últimos Clientes Registrados</div>
                <div class="card-body">
                    @if($ultimosClientes->isEmpty())
                    <p>No hay clientes registrados recientemente</p>
                    @else
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
                    @endif
                </div>
            </div>
        </div>
    </div>
   

</div>


@endsection