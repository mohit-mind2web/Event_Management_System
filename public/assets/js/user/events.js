document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('eventSearch');
    const priceFilter = document.getElementById('priceFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const dateFilter = document.getElementById('dateFilter');
    const resetBtn = document.getElementById('resetFilters');
    const resultsContainer = document.getElementById('events-wrapper');

    let debounceTimer;

    // Initialize filters from URL
    const params = new URLSearchParams(window.location.search);
    if (searchInput && params.has('q')) {
        searchInput.value = params.get('q');
    }
    if (priceFilter && params.has('price')) {
        priceFilter.value = params.get('price');
    }
    if (categoryFilter && params.has('category')) {
        categoryFilter.value = params.get('category');
    }
    if (dateFilter && params.has('date')) {
        dateFilter.value = params.get('date');
    }

    function fetchEvents() {
        const query = searchInput.value;
        const price = priceFilter.value;
        const category = categoryFilter.value;
        const date = dateFilter.value;

        // Use window.location.href to maintain base URL and params
        const url = new URL(window.location.href);
        if (query) url.searchParams.set('q', query); else url.searchParams.delete('q');
        if (price) url.searchParams.set('price', price); else url.searchParams.delete('price');
        if (category) url.searchParams.set('category', category); else url.searchParams.delete('category');
        if (date) url.searchParams.set('date', date); else url.searchParams.delete('date');

        // Reset to page 1 when filtering
        url.searchParams.delete('page');
        // Update browser URL 
        window.history.pushState({}, '', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                resultsContainer.innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    }

    // Debounce search input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchEvents, 300);
        });
    }

    if (priceFilter) priceFilter.addEventListener('change', fetchEvents);
    if (categoryFilter) categoryFilter.addEventListener('change', fetchEvents);
    if (dateFilter) dateFilter.addEventListener('change', fetchEvents);

    // Reset Button Logic
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            searchInput.value = '';
            priceFilter.value = '';
            categoryFilter.value = '';
            dateFilter.value = '';
            fetchEvents();
        });
    }

    // Handle pagination clicks
    if (resultsContainer) {
        resultsContainer.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                const url = e.target.href;

                // Push state for pagination too
                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        resultsContainer.innerHTML = html;
                        const container = document.querySelector('.event-container');
                        if (container) container.scrollIntoView({ behavior: 'smooth' });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }

    // Handle Back Button
    window.addEventListener('popstate', function () {
        window.location.reload();
    });
});
