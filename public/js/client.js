console.log("client JS loaded");




// HOME** post a job modal js
let body = document.querySelector("body");
let post_a_job_btn = document.getElementById("post_a_job");
let post_job_modal = document.querySelector(".post_job_modal");
let close_post_job = document.getElementById("close_post_job");

if (post_a_job_btn && post_job_modal && close_post_job) {
    post_a_job_btn.addEventListener("click", function() {
        post_job_modal.classList.remove("hidden");
        body.classList.add("modal-open");
    });

    close_post_job.addEventListener("click", function() {
        post_job_modal.classList.add("hidden");
        body.classList.remove("modal-open");
    });
}

// profile ** logout js
let logout = document.getElementById("logout");
let logout_warning_modal = document.getElementById("logout_warning_modal");
let cancel_logout = document.getElementById("cancel_logout");

if (logout && logout_warning_modal) {
    logout.addEventListener("click", function() {
        logout_warning_modal.classList.remove("hidden");
        body.classList.add("modal-open");
    });

    cancel_logout.addEventListener("click", function() {
        logout_warning_modal.classList.add("hidden");
        body.classList.remove("modal-open");
    });

    logout_warning_modal.addEventListener("click", function(e) {
        if (e.target === logout_warning_modal) {
            logout_warning_modal.classList.add("hidden");
            body.classList.remove("modal-open");
        }
    });
}



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

// DELETE job
const deleteButtons = document.querySelectorAll(".delete_job_button");
const deleteModal = document.getElementById("delete_job_warning");
const cancelDelete = document.getElementById("cancel_delete_job");
const deleteForm = document.getElementById("delete_job_form");

deleteButtons.forEach(button => {
    button.addEventListener("click", () => {
        const jobId = button.dataset.id;

        // set form action dynamically
        deleteForm.action = `/job-posts/${jobId}`;

        // show modal
        deleteModal.classList.remove("hidden");
    });
});

// cancel close
cancelDelete.addEventListener("click", () => {
    deleteModal.classList.add("hidden");
});





const statusHolders = document.querySelectorAll(".status_holder");
const statusModal = document.getElementById("status_modal");
const closeStatusModal = document.getElementById("close_status_modal");
const modalStatusSpan = statusModal.querySelector("h1 span");
const statusForm = document.getElementById("status_form");


statusHolders.forEach(holder => {
    holder.addEventListener("click", function() {
        const jobId = holder.dataset.id;
        const currentStatus = holder.dataset.status;

        // Set modal status text
        modalStatusSpan.textContent = currentStatus;

        // Apply color based on status
        if (currentStatus === 'open') {
            modalStatusSpan.className = 'text-green-600 font-semibold uppercase'; // replace classes as needed
        } else if (currentStatus === 'close') {
            modalStatusSpan.className = 'text-red-600 font-semibold uppercase';
        } else if (currentStatus === 'pause') {
            modalStatusSpan.className = 'text-gray-600 font-semibold uppercase';
        } else {
            modalStatusSpan.className = 'text-black font-semibold uppercase'; // fallback
        }

        // Open modal
        statusModal.classList.remove("hidden");
        

        // Dynamically set form action
        statusForm.action = `/job-posts/${jobId}/update-status`;
    });
});

closeStatusModal.addEventListener("click", function() {
    statusModal.classList.add("hidden");
});





const statusButtons = statusModal.querySelectorAll(".status_btn");

statusButtons.forEach(btn => {
    btn.addEventListener("click", function() {
        const newStatus = btn.dataset.status;
        const jobId = statusModal.dataset.jobId; // stored when opening modal

        // Update the database via form submission or AJAX
        fetch(`/job-posts/${jobId}/update-status`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // update ONLY the specific job's status span
                const statusSpan = document.querySelector(`.status[data-id='${jobId}']`);
                if(statusSpan) {
                    statusSpan.textContent = newStatus;

                    // optional: update color
                    statusSpan.classList.remove('text-green-600','text-red-600','text-gray-600');
                    if(newStatus === 'open') statusSpan.classList.add('text-green-600');
                    if(newStatus === 'close') statusSpan.classList.add('text-red-600');
                    if(newStatus === 'pause') statusSpan.classList.add('text-gray-600');
                }
                

                // close modal
                statusModal.classList.add("hidden");
            } else {
                alert("Failed to update status.");
            }
        });
    });
});










