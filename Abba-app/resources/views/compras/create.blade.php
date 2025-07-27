@extends('layouts.app')

@section('content')
    <h1>Registrar Compra</h1>

    <form method="POST" action="{{ route('compras.store') }}">
        @csrf

        <div class="mb-3">
            <label>Proveedor</label>
            <select name="proveedor_id" class="form-control" required>
                <option value="">-- Seleccionar proveedor --</option>
                @foreach ($proveedores as $prov)
                    <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                @endforeach
            </select>

        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label>Método de Pago</label>
            <input type="text" name="metodo_pago" class="form-control">
        </div>

        <div id="detalles-container">
            <h5>Detalles</h5>
            <div class="detalle row mb-2">
                <div class="col-md-4">
                    <select name="producto_id[]" class="form-control">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="detalles[0][talle_id]" class="form-control" required>
                        <option value="">Talle</option> {{-- Esta es la opción por defecto --}}
                        @foreach($talles as $talle)
                            <option value="{{ $talle->id }}">{{ $talle->talle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="detalles[0][cantidad]" class="form-control" min="1" placeholder="Cant."
                        required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="detalles[0][precio_unitario]" class="form-control" step="0.01" min="0"
                        placeholder="Precio $" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Compra</button>
    </form>
@endsection