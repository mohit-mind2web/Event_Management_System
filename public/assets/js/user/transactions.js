document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const resetBtn = document.getElementById('resetFilters');
    const resultsContainer = document.getElementById('transactions-wrapper');

    // Initialize filters from URL
    const params = new URLSearchParams(window.location.search);
    if (statusFilter && params.has('status')) {
        statusFilter.value = params.get('status');
    }
    if (dateFilter && params.has('date')) {
        dateFilter.value = params.get('date');
    }

    function fetchTransactions() {
        const status = statusFilter.value;
        const date = dateFilter.value;

        const url = new URL(window.location.href);
        if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
        if (date) url.searchParams.set('date', date); else url.searchParams.delete('date');

        url.searchParams.delete('page');

        // Update browser URL (Persistence enabled)
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

    if (statusFilter) statusFilter.addEventListener('change', fetchTransactions);
    if (dateFilter) dateFilter.addEventListener('change', fetchTransactions);

    // Reset Button Logic
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            statusFilter.value = '';
            dateFilter.value = '';
            fetchTransactions();
        });
    }

    // Handle pagination clicks
    if (resultsContainer) {
        resultsContainer.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                const url = e.target.href;

                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        resultsContainer.innerHTML = html;
                        document.querySelector('.payment-container').scrollIntoView({ behavior: 'smooth' });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }

    window.addEventListener('popstate', function () {
        window.location.reload();
    });
});
