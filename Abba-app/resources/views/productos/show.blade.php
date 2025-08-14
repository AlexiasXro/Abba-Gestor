@extends('layouts.app')

@section('content')
    <!--Abba-app\resources\views\productos\show.blade.php  Detalle de producto-->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <x-header-bar title="Producto: {{ $producto->nombre }}" :buttons="[
            ['route' => route('productos.edit', $producto), 'text' => 'Editar', 'class' => 'btn-warning'],
            ['route' => route('productos.index'), 'text' => 'Volver', 'class' => 'btn-secondary']
        ]" />

<div class="container mt-3">

    <div class="row">

        <!-- Primera columna: Detalles -->
        <div class="col-md-6 mb-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Miniatura</th>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen {{ $producto->nombre }}" class="img-thumbnail" style="max-width: 100px;">
                            @else
                                <em>No disponible</em>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Código</th>
                        <td>{{ $producto->codigo }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $producto->descripcion }}</td>
                    </tr>
                    <tr>
                        <th>Proveedor</th>
                        <td>
                            @if($producto->proveedor)
                                {{ $producto->proveedor->nombre }}
                            @else
                                <em>No asignado</em>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Precio</th>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Precio base</th>
                        <td>${{ number_format($producto->precio_base, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Precio venta</th>
                        <td>${{ number_format($producto->precio_venta, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Precio reventa</th>
                        <td>${{ number_format($producto->precio_reventa, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Stock total</th>
                        <td>{{ $producto->talles->sum('pivot.stock') }}</td>
                    </tr>
                    <tr>
                        <th>Activo</th>
                        <td>{{ $producto->activo ? 'Sí' : 'No' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Segunda columna: Talles -->
        <div class="col-md-6 mb-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
                    <thead>
                        <tr>
                            <th class="text-center fw-bold" style="padding: 0.3rem;">Talle</th>
                            <th class="text-center" style="padding: 0.3rem;">Stock</th>
                            <th class="text-center fw-bold" style="padding: 0.3rem;">Talle</th>
                            <th class="text-center" style="padding: 0.3rem;">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($producto->talles->chunk(2) as $chunk)
                            <tr>
                                @foreach ($chunk as $talle)
                                    <td class="text-center fw-bold" style="padding: 0.3rem;">{{ $talle->talle }}</td>
                                    <td class="text-center" style="padding: 0.3rem;">{{ $talle->pivot->stock }}</td>
                                @endforeach
                                @if ($chunk->count() < 2)
                                    <td class="text-center fw-bold" style="padding: 0.3rem;"></td>
                                    <td class="text-center" style="padding: 0.3rem;"></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection