@extends('layouts.app')

@section('content')
    <!--Abba-app\resources\views\productos\create.blade.php-->

    <!--alerta-->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--fin alerta-->

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Nuevo Producto</h4>
            <!--boton de volver-->
            <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">Volver</a>
        </div>



        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion"
                                class="form-control">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control"
                                value="{{ old('precio') }}" required>
                        </div>

                        <!-- Campos de precios adicionales -->
                        <div class="col-md-6">
                            <label for="precio_base" class="form-label">Precio base (costo)</label>
                            <input type="number" step="0.01" name="precio_base" id="precio_base" class="form-control"
                                value="{{ old('precio_base', $producto->precio_base ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="precio_venta" class="form-label">Precio venta (final)</label>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
                                value="{{ old('precio_venta', $producto->precio_venta ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="precio_reventa" class="form-label">Precio reventa (mayorista)</label>
                            <input type="number" step="0.01" name="precio_reventa" id="precio_reventa" class="form-control"
                                value="{{ old('precio_reventa', $producto->precio_reventa ?? '') }}">
                        </div>
                        <!-- Fin de campos de precios adicionales -->

                        <div class="col-md-6">
                            <label for="stock_minimo" class="form-label">Stock mínimo</label>
                            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
                                value="{{ old('stock_minimo', 3) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="activo" class="form-label">Activo<i class="bi bi-hand-thumbs-up-fill text-success"
                                    title="Activo"></i></label>
                            <select name="activo" id="activo" class="form-select" required>
                                <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 w-25">

                    <h4>Talles y Stock</h4>
                    <table class="table table-bordered table-sm" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th>Talle</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($talles as $talle)
                                <tr>
                                    <td>
                                        {{ $talle->talle }}
                                        <input type="hidden" name="talles[{{ $loop->index }}][id]" value="{{ $talle->id }}">
                                    </td>
                                    <td>
                                        <input type="number" name="talles[{{ $loop->index }}][stock]"
                                            class="form-control form-control-sm text-center" min="0" value="0">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Crear Producto</button>
        </form>
 

    <script>
        // Script para calcular precios automáticamente
        document.addEventListener('DOMContentLoaded', function () {
            const inputBase = document.getElementById('precio_base');
            const inputVenta = document.getElementById('precio_venta');
            const inputReventa = document.getElementById('precio_reventa');

            inputBase.addEventListener('input', () => {
                const base = parseFloat(inputBase.value);
                if (!isNaN(base)) {
                    inputVenta.value = (base * 1.30).toFixed(2);
                    inputReventa.value = (base * 1.15).toFixed(2);
                } else {
                    inputVenta.value = '';
                    inputReventa.value = '';
                }
            });
        });
    </script>
@endsection