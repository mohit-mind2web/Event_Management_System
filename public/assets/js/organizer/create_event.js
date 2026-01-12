document.getElementById('is_paid').addEventListener('change', function () {
    document.getElementById('priceField').style.display = this.checked ? 'grid' : 'none';
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('createEventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let apiUrl = this.getAttribute('data-create-url');
        let alertContainer = document.getElementById('alertContainer');

        // Clear previous alerts
        if (alertContainer) alertContainer.innerHTML = '';

        fetch(apiUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Clear previous errors
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                if (data.status === 201 || data.message === 'Event created successfully') {
                    // Show success message inline
                    if (alertContainer) {
                        alertContainer.innerHTML = '<div class="alert alert-success">Event Created Successfully!</div>';
                    }

                    // Reset the form so they can create another one or just see clean state
                    document.getElementById('createEventForm').reset();

                    // Reset price field visibility
                    document.getElementById('priceField').style.display = 'none';

                    // Scroll to top to see message
                    window.scrollTo(0, 0);

                } else {
                    let errorHtml = '';

                    if (data.messages) {
                        if (typeof data.messages === 'object') {
                            // Validation errors - show on fields
                            for (const [field, message] of Object.entries(data.messages)) {
                                const input = document.querySelector(`[name="${field}"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const feedback = document.createElement('div');
                                    feedback.className = 'invalid-feedback';
                                    feedback.textContent = message;
                                    input.parentNode.appendChild(feedback);
                                }
                            }
                            // Also show a general warning
                            errorHtml = '<div class="alert alert-warning">Please check the highlighted fields.</div>';
                        } else {
                            // General string error
                            errorHtml = `<div class="alert alert-danger">${data.messages}</div>`;
                        }
                    } else if (data.error) {
                        errorHtml = `<div class="alert alert-danger">${data.error}</div>`;
                    } else {
                        errorHtml = '<div class="alert alert-danger">Failed to create event.</div>';
                    }

                    if (alertContainer && errorHtml) {
                        alertContainer.innerHTML = errorHtml;
                        window.scrollTo(0, 0);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (alertContainer) {
                    alertContainer.innerHTML = '<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>';
                    window.scrollTo(0, 0);
                }
            });
    });
});

// Subcategory Fetching
const categorySelect = document.querySelector('select[name="category_id"]');
const subcategorySelect = document.querySelector('select[name="subcategory_id"]');

if (categorySelect) {
    categorySelect.addEventListener('change', function () {
        const categoryId = this.value;
        const subcategoryUrl = `/api/categories/${categoryId}/subcategories`;

        // Reset subcategory dropdown
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        if (categoryId) {
            fetch(subcategoryUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name;
                            subcategorySelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching subcategories:', error));
        }
    });
}
