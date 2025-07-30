<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('productos.store_desde_compra') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoProductoLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Precio base ($)</label>
                        <input type="number" step="0.01" name="precio_base" class="form-control" required>
                    </div>
                    {{-- Agregá otros campos si lo necesitás --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar producto</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
