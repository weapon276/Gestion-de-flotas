
const btnNuevo = document.getElementById('btnNuevo');
const modalNuevo = document.getElementById('modalNuevo');
const btnCerrar = document.getElementById('btnCerrar');
const categoriaSelect = document.getElementById('categoria');
const rutaDetails = document.getElementById('rutaDetails');

// Mostrar el modal
btnNuevo.addEventListener('click', () => {
    modalNuevo.style.display = 'flex';
});

// Cerrar el modal
btnCerrar.addEventListener('click', () => {
    modalNuevo.style.display = 'none';
});

// Cerrar modal al hacer clic fuera de él
window.addEventListener('click', (event) => {
    if (event.target === modalNuevo) {
        modalNuevo.style.display = 'none';
    }
});

// Show/hide Ruta-specific fields based on category selection
categoriaSelect.addEventListener('change', (event) => {
    if (event.target.value === 'ruta') {
        rutaDetails.classList.remove('hidden');
    } else {
        rutaDetails.classList.add('hidden');
    }
});
