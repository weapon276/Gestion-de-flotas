
function searchQuotations() {
    const searchTerm = document.querySelector('.search-input').value.toLowerCase();
    const rows = document.querySelectorAll('.quotations-table tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

function editQuotation(id) {
    console.log('Editing quotation:', id);
    // Implement edit functionality
}

function deleteQuotation(id) {
    if (confirm('¿Está seguro de que desea eliminar este viaje?')) {
        console.log('Deleting quotation:', id);
        // Implement delete functionality
    }
}

function changePage(direction) {
    console.log('Changing page:', direction);
    // Implement pagination functionality
}
