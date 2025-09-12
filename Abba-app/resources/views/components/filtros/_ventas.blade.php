{{-- Filtros colapsables para lista de ventas --}}
<div class="mb-2">
    {{-- Botón toggle --}}
    <button class="btn btn-outline-primary btn-sm" type="button"
            data-bs-toggle="collapse" data-bs-target="#filtrosVentas"
            aria-expanded="{{ request()->except(['page']) ? 'true' : 'false' }}"
            aria-controls="filtrosVentas">
        🔍 Filtros
    </button>

    {{-- Contenido colapsable --}}
    <div class="collapse  {{ request()->except(['page']) ? 'show' : '' }}" id="filtrosVentas">
        <form method="GET" action="{{ route('ventas.index') }}" class="mb-3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

                {{-- N° Venta --}}
                <div class="col">
                    <input type="text" name="numero_venta" value="{{ request('numero_venta') }}"
                           class="form-control form-control-sm" placeholder="N° Venta">
                </div>

                {{-- Fecha desde --}}
                <div class="col">
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                           class="form-control form-control-sm" placeholder="Fecha desde">
                </div>

                {{-- Fecha hasta --}}
                <div class="col">
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                           class="form-control form-control-sm" placeholder="Fecha hasta">
                </div>

                {{-- Cliente --}}
                <div class="col">
                    <input type="text" name="cliente" value="{{ request('cliente') }}"
                           class="form-control form-control-sm" placeholder="Cliente (nombre, DNI, teléfono)">
                </div>

                {{-- Producto --}}
                <div class="col">
                    <input type="text" name="producto" value="{{ request('producto') }}"
                           class="form-control form-control-sm" placeholder="Producto vendido">
                </div>

                {{-- Total mínimo --}}
                <div class="col">
                    <input type="number" name="total_min" step="0.01" value="{{ request('total_min') }}"
                           class="form-control form-control-sm" placeholder="Total min">
                </div>

                {{-- Total máximo --}}
                <div class="col">
                    <input type="number" name="total_max" step="0.01" value="{{ request('total_max') }}"
                           class="form-control form-control-sm" placeholder="Total max">
                </div>

                {{-- Estado --}}
                <div class="col">
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">-- Estado --</option>
                        <option value="pagado" {{ request('estado')=='pagado'?'selected':'' }}>Pagado</option>
                        <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                        <option value="anulado" {{ request('estado')=='anulado'?'selected':'' }}>Anulado</option>
                    </select>
                </div>

                {{-- Método Pago --}}
                <div class="col">
                    <select name="metodo_pago" class="form-select form-select-sm">
                        <option value="">-- Método Pago --</option>
                        <option value="efectivo" {{ request('metodo_pago')=='efectivo'?'selected':'' }}>Efectivo</option>
                        <option value="tarjeta" {{ request('metodo_pago')=='tarjeta'?'selected':'' }}>Tarjeta</option>
                        <option value="transferencia" {{ request('metodo_pago')=='transferencia'?'selected':'' }}>Transferencia</option>
                        <option value="cuotas" {{ request('metodo_pago')=='cuotas'?'selected':'' }}>Cuotas</option>
                    </select>
                </div>
                {{-- Vendedor --}}

            </div>

            {{-- Botones --}}
            <div class="mt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
            </div>
        </form>
    </div>
</div>
