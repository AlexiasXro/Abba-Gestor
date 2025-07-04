document.addEventListener('DOMContentLoaded', function () {
    const inputBusqueda = document.getElementById('busqueda_cliente');
    const selectCliente = document.getElementById('cliente_id');
    let dropdown;

    inputBusqueda.addEventListener('input', async function () {
        const query = this.value.trim();
        if (query.length < 2) return limpiarDropdown();

        const res = await fetch(`/clientes/buscar?query=${encodeURIComponent(query)}`);
        if (!res.ok) return;

        const data = await res.json();
        mostrarSugerencias(data);
    });

    function mostrarSugerencias(clientes) {
        limpiarDropdown();
        if (!clientes.length) return;

        dropdown = document.createElement('div');
        dropdown.classList.add('list-group', 'position-absolute', 'zindex-tooltip');
        dropdown.style.maxHeight = '200px';
        dropdown.style.overflowY = 'auto';
        dropdown.style.width = inputBusqueda.offsetWidth + 'px';

        clientes.forEach(cliente => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = `${cliente.nombre} ${cliente.apellido} - ${cliente.dni || ''}`;
            item.addEventListener('click', () => seleccionarCliente(cliente));
            dropdown.appendChild(item);
        });

        inputBusqueda.parentNode.appendChild(dropdown);
    }

    function seleccionarCliente(cliente) {
        selectCliente.value = cliente.id;
        inputBusqueda.value = `${cliente.nombre} ${cliente.apellido}`;
        limpiarDropdown();
    }

    function limpiarDropdown() {
        if (dropdown && dropdown.parentNode) {
            dropdown.parentNode.removeChild(dropdown);
            dropdown = null;
        }
    }

    document.addEventListener('click', function (e) {
        if (!dropdown || dropdown.contains(e.target) || e.target === inputBusqueda) return;
        limpiarDropdown();
    });
});
