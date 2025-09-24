document.addEventListener("DOMContentLoaded", () => {
    const cancelModal = document.getElementById("cancel_application_modal");
    const closeBtn = document.getElementById("close_cancel_application_button");
    const form = document.getElementById("confirm_cancel_application_form");

    // Open modal and set form action
    document.querySelectorAll(".open_cancel_application_modal").forEach(button => {
        button.addEventListener("click", () => {
            const appId = button.dataset.id;
            form.action = `/applications/${appId}/cancel`;
            cancelModal.classList.remove("hidden");
        });
    });

    // Close modal
    closeBtn.addEventListener("click", () => {
        cancelModal.classList.add("hidden");
    });

    const modal = document.getElementById("delete_job_applied_warning");
    const cancelBtn = document.getElementById("cancel_delete_applied_button");
    const confirmForm = document.getElementById("confirm_delete_applied_form");

    // Open modal
    document.querySelectorAll(".open-delete-job-applied-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            const applicationId = btn.getAttribute("data-id");
            confirmForm.setAttribute("action", `/job-applications/${applicationId}`);
            modal.classList.remove("hidden");
        });
    });

    // Close modal
    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // view applied modal JS
    document.querySelectorAll('.open-view-applied').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('modalFullName').value = button.dataset.fullname;
        document.getElementById('modalEmail').value = button.dataset.email;
        document.getElementById('modalPhoneNum').value = button.dataset.phone;
        document.getElementById('modalMessage').value = button.dataset.message;

        document.getElementById('view_applied_modal').classList.remove('hidden');
                });
            });

            document.querySelectorAll('.close_applied_modal').forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('view_applied_modal').classList.add('hidden');
                });
            });

});
