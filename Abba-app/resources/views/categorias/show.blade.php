@extends('layouts.app')

@section('title', 'Detalle de Categoría')

@section('content')

<x-header-bar
    title="Detalle de Categoría"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('categorias.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="row">
        <!-- Detalle principal -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="card-title mb-3">📂 Detalle de Categoría</h5>

                <p><strong>ID:</strong> {{ $categoria->id }}</p>
                <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
                <p><strong>¿Usa talle?:</strong>
                    @if($categoria->usa_talle)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </p>
                <p><strong>Tipo de talle:</strong> {{ $categoria->tipo_talle ?? '—' }}</p>

                @if($categoria->usa_talle && $categoria->tipo_talle)
                    @php
                        $talles = \App\Models\Talle::where('tipo', $categoria->tipo_talle)->pluck('talle')->toArray();
                    @endphp
                    <p><strong>Talles disponibles:</strong> {{ implode(', ', $talles) }}</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">⬅️ Volver</a>
                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">✏️ Editar</a>
                </div>
            </div>
        </div>

        <!-- Información del módulo -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm p-3">
                <h6 class="card-title text-info">Información del Módulo</h6>
                <p class="card-text mb-1">- Aquí puedes ver los detalles de una categoría específica.</p>
                <p class="card-text mb-1">- Si la categoría usa talles, se muestra el tipo y los talles disponibles.</p>
                <p class="card-text mb-0">- Útil para organizar productos y controlar el inventario por tipo.</p>
            </div>
        </div>
    </div>
</div>

@endsection
