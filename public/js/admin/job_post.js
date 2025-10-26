// job posting cards edit and delete button js
// edit
const editButtons = document.querySelectorAll(".edit_job_button");
const editModal = document.querySelector(".edit_job_modal");
const closeEdit = document.getElementById("close_edit_job");

editButtons.forEach(button => {
    button.addEventListener("click", () => {
        // Show modal
        editModal.classList.remove("hidden");

        // Fill inputs with job data
        editModal.querySelector('#job_title').value = button.dataset.title;
        editModal.querySelector('#job_location').value = button.dataset.location;
        editModal.querySelector('#job_type').value = button.dataset.type;
        editModal.querySelector('#job_pay').value = button.dataset.pay;
        editModal.querySelector('#salary_release').value = button.dataset.salary;
        editModal.querySelector('#skills_required').value = button.dataset.skills;
        editModal.querySelector('#short_description').value = button.dataset.short;
        editModal.querySelector('#full_description').value = button.dataset.full;

        // Store the job ID in hidden input
        let idInput = editModal.querySelector('input[name="job_id"]');
        if (!idInput) {
            idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'job_id';
            editModal.querySelector('form').appendChild(idInput);
        }
        idInput.value = button.dataset.id;

        // ✅ Set form action dynamically
        editModal.querySelector('form').action = `/job-posts/${button.dataset.id}`;
    });
});

// Close modal
closeEdit.addEventListener('click', () => {
    editModal.classList.add("hidden");
});


// handle Save button properly
const saveButton = editModal.querySelector('input[value="Save"]');

if (saveButton) {
    saveButton.addEventListener('click', async (e) => {
        e.preventDefault();

        const form = editModal.querySelector('form');
        const actionUrl = form.action;
        const formData = new FormData(form);

        try {
            const response = await fetch(actionUrl, {
                method: 'POST', // Laravel uses POST with _method=PUT
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                editModal.classList.add('hidden');
                // wait briefly before refreshing
                setTimeout(() => location.reload(), 500);
            } else {
                console.error('Save failed', await response.text());
            }
        } catch (error) {
            console.error('Error saving:', error);
        }
    });
}

const deleteModal = document.getElementById('delete_job_warning');
const cancelDeleteBtn = document.getElementById('cancel_delete_applicant');
const confirmDeleteBtn = document.getElementById('delete_applicant');
let selectedForm = null;

// open modal
document.querySelectorAll('.open-delete-modal').forEach(btn => {
    btn.addEventListener('click', () => {
        selectedForm = btn.closest('.delete-job-form');
        deleteModal.classList.remove('hidden');
    });
});

// cancel delete
cancelDeleteBtn.addEventListener('click', () => {
    deleteModal.classList.add('hidden');
    selectedForm = null;
});

// confirm delete
confirmDeleteBtn.addEventListener('click', () => {
    if (selectedForm) {
        selectedForm.submit();
    }
});