@extends('layouts.app')

@section('title', 'Detalle de proveedor')

@section('content')
 <div class="container mt-3">

    <x-header-bar title="Detalle de Proveedor" :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('proveedores.index'), 'class' => 'btn-secondary'],
        ['text' => 'Editar Proveedor', 'route' => route('proveedores.edit', $proveedor), 'class' => 'btn-warning']
    ]" />

    <div class="container mt-3">
        <div class="row">
            <!-- Detalle del Proveedor -->
            <div class="col-md-8">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title mb-3">📋 Detalle del Proveedor</h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $proveedor->nombre }}</li>
                        <li class="list-group-item"><strong>CUIT:</strong> {{ $proveedor->cuit }}</li>
                        <li class="list-group-item"><strong>Teléfono:</strong> {{ $proveedor->telefono }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $proveedor->email }}</li>
                        <li class="list-group-item"><strong>Observación:</strong> {{ $proveedor->observacion }}</li>
                    </ul>
                </div>
            </div>

            <!-- Panel lateral opcional -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h6 class="card-title">📦 Información adicional</h6>
                    <p class="card-text">Aquí podrías incluir estadísticas, historial de compras, o enlaces a productos relacionados.</p>
                </div>
            </div>
        </div>
    </div>

@endsection
