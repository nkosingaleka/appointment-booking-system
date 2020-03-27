const main = document.querySelector('main');
const availabilityForm = document.querySelector('#availability-form');
const startTime = document.querySelector('#start_time');
const endTime = document.querySelector('#end_time');

const errors = [];

availabilityForm.addEventListener('add', (e) => {
    // Check if the inputs are empty
    if (startTime.value == '' || startTime.value == null) {
        e.preventDefault();
        errors.push('Please enter a valid start time.');
    }

    if (endTime.value == '' || endTime.value == null) {
        e.preventDefault();
        errors.push('Please enter a valid end time.');
    }

    // If there are errors
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

            main.insertBefore(errorList, availabilityForm);
        }
    }
});