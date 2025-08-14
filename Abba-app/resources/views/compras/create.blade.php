@extends('layouts.app')

@section('content')
    <div class="container">

       <x-header-filter 
    title="Crear Compra" 
    filterName="filtro" 
    :filterValue="$filtro ?? ''" 
    placeholder="Nombre o código de producto / Nombre de proveedor" 
    :route="route('compras.create')"
/>


        {{-- Formulario principal --}}
        <form method="POST" action="{{ route('compras.store') }}">
            @csrf

            <div class="row mb-3">
                <label class="form-label">Talles a comprar</label>
                @foreach ($talles as $talle)
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            <span class="input-group-text">{{ $talle->talle }}</span>
                            <input type="number" name="talles[{{ $talle->id }}]" class="form-control" min="0"
                                value="{{ old('talles.' . $talle->id, 0) }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label for="metodo_pago">Método de Pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" class="form-control">
            </div>
    </div>

    {{-- Lista productos filtrados --}}
    <h5>Productos</h5>
   @if($productos->count())
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Proveedor</th>
                <th>Precio Venta</th>
                <th>Stock Mínimo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</td>
                    <td>${{ number_format($producto->precio_venta, 2) }}</td>
                    <td>{{ $producto->stock_minimo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productos->withQueryString()->links() }}

@else
    <p>No se encontraron productos con ese filtro.</p>
@endif

@endsection