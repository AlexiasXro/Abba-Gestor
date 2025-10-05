@extends('layouts.app')

@section('title', 'Nueva Categoría')

@section('content')

<x-header-bar
    title="Crear Categoría"
    :buttons="[
        ['text' => '⬅️ Volver al Listado', 'route' => route('categorias.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="row mt-3">
    <!-- Formulario -->
    <div class="col-md-8">
    <div class="card border-primary shadow-sm p-4">
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="usa_talle" class="form-label">¿Usa talle?</label>
                <select name="usa_talle" id="usa_talle" class="form-select" required>
                    <option value="">-- Seleccionar --</option>
                    <option value="1" {{ old('usa_talle') == '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('usa_talle') == '0' ? 'selected' : '' }}>No</option>
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
                        <option value="{{ $tipo }}" {{ old('tipo_talle') == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_talle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">💾 Guardar Categoría</button>
        </form>
    </div>
</div>


<!-- Panel informativo -->
    <div class="col-md-4">
        <div class="card border-secondary shadow-sm p-3">
            <h5 class="text-info fw-bold mb-3">¿Cómo funciona este módulo?</h5>
            <ul class="small text-muted ps-3">
                <li><strong>Nombre:</strong> Es el título general de la categoría. Ej: Ropa, Calzado, Juguetes.</li>
                <li><strong>¿Usa talle?</strong> Marcá “Sí” si los productos de esta categoría se venden por talles (como ropa o calzado).</li>
                <li><strong>Tipo de talle:</strong> Elegí el sistema de talles que se aplica. Esto permite mostrar talles correctos en el módulo de productos.</li>
                <li><strong>Ejemplos:</strong>
                    <ul>
                        <li>Ropa → XS a XXL</li>
                        <li>Calzado → 35 a 45</li>
                        <li>Niño → 2 a 14</li>
                    </ul>
                </li>
                <li>Si la categoría no usa talles (como Bazar o Electrónica), seleccioná “No” y dejá el tipo vacío.</li>
            </ul>
            <div class="alert alert-info mt-3 mb-0">
                Esta configuración impacta directamente en cómo se cargan productos y cómo se gestiona el stock por talle.
            </div>
        </div>
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
        toggleTipoTalle(); // Ejecutar al cargar por si hay old()
    });
</script>

@endsection
