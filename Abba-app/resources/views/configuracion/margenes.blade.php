@extends('layouts.app')

@section('content')
    @php
        // Botón de volver
        $headerButtons = [
            ['text' => '⬅️ Volver', 'route' => route('panel'), 'class' => 'btn-outline-secondary'],
        ];
    @endphp

    <x-header-bar title="Configuración de Márgenes" :buttons="$headerButtons" />

    <div class="container-sm bg-white p-4 rounded shadow-sm">
        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="h4 mb-3">Configuración de Márgenes de Precio</h2>

        <p class="text-muted mb-4">
            Aquí podés definir los márgenes de ganancia que se aplicarán automáticamente
            cuando cargues un nuevo producto. Estos valores se usarán para calcular los
            precios de venta y reventa a partir del precio base.
        </p>

        <form method="POST" action="{{ route('configuracion.margenes.actualizar') }}">
            @csrf

            <div class="mb-3">
                <label for="margen_venta" class="form-label fw-semibold">Margen de venta (%)</label>
                <input type="number" name="margen_venta" id="margen_venta"
                       value="{{ $margenVenta }}" min="0" max="100" step="0.01"
                       class="form-control" required>
                <div class="form-text">
                    Este margen se aplicará al <strong>precio base</strong> para calcular el <strong>precio de venta</strong>.
                </div>
            </div>

            <div class="mb-3">
                <label for="margen_reventa" class="form-label fw-semibold">Margen de reventa (%)</label>
                <input type="number" name="margen_reventa" id="margen_reventa"
                       value="{{ $margenReventa }}" min="0" max="100" step="0.01"
                       class="form-control" required>
                <div class="form-text">
                    Este margen se aplicará al <strong>precio base</strong> para calcular el <strong>precio de reventa</strong>.
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar configuración
            </button>
        </form>

        <div class="alert alert-warning mt-4 small">
            ⚠️ <strong>Importante:</strong> Esta configuración solo afecta a productos nuevos o editados luego de modificar estos valores. 
            No se actualizan los productos ya guardados.
        </div>
    </div>
@endsection
