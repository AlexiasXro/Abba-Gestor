<form method="GET" action="{{ route('gastos.index') }}" class="mb-3">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

        {{-- Categoría --}}
        <div class="col">
            <select name="categoria" class="form-select form-select-sm">
                <option value="">-- Categoría --</option>
                <option value="insumos" {{ request('categoria')=='insumos'?'selected':'' }}>Insumos</option>
                <option value="servicios" {{ request('categoria')=='servicios'?'selected':'' }}>Servicios</option>
                <option value="otros" {{ request('categoria')=='otros'?'selected':'' }}>Otros</option>
            </select>
        </div>

        {{-- Fecha --}}
        <div class="col">
            <input type="date" name="fecha"
                   value="{{ request('fecha') }}"
                   class="form-control form-control-sm">
        </div>

        {{-- Monto mínimo --}}
        <div class="col">
            <input type="number" name="monto_min" step="0.01"
                   value="{{ request('monto_min') }}"
                   class="form-control form-control-sm"
                   placeholder="Monto min">
        </div>

        {{-- Monto máximo --}}
        <div class="col">
            <input type="number" name="monto_max" step="0.01"
                   value="{{ request('monto_max') }}"
                   class="form-control form-control-sm"
                   placeholder="Monto max">
        </div>
    </div>

    <div class="mt-2 d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        <a href="{{ route('gastos.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
    </div>
</form>