document.querySelectorAll('th[data-sort]').forEach(th => {
    th.addEventListener('click', () => {
        const sortBy = th.dataset.sort;
        const isAsc = !th.classList.contains('sorted-asc');
        
        document.querySelectorAll('th').forEach(header => {
            header.classList.remove('sorted-asc', 'sorted-desc');
        });
        
        th.classList.add(isAsc ? 'sorted-asc' : 'sorted-desc');
        

    });
});

const searchInput = document.querySelector('.search-input');
let searchTimeout;

searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {

    }, 500);
});

document.querySelector('.records-per-page select').addEventListener('change', (e) => {

});

document.querySelectorAll('.pagination-controls .page-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!btn.classList.contains('active')) {
            document.querySelector('.page-btn.active').classList.remove('active');
            btn.classList.add('active');
  
        }
    });
});