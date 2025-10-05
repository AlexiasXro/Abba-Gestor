@props(['producto' => null, 'proveedores', 'categorias'])
<!-- Abba-app\resources\views\productos\_form.blade.php -->





<div class="row">
    <div class="col-md-4 p-2">
        <label for="codigo" class="form-label">Código<span class="text-danger">*</span></label>
        <input type="text" name="codigo" id="codigo" class="form-control"
            value="{{ old('codigo', $producto->codigo ?? '') }}" required>
    </div>

    <div class="col-md-4 p-2">
        <label for="precio_base" class="form-label fw-bold">Precio costo <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="precio_base" id="precio_base"
            class="form-control border border-2 border-primary shadow-sm"
            value="{{ old('precio_base', $producto->precio_base ?? '') }}" required autofocus>
        <small class="text-muted">Complete este campo primero: a partir de aquí se calculan los demás precios.</small>
    </div>
    <div class="col-md-4 p-2">
        <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
    </div>
    <div class="col-md-4 p-2">
        <label for="precio_venta" class="form-label">Precio venta (final)</label>
        <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
            value="{{ old('precio_venta', $producto->precio_venta ?? '') }}">
    </div>
    <div class="col-md-4 p-2">
        <label for="proveedor_nombre" class="form-label">Proveedor (opcional)</label>
        <input list="proveedores-list" id="proveedor_nombre" name="proveedor_nombre" class="form-control"
            autocomplete="off" value="{{ old('proveedor_nombre') }}" placeholder="Escriba para buscar proveedor" />
        <datalist id="proveedores-list">
            @foreach ($proveedores as $prov)
                <option data-id="{{ $prov->id }}" value="{{ $prov->nombre }}"></option>
            @endforeach
        </datalist>
        <input type="hidden" name="proveedor_id" id="proveedor_id" value="{{ old('proveedor_id') }}">
    </div>
    <div class="col-md-4 p-2">
        <label for="precio_reventa" class="form-label">Precio reventa (mayorista)</label>
        <input type="number" step="0.01" name="precio_reventa" id="precio_reventa" class="form-control"
            value="{{ old('precio_reventa', $producto->precio_reventa ?? '') }}">
    </div>
    <div class="col-md-4 p-2">
        <label for="categoria_id" class="form-label">Categoría<span class="text-danger">*</span></label>
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
        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
            value="{{ old('stock_minimo', 3) }}" required>
        <small class="text-muted">Se usa para alertas de reposición.</small>

    </div>
    <div class="col-md-4 p-2">
        <label for="activo" class="form-label">Activo<i class="bi bi-hand-thumbs-up-fill text-success"
                title="Activo"></i></label>
        <select name="activo" id="activo" class="form-select" required>
            <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>No</option>
        </select>
        <small class="text-muted">Marcá "No" si no se vende más.</small>
    </div>
    <div class="col-md-4 p-2">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
    </div>
    <div class="col-md-4 p-2">
        <div class="border rounded shadow-sm p-2 text-center" style="max-width: 220px; margin: 0 auto;">
            @if(isset($producto) && $producto->imagen)
                <!-- Imagen existente (edit) -->
                <img id="preview" src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="img-fluid"
                    style="max-height: 200px;">
            @else
                <!-- Preview vacío (create) -->
                <img id="preview" src="#" alt="Vista previa" class="img-fluid" style="max-height: 200px; display: none;">
            @endif
        </div>
    </div>
    <div class="col-md-4 p-2">
        <label for="imagen" class="form-label">Imagen del producto</label>
        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
    </div>
    <!-- talle -->
    <div class="col-md-4 p-2">

        <div style="max-width: 180px; width: 100%;">
            <div id="tablaTallesContainer" class="border rounded shadow-sm p-3 bg-light mb-3" style="">

                <h6 class="text-info mb-2">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i> Talles por categoría
                </h6>
                <!-- tabla aquí -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm rounded" style="font-size: 0.9rem;">
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
    <!--Confirmar-->
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Crear Producto
        </button>
    </div>
    </div>