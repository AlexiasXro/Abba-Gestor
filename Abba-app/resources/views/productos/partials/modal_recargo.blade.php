


<!-- Modal Abba\Abba-app\resources\views\productos\partials-->
<!-- Modal -->
<div id="modal-recargo-{{ $producto->id }}"
     style="display: none;"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-end p-10">
    <div class="rounded shadow-lg max-w-sm w-80 p-4 bg-white">
        <form method="POST" action="{{ route('producto.aplicarRecargo', $producto->id) }}" class="space-y-4">
            @csrf

            <div>
                <label for="recargo-select-{{ $producto->id }}" class="form-label font-semibold">Porcentaje de recargo:</label>
                <select name="recargo" id="recargo-select-{{ $producto->id }}" class="form-select w-full">
                    @foreach([5, 10, 15, 20, 30, 40, 50, 60, 70, 80, 90, 100] as $p)
                        <option value="{{ $p }}">{{ $p }}%</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="precio-deseado-{{ $producto->id }}" class="form-label font-semibold">O ingresar precio de venta deseado ($):</label>
                <input type="number" step="0.01" min="0" id="precio-deseado-{{ $producto->id }}" class="form-input w-full">
            </div>

            <div class="text-sm">
                <p><strong>Precio base:</strong> ${{ number_format($producto->precio_base, 2) }}</p>
                <p><strong>Precio venta estimado:</strong> <span id="nuevo-venta-{{ $producto->id }}"></span></p>
                <p><strong>Precio reventa estimado:</strong> <span id="nuevo-reventa-{{ $producto->id }}"></span></p>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button"
                        onclick="cerrarModalRecargo({{ $producto->id }})"
                        class="btn btn-secondary px-3 py-1">Cancelar</button>
                <button type="submit" class="btn btn-primary px-3 py-1">Aplicar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('recargo-select-{{ $producto->id }}');
        const inputPrecio = document.getElementById('precio-deseado-{{ $producto->id }}');
        const nuevoVenta = document.getElementById('nuevo-venta-{{ $producto->id }}');
        const nuevoReventa = document.getElementById('nuevo-reventa-{{ $producto->id }}');
        const base = {{ $producto->precio_base }};

        function actualizarDesdePorcentaje() {
            const porcentaje = parseFloat(select.value);
            const venta = (base * (1 + porcentaje / 100)).toFixed(2);
            const reventa = (base * (1 + (porcentaje - 10) / 100)).toFixed(2);

            inputPrecio.value = ''; // limpiar input
            nuevoVenta.textContent = `$${venta}`;
            nuevoReventa.textContent = `$${reventa}`;
        }

        function actualizarDesdePrecioDeseado() {
            const valor = parseFloat(inputPrecio.value);
            if (!valor || valor <= 0) return;

            const porcentaje = ((valor - base) / base) * 100;
            const reventa = (base * (1 + (porcentaje - 10) / 100)).toFixed(2);

            nuevoVenta.textContent = `$${valor.toFixed(2)}`;
            nuevoReventa.textContent = `$${reventa}`;

            // actualizar el select también
            select.value = Math.round(porcentaje);
        }

        select.addEventListener('change', actualizarDesdePorcentaje);
        inputPrecio.addEventListener('input', actualizarDesdePrecioDeseado);

        actualizarDesdePorcentaje(); // valores iniciales
    });

    function abrirModalRecargo(id) {
    const modal = document.getElementById(`modal-recargo-${id}`);
    modal.style.display = 'flex';
}

function cerrarModalRecargo(id) {
    const modal = document.getElementById(`modal-recargo-${id}`);
    modal.style.display = 'none';
}


    function aplicarRecargo(id) {
        const select = document.getElementById(`recargo-select-${id}`);
        const inputPrecio = document.getElementById(`precio-deseado-${id}`);
        const inputVenta = document.getElementById('precio_venta');
        const inputReventa = document.getElementById('precio_reventa');
        const inputBase = document.getElementById('precio_base');

        const base = parseFloat(inputBase.value);
        let venta, reventa, porcentaje;

        if (inputPrecio.value) {
            venta = parseFloat(inputPrecio.value);
            porcentaje = ((venta - base) / base) * 100;
        } else {
            porcentaje = parseFloat(select.value);
            venta = base * (1 + porcentaje / 100);
        }

        reventa = base * (1 + (porcentaje - 10) / 100);

        inputVenta.value = venta.toFixed(2);
        inputReventa.value = reventa.toFixed(2);

        cerrarModalRecargo(id);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputBase = document.getElementById('precio_base');
        const inputVenta = document.getElementById('precio_venta');
        const inputReventa = document.getElementById('precio_reventa');

        inputBase.addEventListener('input', () => {
            inputVenta.value = '';
            inputReventa.value = '';
        });
    });


</script>
