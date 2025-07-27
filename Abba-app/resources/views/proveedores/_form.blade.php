<!-- resources/views/proveedores/_form.blade.php -->
<div class="mb-3">
    <label>Nombre *</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre ?? '') }}" required>
</div>
<div class="mb-3">
    <label>CUIT</label>
    <input type="text" name="cuit" class="form-control" value="{{ old('cuit', $proveedor->cuit ?? '') }}">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $proveedor->email ?? '') }}">
</div>
<div class="mb-3">
    <label>Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
</div>
<div class="mb-3">
    <label>Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
</div>
<div class="mb-3">
    <label>Observaciones</label>
    <textarea name="observaciones" class="form-control">{{ old('observaciones', $proveedor->observaciones ?? '') }}</textarea>
</div>
