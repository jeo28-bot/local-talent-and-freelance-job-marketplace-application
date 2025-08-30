console.log('Hello, Laravel!');

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