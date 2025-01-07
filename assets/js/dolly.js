const modalNuevoDolly = document.getElementById('modalNuevoDolly');
const modalCambiarEstado = document.getElementById('modalCambiarEstado');
const btnNuevoDolly = document.getElementById('btnNuevoDolly');
const closeBtns = document.getElementsByClassName('close');

btnNuevoDolly.onclick = function() {
    modalNuevoDolly.style.display = "block";
}

for (let closeBtn of closeBtns) {
    closeBtn.onclick = function() {
        modalNuevoDolly.style.display = "none";
        modalCambiarEstado.style.display = "none";
    }
}

window.onclick = function(event) {
    if (event.target == modalNuevoDolly) {
        modalNuevoDolly.style.display = "none";
    }
    if (event.target == modalCambiarEstado) {
        modalCambiarEstado.style.display = "none";
    }
}

// Handle form submissions
document.getElementById('formNuevoDolly').onsubmit = function(e) {
    e.preventDefault();
    // Add code here to handle form submission (e.g., AJAX request)
    console.log('Nuevo Dolly form submitted');
    modalNuevoDolly.style.display = "none";
}

document.getElementById('formCambiarEstado').onsubmit = function(e) {
    e.preventDefault();
    // Add code here to handle form submission (e.g., AJAX request)
    console.log('Cambiar Estado form submitted');
    modalCambiarEstado.style.display = "none";
}

// Handle edit and change state buttons
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.onclick = function() {
        const dollyId = this.getAttribute('data-id');
        console.log('Edit Dolly ID:', dollyId);
        // Add code here to handle editing (e.g., open edit modal)
    }
});

document.querySelectorAll('.change-state-btn').forEach(btn => {
    btn.onclick = function() {
        const dollyId = this.getAttribute('data-id');
        document.getElementById('dollyId').value = dollyId;
        modalCambiarEstado.style.display = "block";
    }
});

// Búsqueda en tiempo real
const searchInput = document.querySelector('.search-input');
let searchTimeout;

searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        window.location.href = `?search=${e.target.value}&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>`;
    }, 500);
});

// Ordenamiento por columnas
document.querySelectorAll('th[data-sort]').forEach(th => {
    th.addEventListener('click', () => {
        const sortBy = th.dataset.sort;
        const currentOrder = new URLSearchParams(window.location.search).get('order') || 'DESC';
        const newOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';
        window.location.href = `?sort=${sortBy}&order=${newOrder}&search=<?php echo urlencode($search); ?>`;
    });
});
