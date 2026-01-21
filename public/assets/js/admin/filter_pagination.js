document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.filters-container');
    const tableContainer = document.getElementById('table-container');

    // Helper to fetch data for table updates
    function fetchData(url) {
        if (!tableContainer) return;

        const headers = new Headers();
        headers.append('X-Requested-With', 'XMLHttpRequest');

        tableContainer.style.opacity = '0.5';

        fetch(url, { headers: headers })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                tableContainer.style.opacity = '1';
                attachTableListeners(); // Re-attach listeners for the new content
                window.history.pushState(null, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                tableContainer.style.opacity = '1';
            });
    }

    // Initialize Flatpickr if available and form exists
    if (typeof flatpickr !== 'undefined' && form) {
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
        if (!form) return;
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        fetchData(`${window.location.pathname}?${params.toString()}`);
    }

    // Attach form listeners if form exists
    if (form) {
        const inputs = form.querySelectorAll('select');
        inputs.forEach(input => {
            input.removeAttribute('onchange');
            input.addEventListener('change', triggerFetch);
        });

        const textInputs = form.querySelectorAll('input[type="text"]:not(.datepicker-range)');
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
            // Handle reset button specifically if it triggers submit
            if (e.submitter && e.submitter.type === 'reset') {
                window.location.href = window.location.pathname;
            }
        });

        const resetButton = form.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = window.location.pathname;
            });
        }
    }

    // Attach listeners for Table (Pagination + User Actions)
    function attachTableListeners() {
        if (!tableContainer) return;

        // 1. Pagination
        const paginationLinks = tableContainer.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                fetchData(this.href);
            });
        });

        // 2. User Actions (inside table)
        attachUserActionListeners();
    }

    // User Toggle Status Listener (Block/Unblock)
    function attachUserActionListeners() {
        if (!tableContainer) return;
        const actionButtons = tableContainer.querySelectorAll('.ajax-action-btn');

        actionButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.href;

                // Visual feedback
                const originalText = this.innerText;

                this.innerText = '...';
                this.style.opacity = '0.7';

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.newStatusText) {
                            // Locate the row or status span to update
                            const row = this.closest('tr');
                            const statusSpan = row.querySelector('.badge');
                            if (statusSpan) {
                                statusSpan.className = `badge ${data.newStatusClass}`;
                                statusSpan.innerText = data.newStatusText;
                            }

                            // Update button
                            this.innerText = data.newBtnText;
                            this.style.backgroundColor = data.newBtnClass;
                            this.style.opacity = '1';
                        } else {
                            alert(data.message || 'Error updating status');
                            this.innerText = originalText;
                            this.style.opacity = '1';
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        this.innerText = originalText;
                        this.style.opacity = '1';
                    });
            });
        });
    }

    // Event Approval/Reject Listener (Event Details Page)
    function attachEventActionListeners() {
        const eventButtons = document.querySelectorAll('.ajax-event-action-btn');
        eventButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (!confirm(this.dataset.action === 'approve' ? 'Approve this event?' : 'Reject this event?')) return;

                const url = this.href;
                const originalText = this.innerText;
                this.innerText = 'Processing...';

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hide buttons
                            const btnContainer = this.parentElement;
                            if (btnContainer) btnContainer.style.display = 'none';

                            // Find status badge in header - check specific structure
                            const statusBadge = document.querySelector('.event-header .status-badge');
                            if (statusBadge) {
                                if (this.dataset.action === 'approve') {
                                    statusBadge.className = 'status-badge status-active';
                                    statusBadge.innerText = 'Approved';
                                } else {
                                    statusBadge.className = 'status-badge status-inactive';
                                    statusBadge.innerText = 'Rejected';
                                }
                            }
                        } else {
                            alert(data.message || 'Error processing request');
                            this.innerText = originalText;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        this.innerText = originalText;
                    });
            });
        });
    }

    // Initial Attachments
    attachTableListeners();     // For Pages with Table (Manage Users, All Events, etc.)
    attachEventActionListeners(); // For Event Details Page
});
