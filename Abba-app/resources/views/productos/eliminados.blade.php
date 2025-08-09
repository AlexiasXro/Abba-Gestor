@extends('layouts.app')

@section('content')

    @if(session('restaurado'))
        <div class="alert alert-success">{{ session('restaurado') }}</div>
    @endif

    <div class="container">
        <h4>Productos Eliminados</h4>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">Volver a Activos</a>

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
                        <th class="text-center fs-6">Factura B<hr class="my-0" style="margin-top:2px; margin-bottom:2px; border-top:1px solid #ccc;">Venta</th>
                        <th class="text-center fs-6">Factura A<hr class="my-0" style="margin-top:2px; margin-bottom:2px; border-top:1px solid #ccc;">Reventa</th>
                        <th>Stock Total</th>

                        @foreach($todosLosTalles as $talle)
                            <th>{{ $talle->talle }}</th>
                        @endforeach

                        <th><i class="bi bi-trash-fill text-danger" title="Eliminado"></i></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($productosEliminados as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>
                                @if($producto->imagen_url)
                                    <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="img" style="width: 45px; height: auto;">
                                @else
                                    <img src="{{ asset('images/placeholder.svg') }}" alt="Sin imagen" style="width: 45px; height: auto;">
                                @endif
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>${{ number_format($producto->precio_base ?? 0, 2) }}</td>
                            <td>${{ number_format($producto->precio_venta ?? 0, 2) }}</td>
                            <td>${{ number_format($producto->precio_reventa ?? 0, 2) }}</td>
                            <td>{{ $producto->talles->sum('pivot.stock') }}</td>

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

                            <td><span class="text-danger">Eliminado</span></td>
                            <td>
                                <form action="{{ route('productos.restaurar', $producto->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Seguro que querés restaurar este producto?')">
                                    @csrf
                                    <button class="btn btn-success btn-sm" title="Restaurar">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 8 + $todosLosTalles->count() }}" class="text-center py-4">
                                <div class="alert alert-info mb-0">
                                    <i class="bi bi-info-circle-fill"></i> No hay productos eliminados para mostrar.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $productosEliminados->links() }}
        </div>
    </div>
@endsection
