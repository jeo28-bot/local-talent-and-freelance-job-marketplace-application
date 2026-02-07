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




window.addEventListener('beforeunload', async () => {
    await fetch('/user-status-offline', {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });
});


