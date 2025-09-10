console.log("employee JS loaded");

// logout clicked
let logout_warning_modal = document.querySelector('#logout_warning_modal');
let logout_button = document.querySelector('#logout');
let close_logout_warning = document.querySelector('#cancel_logout');

logout_button.addEventListener('click', () => {
  logout_warning_modal.classList.remove('hidden'); // show modal
  console.log('logout clicked');
});

close_logout_warning.addEventListener('click', () => {
  logout_warning_modal.classList.add('hidden'); // show modal
  console.log('cancel logout clicked');
});

// edit skills
let edit_skills_button = document.querySelector('#edit_skills');
let edit_skill_modal = document.querySelector('#edit_skill_modal');
let cancel_skill_edit = document.querySelector('#cancel_skill_edit');

edit_skills_button.addEventListener('click', () => {
  console.log('edit skills clicked');
  edit_skill_modal.classList.remove('hidden'); // show modal
});
cancel_skill_edit.addEventListener('click', () => {
  edit_skill_modal.classList.add('hidden'); // hide modal
  console.log('cancel edit skills clicked');
});

// edit credentials
