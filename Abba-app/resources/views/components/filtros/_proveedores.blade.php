<div class="mb-2">
    {{-- Botón toggle --}}
    <button class="btn btn-outline-primary btn-sm" type="button" 
            data-bs-toggle="collapse" data-bs-target="#filtrosProveedores" 
            aria-expanded="{{ request()->except(['page']) ? 'true' : 'false' }}" 
            aria-controls="filtrosProveedores">
        🔍 Filtros
    </button>

    {{-- Contenido colapsable --}}
    <div class="collapse mt-2 {{ request()->except(['page']) ? 'show' : '' }}" id="filtrosProveedores">
        <form method="GET" action="{{ route('proveedores.index') }}">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

                {{-- Nombre --}}
                <div class="col">
                    <input type="text" name="nombre"
                           value="{{ request('nombre') }}"
                           class="form-control form-control-sm"
                           placeholder="Nombre proveedor">
                </div>

                {{-- CUIT --}}
                <div class="col">
                    <input type="text" name="cuit"
                           value="{{ request('cuit') }}"
                           class="form-control form-control-sm"
                           placeholder="CUIT">
                </div>

                {{-- Teléfono --}}
                <div class="col">
                    <input type="text" name="telefono"
                           value="{{ request('telefono') }}"
                           class="form-control form-control-sm"
                           placeholder="Teléfono">
                </div>

                {{-- Email --}}
                <div class="col">
                    <input type="text" name="email"
                           value="{{ request('email') }}"
                           class="form-control form-control-sm"
                           placeholder="Email">
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
            </div>
        </form>
    </div>
</div>
