<script>
    document.addEventListener("DOMContentLoaded", function () {
        const metodoPago = document.getElementById("metodo_pago");
        const modalTipoPago = document.getElementById("modal-tipo-pago");

        // contenedores
        const cuotas = document.getElementById("cuotas-container");
        const resumenCuotas = document.getElementById("resumen-cuotas");
        const montoEntregado = document.getElementById("monto-entregado-container");
        const tipoTarjeta = document.getElementById("tipo-tarjeta-container");
        const numeroOperacion = document.getElementById("numero-operacion-container");

        // inputs
        const montoPagado = document.getElementById("monto_pagado");
        const vueltoText = document.getElementById("vuelto-text");
        const totalModal = document.getElementById("total-modal"); // asegúrate de tener este span con el total

        metodoPago.addEventListener("change", function () {
            let value = this.value;
            modalTipoPago.textContent = this.options[this.selectedIndex].text;

            // ocultar todo primero
            cuotas.classList.add("d-none");
            resumenCuotas.classList.add("d-none");
            montoEntregado.classList.add("d-none");
            tipoTarjeta.classList.add("d-none");
            numeroOperacion.classList.add("d-none");
            vueltoText.textContent = "";

            // mostrar según pago
            if (value === "efectivo") {
                montoEntregado.classList.remove("d-none");
            } else if (value === "tarjeta") {
                tipoTarjeta.classList.remove("d-none");
                numeroOperacion.classList.remove("d-none");
            } else if (value === "transferencia") {
                numeroOperacion.classList.remove("d-none");
            } else if (value === "cuotas") {
                cuotas.classList.remove("d-none");
                resumenCuotas.classList.remove("d-none");
            }
        });

        // calcular vuelto en efectivo
        montoPagado.addEventListener("input", function () {
            let total = parseFloat(totalModal.textContent.replace(/[^0-9.-]+/g, "")) || 0;
            let pagado = parseFloat(this.value) || 0;
            let vuelto = pagado - total;

            if (pagado === 0) {
                vueltoText.textContent = "";
                return;
            }

            if (vuelto < 0) {
                vueltoText.textContent = `Faltan $${Math.abs(vuelto).toFixed(2)}`;
                vueltoText.classList.remove("text-success");
                vueltoText.classList.add("text-danger");
            } else {
                vueltoText.textContent = `Vuelto: $${vuelto.toFixed(2)}`;
                vueltoText.classList.remove("text-danger");
                vueltoText.classList.add("text-success");
            }
        });
    });
</script>
<div class="modal fade" id="modal-detalle-pago" tabindex="-1" aria-labelledby="modalDetallePagoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detalle de Pago - <span id="modal-tipo-pago">Seleccionar</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <!-- Tabla resumen productos -->
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Talle</th>
                            <th>Cant.</th>
                            <th>Precio</th>
                            <th>Desc. $</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="detalle-pago-modal">
                        <!-- JS agrega los productos -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total</th>
                            <th id="total-modal">$0.00</th>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <!-- FORMULARIO CUOTAS -->
                <div id="cuotas-container" class="d-none">
                    <div class="row">
                        <div class="col-6">
                            <label for="entrega_inicial" class="form-label">Entrega Inicial</label>
                            <input type="number" class="form-control" name="entrega_inicial" id="entrega_inicial"
                                min="0" step="0.01">
                        </div>
                        <div class="col-6">
                            <label for="cantidad_cuotas" class="form-label">Cantidad de
                                Cuotas</label>
                            <input type="number" class="form-control" name="cantidad_cuotas" id="cantidad_cuotas"
                                min="1" value="2">
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DE CUOTAS -->
                <div id="resumen-cuotas" class="mt-3 d-none">
                    <div class="alert alert-info p-2">
                        <strong>Resumen:</strong><br>
                        Entrega Inicial: <span id="resumen-entrega">$0.00</span><br>
                        Cuota Final: <span id="resumen-cuota-final">$0.00</span><br>
                        Total Venta: <span id="resumen-total">$0.00</span>
                    </div>
                </div>

                <!-- Monto entregado (efectivo) -->
                <div class="mb-3 d-none" id="monto-entregado-container">
                    <label for="monto_pagado" class="form-label">Monto Entregado</label>
                    <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" min="0" step="0.01"
                        value="0">
                    <small id="vuelto-text" class="form-text"></small>
                </div>


                <!-- Tipo de tarjeta -->
                <div class="mb-3 d-none" id="tipo-tarjeta-container">
                    <label for="tipo_tarjeta" class="form-label">Tipo de Tarjeta</label>
                    <select class="form-select" id="tipo_tarjeta" name="tipo_tarjeta">
                        <option value="">-- Seleccionar tipo --</option>
                        <option value="debito">Débito</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>

                <!-- Número de operación -->
                <div class="mb-3 d-none" id="numero-operacion-container">
                    <label for="numero_operacion" class="form-label">Número de Operación</label>
                    <input type="text" class="form-control" id="numero_operacion" name="numero_operacion"
                        maxlength="50">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Registrar Venta</button>
            </div>
        </div>
    </div>
</div>