document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('productos-container');
    const addButton = document.getElementById('agregar-producto');
    const template = document.getElementById('producto-template');
    const totalMostrado = document.getElementById('total_mostrado');
    const metodoPagoSelect = document.getElementById('metodo_pago');
    const montoEntregadoContainer = document.getElementById('monto-entregado-container');
    const montoPagadoInput = document.getElementById('monto_pagado');
    const vueltoText = document.getElementById('vuelto-text');
    const tipoTarjetaContainer = document.getElementById('tipo-tarjeta-container');
    const numeroOperacionContainer = document.getElementById('numero-operacion-container');
    const stockDisponible = window.stockDisponible;

    // Inicial
    agregarProducto();
    mostrarCamposMetodoPago();
    recalcularTotales();

    // Agregar nuevo producto
    addButton.addEventListener('click', agregarProducto);

    // Cambia el método de pago
    metodoPagoSelect.addEventListener('change', () => {
        mostrarCamposMetodoPago();
        recalcularTotales();
    });

    // Cambia monto entregado
    montoPagadoInput.addEventListener('input', recalcularTotales);

    function mostrarCamposMetodoPago() {
        const metodo = metodoPagoSelect.value;
        montoEntregadoContainer.classList.toggle('d-none', metodo !== 'efectivo');
        tipoTarjetaContainer.classList.toggle('d-none', metodo !== 'tarjeta');
        numeroOperacionContainer.classList.toggle('d-none', metodo !== 'transferencia');
    }

    function agregarProducto() {
        const clone = template.content.cloneNode(true);
        const productoItem = clone.querySelector('.producto-item');
        const index = document.querySelectorAll('.producto-item').length;
        const inputs = productoItem.querySelectorAll('[name]');

        // Nombrado único
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[]', `[${index}]`);
            input.setAttribute('name', name);
        });

        const productoSelect = productoItem.querySelector('.producto-select');
        const talleSelect = productoItem.querySelector('.talle-select');
        const cantidadInput = productoItem.querySelector('.cantidad');
        const precioInput = productoItem.querySelector('.precio');
        const descuentoInput = productoItem.querySelector('.descuento');

        productoSelect.addEventListener('change', () => {
            const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio') || 0;
            precioInput.value = precio;
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            validarStock(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        talleSelect.addEventListener('change', () => {
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            validarStock(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        cantidadInput.addEventListener('input', () => {
            const productoId = productoSelect.value;
            const talleId = talleSelect.value;

            if (!productoId || !talleId) {
                cantidadInput.removeAttribute('max');
            } else {
                const max = cantidadInput.getAttribute('max');
                const val = parseInt(cantidadInput.value);
                if (max && val > parseInt(max)) cantidadInput.value = max;
                else if (val < 1 || isNaN(val)) cantidadInput.value = 1;
            }

            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            validarStock(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        precioInput.addEventListener('input', recalcularTotales);
        descuentoInput.addEventListener('input', recalcularTotales);

        productoItem.querySelector('.quitar-producto').addEventListener('click', () => {
            productoItem.remove();
            recalcularTotales();
        });

        container.appendChild(clone);
    }

    function actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput) {
        const productoId = productoSelect?.value;
        const talleId = talleSelect?.value;
        console.log('Producto:', productoId, 'Talle:', talleId);
        //console.log('StockDisponible:', stockDisponible);
        //console.log('Stock del producto:', stockDisponible[productoId]);

        // Validación robusta: existe producto y talle, y el stock para ese talle
        if (
            !productoId ||
            !talleId ||
            !stockDisponible[productoId] ||
            !Object.prototype.hasOwnProperty.call(stockDisponible[productoId], talleId)
        ) {
            console.warn(`Stock no disponible para producto ${productoId} y talle ${talleId}`);
            cantidadInput.removeAttribute('max');
            return;
        }

        const stockMax = stockDisponible[productoId][talleId];
        cantidadInput.setAttribute('max', stockMax);

        const cantidadActual = parseInt(cantidadInput.value) || 1;
        if (cantidadActual > stockMax) {
            cantidadInput.value = stockMax;
        }
    }


    function validarStock(productoSelect, talleSelect, cantidadInput) {
        const productoId = productoSelect.value;
        const talleId = talleSelect.value;
        const cantidad = parseInt(cantidadInput.value) || 0;

        if (!productoId || !talleId || !stockDisponible[productoId] || stockDisponible[productoId][talleId] === undefined) {
            cantidadInput.classList.remove('is-invalid');
            const feedback = cantidadInput.parentElement.querySelector('.invalid-feedback');
            if (feedback) feedback.remove();
            return;
        }

        const stock = stockDisponible[productoId][talleId];
        const esValido = cantidad <= stock;

        let feedback = cantidadInput.parentElement.querySelector('.invalid-feedback');
        if (!esValido) {
            cantidadInput.classList.add('is-invalid');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                cantidadInput.parentElement.appendChild(feedback);
            }
            feedback.textContent = 'Stock insuficiente para este talle.';
        } else {
            cantidadInput.classList.remove('is-invalid');
            if (feedback) feedback.remove();
        }

        const botonConfirmar = document.getElementById('confirmar-venta');
        if (document.querySelector('.cantidad.is-invalid')) {
            botonConfirmar?.setAttribute('disabled', 'disabled');
        } else {
            botonConfirmar?.removeAttribute('disabled');
        }
    }

    function recalcularTotales() {
        let total = 0;

        document.querySelectorAll('.producto-item').forEach(item => {
            const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(item.querySelector('.precio').value) || 0;
            const descuento = parseFloat(item.querySelector('.descuento').value) || 0;

            let subtotal = (precio * cantidad) - descuento;
            if (subtotal < 0) subtotal = 0;
            total += subtotal;
        });

        totalMostrado.value = `$${total.toFixed(2)}`;

        if (metodoPagoSelect.value === 'efectivo') {
            const pagado = parseFloat(montoPagadoInput.value) || 0;
            const vuelto = pagado - total;
            vueltoText.textContent = vuelto >= 0
                ? `Vuelto: $${vuelto.toFixed(2)}`
                : `Falta: $${Math.abs(vuelto).toFixed(2)}`;
            vueltoText.classList.toggle('text-danger', vuelto < 0);
            vueltoText.classList.toggle('text-success', vuelto >= 0);
        } else {
            vueltoText.textContent = '';
        }
    }
});
