document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('statusFilter');
    const paymentFilter = document.getElementById('paymentFilter');
    const resetBtn = document.getElementById('resetFilters');
    const resultsContainer = document.getElementById('registrations-wrapper');

    // Initialize filters from URL
    const params = new URLSearchParams(window.location.search);
    if (statusFilter && params.has('status')) {
        statusFilter.value = params.get('status');
    }
    if (paymentFilter && params.has('payment_status')) {
        paymentFilter.value = params.get('payment_status');
    }

    function fetchRegistrations() {
        const status = statusFilter.value;
        const paymentStatus = paymentFilter.value;

        const url = new URL(window.location.href);
        if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
        if (paymentStatus) url.searchParams.set('payment_status', paymentStatus); else url.searchParams.delete('payment_status');

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

    if (statusFilter) statusFilter.addEventListener('change', fetchRegistrations);
    if (paymentFilter) paymentFilter.addEventListener('change', fetchRegistrations);

    // Reset Button Logic
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            statusFilter.value = '';
            paymentFilter.value = '';
            fetchRegistrations();
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
                        document.querySelector('.registrations-container').scrollIntoView({ behavior: 'smooth' });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }

    window.addEventListener('popstate', function () {
        window.location.reload();
    });
});
