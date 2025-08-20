{{-- resources/views/components/filtros/_gastos.blade.php --}}
<div class="mb-2">
    {{-- Botón toggle --}}
    <button class="btn btn-outline-primary btn-sm" type="button"
            data-bs-toggle="collapse" data-bs-target="#filtrosGastos"
            aria-expanded="{{ request()->except(['page']) ? 'true' : 'false' }}"
            aria-controls="filtrosGastos">
        🔍 Filtros
    </button>

    {{-- Contenido colapsable --}}
    <div class="collapse mt-2 {{ request()->except(['page']) ? 'show' : '' }}" id="filtrosGastos">
        <form method="GET" action="{{ route('gastos.index') }}">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

                {{-- Fecha --}}
                <div class="col">
                    <input type="date" name="fecha"
                           value="{{ request('fecha') }}"
                           class="form-control form-control-sm"
                           placeholder="Fecha">
                </div>

                {{-- Monto --}}
                <div class="col">
                    <input type="number" name="monto" step="0.01"
                           value="{{ request('monto') }}"
                           class="form-control form-control-sm"
                           placeholder="Monto ($)">
                </div>

                {{-- Categoría --}}
                <div class="col">
                    <select name="categoria" class="form-select form-select-sm">
                        <option value="">-- Categoría --</option>
                        <option value="insumos" {{ request('categoria')=='insumos'?'selected':'' }}>Insumos</option>
                        <option value="servicios" {{ request('categoria')=='servicios'?'selected':'' }}>Servicios</option>
                        <option value="otros" {{ request('categoria')=='otros'?'selected':'' }}>Otros</option>
                    </select>
                </div>

                {{-- Descripción --}}
                <div class="col">
                    <input type="text" name="descripcion"
                           value="{{ request('descripcion') }}"
                           class="form-control form-control-sm"
                           placeholder="Descripción">
                </div>

            </div>

            {{-- Botones --}}
            <div class="mt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <a href="{{ route('gastos.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
            </div>
        </form>
    </div>
</div>

