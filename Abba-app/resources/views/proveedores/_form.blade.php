<div class="mb-3">
    <label for="nombre" class="form-label"><i class="bi bi-person-fill"></i> Nombre *</label>
    <input type="text" name="nombre" id="nombre" class="form-control form-control-sm"
           value="{{ old('nombre', $proveedor->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="cuit" class="form-label"><i class="bi bi-credit-card-2-front"></i> CUIT</label>
    <input type="text" name="cuit" id="cuit" class="form-control form-control-sm"
           value="{{ old('cuit', $proveedor->cuit ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
    <input type="email" name="email" id="email" class="form-control form-control-sm"
           value="{{ old('email', $proveedor->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="telefono" class="form-label"><i class="bi bi-telephone-fill"></i> Teléfono</label>
    <input type="text" name="telefono" id="telefono" class="form-control form-control-sm"
           value="{{ old('telefono', $proveedor->telefono ?? '') }}">
</div>

<div class="mb-3">
    <label for="direccion" class="form-label"><i class="bi bi-geo-alt-fill"></i> Dirección</label>
    <input type="text" name="direccion" id="direccion" class="form-control form-control-sm"
           value="{{ old('direccion', $proveedor->direccion ?? '') }}">
</div>

<div class="mb-3">
    <label for="observaciones" class="form-label"><i class="bi bi-chat-left-text-fill"></i> Observaciones</label>
    <textarea name="observaciones" id="observaciones" class="form-control form-control-sm"
              rows="3">{{ old('observaciones', $proveedor->observaciones ?? '') }}</textarea>
</div>
