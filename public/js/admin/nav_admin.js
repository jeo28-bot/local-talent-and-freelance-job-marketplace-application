
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

// Hide nav when modal background is clicked
modalBg.addEventListener('click', () => {
    vertNav.classList.add('hidden');
    modalBg.classList.add('hidden');
});

// Toggle nav when hamburger clicked
hamburger_button.addEventListener('click', () => {
    const isHidden = vertNav.classList.contains('hidden');

    vertNav.classList.toggle('hidden');

    if (isHidden) {
        // menu is now open
        modalBg.classList.remove('hidden');
    } else {
        // menu is now closed
        modalBg.classList.add('hidden');
    }
});

window.addEventListener('resize', () => {
  if (window.innerWidth >= 1024) {
    // desktop: show nav, hide modal
    vertNav.classList.remove('hidden');
    modalBg.classList.add('hidden');
  } else {
    // mobile: hide nav + modal initially (optional)
    vertNav.classList.add('hidden');
    modalBg.classList.add('hidden');
  }
});