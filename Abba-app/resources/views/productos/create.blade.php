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

                                        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="">
                                            @csrf
                                            <div class="row">
                                                <!-- Columna izquierda -->
                                                <div class="col-md-8 card shadow-sm rounded mb-3">

                                                    <div class="row my-2 ">
                                                        <div class="col-md-4 p-2">
                                                            <label for="codigo" class="form-label">Código<span class="text-danger">*</span></label>
                                                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4 p-2">
                                                            <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                                                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                                        </div>

                                                        <div class="col-md-4 p-2">
                                                            <label for="precio_base" class="form-label fw-bold">
                                                                Precio costo <span class="text-danger">*</span>
                                                                <i class="bi bi-info-circle-fill text-secondary ms-1" data-bs-toggle="tooltip"
                                                                    title="Complete este campo primero: a partir de aquí se calculan los demás precios."></i>
                                                            </label>
                                                            <input type="number" step="0.01" name="precio_base" id="precio_base"
                                                                class="form-control border border-2 border-primary shadow-sm"
                                                                value="{{ old('precio_base', $producto->precio_base ?? '') }}" required autofocus>

                                                        </div>


                        <div class="col-md-4 p-2">
                            <label for="proveedor_nombre" class="form-label">Proveedor (opcional)</label>
                            <input list="proveedores-list" id="proveedor_nombre" name="proveedor_nombre" class="form-control" autocomplete="off"
                                value="{{ old('proveedor_nombre') }}" placeholder="Escriba para buscar proveedor" />
                            <datalist id="proveedores-list">
                                @foreach ($proveedores as $prov)
                                    <option data-id="{{ $prov->id }}" value="{{ $prov->nombre }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="proveedor_id" id="proveedor_id" value="{{ old('proveedor_id') }}">
                        </div>

                        <div class="col-md-4 p-2">
                            <label for="precio_venta" class="form-label">Precio venta (final)</label>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
                                value="{{ old('precio_venta', $producto->precio_venta ?? '') }}">
                        </div>



                        <div class="col-md-4 p-2">
                            <label for="precio_reventa" class="form-label">Precio reventa (mayorista)</label>
                            <input type="number" step="0.01" name="precio_reventa" id="precio_reventa" class="form-control"
                                value="{{ old('precio_reventa', $producto->precio_reventa ?? '') }}">
                        </div>


                        <div class="col-md-4 p-2">
                            <label for="categoria_id" class="form-label">
                                Categoría <span class="text-danger">*</span>
                                <i class="bi bi-info-circle-fill text-alert ms-1" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Algunas categorías requieren talles. Se mostrarán automáticamente si aplican."></i>
                            </label>
                            <select name="categoria_id" id="categoria_id" class="form-select" required>
                                <option value="">-- Seleccionar categoría --</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" data-usa-talle="{{ $categoria->usa_talle }}"
                                        data-tipo-talle="{{ $categoria->tipo_talle }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



            <div class="col-md-4 p-2">
                <label for="stock_minimo" class="form-label">Stock mínimo<span class="text-danger">*</span></label>
                <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="{{ old('stock_minimo', 3) }}"
                    required>
                <small class="text-muted" style="font-size: 0.75rem">Se usa para alertas de reposición.</small>

            </div>

            <div class="col-md-4 p-2">
                <label for="activo" class="form-label">Activo<i class="bi bi-hand-thumbs-up-fill text-success"
                        title="Activo"></i></label>
                <select name="activo" id="activo" class="form-select" required>
                    <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>No</option>
                </select>
                <small class="text-muted" style="font-size: 0.75rem">Marcá "No" si no se vende más.</small>
            </div>
        <div class="col-md-4 p-2">
            <label for="descripcion" class="form-label">
                Descripción
                <i class="bi bi-info-circle-fill text-secondary ms-1" data-bs-toggle="tooltip"
                    title="Máximo 300 caracteres. Evitá saltos de línea innecesarios."></i>
            </label>
            <textarea name="descripcion" id="descripcion" class="form-control form-control-sm" maxlength="300" rows="3"
                style="resize: none;" placeholder="Breve descripción del producto...">{{ old('descripcion') }}</textarea>
        </div>

        <div class="col-md-4 p-2">
            <div class="border rounded shadow-sm p-2 text-center" style="max-width: 220px; height: 200px; margin: 0 auto;">
                @if(isset($producto) && $producto->imagen)
                    <!-- Imagen existente (edit) -->
                    <img id="preview" src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="img-fluid h-100"
                        style="object-fit: contain;">
                @else
                    <!-- Placeholder visual (create) -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                        <i class="bi bi-image" style="font-size: 2rem;"></i>

                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4 p-2">
            <label for="imagen" class="form-label">Imagen del producto</label>
            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
        </div>



        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear Producto
            </button>
        </div>

        </div>
        </div>


                                                        <!-- Columna derecha -->
                                                        <div class="col-md-4 d-flex justify-content-start ">

                                                            <div style="max-width: 180px; width: 100%;">
                                                                <div id="tablaTallesContainer" class="border border-primary rounded shadow-sm p-3 bg-light mb-3" style="display: none;">

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered  table-sm rounded" style="font-size: 0.9rem;">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th class="text-center" style="width: 60px;">Talle</th>
                                                                                    <th class="text-center" style="width: 90px;">Stock</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($talles as $talle)
                                                                                    <tr>
                                                                                        <td class="text-center">
                                                                                            {{ $talle->talle }}
                                                                                            <input type="hidden" name="talles[{{ $loop->index }}][id]" value="{{ $talle->id }}">
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            <div class="input-group input-group-sm" style="max-width: 90px; margin: 0 auto;">
                                                                                                <input type="number" name="talles[{{ $loop->index }}][stock]"
                                                                                                    class="form-control form-control-sm text-center stock-input" min="0" value="0"
                                                                                                    style="padding: 0.25rem;">
                                                                                                <button type="button" class="btn btn-outline-secondary increment"
                                                                                                    style="padding: 0.25rem 0.4rem;">+</button>
                                                                                                <button type="button" class="btn btn-outline-secondary decrement"
                                                                                                    style="padding: 0.25rem 0.4rem;">-</button>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        </form>
                                                        </div>
                 </div>



                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                    const categoriaSelect = document.getElementById('categoria_id');
                                    const tablaTallesContainer = document.getElementById('tablaTallesContainer');
                                    const tablaBody = tablaTallesContainer.querySelector('tbody');

                                    categoriaSelect.addEventListener('change', function () {
                                        const selected = categoriaSelect.options[categoriaSelect.selectedIndex];
                                        const usaTalle = selected.getAttribute('data-usa-talle') === '1';
                                        const tipoTalle = selected.getAttribute('data-tipo-talle');

                                        if (usaTalle && tipoTalle) {
                                            tablaTallesContainer.style.display = 'block';

                                            fetch(`/api/talles?tipo=${tipoTalle}`)
                                                .then(res => res.json())
                                                .then(talles => {
                                                    tablaBody.innerHTML = '';
                                                    talles.forEach((talle, index) => {
                                                        tablaBody.innerHTML += `
                                                            <tr>
                                                                <td class="text-center">
                                                                    ${talle.talle}
                                                                    <input type="hidden" name="talles[${index}][id]" value="${talle.id}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="input-group input-group-sm" style="max-width: 90px; margin: 0 auto;">
                                                                        <input type="number" name="talles[${index}][stock]" class="form-control form-control-sm text-center stock-input" min="0" value="0" style="padding: 0.25rem;">
                                                                        <button type="button" class="btn btn-outline-secondary increment" style="padding: 0.25rem 0.4rem;">+</button>
                                                                        <button type="button" class="btn btn-outline-secondary decrement" style="padding: 0.25rem 0.4rem;">-</button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        `;
                                                    });

                                                    // Reasignar eventos a los nuevos botones
                                                    setTimeout(() => {
                                                        document.querySelectorAll('.increment').forEach(btn => {
                                                            btn.addEventListener('click', () => {
                                                                const input = btn.closest('.input-group').querySelector('.stock-input');
                                                                input.value = parseInt(input.value) + 1;
                                                            });
                                                        });

                                                        document.querySelectorAll('.decrement').forEach(btn => {
                                                            btn.addEventListener('click', () => {
                                                                const input = btn.closest('.input-group').querySelector('.stock-input');
                                                                if (parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
                                                            });
                                                        });
                                                    }, 100);
                                                });
                                        } else {
                                            tablaTallesContainer.style.display = 'none';
                                            tablaBody.innerHTML = '';
                                        }
                                    });

                                    // Ejecutar al cargar si hay old()
                                    if (categoriaSelect.value) {
                                        categoriaSelect.dispatchEvent(new Event('change'));
                                    }
                                });

                                    </script>

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

                                        document.querySelectorAll('.increment').forEach(btn => {
                                            btn.addEventListener('click', () => {
                                                const input = btn.closest('.input-group').querySelector('.stock-input');
                                                input.value = parseInt(input.value) + 1;
                                            });
                                        });

                                        document.querySelectorAll('.decrement').forEach(btn => {
                                            btn.addEventListener('click', () => {
                                                const input = btn.closest('.input-group').querySelector('.stock-input');
                                                if (parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
                                            });
                                        });
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