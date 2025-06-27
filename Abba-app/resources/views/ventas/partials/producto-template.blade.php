<!-- Template para agregar productos dinámicamente -->
<template id="producto-template">
    <div class="producto-item card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Producto</label>

                    <select class="form-select producto-select" name="productos[][producto_id]" required>
                        
                        <option value="">-- Seleccionar producto --</option>
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                            {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Talle</label>
                    <select class="form-select talle-select" name="productos[][talle_id]" required>
                        <option value="">-- Seleccionar talle --</option>
                        @foreach($talles as $talle)
                        <option value="{{ $talle->id }}">{{ $talle->talle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control cantidad" name="productos[][cantidad]" min="1" value="1"
                        required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" class="form-control precio" name="productos[][precio]" step="0.01" min="0"
                        required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Descuento</label>
                    <input type="number" class="form-control descuento" name="productos[][descuento]" step="0.01"
                        min="0" value="0">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn btn-danger btn-sm quitar-producto">Quitar</button>
                </div>
            </div>
        </div>
    </div>
</template>