@extends('layouts.app')

@section('content')


    <div class="container ">
        <x-header-bar title="Cierre de Caja" :buttons="[
            ['text' => 'Volver al Listado', 'route' => route('cierres.index'), 'class' => 'btn-secondary']
        ]" />


<div class="container mt-4">
    <div class="row g-3">
        
        {{-- Columna principal: formulario --}}
        <div class="col-md-7">
            <div class="card shadow-sm border ">
                <div class="card-body">
                    <h4 class="mb-4 text-dark fw-semibold">
                        🧾 Cierre de Caja - {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                    </h4>

                    @if(session('error'))
                        <div class="alert alert-danger small">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="cierre-form" action="{{ route('cierres.store') }}" method="POST" class="mb-0">
                        @csrf

                        <input type="hidden" name="fecha" value="{{ $fecha }}">

                        {{-- Ventas efectivo --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                💵 Ventas en efectivo
                                <i class="bi bi-info-circle text-muted" data-bs-toggle="tooltip" title="Ingresos en efectivo registrados hoy"></i>
                            </label>
                            <input type="text" class="form-control bg-light fw-semibold"
                                value="${{ number_format($monto_efectivo, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="monto_efectivo" value="{{ $monto_efectivo }}">
                        </div>

                        {{-- Ventas cuotas --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                📄 Ventas en cuotas
                                <i class="bi bi-info-circle text-muted" data-bs-toggle="tooltip" title="Ingresos por ventas en cuotas registradas hoy"></i>
                            </label>
                            <input type="text" class="form-control bg-light fw-semibold"
                                value="${{ number_format($monto_cuotas, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="monto_cuotas" value="{{ $monto_cuotas }}">
                        </div>

                        {{-- Gastos --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                📉 Total gastos
                                <i class="bi bi-info-circle text-muted" data-bs-toggle="tooltip" title="Egresos cargados en el sistema"></i>
                            </label>
                            <input type="text" class="form-control bg-light text-danger fw-semibold"
                                value="- ${{ number_format($total_gastos, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="total_gastos" value="{{ $total_gastos }}">
                        </div>

                        {{-- Saldo final --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">✅ Saldo final</label>
                            <input type="text" class="form-control fw-bold text-success fs-5 text-center"
                                value="${{ number_format($monto_total, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="monto_total" value="{{ $monto_total }}">
                        </div>

                        {{-- Botones --}}
                        <div class="text-end">
                            <a href="{{ route('cierres.index') }}" class="btn btn-outline-danger me-2 fw-semibold">Cancelar</a>
                            <button type="submit" class="btn btn-info fw-semibold">
                                <i class="bi bi-check-circle"></i> Confirmar cierre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Columna lateral: explicación --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm bg-light h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">ℹ️ ¿Qué es el cierre de caja?</h5>
                    <p class="text-muted">
                        El <strong>cierre de caja</strong> es un procedimiento diario que permite verificar
                        ingresos (<em>ventas en efectivo y cuotas</em>) y egresos (<em>gastos</em>).
                    </p>
                    <p class="text-muted">
                        Al confirmarlo, el sistema guarda un resumen del día con el <strong>saldo final</strong>,
                        ayudándote a llevar un control claro de la caja.
                    </p>
                    <hr>
                    <h6 class="fw-semibold">✔️ Pasos recomendados:</h6>
                    <ul class="small text-muted mb-0">
                        <li>Verificá que <a href="{{ route('ventas.index') }}">todas las ventas</a> estén cargadas.</li>
                        <li>Revisá que <a href="{{ route('gastos.index') }}">los gastos</a> estén registrados.</li>
                        <li>Compará el efectivo físico con el monto mostrado aquí.</li>
                        <li>Confirmá el cierre para bloquear cambios posteriores.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Scripts de interacción --}}
@push('scripts')
<script>
    // Activa tooltips de Bootstrap
    document.addEventListener("DOMContentLoaded", function(){
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Confirmación con SweetAlert
    document.getElementById("cierre-form").addEventListener("submit", function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar cierre de caja?',
            text: "Una vez cerrado, no se podrán modificar los registros de este día.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });
</script>
@endpush
