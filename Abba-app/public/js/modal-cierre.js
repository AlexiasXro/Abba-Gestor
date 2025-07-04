document.body.addEventListener('htmx:afterSwap', (event) => {
    if (event.target.id === 'cliente_id') {
        const modalEl = document.getElementById('modalNuevoCliente');
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }
        const form = document.getElementById('formNuevoCliente');
        if (form) form.reset();
    }
});
