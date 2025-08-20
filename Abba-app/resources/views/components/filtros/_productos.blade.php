<div class="mb-2">
    {{-- Botón toggle --}}
    <button class="btn btn-outline-primary btn-sm" type="button"
            data-bs-toggle="collapse" data-bs-target="#filtrosProductos"
            aria-expanded="{{ request()->except(['page']) ? 'true' : 'false' }}"
            aria-controls="filtrosProductos">
        🔍 Filtros
    </button>

    {{-- Contenido colapsable --}}
    <div class="collapse mt-2 {{ request()->except(['page']) ? 'show' : '' }}" id="filtrosProductos">
        <form method="GET" action="{{ route('productos.index') }}">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

                
                {{-- Precio mínimo --}}
                <div class="col">
                    <input type="number" name="precio_min" step="0.01"
                           value="{{ request('precio_min') }}"
                           class="form-control form-control-sm"
                           placeholder="Precio min">
                </div>

                {{-- Precio máximo --}}
                <div class="col">
                    <input type="number" name="precio_max" step="0.01"
                           value="{{ request('precio_max') }}"
                           class="form-control form-control-sm"
                           placeholder="Precio max">
                </div>

                {{-- Precio costo mínimo --}}
                <div class="col">
                    <input type="number" name="precio_costo_min" step="0.01"
                           value="{{ request('precio_costo_min') }}"
                           class="form-control form-control-sm"
                           placeholder="Precio costo min">
                </div>

                {{-- Precio costo máximo --}}
                <div class="col">
                    <input type="number" name="precio_costo_max" step="0.01"
                           value="{{ request('precio_costo_max') }}"
                           class="form-control form-control-sm"
                           placeholder="Precio costo max">
                </div>

                {{-- Factura B --}}
                <div class="col">
                    <select name="factura_b" class="form-select form-select-sm">
                        <option value="">-- Factura B --</option>
                        <option value="venta" {{ request('factura_b')=='venta'?'selected':'' }}>Venta</option>
                        <option value="reventa" {{ request('factura_b')=='reventa'?'selected':'' }}>Reventa</option>
                    </select>
                </div>

                {{-- Factura A --}}
                <div class="col">
                    <select name="factura_a" class="form-select form-select-sm">
                        <option value="">-- Factura A --</option>
                        <option value="venta" {{ request('factura_a')=='venta'?'selected':'' }}>Venta</option>
                        <option value="reventa" {{ request('factura_a')=='reventa'?'selected':'' }}>Reventa</option>
                    </select>
                </div>

                {{-- Stock mínimo --}}
                <div class="col">
                    <input type="number" name="stock_min"
                           value="{{ request('stock_min') }}"
                           class="form-control form-control-sm"
                           placeholder="Stock min">
                </div>

                {{-- Stock máximo --}}
                <div class="col">
                    <input type="number" name="stock_max"
                           value="{{ request('stock_max') }}"
                           class="form-control form-control-sm"
                           placeholder="Stock max">
                </div>

                {{-- Talle (Stock) --}}
                <div class="col">
                    <input type="text" name="talle"
                           value="{{ request('talle') }}"
                           class="form-control form-control-sm"
                           placeholder="Talle">
                </div>

            </div>

            {{-- Botones --}}
            <div class="mt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
            </div>
        </form>
    </div>
</div>
