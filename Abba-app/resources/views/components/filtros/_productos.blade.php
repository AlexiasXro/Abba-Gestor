<div class="mb-2">
    {{-- Botón toggle  C:\Users\Romin\Documents\Proyecto-CODE\Abba\Abba-app\resources\views\components\filtros\_productos.blade.php--}}
    <button class="btn btn-outline-primary btn-sm" type="button"
            data-bs-toggle="collapse" data-bs-target="#filtrosProductos"
            aria-expanded="{{ request()->except(['page']) ? 'true' : 'false' }}"
            aria-controls="filtrosProductos">
        🔍 Filtros
    </button>

    {{-- Contenido colapsable --}}
{{-- Contenido colapsable --}}
<div class="collapse mt-2 {{ request()->except(['page']) ? 'show' : '' }}" id="filtrosProductos">
    <form method="GET" action="{{ route('productos.index') }}">
        <div class="row g-1">

            {{-- Código --}}
            <div class="col-12 col-sm-6 col-md-3">
                <input type="text" name="codigo"
                       value="{{ request('codigo') }}"
                       class="form-control form-control-sm"
                       placeholder="Código"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
            </div>

            {{-- Nombre --}}
            <div class="col-12 col-sm-6 col-md-3">
                <input type="text" name="nombre"
                       value="{{ request('nombre') }}"
                       class="form-control form-control-sm"
                       placeholder="Nombre"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
            </div>

            {{-- Precio min / max juntos --}}
            <div class="col-12 col-sm-6 col-md-3 d-flex gap-1">
                <input type="number" name="precio_min" step="0.01"
                       value="{{ request('precio_min') }}"
                       class="form-control form-control-sm"
                       placeholder="Precio min"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
                <input type="number" name="precio_max" step="0.01"
                       value="{{ request('precio_max') }}"
                       class="form-control form-control-sm"
                       placeholder="Precio max"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
            </div>

            {{-- Precio costo min / max juntos --}}
            <div class="col-12 col-sm-6 col-md-3 d-flex gap-1">
                <input type="number" name="precio_costo_min" step="0.01"
                       value="{{ request('precio_costo_min') }}"
                       class="form-control form-control-sm"
                       placeholder="Costo min"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
                <input type="number" name="precio_costo_max" step="0.01"
                       value="{{ request('precio_costo_max') }}"
                       class="form-control form-control-sm"
                       placeholder="Costo max"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
            </div>

            {{-- Stock min / max juntos --}}
            <div class="col-12 col-sm-6 col-md-3 d-flex gap-1">
                <input type="number" name="stock_min"
                       value="{{ request('stock_min') }}"
                       class="form-control form-control-sm"
                       placeholder="Stock min"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
                <input type="number" name="stock_max"
                       value="{{ request('stock_max') }}"
                       class="form-control form-control-sm"
                       placeholder="Stock max"
                       style="padding:0.25rem 0.4rem; font-size:0.8rem;">
            </div>

            {{-- Talle (select dinámico) --}}
            <div class="col-12 col-sm-6 col-md-3">
                <select name="talle" class="form-select form-select-sm">
    <option value="">-- Talle --</option>
    @foreach($tallesDisponibles as $talle)
        <option value="{{ $talle->id }}" {{ request('talle') == $talle->id ? 'selected' : '' }}>
            {{ $talle->nombre }}
        </option>
    @endforeach
</select>
            </div>

        </div>

        {{-- Botones --}}
        <div class="mt-2 d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary btn-sm" style="padding:0.25rem 0.5rem;">Filtrar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm" style="padding:0.25rem 0.5rem;">Limpiar</a>
        </div>
    </form>
</div>
</div>
    

