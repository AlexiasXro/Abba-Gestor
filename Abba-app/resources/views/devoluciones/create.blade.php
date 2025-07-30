@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Registrar Devolución</h4>

        {{-- Mensajes de éxito y errores --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('devoluciones.store') }}" method="POST">
            @csrf

            {{-- Venta --}}
            <div class="mb-3">
                <label for="venta_id" class="form-label">Venta</label>
                <select name="venta_id" id="venta_id" class="form-select" required>
                    <option value="">Seleccionar venta</option>
                    @foreach($ventas as $v)
                        <option value="{{ $v->id }}" {{ old('venta_id', request('venta_id')) == $v->id ? 'selected' : '' }}>
                            #{{ $v->id }} - {{ $v->cliente->nombre ?? 'Sin cliente' }}
                            ({{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Producto (solo lectura si viene por URL) --}}
            @if($producto)
                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <input type="text" class="form-control" value="{{ $producto->nombre }}" readonly>
                    <input type="hidden" name="producto_id" value="{{ old('producto_id', $producto->id) }}">
                </div>
            @else
                {{-- Si querés permitir selección manual si no vino por URL --}}
                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <input type="number" name="producto_id" id="producto_id" class="form-control"
                        value="{{ old('producto_id') }}" required>
                </div>
            @endif
   
            {{-- Talle (solo lectura si viene por URL) --}}
            @if($talle)
                <div class="mb-3">
                    <label class="form-label">Talle</label>
                    <input type="text" class="form-control" value="Talle {{ $talle->numero }}" readonly>
                    <input type="hidden" name="talle_id" value="{{ old('talle_id', $talle->id) }}">
                </div>
            @else
                {{-- Si querés permitir selección manual si no vino por URL --}}
                <div class="mb-3">
                    <label for="talle_id" class="form-label">Talle</label>
                    <input type="number" name="talle_id" id="talle_id" class="form-control" value="{{ old('talle_id') }}"
                        required>
                </div>
            @endif

            {{-- Tipo --}}
            <div class="mb-3">
                <label class="form-label">Tipo de devolución</label>
                <select name="tipo" class="form-select" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="devolucion" {{ old('tipo') == 'devolucion' ? 'selected' : '' }}>Devolución</option>
                    <option value="garantia" {{ old('tipo') == 'garantia' ? 'selected' : '' }}>Garantía</option>
                </select>
            </div>

            {{-- Cantidad --}}
            <div class="mb-3">
                <label class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad') }}" min="1" required>
            </div>
            {{-- Motivo --}}
            <div class="mb-3">
                <label class="form-label">Motivo</label>
                <input type="text" name="motivo_texto" class="form-control" value="{{ old('motivo_texto') }}" required>
            </div>
            {{-- Observaciones (opcional) --}}
            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
            </div>

            {{-- Botón --}}
            <button type="submit" class="btn btn-primary">Registrar devolución</button>
        </form>
    </div>
@endsection