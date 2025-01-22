

function showModal(modalId, clienteId) {
    // Implement modal functionality here
    console.log(`Showing modal ${modalId} for cliente ${clienteId}`);
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (this.querySelector('[name="eliminar"]')) {
                if (!confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                    e.preventDefault();
                }
            } else if (this.querySelector('[name="suspender"]')) {
                if (!confirm('¿Estás seguro de que quieres suspender este cliente?')) {
                    e.preventDefault();
                }
            }
        });
    });
});
