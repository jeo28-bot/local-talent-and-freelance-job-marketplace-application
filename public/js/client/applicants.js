document.addEventListener("DOMContentLoaded", () => {
 const viewButtons = document.querySelectorAll(".view_applicant_button");
  const modal = document.getElementById("view_applicant");
  const closeBtns = document.querySelectorAll(".close_view_applicant");

  const usernameEl = document.getElementById("applicant_username");
  const jobTitleEl = document.getElementById("applicant_job_title");
  const statusEl   = document.getElementById("applicant_status");
  const fullnameEl = document.getElementById("applicant_fullname");
  const emailEl    = document.getElementById("applicant_email");
  const phoneEl    = document.getElementById("applicant_phone");
  const messageEl  = document.getElementById("applicant_message");
  const documentsContainer = document.getElementById("applicant_documents");

  const setText = (el, text) => { if (el) el.textContent = text ?? "—"; };

  viewButtons.forEach(btn => {
      btn.addEventListener("click", () => {
          const ds = btn.dataset;

          setText(usernameEl, ds.username);
          setText(jobTitleEl, ds.jobtitle);
          setText(fullnameEl, ds.fullname);
          setText(emailEl, ds.email);
          setText(phoneEl, ds.phone);
          setText(messageEl, ds.message);

          // Status coloring
          if (statusEl) {
              const s = (ds.status || "").toLowerCase();
              statusEl.textContent = s ? s.charAt(0).toUpperCase() + s.slice(1) : "—";
              statusEl.classList.remove("text-green-500","text-red-500","text-orange-500","text-gray-600");
              if (s === "accepted") statusEl.classList.add("text-green-500");
              else if (s === "rejected") statusEl.classList.add("text-red-500");
              else if (s === "pending") statusEl.classList.add("text-orange-500");
              else statusEl.classList.add("text-gray-600");
          }

          // Populate documents
          documentsContainer.innerHTML = ""; // clear previous
          let docs = {};
          try {
              docs = JSON.parse(ds.documents);
          } catch(e) {
              console.error("Invalid documents JSON", e);
          }

          if (Object.keys(docs).length > 0) {
              for (let type in docs) {
                  const path = docs[type];
                  const div = document.createElement("div");
                  div.classList.add("doc_item");
                  div.innerHTML = `<strong>${type.charAt(0).toUpperCase() + type.slice(1)}:</strong>
                      <a href="/storage/${path}" target="_blank" class="text-blue-600 underline">
                          ${path.split('/').pop()}
                      </a>`;
                  documentsContainer.appendChild(div);
              }
          } else {
              documentsContainer.innerHTML = "<em>No documents submitted.</em>";
          }

          // Show modal
          if (modal) modal.classList.remove("hidden");
      });
  });

  // Optional: Close modal
  closeBtns.forEach(btn => {
      btn.addEventListener("click", () => {
          if (modal) modal.classList.add("hidden");
      });
  });

  // click outside modal content to close (backdrop)
  if (modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) modal.classList.add("hidden");
    });
  }

  // Escape key to close
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal && !modal.classList.contains("hidden")) {
      modal.classList.add("hidden");
    }
  });

  
    const delete_job_warning = document.getElementById("delete_job_warning");
    const cancelBtn = document.getElementById("cancel_delete_applicant");
    const confirmBtn = document.getElementById("delete_applicant");

    let formToSubmit = null; // store form reference

    // Open modal
    document.querySelectorAll(".open-delete-modal").forEach(btn => {
        btn.addEventListener("click", (e) => {
            formToSubmit = e.target.closest("form"); // get the form of clicked delete button
            delete_job_warning.classList.remove("hidden");
        });
    });

    // Cancel
    cancelBtn.addEventListener("click", () => {
        delete_job_warning.classList.add("hidden");
        formToSubmit = null;
    });

    // Confirm delete
    confirmBtn.addEventListener("click", () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

 
    
});
