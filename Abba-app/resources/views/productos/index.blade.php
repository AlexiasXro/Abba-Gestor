@extends('layouts.app')

@section('content')

<!-- alerta-->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!--fin alerta-->

<!--Abba-app\resources\views\productos\index.blade.php-->
<div class="container">
    <h1>Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>
    <a href="{{ route('productos.eliminados') }}" class="btn btn-secondary mb-3">Ver Eliminados</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock Total</th>
                <th>Talles</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>

                    <!-- Stock total sumando todos los talles -->
                    <td>{{ $producto->talles->sum('pivot.stock') }}</td>

                    <!-- Talles con badges -->
                    <td>
                        @forelse($producto->talles as $talle)
                            <span class="badge bg-primary me-1" title="Stock: {{ $talle->pivot->stock }}">
                                {{ $talle->talle }}
                            </span>
                        @empty
                            <span class="text-muted">Sin talles</span>
                        @endforelse
                    </td>

                    <td>{{ $producto->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que querés eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty

            <tr><td colspan="7" class="text-center">No hay productos activos.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
