document.addEventListener('DOMContentLoaded', function () {
    const metodoPagoSelect = document.getElementById('metodo_pago');
    const cuotasContainer = document.getElementById('cuotas-container');
    const resumenCuotas = document.getElementById('resumen-cuotas');
    const entregaInicialInput = document.getElementById('entrega_inicial');
    const cantidadCuotasInput = document.getElementById('cantidad_cuotas');

    if (cantidadCuotasInput) {
        cantidadCuotasInput.addEventListener('input', calcularCuotas);
    }

    if (entregaInicialInput) {
        entregaInicialInput.addEventListener('input', calcularCuotas);
    }

    if (metodoPagoSelect) {
        metodoPagoSelect.addEventListener('change', () => {
            const metodo = metodoPagoSelect.value;
            const esCuotas = metodo === 'cuotas';

            cuotasContainer.classList.toggle('d-none', !esCuotas);
            resumenCuotas.classList.toggle('d-none', !esCuotas);

            if (esCuotas) calcularCuotas();
        });
    }

    function calcularCuotas() {
        const entrega = parseFloat(entregaInicialInput.value) || 0;
        const cuotas = parseInt(cantidadCuotasInput.value) || 2;
        const totalTexto = document.getElementById('total_mostrado').value.replace('$', '') || '0';
        const total = parseFloat(totalTexto);

        let restante = Math.max(total - entrega, 0);
        let cuotaMensual = cuotas > 1 ? (restante / (cuotas - 1)) : restante;

        document.getElementById('resumen-entrega').textContent = `$${entrega.toFixed(2)}`;
        document.getElementById('resumen-cuota-final').textContent = `$${cuotaMensual.toFixed(2)} x ${cuotas - 1}`;
        document.getElementById('resumen-total').textContent = `$${total.toFixed(2)}`;
    }
});
