@extends('layouts.app')

@section('content')

    <!-- alerta-->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!--fin alerta-->

    <!-- Abba-app\resources\views\productos\index.blade.php -->
    <div class="container">
        <h4>Productos</h4>
        <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>
        <a href="{{ route('productos.eliminados') }}" class="btn btn-secondary mb-3">Ver Eliminados</a>

        @php
            $todosLosTalles = \App\Models\Talle::orderBy('talle')->get(); // ordenados por talle
        @endphp

        <table class="table table-bordered table-striped table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock Total</th>

                    {{-- Cabecera dinámica con talles --}}
                    @foreach($todosLosTalles as $talle)
                        <th>{{ $talle->talle }}</th>
                    @endforeach

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
                        <td>{{ $producto->talles->sum('pivot.stock') }}</td>

                        {{-- Mostrar stock por talle --}}
                        @foreach($todosLosTalles as $talle)
                            @php
                                $talleProducto = $producto->talles->firstWhere('id', $talle->id);
                                $stock = $talleProducto ? $talleProducto->pivot->stock : 0;
                            @endphp
                            <td class="text-center">
                                @if($stock > 0)
                                    <span class="text-success fw-bold">{{ $stock }}</span>
                                @else
                                    <span class="text-danger fw-bold">❌</span>
                                @endif
                            </td>
                        @endforeach

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
                    <tr>
                        <td colspan="{{ 7 + $todosLosTalles->count() }}" class="text-center py-4">
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle-fill"></i> {{-- Ícono si usás Bootstrap Icons --}}
                                No hay productos activos para mostrar.
                            </div>
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    <!-- Paginación productos-->
        <div class="">
            

            {{ $productos->links() }}
        </div>

    </div>
@endsection