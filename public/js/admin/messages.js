document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('delete_chat');
        const cancelBtn = document.getElementById('cancel_delete_applicant');
        const confirmDeleteBtn = document.getElementById('delete_applicant');
        let currentForm = null;

        // When the delete button is clicked
        document.querySelectorAll('.openDeleteModal').forEach(btn => {
            btn.addEventListener('click', () => {
                currentForm = btn.closest('form'); // store the correct form
                modal.classList.remove('hidden');
            });
        });

        // Cancel delete
        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            currentForm = null;
        });

        // Confirm delete
        confirmDeleteBtn.addEventListener('click', () => {
            if (currentForm) currentForm.submit();
        });
});