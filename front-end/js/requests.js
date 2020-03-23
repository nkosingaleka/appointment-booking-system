// Select page elements
const main = document.querySelector('main');
const cancelBtns = document.querySelectorAll('.cancel-btn');
const requestsTable = document.querySelector('table');

// Define array for displaying errors
const errors = [];

/**
 * Displays the pop-up form for the user to provide a reason for cancelling a selected appointment booking request.
 * @param {String} requestToCancel ID of the request to be cancelled.
 */
function showCancellationReasonTextbox(requestToCancel) {
  // Retrieve the selected request element
  const request = document.getElementById(requestToCancel);

  // Define the pop-up cancellation reason form
  const cancellationReasonArea = document.createElement('form');
  cancellationReasonArea.classList.add('cancellation-reason');
  cancellationReasonArea.setAttribute('method', 'POST');
  cancellationReasonArea.setAttribute('action', '');
  cancellationReasonArea.textContent = 'Confirm cancellation?';

  // Validate input when the form is submitted
  cancellationReasonArea.addEventListener('submit', (e) => {
    //Checks if the input exceeds 255 characters
    if (cancellationReasonTextbox.value.length > 255) {
      e.preventDefault();
      errors.push('Please ensure the cancellation reason does not exceed 255 characters.');
    }

    //Checks request ID exists
    if (requestIdInput.value != requestToCancel) {
      e.preventDefault();
      errors.push('Please select an existing appointment booking request.');
    }

    if (errors.length > 0) {
      // If the error list isn't already there
      if (document.querySelector('.error-message') == null) {
        // Create the error list
        const errorList = document.createElement('div');
        const ul = document.createElement('ul');

        errorList.className = 'error-message';

        if (errors.length > 1) {
          // Add the error to the list
          for (const error of errors) {
            const li = document.createElement('li');

            li.textContent = error;

            ul.append(li);
            errorList.append(ul);
          }
        } else {
          const p = document.createElement('p');

          p.textContent = errors[0];

          errorList.append(p);
        }

        main.insertBefore(errorList, requestsTable);
      }
    }
  });

  // Define the hidden field containing the ID of the request to be deleted
  const requestIdInput = document.createElement('input');
  requestIdInput.setAttribute('id', `${requestToCancel}-id`);
  requestIdInput.setAttribute('name', `${requestToCancel}-id`);
  requestIdInput.setAttribute('type', 'hidden');
  requestIdInput.setAttribute('value', request.id);

  // Define the label for the cancellation reason textbox
  const cancellationReasonLabel = document.createElement('label');
  cancellationReasonLabel.setAttribute('for', `${requestToCancel}-reason`);
  cancellationReasonLabel.textContent = 'Cancellation reason (optional)';

  // Define the cancellation reason textbox
  const cancellationReasonTextbox = document.createElement('textarea');
  cancellationReasonTextbox.setAttribute('id', `${requestToCancel}-reason`);
  cancellationReasonTextbox.setAttribute('name', `${requestToCancel}-reason`);

  // Define the button to submit the cancellation reason
  const cancellationReasonConfirm = document.createElement('input');
  cancellationReasonConfirm.setAttribute('name', `${requestToCancel}-reason-submit`);
  cancellationReasonConfirm.setAttribute('type', 'submit');
  cancellationReasonConfirm.setAttribute('value', 'Confirm');

  // Append cancellation reason elements to a pop-up
  cancellationReasonLabel.append(cancellationReasonTextbox);
  cancellationReasonArea.append(cancellationReasonLabel);
  cancellationReasonArea.append(cancellationReasonConfirm);
  cancellationReasonArea.append(requestIdInput);

  // Show the pop-up if it does not already exist
  if (!requestsTable.nextElementSibling || !requestsTable.nextElementSibling.matches('.cancellation-reason')) {
    main.append(cancellationReasonArea);
  }
}

/**
 * Sets up the page once it has fully loaded.
 */
function init() {
  for (const cancelBtn of cancelBtns) {
    const id = cancelBtn.parentElement.parentElement.id;

    cancelBtn.setAttribute('href', `?cancel=${id}`);

    cancelBtn.addEventListener('click', (e) => {
      // Prevent page re-load
      e.preventDefault();

      // Append form for adding cancellation reason
      showCancellationReasonTextbox(id);
    });
  }
}

window.addEventListener('load', init);
