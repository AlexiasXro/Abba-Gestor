@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cuotas pendientes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

<form method="GET" class="mb-3 d-flex gap-2 align-items-center flex-wrap">
    <select name="estado" class="form-select w-auto">
        <option value="">-- Todos los estados --</option>
        <option value="pagada" {{ request('estado') == 'pagada' ? 'selected' : '' }}>Pagadas</option>
        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
        <option value="vencida" {{ request('estado') == 'vencida' ? 'selected' : '' }}>Vencidas</option>
    </select>

    <input
        type="text"
        name="cliente"
        class="form-control w-auto"
        placeholder="Buscar por nombre o apellido"
        value="{{ request('cliente') }}"
    />

    <button type="submit" class="btn btn-primary">Filtrar</button>
</form>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Venta</th>
            <th>Cliente</th>
            <th>Cuota</th>
            <th>Monto</th>
            <th>Vence</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($cuotas as $cuota)
            <tr>
                <td><a href="{{ route('ventas.show', $cuota->venta_id) }}">#{{ $cuota->venta_id }}</a></td>
                <td>{{ $cuota->venta->cliente->nombre ?? 'Sin cliente' }} {{ $cuota->venta->cliente->apellido ?? '' }}</td>
                <td>{{ $cuota->numero }}</td>
                <td>${{ number_format($cuota->monto, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                <td>
                    @if($cuota->pagada)
                        <span class="badge bg-success">Pagada</span>
                    @elseif(\Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast())
                        <span class="badge bg-danger">Vencida</span>
                    @else
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @endif
                </td>
                <td>
                    @if(!$cuota->pagada)
                        <button
                            type="button"
                            class="btn btn-sm btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmPagoModal"
                            data-cuota-id="{{ $cuota->id }}"
                            data-venta-id="{{ $cuota->venta_id }}"
                        >
                            Marcar como pagada
                        </button>
                    @else
                        <em class="text-muted">Sin acciones</em>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No hay cuotas para mostrar.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<!-- Modal Confirmar Pago -->
<div class="modal fade" id="confirmPagoModal" tabindex="-1" aria-labelledby="confirmPagoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formPagarCuota" method="POST" action="">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmPagoModalLabel">Confirmar pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro que querés marcar esta cuota como pagada?
          <p><strong>Venta ID:</strong> <span id="ventaIdModal"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Confirmar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var confirmPagoModal = document.getElementById('confirmPagoModal');
    var form = document.getElementById('formPagarCuota');
    var ventaIdSpan = document.getElementById('ventaIdModal');

    confirmPagoModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var cuotaId = button.getAttribute('data-cuota-id');
        var ventaId = button.getAttribute('data-venta-id');

        ventaIdSpan.textContent = ventaId;
        form.action = '/cuotas/pagar/' + cuotaId;  // Cambiá esta ruta si usás named routes
    });
});
</script>

@endsection
