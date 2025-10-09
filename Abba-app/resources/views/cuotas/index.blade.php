@extends('layouts.app')

@section('content')
<!-- resources\views\cuotas\index.blade.php -->
    <x-header-bar title="Listado de Cuotas" :buttons="[
            ['text' => '+ Nueva Cuota', 'route' => route('cuotas.index'), 'class' => 'btn-primary']
        ]" />
    <div class="container">


        
 <div class="table-responsive">
        <table class="table table-bordered table-sm  table-striped  align-middle text-center small shadow-sm">
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
                        <td>{{ $cuota->venta->cliente->nombre ?? 'Sin cliente' }} {{ $cuota->venta->cliente->apellido ?? '' }}
                        </td>
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
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#confirmPagoModal" data-cuota-id="{{ $cuota->id }}"
                                    data-venta-id="{{ $cuota->venta_id }}">
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
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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