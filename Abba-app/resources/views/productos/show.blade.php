@extends('layouts.app')

@section('content')
    <!--Abba-app\resources\views\productos\show.blade.php  Detalle de producto-->


    <x-header-bar title="Producto: {{ $producto->nombre }}" :buttons="[
            ['route' => route('productos.edit', $producto), 'text' => 'Editar', 'class' => 'btn-warning'],
            ['route' => route('productos.index'), 'text' => 'Listado', 'class' => 'btn-secondary']
        ]" />

    <div class="container mt-4">
        {{-- ALERTA --}}
        @if(session('status'))
            <x-alert type="{{ session('status_type') ?? 'info' }}" message="{{ session('status') }}" />
        @endif
        <div class="row g-3">
            <!-- Imagen del producto -->
            <div class="col-lg-4 col-md-12 text-center">
                <div class="card shadow-sm border-1 rounded-2 p-2 h-100">
                    <label class="form-label fw-bold">Imagen del producto</label>
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                            class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/placeholder.svg') }}" alt="Sin imagen" class="img-fluid rounded"
                            style="max-height: 200px; object-fit: cover;">
                    @endif
                    <td class="text-center align-middle">
                        <div id="qrcode-show {{ $producto->codigo }}" class="mt-2"></div>
                    </td>
                </div>



            </div>

            <!-- Detalles principales -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-1 rounded-2 p-2 h-100">
                    <h5 class="fw-bold mb-3 text-center">Detalles del producto</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <tbody>
                                <tr>
                                    <th>Código</th>

                                    <td>
                                        <div id="qrcode-show {{ $producto->codigo }}">
                                            <p class="mb-0 text-muted small">{{ $producto->codigo }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Descripción</th>
                                    <td>{{ $producto->descripcion ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Categoría</th>
                                    <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                                </tr>



                                <tr>
                                    <th>Proveedor</th>
                                    <td>{{ $producto->proveedor->nombre ?? 'No asignado' }}</td>
                                </tr>
                                <tr>
                                    <th>Precio</th>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                </tr>

                                <tr>

                                    <th>Stock total</th>
                                    <td>{{ $producto->talles->sum('pivot.stock') }}</td>
                                </tr>
                                <tr>
                                    <th>Activo</th>
                                    <td>{{ $producto->activo ? 'Sí' : 'No' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Talles y stock -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-1 rounded-2 p-2 h-100">
                    <h5 class="fw-bold mb-3 text-center">Talles y Stock</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center mb-0"
                            style="font-size: 0.85rem;">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 60px;">Talle</th>
                                    <th style="width: 60px;">Stock</th>
                                    <th style="width: 60px;">Talle</th>
                                    <th style="width: 60px;">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producto->talles->chunk(2) as $chunk)
                                    <tr>
                                        @foreach ($chunk as $talle)
                                            <td class="fw-bold p-1">{{ $talle->talle }}</td>
                                            <td class="p-1">{{ $talle->pivot->stock }}</td>
                                        @endforeach
                                        @if ($chunk->count() < 2)
                                            <td class="p-1"></td>
                                            <td class="p-1"></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



@endsection