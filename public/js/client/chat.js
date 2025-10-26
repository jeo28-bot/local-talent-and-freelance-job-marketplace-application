document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('chat_options_btn');
    const menu = document.getElementById('chat_options_menu');

    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // prevent closing instantly
        menu.classList.toggle('hidden');
    });

    // Hide menu when clicking outside
    document.addEventListener('click', () => {
        menu.classList.add('hidden');
    });

    const chatContainer = document.getElementById('chatContainer');

    // scroll to the bottom
    chatContainer.scrollTop = chatContainer.scrollHeight;

    
    
});