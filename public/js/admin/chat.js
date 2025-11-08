const wrapper = document.getElementById('chat_options_wrapper');
    const button = document.getElementById('chat_options_btn');
    const menu = document.getElementById('chat_options_menu');

    let menuOpen = false;

    // Hover adds relative
    button.addEventListener('mouseenter', () => {
        if (!menuOpen) wrapper.classList.add('relative');
    });

    // Hover out removes it only if menu not open
    button.addEventListener('mouseleave', () => {
        if (!menuOpen) wrapper.classList.remove('relative');
    });

    // Click toggles dropdown and locks relative
    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menuOpen = !menuOpen;
        wrapper.classList.add('relative');

        if (!menuOpen) wrapper.classList.remove('relative');
    });

    // Click outside closes menu
    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            menu.classList.add('hidden');
            menuOpen = false;
            wrapper.classList.remove('relative');
        }
    });

    // JS for modal delete
    const deleteModal = document.getElementById('delete_chat');
    const openDeleteBtn = document.getElementById('open_delete_modal');
    const cancelDeleteBtn = document.getElementById('cancel_delete_applicant');
    const chatOptionsMenu = document.getElementById('chat_options_menu');

    // 🟥 When clicking "Delete" — open modal & hide dropdown
    openDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.remove('hidden');
        chatOptionsMenu.classList.add('hidden');
    });

    // 🟦 When canceling — close modal & show dropdown again
    cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
        chatOptionsMenu.classList.remove('hidden');
    });

    // makes the scroll all the way to the bottom
    const chatContainer = document.querySelector('#chatContainer');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }