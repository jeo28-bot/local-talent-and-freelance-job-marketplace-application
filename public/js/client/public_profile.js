document.addEventListener("DOMContentLoaded", () => {   
     // big preview main image when clicked JS
        const bigPreview2 = document.getElementById('bigPreview');
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeImageModal = document.getElementById('closeImageModal');

        // When big preview is clicked -> open modal
        bigPreview2.addEventListener('click', () => {
            modalImage.src = bigPreview2.src;
            imageModal.classList.remove('hidden');
        });

        // Close modal when close button clicked
        closeImageModal.addEventListener('click', () => {
            imageModal.classList.add('hidden');
        });

        // Close modal when clicking outside the image
        imageModal.addEventListener('click', (e) => {
            if (e.target === imageModal) {
                imageModal.classList.add('hidden');
            }
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