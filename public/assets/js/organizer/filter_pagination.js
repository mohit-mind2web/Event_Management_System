document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.filters-container');
    const tableContainer = document.getElementById('table-container');

    if (!form || !tableContainer) return; // Exit if elements don't exist

    // Function to fetch and update data
    function fetchData(url) {
        // Add AJAX header
        const headers = new Headers();
        headers.append('X-Requested-With', 'XMLHttpRequest');

        fetch(url, { headers: headers })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                attachPaginationListeners();
                window.history.pushState(null, '', url);
            })
            .catch(error => console.error('Error:', error));
    }

    // Initialize Flatpickr
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".datepicker-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2 || selectedDates.length === 0) {
                    triggerFetch();
                }
            }
        });
    }

    function triggerFetch() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        fetchData(`${window.location.pathname}?${params.toString()}`);
    }

    // Handle Form Inputs
    const inputs = form.querySelectorAll('select');
    inputs.forEach(input => {
        input.removeAttribute('onchange'); // Remove inline handlers
        input.addEventListener('change', triggerFetch);
    });

    const textInputs = form.querySelectorAll('input[type="text"]:not(.datepicker)');
    textInputs.forEach(input => {
        let debounceTimer;
        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(triggerFetch, 500);
        });

        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(debounceTimer);
                triggerFetch();
            }
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    // Handle Pagination
    function attachPaginationListeners() {
        const paginationLinks = tableContainer.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                fetchData(this.href);
            });
        });
    }

    attachPaginationListeners();
});
