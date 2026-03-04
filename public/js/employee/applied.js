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

    document.querySelectorAll('.open-view-applied').forEach(button => {
        button.addEventListener('click', () => {
            const ds = button.dataset;

            // populate fields
            document.getElementById('modalFullName').value = ds.fullname;
            document.getElementById('modalEmail').value = ds.email;
            document.getElementById('modalPhoneNum').value = ds.phone;
            document.getElementById('modalMessage').value = ds.message;

            // populate documents
            const documentsContainer = document.getElementById('applied_documents');
            documentsContainer.innerHTML = ""; // clear previous

            let documents = {};
            try {
                documents = ds.documents ? JSON.parse(ds.documents) : {};
            } catch (e) {
                console.error("Failed to parse documents JSON", e);
            }

            const keys = Object.keys(documents);
            keys.forEach(key => {
                const value = documents[key];
                if (value && value.trim() !== "") {
                    const div = document.createElement("div");
                    div.classList.add("doc_item");
                    div.innerHTML = `<strong>${key.charAt(0).toUpperCase() + key.slice(1)}:</strong> 
                        <a href="/storage/${value}" target="_blank" class="text-blue-600 underline">${value.split('/').pop()}</a>`;
                    documentsContainer.appendChild(div);
                }
            });

            if (!documentsContainer.hasChildNodes()) {
                documentsContainer.innerHTML = "<em>No documents submitted.</em>";
            }

            // show modal
            document.getElementById('view_applied_modal').classList.remove('hidden');
        });
    });

    document.querySelectorAll('.close_applied_modal').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('view_applied_modal').classList.add('hidden');
        });
    });

});
