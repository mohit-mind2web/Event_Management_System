document.getElementById('is_paid').addEventListener('change', function () {
    document.getElementById('priceField').style.display = this.checked ? 'grid' : 'none';
});

document.addEventListener('DOMContentLoaded', function () {

    // Subcategory Loading Logic (Specific for Edit to handle pre-selection)
    const categorySelect = document.querySelector('select[name="category_id"]');
    const subcategorySelect = document.querySelector('select[name="subcategory_id"]');

    // Helper to load subcategories
    function loadSubcategories(categoryId, selectedId = null) {
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        if (!categoryId) return;

        fetch(`/api/categories/${categoryId}/subcategories`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
                        if (selectedId && sub.id == selectedId) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching subcategories:', error));
    }

    // Initial Load
    if (categorySelect.value) {
        loadSubcategories(categorySelect.value, subcategorySelect.getAttribute('data-selected'));
    }

    // On Change
    categorySelect.addEventListener('change', function () {
        loadSubcategories(this.value);
    });


    // Form Submission
    document.getElementById('editEventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let updateUrl = this.getAttribute('data-update-url');
        let alertContainer = document.getElementById('alertContainer');

        // Clear previous alerts
        if (alertContainer) alertContainer.innerHTML = '';

        fetch(updateUrl, {
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

                if (data.status === 200 || data.message === 'Event updated successfully') { // 200 OK for update
                    // Show success message inline
                    if (alertContainer) {
                        alertContainer.innerHTML = '<div class="alert alert-success">Event Updated Successfully! Redirecting...</div>';
                    }
                    window.scrollTo(0, 0);

                    // Redirect after short delay
                    setTimeout(() => {
                        window.location.href = '/organizer/myevents';
                    }, 1500);

                } else {
                    let errorHtml = '';

                    if (data.messages) {
                        if (typeof data.messages === 'object') {
                            // Validation errors
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
                            errorHtml = '<div class="alert alert-warning">Please check the highlighted fields.</div>';
                        } else {
                            errorHtml = `<div class="alert alert-danger">${data.messages}</div>`;
                        }
                    } else if (data.error) {
                        errorHtml = `<div class="alert alert-danger">${data.error}</div>`;
                    } else {
                        errorHtml = '<div class="alert alert-danger">Failed to update event.</div>';
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
