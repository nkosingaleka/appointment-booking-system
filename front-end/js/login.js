'use strict';

// Select elements 
const main = document.querySelector('main');
const loginForm = document.querySelector('#login-form');
const email = document.querySelector('#email');
const password = document.querySelector('#password');

const errors = [];

// Validate input when the form is submitted
loginForm.addEventListener('submit', (e) => {
    // Check if the inputs are empty
    if (email.value == '' || email.value == null) {
        e.preventDefault();
        errors.push('Sorry, your email address was not found. Please check your input and try again.');
    }

    if (password.value == '' || password.value == null) {
        e.preventDefault();
        errors.push('Sorry, your email address and password combination was incorrect. Please check your input and try again.');
    }

    // If there are errors
    if (errors.length > 0) {
        // If the error list isn't already there
        if (document.querySelector('.error-message') == null) {
            // Create the error list
            const errorList = document.createElement('div');
            const ul = document.createElement('ul');

            errorList.className = 'error-message';

            // Add the error to the list
            for (const error of errors) {
                const li = document.createElement('li');

                li.textContent = error;
                ul.append(li);
            }

            errorList.append(ul);
            main.insertBefore(errorList, loginForm);
        }
    }
});
