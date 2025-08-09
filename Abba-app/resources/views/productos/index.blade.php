@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container">
        <h4>Productos</h4>
        <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>
        <a href="{{ route('productos.eliminados') }}" class="btn btn-secondary mb-3">Ver Eliminados</a>

        @php
            $todosLosTalles = \App\Models\Talle::orderBy('talle')->get();
        @endphp
        <div class="table-responsive">


            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Código</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Precio costo</th>
                        <th class="small">Factura B<hr class="my-0">Venta</th>
                        <th class="small"> Factura A<hr class="my-0">Reventa</th>
                        <th>Stock Total</th>

                        {{-- Talles --}}
                        @foreach($todosLosTalles as $talle)
                            <th>{{ $talle->talle }}</th>
                        @endforeach

                        <th><i class="bi bi-hand-thumbs-up-fill text-success" title="Activo"></i></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    {{-- Verifica si hay productos --}}
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>

                            <td>
                                {{-- Verifica si el producto tiene una URL de imagen cargada en la base de datos --}}
                                @if($producto->imagen_url)
                                    {{-- Si tiene, se muestra esa imagen desde el almacenamiento local de Laravel --}}
                                    <img src="{{ asset('storage/' . $producto->imagen_url) }}" {{-- Genera la URL completa hacia la
                                        imagen cargada --}} alt="img" style="width: 45px; height: auto;">
                                @else
                                    {{-- Si no hay imagen cargada, se muestra una imagen por defecto (placeholder) --}}
                                    <img src="{{ asset('images/placeholder.svg') }}" alt="Sin imagen"
                                        style="width: 45px; height: auto;">
                                @endif
                            </td>


                            <td>{{ $producto->nombre }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>${{ number_format($producto->precio_base ?? 0, 2) }}</td>
                            <td>${{ number_format($producto->precio_venta ?? 0, 2) }}</td>
                            <td>${{ number_format($producto->precio_reventa ?? 0, 2) }}</td>
                            <td>{{ $producto->talles->sum('pivot.stock') }}</td>

                            {{-- Stock por talle --}}
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
                                <a href="{{ route('productos.show', $producto) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm"
                                    title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Seguro que querés eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 8 + $todosLosTalles->count() }}" class="text-center py-4">
                                <div class="alert alert-info mb-0">
                                    <i class="bi bi-info-circle-fill"></i> No hay productos activos para mostrar.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="">
            {{ $productos->links() }}
        </div>
    </div>
@endsection