  // Add event listener to all buttons
  document.querySelectorAll('button[data-target]').forEach(button => {
    button.addEventListener('click', function() {
      const targetId = this.getAttribute('data-target');  // Get the section id
      const targetElement = document.querySelector(targetId);  // Find the target element

      // Smooth scroll to the target element
      targetElement.scrollIntoView({
        behavior: 'smooth',
        block: 'start'  // Scroll the target to the top of the viewport
      });
    });
  });