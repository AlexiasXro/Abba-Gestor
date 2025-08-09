@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Configuración de Márgenes de Precio</h2>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-gray-700 mb-6">
            Aquí podés definir los márgenes de ganancia que se aplicarán automáticamente
            cuando cargues un nuevo producto. Estos valores se usarán para calcular los
            precios de venta y reventa a partir del precio base.
        </p>

        <form method="POST" action="{{ route('configuracion.margenes.actualizar') }}" class="space-y-4">
            @csrf

            <div>
                <label for="margen_venta" class="block font-medium text-gray-800">Margen de venta (%)</label>
                <input type="number" name="margen_venta" id="margen_venta"
                       value="{{ $margenVenta }}" min="0" max="100" step="0.01"
                       class="w-full border rounded px-3 py-2 mt-1" required>
                <p class="text-sm text-gray-600 mt-1">Este margen se aplicará al <strong>precio base</strong> para calcular el <strong>precio de venta</strong>.</p>
            </div>

            <div>
                <label for="margen_reventa" class="block font-medium text-gray-800">Margen de reventa (%)</label>
                <input type="number" name="margen_reventa" id="margen_reventa"
                       value="{{ $margenReventa }}" min="0" max="100" step="0.01"
                       class="w-full border rounded px-3 py-2 mt-1" required>
                <p class="text-sm text-gray-600 mt-1">Este margen se aplicará al <strong>precio base</strong> para calcular el <strong>precio de reventa</strong>.</p>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Guardar configuración
            </button>
        </form>

        <div class="mt-6 text-sm text-gray-600">
            <p>⚠️ <strong>Importante:</strong> Esta configuración solo afecta a productos nuevos o editados luego de modificar estos valores. No se actualizan los productos ya guardados.</p>
        </div>
    </div>
@endsection
