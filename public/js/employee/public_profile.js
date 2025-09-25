document.addEventListener("DOMContentLoaded", () => {
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