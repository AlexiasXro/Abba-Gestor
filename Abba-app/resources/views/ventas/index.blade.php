@extends('layouts.app')

@section('content')
    {{-- resources\views\ventas\index.blade.php --}}

    {{-- HEADER PRINCIPAL --}}
    <x-header-bar title="Ventas" action="index" :buttons="[
            ['text' => '+ Nueva Venta', 'route' => route('ventas.create'), 'class' => 'btn-primary']
        ]" filterName="cliente" filterPlaceholder="Buscar cliente..."
        :filterValue="request('cliente')" filterRoute="{{ route('ventas.index') }}" />

    <div class="container mt-1">

        @include('components.filtros._ventas')

        {{-- Tabla de ventas --}}

        <table class="table table-bordered table-striped table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Producto vendido</th>
                    <th>Total de la venta</th>
                    <th>Estado</th>
                    <th>Método Pago</th>
                    <th>Vendedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</td>

                        {{-- Producto vendido: resumen de ítems con talles --}}
                        <td>
                            @php
                                $cantidadProductos = $venta->detalles->sum('cantidad');
                                $productosConTalles = $venta->detalles->map(function ($detalle) {
                                    $talle = $detalle->talle ? "({$detalle->talle->talle})" : "";
                                    return "{$detalle->producto->nombre} {$talle}";
                                })->unique()->implode(', ');
                            @endphp

                            {{ $cantidadProductos }} ítem{{ $cantidadProductos > 1 ? 's' : '' }}<br>
                            <small class="text-muted">{{ $productosConTalles }}</small>
                        </td>

                        {{-- Total --}}
                        <td>${{ number_format($venta->total, 2, ',', '.') }}</td>

                        {{-- Estado --}}
                        <td>
                            @if($venta->estado === 'pagado')
                                <span class="badge bg-success">Pagado</span>
                            @elseif($venta->estado === 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @else
                                <span class="badge text-danger">_</span>
                            @endif
                        </td>

                        {{-- Método de pago --}}
                        <td>{{ ucfirst($venta->metodo_pago) }}</td>

                        {{-- Vendedor --}}
                        <td>{{ $venta->usuario->nombre ?? '—' }}</td>

                        {{-- Acciones --}}
                        <td>
                            {{-- Ver venta --}}
                            <a href="{{ route('ventas.show', $venta) }}" class="btn btn-info btn-sm" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- Editar venta (opcional)
                            <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            --}}

                            {{-- Anular venta
                            <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Seguro que querés anular esta venta?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Anular">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>--}}

                            {{-- Imprimir ticket en la misma página --}}
                            <button class="btn btn-primary no-print btn-sm" onclick="window.print()">
                                <i class="bi bi-printer"></i> Imprimir Ticket
                            </button>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No se encontraron ventas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        {{-- Paginación --}}
        <div class="d-flex justify-content-center">

        </div>
        <!--  -->
@endsection