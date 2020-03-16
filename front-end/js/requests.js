// Select page elements
const main = document.querySelector('main');
const cancelBtns = document.querySelectorAll('.cancel-btn');

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
  cancellationReasonArea.textContent = 'You may optionally provide a reason for cancelling this appointment booking request.';

  // Define the hidden field containing the ID of the request to be deleted
  const requestIdInput = document.createElement('input');
  requestIdInput.setAttribute('id', `${requestToCancel}-id`);
  requestIdInput.setAttribute('name', `${requestToCancel}-id`);
  requestIdInput.setAttribute('type', 'hidden');
  requestIdInput.setAttribute('value', request.id);

  // Define the label for the cancellation reason textbox
  const cancellationReasonLabel = document.createElement('label');
  cancellationReasonLabel.setAttribute('for', `${requestToCancel}-reason`);
  cancellationReasonLabel.textContent = 'Cancellation Reason';

  // Define the cancellation reason textbox
  const cancellationReasonTextbox = document.createElement('textarea');
  cancellationReasonTextbox.setAttribute('id', `${requestToCancel}-reason`);
  cancellationReasonTextbox.setAttribute('name', `${requestToCancel}-reason`);

  // Define the button to submit the cancellation reason
  const cancellationReasonSubmit = document.createElement('input');
  cancellationReasonSubmit.setAttribute('name', `${requestToCancel}-reason-submit`);
  cancellationReasonSubmit.setAttribute('type', 'submit');
  cancellationReasonSubmit.setAttribute('value', 'Submit');

  // Append cancellation reason elements to a pop-up
  cancellationReasonLabel.append(cancellationReasonTextbox);
  cancellationReasonArea.append(cancellationReasonLabel);
  cancellationReasonArea.append(cancellationReasonSubmit);
  cancellationReasonArea.append(requestIdInput);

  // Show the pop-up if it does not already exist
  if (!request.nextElementSibling) {
    request.after(cancellationReasonArea);
  }
}

/**
 * Sets up the page once it has fully loaded.
 */
function init() {
  for (const cancelBtn of cancelBtns) {
    const id = cancelBtn.parentElement.id;

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
