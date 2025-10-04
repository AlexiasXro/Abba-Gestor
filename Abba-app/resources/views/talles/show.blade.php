@extends('layouts.app')

@section('title', 'Detalle de Talle')

@section('content')

<x-header-bar
    title="Detalle de Talle"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('talles.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="row">
        <!-- Detalle del Talle -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="card-title mb-3">📏 Detalle del Talle</h5>

                <p><strong>ID:</strong> {{ $talle->id }}</p>
                <p><strong>Talle:</strong> {{ $talle->talle }}</p>
                <p><strong>Tipo:</strong> {{ ucfirst($talle->tipo) }}</p>

                <div class="mt-3">
                    <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
                    <a href="{{ route('talles.edit', $talle) }}" class="btn btn-warning">✏️ Editar</a>
                </div>
            </div>
        </div>

        <!-- Contenedor informativo -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm p-3">
                <h6 class="card-title text-info">Información del Módulo</h6>
                <p class="card-text mb-1">- Aquí puedes ver los detalles de un talle específico.</p>
                <p class="card-text mb-1">- El campo "Tipo" ayuda a clasificar productos: Calzado, Ropa, Niño o Único.</p>
                <p class="card-text mb-0">- Útil para controlar stock y asignar talles a productos correctamente.</p>
            </div>
        </div>
    </div>
</div>
@endsection
