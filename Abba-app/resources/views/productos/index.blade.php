@extends('layouts.app')

@section('content')
{{-- resources/views/productos/index.blade.php --}}

@php
// Botones del header separados para que Blade los maneje mejor
$headerButtons = [
    ['text' => 'Nuevo Producto', 'route' => route('productos.create'), 'class' => 'btn-primary'],
    ['text' => 'Ver Eliminados', 'route' => route('productos.eliminados'), 'class' => 'btn-secondary'],
];

// Todos los talles disponibles
$todosLosTalles = \App\Models\Talle::orderBy('talle')->get();
@endphp

<x-header-bar 
    title="Productos" 
    :buttons="$headerButtons" 
    filterName="filtro" 
    :filterValue="$filtro ?? ''" 
    filterPlaceholder="Buscar por nombre, código o proveedor" 
    :filterRoute="route('productos.index')" 
/>

<div class="container mt-3">
    {{-- Filtros profesionales --}}
    @include('components.filtros._productos')

    {{-- Tabla de productos --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Código</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Precio costo</th>
                    <th class="small">Factura B
                        <hr class="my-0">Venta
                    </th>
                    <th class="small">Factura A
                        <hr class="my-0">Reventa
                    </th>
                    <th>Stock Total</th>
                    <th>Talles (Stock)</th>
                    <th><i class="bi bi-hand-thumbs-up-fill text-success" title="Activo"></i></th>
                    <th>Acciones
                        <a href="{{ route('productos.qr') }}" class="btn btn-primary ms-2">Ver QRs</a>
                    </th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($productos as $producto)
                <tr>
                    {{-- Código y QR --}}
                    <td class="text-center align-middle">
                        <div id="qrcode-index{{ $producto->codigo }}">
                            <p class="mb-0 text-muted small">{{ $producto->codigo }}</p>
                        </div>
                    </td>

                    {{-- Imagen --}}
                    <td class="text-center align-middle">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" width="80" height="80" style="object-fit: cover; border-radius: 4px;">
                        @else
                            <img src="{{ asset('images/placeholder.svg') }}" alt="Sin imagen" width="80" height="80" style="object-fit: cover; border-radius: 4px;">
                        @endif
                    </td>

                    {{-- Datos --}}
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>${{ number_format($producto->precio_base ?? 0, 2) }}</td>
                    <td>${{ number_format($producto->precio_venta ?? 0, 2) }}</td>
                    <td>${{ number_format($producto->precio_reventa ?? 0, 2) }}</td>

                    {{-- Stock --}}
                    <td>{{ $producto->talles->sum('pivot.stock') }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            @foreach($todosLosTalles as $talle)
                                @php
                                    $talleProducto = $producto->talles->firstWhere('id', $talle->id);
                                    $stock = $talleProducto ? $talleProducto->pivot->stock : 0;
                                    $color = ($stock > 0 && $stock <= 1) ? 'text-danger' : 'text-black';
                                @endphp
                                @if($stock > 0)
                                    <span class="{{ $color }}" style="font-size: 0.85rem;">
                                        <strong style="margin-right: 2px;">{{ $talle->talle }}</strong>({{ $stock }})
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </td>

                    {{-- Activo --}}
                    <td>{{ $producto->activo ? 'Sí' : 'No' }}</td>

                    {{-- Acciones --}}
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="url: {{ route('productos.show', $p->codigo) }}" class="btn btn-info btn-sm" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que querés eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">No hay productos</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-2">
        {{ $productos->links() }}
    </div>
</div>

{{-- Librerías y QR JS --}}
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
    window.productosQR = [
        @foreach($productos as $p)
            {
                codigo: "{{ $p->codigo }}",
                url: "{{ route('productos.show', $p->id) }}",
                containerId: "qrcode-index{{ $p->codigo }}"
            }@if(!$loop->last),@endif
        @endforeach
    ];
</script>


<script src="{{ asset('js/qrcode-productos.js') }}"></script>

@endsection
