document.addEventListener("DOMContentLoaded", () => {
    console.log('profile JS connected')
    let edit_details_button = document.querySelector('.edit_details_button')
    let close_edit_user_details = document.querySelector('#close_edit_user_details')
    let edit_user_details_modal = document.querySelector('.edit_user_details_modal')


    edit_details_button.addEventListener('click', ()=>{
        edit_user_details_modal.classList.remove('hidden');
    })
    close_edit_user_details.addEventListener('click', ()=>{
        edit_user_details_modal.classList.add('hidden');
    })

    let edit_skills_button = document.querySelector('#edit_skills_button')
    let cancel_skill_edit = document.querySelector('#cancel_skill_edit')
    let edit_skills_modal = document.querySelector('.edit_skills_modal')

    edit_skills_button.addEventListener('click', ()=>{
        edit_skills_modal.classList.remove('hidden')
    })
    cancel_skill_edit.addEventListener('click', ()=>{
    edit_skills_modal.classList.add('hidden') 
    })

    let profile_pic_clicked = document.querySelector('.profile_pic_clicked')
    let profile_pic_modal = document.querySelector('.profile_pic_modal')
    let close_profile_pic_modal = document.querySelector('#close_profile_pic_modal')

    profile_pic_clicked.addEventListener('click',()=>{
        profile_pic_modal.classList.remove('hidden')
    })

    close_profile_pic_modal.addEventListener('click',()=>{
        profile_pic_modal.classList.add('hidden')
    })

    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    fileInput.addEventListener('change', () => {
        fileList.innerHTML = ''; // clear old list
        Array.from(fileInput.files).forEach((file, index) => {
        const li = document.createElement('li');
        li.className = "flex items-center justify-between bg-gray-100 px-3 py-2 rounded-lg";

        li.innerHTML = `
            <span class="text-gray-700 text-sm">${file.name}</span>
            <button type="button" data-index="${index}" 
            class="text-red-500 hover:text-red-700 font-bold">x</button>
        `;

        fileList.appendChild(li);
        });

        // Add delete functionality
        fileList.querySelectorAll("button").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const index = e.target.getAttribute("data-index");
            removeFile(index);
        });
        });
    });

    function removeFile(index) {
        const dt = new DataTransfer();
        const files = fileInput.files;

        Array.from(files).forEach((file, i) => {
        if (i != index) dt.items.add(file); // keep all except removed one
        });

        fileInput.files = dt.files; // update input
        fileInput.dispatchEvent(new Event('change')); // re-render list
    }

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', () => {
        imagePreview.innerHTML = ''; // clear previews
        Array.from(imageInput.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrapper = document.createElement('div');
            wrapper.className = "relative w-24 h-24";

            wrapper.innerHTML = `
            <img src="${e.target.result}" 
                class="w-full h-full object-cover rounded-lg shadow" />
            <button type="button" data-index="${index}" 
                class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 
                    flex items-center justify-center rounded-full text-xs 
                    hover:bg-red-600">x</button>
            `;

            imagePreview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
        });

        // Delete functionality
        setTimeout(() => {
        imagePreview.querySelectorAll("button").forEach(btn => {
            btn.addEventListener("click", (e) => {
            const index = e.target.getAttribute("data-index");
            removeImage(index);
            });
        });
        }, 100);
    });

    function removeImage(index) {
        const dt = new DataTransfer();
        const files = imageInput.files;

        Array.from(files).forEach((file, i) => {
        if (i != index) dt.items.add(file); // keep all except removed one
        });

        imageInput.files = dt.files; // update input
        imageInput.dispatchEvent(new Event('change')); // refresh previews
    }

    // credentials modal JS
    let edit_credentials = document.querySelector('#edit_credentials')
    let ceredential_uploads_modal = document.querySelector('#ceredential_uploads_modal')
    let close_credential_upload = document.querySelector('#close_credential_upload')

    edit_credentials.addEventListener('click',()=>{
        ceredential_uploads_modal.classList.remove('hidden')
    })
    close_credential_upload.addEventListener('click',()=>{
        ceredential_uploads_modal.classList.add('hidden')
    })

    // delete file upload JS
    const modal = document.getElementById("delete_file_warning");
    const cancelBtn = document.getElementById("cancel_delete_file");
    const deleteForm = document.getElementById("confirm_delete_file_form");

    // Open modal
    document.querySelectorAll(".open-delete-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            const url = btn.getAttribute("data-url");
            deleteForm.setAttribute("action", url);
            modal.classList.remove("hidden");
        });
    });

    // Close modal
    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // image upload clicked image main display JS
    const thumbnails = document.querySelectorAll('.thumbnail');
        const bigPreview = document.getElementById('bigPreview');
        const deleteBtn = document.getElementById('deleteImageBtn');
        const delelte_modal = document.getElementById('delete_image_warning');
        const delelte_cancelBtn = document.getElementById('cancel_delete_image');
        const delete_deleteForm = document.getElementById('confirm_delete_image_form');

        let currentId = thumbnails[0]?.dataset.id || null; // default to first image

        // when thumbnail clicked -> update big preview + currentId
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => {
                bigPreview.src = thumb.src;
                currentId = thumb.dataset.id;
            });
        });

        // open delelte_modal when delete button clicked
        deleteBtn.addEventListener('click', () => {
            if (!currentId) return;
            delelte_modal.classList.remove('hidden');
            // set form action dynamically
            delete_deleteForm.action = `/profile/uploads/${currentId}`;
        });

        // cancel delelte_modal
        delelte_cancelBtn.addEventListener('click', () => {
            delelte_modal.classList.add('hidden');
        });
    
    
});