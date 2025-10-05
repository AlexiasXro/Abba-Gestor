@extends('layouts.app')


<!-- Abba\Abba-app\resources\views\productos\edit.blade.php -->
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <x-header-bar title="Editar Productos" :buttons="[
            ['route' => route('productos.show', $producto), 'text' => 'Volver', 'class' => 'btn-outline-secondary']
        ]">
        <x-slot name="extraButtons">
            <button class="btn btn-warning btn-sm" onclick="abrirModalRecargo({{ $producto->id }})">
                Modificar recargo
            </button>
        </x-slot>
    </x-header-bar>



    <div class="container  mt-2">


        @include('productos.partials.modal_recargo', ['producto' => $producto])


        <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data" class="">
            @csrf
            @method('PUT')


            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-8 card shadow-sm rounded mb-3">
                    <div class="row my-2 ">
                        <div class="col-md-6 p-2">
                            <label for="codigo" class="form-label">Código<span class="text-danger">*</span></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                value="{{ old('codigo', $producto->codigo) }}" required>

                        </div>
                        <div class="col-md-6 p-2">
                            <label for="precio_base" class="form-label fw-bold ">
                                Precio costo <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="precio_base" id="precio_base"
                                class="form-control border border-2 border-primary shadow-sm"
                                value="{{ old('precio_base', $producto->precio_base ?? '') }}" required autofocus>
                            <small class="text-muted">Complete este campo primero: a partir de aquí se calculan los demás
                                precios.</small>
                        </div>

                        <div class="col-md-6 p-2">
                            <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="{{ old('nombre', $producto->nombre) }}" required>

                        </div>



                        <div class="col-md-6 p-2">
                            <label for="precio_venta" class="form-label">Precio venta (final)</label>
                            <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
                                value="{{ old('precio_venta', $producto->precio_venta ?? '') }}">
                        </div>

                        <div class="col-md-6 p-2">
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


                        <div class="col-md-6 p-2">
                            <label for="precio_reventa" class="form-label">Precio reventa (mayorista)</label>
                            <input type="number" step="0.01" name="precio_reventa" id="precio_reventa" class="form-control"
                                value="{{ old('precio_reventa', $producto->precio_reventa ?? '') }}">
                        </div>
                        <div class="col-md-6 p-2">
                            <label for="categoria_id" class="form-label">Categoría<span class="text-danger">*</span></label>
                            <select name="categoria_id" id="categoria_id" class="form-select" required>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Fin de campos de precios adicionales -->

                        <div class="col-md-6 p-2">
                            <label for="stock_minimo" class="form-label">Stock mínimo<span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
                                value="{{ old('stock_minimo', 3) }}" required>
                            <small class="text-muted">Se usa para alertas de reposición.</small>

                        </div>

                        <div class="col-md-6 p-2">
                            <label for="activo" class="form-label">Activo<i class="bi bi-hand-thumbs-up-fill text-success"
                                    title="Activo"></i></label>
                            <select name="activo" id="activo" class="form-select" required>
                                <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            <small class="text-muted">Marcá "No" si no se vende más.</small>
                        </div>

                        <div class="col-md-6 p-2">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion"
                                class="form-control">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="col-md-6 p-2">
                            <div class="border rounded shadow-sm p-2 text-center" style="max-width: 220px; margin: 0 auto;">
                                @if(isset($producto) && $producto->imagen)
                                    <!-- Imagen existente (edit) -->
                                    <img id="preview" src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa"
                                        class="img-fluid" style="max-height: 200px;">
                                @else
                                    <!-- Preview vacío (create) -->
                                    <img id="preview" src="#" alt="Vista previa" class="img-fluid"
                                        style="max-height: 200px; display: none;">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 p-2">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                        </div>



                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Confirmar
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Columna derecha -->
                <div class="col-md-4 d-flex justify-content-start">

                    <div style="max-width: 180px; width: 100%;">

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm rounded " class="border border-primary rounded shadow-sm p-3 bg-light mb-3"
             style="display: none;">
                                <thead class="table-secondary">
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
                                                <input type="hidden" name="talles[{{ $loop->index }}][id]"
                                                    value="{{ $talle->id }}">
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm"
                                                    style="max-width: 90px; margin: 0 auto;">
                                                    <input type="number" name="talles[{{ $loop->index }}][stock]"
                                                        class="form-control form-control-sm text-center stock-input" min="0"
                                                        value="0" style="padding: 0.25rem;">
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