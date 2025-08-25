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



    <div class="container">


        @include('productos.partials.modal_recargo', ['producto' => $producto])


        <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data"
            class="bg-light p-4 rounded shadow-xl">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control form-control-sm"
                                value="{{ old('codigo', $producto->codigo) }}" required>
                            <div class="form-text">Código interno o del proveedor.</div>
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
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-sm"
                                value="{{ old('nombre', $producto->nombre) }}" required>
                            <div class="form-text">Nombre que se muestra en el sistema.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control form-control-sm"
                            rows="2">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        <div class="form-text">Detalles adicionales. Opcional.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="proveedor_id" class="form-label">Proveedor (opcional)</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-select">
                            <option value="">-- Sin proveedor asignado --</option>
                            @foreach ($proveedores as $prov)
                                <option value="{{ $prov->id }}" {{ old('proveedor_id', $producto->proveedor_id) == $prov->id ? 'selected' : '' }}>
                                    {{ $prov->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h6 class="fw-bold mt-4">Precios</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_base" class="form-label">Precio Base</label>
                            <input type="number" step="0.01" name="precio_base" id="precio_base"
                                class="form-control form-control-sm"
                                value="{{ old('precio_base', $producto->precio_base ?? '') }}">
                            <div class="form-text">Costo del producto.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="precio_venta" class="form-label mb-0">Precio Venta</label>

                            </div>

                            <input type="number" step="0.01" name="precio_venta" id="precio_venta"
                                class="form-control form-control-sm"
                                value="{{ old('precio_venta', $producto->precio_venta ?? '') }}">
                            <div class="form-text">Precio al público (ej. base + 30%).</div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="precio_reventa" class="form-label">Precio Reventa</label>
                            <input type="number" step="0.01" name="precio_reventa" id="precio_reventa"
                                class="form-control form-control-sm"
                                value="{{ old('precio_reventa', $producto->precio_reventa ?? '') }}">
                            <div class="form-text">Para mayoristas o revendedores.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="precio" class="form-label">Precio (General)</label>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control form-control-sm"
                                value="{{ old('precio', $producto->precio) }}" required>
                            <div class="form-text">Campo genérico o de compatibilidad.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control form-control-sm"
                                value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0">
                            <div class="form-text">Se usa para alertas de reposición.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="activo" class="form-label">Producto Activo<i
                                    class="bi bi-hand-thumbs-up-fill text-success" title="Activo"></i></label>
                            <select name="activo" id="activo" class="form-select form-select-sm">
                                <option value="1" {{ old('activo', $producto->activo) == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('activo', $producto->activo) == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            <div class="form-text">Marcá "No" si no se vende más.</div>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha (Talles y Stock) -->

                <!-- Columna derecha (Talles y Stock) -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold mb-3">Stock por Talle</h6>
                    <div class="row">
                        @foreach ($talles->chunk(ceil($talles->count() / 2)) as $columna)
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless align-middle mb-0">
                                        <tbody>
                                            @foreach ($columna as $talle)
                                                @php
                                                    $stock = $producto->talles->firstWhere('id', $talle->id)?->pivot->stock ?? 0;
                                                @endphp
                                                <tr>
                                                    <td class="text-center align-middle" style="width: 30%;">
                                                        <label class="text-center form-label mb-0">{{ $talle->talle }}</label>
                                                        <input type="hidden"
                                                            name="talles[{{ $loop->parent->index * ceil($talles->count() / 2) + $loop->index }}][id]"
                                                            value="{{ $talle->id }}">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <input type="number"
                                                            name="talles[{{ $loop->parent->index * ceil($talles->count() / 2) + $loop->index }}][stock]"
                                                            class="form-control form-control-sm text-center" min="0"
                                                            placeholder="Modificar" title="Podés modificar el stock"
                                                            value="{{ old('talles.' . ($loop->parent->index * ceil($talles->count() / 2) + $loop->index) . '.stock', $stock) }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-4">Actualizar Producto</button>
        </form>

    </div>

    <script>
        // Actualizar precios automáticamente
        document.addEventListener('DOMContentLoaded', function () {
            const inputBase = document.getElementById('precio_base');
            const inputVenta = document.getElementById('precio_venta');
            const inputReventa = document.getElementById('precio_reventa');

            inputBase.addEventListener('input', () => {
                const base = parseFloat(inputBase.value);
                if (!isNaN(base)) {
                    inputVenta.value = (base * 1.30).toFixed(2);
                    inputReventa.value = (base * 1.15).toFixed(2);
                }
            });
        });
    </script>
@endsection