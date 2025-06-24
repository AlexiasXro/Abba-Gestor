@extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Panel de Control</h1>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-lg w-100 py-3">
                <i class="fas fa-cash-register me-2"></i> Nueva Venta
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('productos.index') }}" class="btn btn-success btn-lg w-100 py-3">
                <i class="fas fa-shoe-prints me-2"></i> Productos
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('clientes.index') }}" class="btn btn-info btn-lg w-100 py-3">
                <i class="fas fa-users me-2"></i> Clientes
            </a>
        </div>
    </div>

    <!-- Resumen de ventas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ventas Hoy</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="display-4">{{ $ventasHoy->cantidad ?? 0 }}</h2>
                    <p class="lead">ventas realizadas</p>
                    <h3 class="text-success">${{ number_format($ventasHoy->monto ?? 0, 2) }}</h3>
                    <p class="text-muted">Total acumulado</p>
                </div>
            </div>
        </div>

        <!-- Productos con stock bajo -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Productos con Stock Bajo</h5>
                </div>
                <div class="card-body">
                    @if($productosBajoStock->isEmpty())
                    <div class="alert alert-success mb-0">
                        Todo el stock está en orden
                    </div>
                    @else
                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Talle</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productosBajoStock as $productoId => $items)
                                @foreach ($items as $index => $item)
                                <tr>
                                    @if ($index === 0)
                                    <td rowspan="{{ $items->count() }}">
                                        <strong>{{ optional($item->producto)->nombre ?? 'Producto eliminado' }}</strong>
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


        <!-- Últimos clientes -->
        <!-- Últimos clientes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Últimos Clientes Registrados</h5>
                    </div>
                    <div class="card-body">
                        @if($ultimosClientes->isEmpty())
                        <p class="text-muted">No hay clientes registrados recientemente</p>
                        @else
                        <div class="table-responsive">
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