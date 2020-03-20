// Select page elements
const appointmentTypes = document.querySelectorAll('tbody > tr select');

/**
 * Sets up the page once it has fully loaded.
 */
function init() {
  for (const appointmentType of appointmentTypes) {
    // Add appointment type when selected
    appointmentType.addEventListener('change', (e) => {
      appointmentType.parentElement.submit();
    });
  }
}

window.addEventListener('load', init);
