
import Echo from "laravel-echo";
window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});


document.querySelectorAll("#faq-container details").forEach((detail) => {
    detail.addEventListener("toggle", function () {
      if (this.open) {
        document.querySelectorAll("#faq-container details").forEach((el) => {
          if (el !== this && el.open) {
            el.open = false; // Close others
          }
        });
      }
    });
  });

// employee page js
let hamburger = document.querySelector(".hamburger_menu");
let close_nav_menu = document.querySelector(".close_nav_menu");
let popMenu = document.querySelector(".hamburger_pop_menu");
const menuContent = popMenu.querySelector("div");

hamburger.addEventListener("click", function() {
  console.log("hamburger menu clicked");
  popMenu.classList.remove("hidden");
});

close_nav_menu.addEventListener("click", function() {
  console.log("close menu clicked");
  popMenu.classList.add("hidden");
});

popMenu.addEventListener("click", (e) => {
  if (!menuContent.contains(e.target)) {
    popMenu.classList.add("hidden");
  }
});

// quick apply modal
let quick_apply_modal = document.querySelector('.quick_apply_modal');
let quick_apply_button = document.querySelector('#quick_apply_button');
let close_quick_apply = document.querySelector('#close_quick_apply');

quick_apply_button.addEventListener('click', () => {
  quick_apply_modal.classList.remove('hidden'); // show modal
  console.log('quick apply clicked');
});

close_quick_apply.addEventListener('click', () => {
  quick_apply_modal.classList.add('hidden'); // hide modal
  console.log('quick apply closed');
});

// report job modal
let report_job = document.querySelector('#report_job');
let report_modal = document.querySelector('.report_modal')
let close_report_modal = document.querySelector('#close_report_modal')

report_job.addEventListener('click', ()=>{
  console.log('report job clicked');
  report_modal.classList.remove('hidden')
})

close_report_modal.addEventListener('click', ()=>{
  console.log('report job clicked');
  report_modal.classList.add('hidden')
})




