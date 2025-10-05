@extends('layouts.app')

@section('title', 'Detalle de Talle')

@section('content')

    <x-header-bar title="Detalle de Talle" :buttons="[
            ['text' => 'Volver al Listado', 'route' => route('talles.index'), 'class' => 'btn-secondary']
        ]" />

    <div class="container mt-3">
        <div class="row">
            <!-- Detalle del Talle  C:\Users\Romin\Documents\Proyecto-CODE\Abba\Abba-app\resources\views\talles\show.blade.php-->
            <div class="col-md-8">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title mb-3">📏 Detalle del Talle</h5>

                    <p><strong>ID:</strong> {{ $talle->id }}</p>
                    <p><strong>Talle:</strong> {{ $talle->talle }}</p>
                    <p><strong>Tipo:</strong>
                        @if($talle->tipo === 'calzado')
                            <span class="badge bg-primary">Calzado</span>
                        @elseif($talle->tipo === 'ropa')
                            <span class="badge bg-success">Ropa</span>
                        @elseif($talle->tipo === 'niño')
                            <span class="badge bg-info text-dark">Niño</span>
                        @elseif($talle->tipo === 'unico')
                            <span class="badge bg-warning text-dark">Único</span>
                        @elseif($talle->tipo === 'adulto')
                            <span class="badge bg-dark">Adulto</span>
                        @elseif($talle->tipo === 'juvenil')
                            <span class="badge bg-secondary">Juvenil</span>
                        @elseif($talle->tipo === 'bebé')
                            <span class="badge bg-light text-dark">Bebé</span>
                        @else
                            <span class="badge bg-secondary">Desconocido</span>
                        @endif
                    </p>

                    @php
                        $categorias = \App\Models\Categoria::where('tipo_talle', $talle->tipo)->pluck('nombre')->toArray();
                    @endphp

                    @if($categorias)
                        <p><strong>Usado en categorías:</strong> {{ implode(', ', $categorias) }}</p>
                    @endif



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
                    <p class="card-text mb-1">- El campo "Tipo" clasifica el talle según el producto: Calzado, Ropa, Niño,
                        Único, Adulto, Juvenil, Bebé, entre otros.</p>

                    <p class="card-text mb-0">- Útil para controlar stock y asignar talles a productos correctamente.</p>
                </div>
            </div>
        </div>
    </div>
@endsection