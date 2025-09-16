{{-- resources/views/gastos/create.blade.php --}}
@extends('layouts.app')

@section('content')

<x-header-bar
    title="Registrar Gasto"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('gastos.index'), 'class' => 'btn-secondary']
    ]"  
/>

<div class="container py-4">
    <div class="row">
        {{-- Columna principal: formulario --}}
        <div class="col-md-7">
            <div class="card shadow-sm gradient-border ">
                <div class="card-body">
            

            <form action="{{ route('gastos.store') }}" method="POST" class="row g-3">
    @csrf

    <!-- Fecha -->
    <div class="col-md-4">
        <label for="fecha" class="form-label fw-medium">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
    </div>

    <!-- Monto -->
    <div class="col-md-4">
        <label for="monto" class="form-label fw-medium">Monto ($)</label>
        <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" required>
    </div>

    <!-- Categoría (select con opciones estándar) -->
    <div class="col-md-4">
        <label for="categoria" class="form-label fw-medium">Categoría</label>
        <select name="categoria" id="categoria" class="form-select" required>
            <option value="">Selecciona...</option>
            <option value="Mantenimiento" {{ old('categoria')=='Mantenimiento'?'selected':'' }}>Mantenimiento</option>
            <option value="Servicios" {{ old('categoria')=='Servicios'?'selected':'' }}>Servicios</option>
            <option value="Impuesto" {{ old('categoria')=='Impuesto'?'selected':'' }}>Impuesto</option>
            <option value="Publicidad" {{ old('categoria')=='Publicidad'?'selected':'' }}>Publicidad</option>
            <option value="Otros" {{ old('categoria')=='Otros'?'selected':'' }}>Otros</option>
        </select>
    </div>

    <!-- Método de pago -->
    <div class="col-md-4">
        <label for="metodo_pago" class="form-label fw-medium">Método de pago</label>
        <select name="metodo_pago" id="metodo_pago" class="form-select" required>
            <option value="">Selecciona...</option>
            <option value="efectivo" {{ old('metodo_pago')=='efectivo'?'selected':'' }}>Efectivo</option>
            <option value="tarjeta" {{ old('metodo_pago')=='tarjeta'?'selected':'' }}>Tarjeta</option>
            <option value="transferencia" {{ old('metodo_pago')=='transferencia'?'selected':'' }}>Transferencia</option>
        </select>
    </div>

    <!-- Descripción -->
    <div class="col-12">
        <label for="descripcion" class="form-label fw-medium">Descripción (opcional)</label>
        <textarea name="descripcion" id="descripcion" rows="2" class="form-control" placeholder="Detalle del gasto">{{ old('descripcion') }}</textarea>
    </div>

    <!-- Botones -->
    <div class="col-12 text-end">
        <a href="{{ route('gastos.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-dark">Registrar</button>
    </div>
</form>
 </div>
  </div>
   </div>
      {{-- Columna lateral: explicación para crear gastos --}}
<div class="col-md-5">
    <div class="card border-0 shadow-sm bg-light h-100">
        <div class="card-body">
            <h5 class="fw-bold text-primary mb-3">ℹ️ ¿Qué es un gasto?</h5>
            <p class="text-muted">
                Un <strong>gasto</strong> representa un egreso de dinero de la empresa, como pago de servicios, impuestos,
                mantenimiento, publicidad o cualquier otro desembolso necesario para operar.
            </p>
            <p class="text-muted">
                Registrar correctamente los gastos te permite:
                <ul class="mb-0">
                    <li>Llevar un control claro de tus egresos diarios.</li>
                    <li>Obtener reportes precisos para análisis financiero.</li>
                    <li>Comparar los gastos con los ingresos en los cierres de caja.</li>
                </ul>
            </p>
            <hr>
            <h6 class="fw-semibold">✔️ Tips al registrar un gasto:</h6>
            <ul class="small text-muted mb-0">
                <li>Seleccioná la <strong>fecha</strong> correcta del gasto.</li>
                <li>Ingresá el <strong>monto</strong> real, con decimales si corresponde.</li>
                <li>Elegí la <strong>categoría</strong> apropiada para poder filtrar y analizar gastos.</li>
                <li>Seleccioná el <strong>método de pago</strong> (efectivo, tarjeta, transferencia).</li>
                <li>Agregá una <strong>descripción</strong> clara para futuras referencias.</li>
                <li>Revisá todo antes de hacer clic en "Registrar".</li>
            </ul>
        </div>
    </div>
</div>
@endsection
