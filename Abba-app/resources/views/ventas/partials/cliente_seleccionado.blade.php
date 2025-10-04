<div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
    <div>
        <span>{{ $cliente->nombre }} {{ $cliente->apellido }} - DNI: {{ $cliente->dni ?? '-' }} - Tel: {{ $cliente->telefono ?? '-' }}</span>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary"
        onclick="document.getElementById('clienteSeleccionado').innerHTML='';document.getElementById('clienteId').value='';document.getElementById('buscarCliente').focus();">
        Cambiar
    </button>
</div>

<input type="hidden" name="cliente_id" value="{{ $cliente->id }}" id="clienteId">

