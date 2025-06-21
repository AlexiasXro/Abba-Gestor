@extends('layouts.app')

@section('content')
<!--Abba-app\resources\views\productos\show.blade.php  Detalle de producto-->
<div class="container">
    <h1>Producto: {{ $producto->nombre }}</h1>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">Volver</a>

    <table class="table table-bordered">
        <tr><th>Código</th><td>{{ $producto->codigo }}</td></tr>
        <tr><th>Descripción</th><td>{{ $producto->descripcion }}</td></tr>
        <tr><th>Precio</th><td>${{ number_format($producto->precio, 2) }}</td></tr>
        <tr><th>Stock mínimo</th><td>{{ $producto->stock_minimo }}</td></tr>
        <tr><th>Activo</th><td>{{ $producto->activo ? 'Sí' : 'No' }}</td></tr>
    </table>

    <h4>Talles y Stock</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Talle</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($producto->talles as $talle)
                <tr>
                    <td>{{ $talle->talle }}</td>
                    <td>{{ $talle->pivot->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
</div>
@endsection
