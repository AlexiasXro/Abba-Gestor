@extends('layouts.app')

@section('content')


    <div class="container ">
        <x-header-bar title="Cierre de Caja" :buttons="[
            ['text' => 'Volver al Listado', 'route' => route('cierres.index'), 'class' => 'btn-secondary']
        ]" />

        <div class="row  >
                    {{-- Columna principal: formulario --}}
                    <div class=" col-md-7">
            <div class="card shadow-sm gradient-border ">
                <div class="card-body">
                    <h4 class="mb-4 text-dark fw-semibold">Cierre de Caja -
                        {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                    </h4>

                    @if(session('error'))
                        <div class="alert alert-danger small">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('cierres.store') }}" method="POST" class="mb-0 ">
                        @csrf

                        <input type="hidden" name="fecha" value="{{ $fecha }}">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Ventas en efectivo</label>
                            <input type="text" class="form-control"
                                value="${{ number_format($monto_efectivo, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="monto_efectivo" value="{{ $monto_efectivo }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Ventas en cuotas</label>
                            <input type="text" class="form-control" value="${{ number_format($monto_cuotas, 2, ',', '.') }}"
                                readonly>
                            <input type="hidden" name="monto_cuotas" value="{{ $monto_cuotas }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Total gastos</label>
                            <input type="text" class="form-control" value="${{ number_format($total_gastos, 2, ',', '.') }}"
                                readonly>
                            <input type="hidden" name="total_gastos" value="{{ $total_gastos }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Saldo final</label>
                            <input type="text" class="form-control fw-bold text-success"
                                value="${{ number_format($monto_total, 2, ',', '.') }}" readonly>
                            <input type="hidden" name="monto_total" value="{{ $monto_total }}">
                        </div>

                        <div class="text-end ">
                            <a href="{{ route('cierres.index') }}"
                                class="btn btn-outline-danger me-2 fw-semibold">Cancelar</a>
                            <button type="submit" class="btn btn-info fw-semibold ">Confirmar cierre</button>
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
                        y registrar los ingresos (ventas en efectivo y cuotas) y egresos (gastos) de la jornada.
                    </p>
                    <p class="text-muted">
                        Al confirmarlo, el sistema guarda un resumen del día con el <strong>saldo final
                            disponible</strong>,
                        lo que te ayuda a llevar un control claro de la caja.
                    </p>
                    <hr>
                    <h6 class="fw-semibold">✔️ Pasos recomendados:</h6>
                    <ul class="small text-muted mb-0">
                        <li>
                            Verificá que
                            <a href="{{ route('ventas.index') }}" target="_blank" rel="noopener noreferrer">
                                todas las ventas del día
                            </a>
                            estén cargadas.
                        </li>
                        <li>
                            Revisá si
                            <a href="{{ route('gastos.index') }}" target="_blank" rel="noopener noreferrer">
                                registraste correctamente los gastos
                            </a>.
                        </li>
                        <li>Compará el efectivo físico con el monto mostrado aquí.</li>
                        <li>Confirmá el cierre para bloquear cambios posteriores.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection