@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')

<x-header-bar
    title="Editar Categoría"
    :buttons="[
        ['text' => '⬅️ Volver al Listado', 'route' => route('categorias.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="card shadow-sm p-4">
        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre', $categoria->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="usa_talle" class="form-label">¿Usa talle?</label>
                <select name="usa_talle" id="usa_talle" class="form-select" required>
                    <option value="">-- Seleccionar --</option>
                    <option value="1" {{ old('usa_talle', $categoria->usa_talle) == '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('usa_talle', $categoria->usa_talle) == '0' ? 'selected' : '' }}>No</option>
                </select>
                @error('usa_talle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="tipoTalleContainer" style="display: none;">
                <label for="tipo_talle" class="form-label">Tipo de talle</label>
                <select name="tipo_talle" id="tipo_talle" class="form-select">
                    <option value="">-- Seleccionar tipo --</option>
                    @foreach(['calzado', 'ropa', 'niño', 'unico', 'adulto', 'juvenil', 'bebé'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_talle', $categoria->tipo_talle) == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_talle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">💾 Actualizar Categoría</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usaTalle = document.getElementById('usa_talle');
        const tipoTalleContainer = document.getElementById('tipoTalleContainer');

        function toggleTipoTalle() {
            tipoTalleContainer.style.display = usaTalle.value === '1' ? 'block' : 'none';
        }

        usaTalle.addEventListener('change', toggleTipoTalle);
        toggleTipoTalle(); // Ejecutar al cargar por si hay old() o datos precargados
    });
</script>

@endsection
