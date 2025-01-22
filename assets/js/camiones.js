
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (this.querySelector('[name="eliminar"]')) {
                if (!confirm('¿Estás seguro de que quieres eliminar este camión?')) {
                    e.preventDefault();
                }
            }
        });
    });
});
