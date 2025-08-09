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


    <div class="container ">
        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <h3 class="mb-0">Producto: {{ $producto->nombre }}</h3>

            <div class="d-flex gap-2">
              
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>


        <div class="row">
            <!-- Primera columna: Detalles -->
            <div class="col-md-6 mb-2">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Código</th>
                        <td>{{ $producto->codigo }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $producto->descripcion }}</td>
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

            <!-- Segunda columna: Talles -->
            <div class="col-md-6 mb-2">
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
                                    {{-- Si hay un solo elemento, agregamos dos celdas vacías para completar la fila --}}
                                    <td  class="text-center fw-bold"style="padding: 0.3rem;"></td>
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