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


    <x-header-bar title="Crear Productos" :buttons="[
            ['route' => route('productos.index'), 'text' => 'Volver', 'class' => 'btn-secondary']
        ]" />

    <div class="container mt-2">

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
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

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            @if(isset($producto) && $producto->imagen)
                                <!-- Imagen existente (edit) -->
                                <img id="preview" src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa"
                                    style="max-width: 200px; max-height: 200px; display: block;">
                            @else
                                <!-- Preview vacío (create) -->
                                <img id="preview" src="#" alt="Vista previa"
                                    style="max-width: 200px; max-height: 200px; display: none;">
                            @endif
                        </div>

                        <script>
                            const inputImagen = document.getElementById('imagen');
                            const preview = document.getElementById('preview');

                            inputImagen.addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                if (!file) return;

                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                }
                                reader.readAsDataURL(file);
                            });
                        </script>


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
                            <label for="proveedor_nombre" class="form-label">Proveedor (opcional)</label>
                            <input list="proveedores-list" id="proveedor_nombre" name="proveedor_nombre"
                                class="form-control" autocomplete="off" value="{{ old('proveedor_nombre') }}"
                                placeholder="Escriba para buscar proveedor" />
                            <datalist id="proveedores-list">
                                @foreach ($proveedores as $prov)
                                    <option data-id="{{ $prov->id }}" value="{{ $prov->nombre }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="proveedor_id" id="proveedor_id" value="{{ old('proveedor_id') }}">
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const inputNombre = document.getElementById('proveedor_nombre');
                                const inputId = document.getElementById('proveedor_id');
                                const dataList = document.getElementById('proveedores-list');

                                // Cuando el usuario cambie el texto
                                inputNombre.addEventListener('input', () => {
                                    const val = inputNombre.value;
                                    // Buscar en options del datalist el que coincida exactamente
                                    const option = Array.from(dataList.options).find(opt => opt.value === val);
                                    if (option) {
                                        // Si coincide, setear el id oculto
                                        inputId.value = option.getAttribute('data-id');
                                    } else {
                                        // Si no coincide, limpiar el id oculto
                                        inputId.value = '';
                                    }
                                });
                            });
                        </script>

                        <div class="col-md-6">
                            <label for="precio_base" class="form-label fw-bold text-primary">
                                ⭐ Precio base (costo) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="precio_base" id="precio_base"
                                class="form-control border border-2 border-primary shadow-sm"
                                value="{{ old('precio_base', $producto->precio_base ?? '') }}" required autofocus>
                            <small class="text-muted">Complete este campo primero: a partir de aquí se calculan los demás
                                precios.</small>
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

                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio (alias)</label>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control"
                                value="{{ old('precio', $producto->precio ?? '') }}" readonly
                                placeholder="Se calcula a partir del precio base">
                            <small class="text-muted">⚠️ Este campo es solo informativo. Ingrese el valor en <strong>Precio
                                    base</strong>.</small>
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
    </div>

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


