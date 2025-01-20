// Real-time Search
const searchInput = document.querySelector('.search-input');
let searchTimeout;

searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Construct the new URL with search query and sort/order parameters
        window.location.href = `?search=${e.target.value}&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>`;
    }, 500);
});

// Column Sorting
document.querySelectorAll('th[data-sort]').forEach(th => {
    th.addEventListener('click', () => {
        const sortBy = th.dataset.sort;
        const currentOrder = new URLSearchParams(window.location.search).get('order') || 'DESC';
        const newOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';

        // Construct the new URL with the updated sort and order parameters
        window.location.href = `?sort=${sortBy}&order=${newOrder}&search=<?php echo urlencode($search); ?>`;
    });
});