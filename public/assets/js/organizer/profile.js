document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editProfileModal');
    const updateBtn = document.getElementById('updateProfileBtn');
    const closeBtn = document.querySelector('.close');

    // Open Modal
    if (updateBtn) {
        updateBtn.onclick = function () {
            modal.style.display = "block";
            // Add slight delay for animation
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }
    }

    // Close Modal Function
    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }

    // Close on X click
    if (closeBtn) {
        closeBtn.onclick = closeModal;
    }

    // Close on click outside
    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }
});
