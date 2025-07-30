<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('detalles-container');
    const btnAdd = document.getElementById('btn-add-detalle');

    btnAdd.addEventListener('click', function () {
        const detalles = container.querySelectorAll('.detalle');
        const lastDetalle = detalles[detalles.length - 1];
        const newIndex = detalles.length;
        const newDetalle = lastDetalle.cloneNode(true);

        newDetalle.setAttribute('data-index', newIndex);

        newDetalle.querySelectorAll('select').forEach(select => {
            select.name = select.name.replace(/\d+/, newIndex);
            select.value = '';
        });

        newDetalle.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\d+/, newIndex);
            input.value = '';
        });

        const btnRemove = newDetalle.querySelector('.btn-remove-detalle');
        btnRemove.style.display = 'inline-block';
        btnRemove.onclick = () => {
            newDetalle.remove();
            actualizarIndices();
        };

        container.appendChild(newDetalle);
    });

    container.querySelectorAll('.btn-remove-detalle').forEach(btn => {
        btn.style.display = 'inline-block';
        btn.onclick = () => {
            btn.closest('.detalle').remove();
            actualizarIndices();
        }
    });

    function actualizarIndices() {
        const detalles = container.querySelectorAll('.detalle');
        detalles.forEach((detalle, index) => {
            detalle.setAttribute('data-index', index);
            detalle.querySelectorAll('select').forEach(select => {
                select.name = select.name.replace(/\d+/, index);
            });
            detalle.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, index);
            });
        });
    }
});
</script>
