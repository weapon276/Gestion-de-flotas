function toggleLoading(button) {
    const originalContent = button.innerHTML;
    
    button.classList.add('loading');
    button.innerHTML = '<span></span>';
    
    setTimeout(() => {
        button.classList.remove('loading');
        button.innerHTML = originalContent;
    }, 1000);
}

function toggleLoading(button) {
    button.classList.add('loading');
    setTimeout(() => {
        button.classList.remove('loading');
    }, 2000);
}
function openModal(cliente) {
    const modal = document.getElementById('clienteModal');
    const form = document.getElementById('clienteForm');
    const modalTitle = document.getElementById('modalTitle');
    if (cliente) {
        modalTitle.textContent = 'Editando al cliente';
        Object.keys(cliente).forEach(key => {
            const field = document.getElementById(key);
            if (field) {
                field.value = cliente[key];
            }
        });
    } else {
        modalTitle.textContent = 'Nuevo cliente';
        form.reset();
    }
    toggleCreditoFields();
    modal.style.display = 'block';
}
function closeModal() {
    const modal = document.getElementById('clienteModal');
    modal.style.display = 'none';
}
function saveClient() {
    const form = document.getElementById('clienteForm');
    if (form.checkValidity()) {
        const formData = new FormData(form);
        console.log('Saving client:', Object.fromEntries(formData));
        closeModal();
    } else {
        form.reportValidity();
    }
}
function deleteClient(clientId) {
    if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
        console.log('Deleting client:', clientId);
    }
}
function toggleCreditoFields() {
    const tipoCredito = document.getElementById('TipoCredito');
    const lineaCreditoGroup = document.getElementById('lineaCreditoGroup');
    const diasCreditoGroup = document.getElementById('diasCreditoGroup');
    if (tipoCredito.value === 'Limitado') {
        lineaCreditoGroup.style.display = 'block';
        diasCreditoGroup.style.display = 'block';
    } else {
        lineaCreditoGroup.style.display = 'none';
        diasCreditoGroup.style.display = 'none';
    }
}
function searchClients() {
    const searchTerm = document.querySelector('.search-input').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
function changePage(direction) {
    console.log('Changing page:', direction);
}
document.getElementById('TipoCredito').addEventListener('change', toggleCreditoFields);
document.querySelector('.search-input').addEventListener('input', searchClients);
toggleCreditoFields();
