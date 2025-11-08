
// profile dropwdown toggle JS
const profileDropdown = document.getElementById('profile_dropdown');
const arrowIcon = document.getElementById('arrow_icon');
const dropdown_items = document.getElementById('dropdown_items');

profileDropdown.addEventListener('click', () => {
    // Toggle dropdown visibility
    dropdown_items.classList.toggle('hidden');

    // Toggle the icon’s direction (down ↕ up)
    const path = arrowIcon.querySelector('path');
    const isDown = path.getAttribute('d') === 'm19.5 8.25-7.5 7.5-7.5-7.5';
    path.setAttribute(
        'd',
        isDown
            ? 'm4.5 15.75 7.5-7.5 7.5 7.5' // Up arrow
            : 'm19.5 8.25-7.5 7.5-7.5-7.5' // Down arrow
    );
});


// vert nav links JS
// ----- VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV ----- //
// Get all dropdowns and arrows globally
const allDropdowns = document.querySelectorAll('.dropdown_items');
const allArrows = document.querySelectorAll('[id$="_arrow"]');
const allNavLinks = document.querySelectorAll('.nav_link');

// nav users JS
let nav_users = document.getElementById('nav_users');
let nav_users_arrow = document.getElementById('nav_users_arrow');
let dropdown_users = document.getElementById('dropdown_users')


    nav_users.addEventListener('click', () => {
    // Step 1: Check if this dropdown is currently open
    const isCurrentlyOpen = !dropdown_users.classList.contains('hidden');

    // Step 2: Close all other dropdowns
    allDropdowns.forEach(drop => {
        if (drop !== dropdown_users) drop.classList.add('hidden');
    });

    // Step 3: Reset all arrows to down
    allArrows.forEach(arrow => {
        arrow.querySelector('path').setAttribute(
            'd',
            'm19.5 8.25-7.5 7.5-7.5-7.5'
        );
    });

    // Step 4: Reset all nav active states
    allNavLinks.forEach(link => link.classList.remove('admin_selected_nav'));

    // Step 5: Toggle this dropdown
    dropdown_users.classList.toggle('hidden');

    // Step 6: Toggle arrow direction
    const isHidden = dropdown_users.classList.contains('hidden');
    nav_users_arrow.querySelector('path').setAttribute(
        'd',
        isHidden
            ? 'm19.5 8.25-7.5 7.5-7.5-7.5' // Down arrow
            : 'm4.5 15.75 7.5-7.5 7.5 7.5' // Up arrow
    );

    // Step 7: Only add highlight if dropdown is open
    if (!isCurrentlyOpen) {
        nav_users.classList.add('admin_selected_nav');
    }
});

// nav JobPosts
let nav_jobPosts = document.getElementById('nav_jobPosts');
let nav_jobPosts_arrow = document.getElementById('nav_jobPosts_arrow');
let dropdown_jobPosts = document.getElementById('dropdown_jobPosts')

    nav_jobPosts.addEventListener('click', () => {
    // Step 1: Check if this dropdown is currently open
    const isCurrentlyOpen = !dropdown_jobPosts.classList.contains('hidden');

    // Step 2: Close all other dropdowns
    allDropdowns.forEach(drop => {
        if (drop !== dropdown_jobPosts) drop.classList.add('hidden');
    });

    // Step 3: Reset all arrows to down
    allArrows.forEach(arrow => {
        arrow.querySelector('path').setAttribute(
            'd',
            'm19.5 8.25-7.5 7.5-7.5-7.5'
        );
    });

    // Step 4: Reset all nav active states
    allNavLinks.forEach(link => link.classList.remove('admin_selected_nav'));

    // Step 5: Toggle this dropdown
    dropdown_jobPosts.classList.toggle('hidden');

    // Step 6: Toggle arrow direction
    const isHidden = dropdown_jobPosts.classList.contains('hidden');
    nav_jobPosts_arrow.querySelector('path').setAttribute(
        'd',
        isHidden
            ? 'm19.5 8.25-7.5 7.5-7.5-7.5' // Down arrow
            : 'm4.5 15.75 7.5-7.5 7.5 7.5' // Up arrow
    );

    // Step 7: Only add highlight if dropdown is open
    if (!isCurrentlyOpen) {
        nav_jobPosts.classList.add('admin_selected_nav');
    }
});

const modalBg = document.getElementById('modal_bg');
const vertNav = document.getElementById('vert_nav');
const hamburger_button = document.getElementById('hamburder_button');
const searchIcon = document.getElementById('search_icon'); // give your SVG this ID

function openModal() {
    modalBg.classList.remove('hidden');
    if (searchIcon) searchIcon.style.display = 'none';
}

function closeModal() {
    modalBg.classList.add('hidden');
    if (searchIcon) searchIcon.style.display = 'block';
}

function checkScreenSize() {
    if (window.innerWidth < 1024) {
        vertNav.classList.add('hidden');
        closeModal();
    } else {
        vertNav.classList.remove('hidden');
        closeModal();
    }
}

// 🔥 Hide nav on mobile/tablet when page loads
document.addEventListener('DOMContentLoaded', checkScreenSize);

// Toggle menu
hamburger_button.addEventListener('click', () => {
    const isHidden = vertNav.classList.contains('hidden');
    vertNav.classList.toggle('hidden');
    if (isHidden) openModal();
    else closeModal();
});

// Click outside to close
modalBg.addEventListener('click', () => {
    vertNav.classList.add('hidden');
    closeModal();
});

// Handle resize
window.addEventListener('resize', checkScreenSize);

