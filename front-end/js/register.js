'use strict';

// Select elements 
const main = document.querySelector('main');
const registerForm = document.querySelector('#registration-form');

const email = document.querySelector('#email');
const password = document.querySelector('#password');

const pTitle = document.querySelector('#p_title');
const pForename = document.querySelector('#p_forename');
const pSurname = document.querySelector('#p_surname');
const pSex = document.querySelector('#p_sex');
const pDateOfBirth = document.querySelector('#p_date_of_birth');
const pHouseName = document.querySelector('#p_house_name');
const pHouseNo = document.querySelector('#p_house_no');
const pStreet = document.querySelector('#p_street');
const pCity = document.querySelector('#p_city');
const pCounty = document.querySelector('#p_county');
const pPostcode = document.querySelector('#p_postcode');
const pTelNo = document.querySelector('#p_tel_no');
const pMobNo = document.querySelector('#p_mob_no');
const pNHSNo = document.querySelector('#p_nhs_no');
const pHCNo = document.querySelector('#p_hc_no');

const nokRelationship = document.querySelector('#nok_relationship');
const nokTitle = document.querySelector('#nok_title');
const nokForename = document.querySelector('#nok_forename');
const nokSurname = document.querySelector('#nok_surname');
const nokHouseName = document.querySelector('#nok_house_name');
const nokHouseNo = document.querySelector('#nok_house_no');
const nokStreet = document.querySelector('#nok_street');
const nokCity = document.querySelector('#nok_city');
const nokCounty = document.querySelector('#nok_county');
const nokPostcode = document.querySelector('#nok_postcode');
const nokTelNo = document.querySelector('#nok_tel_no');
const nokMobNo = document.querySelector('#nok_mob_no');

const consentBoxCheck = document.querySelector('#consent_check');

const errors = [];

// Validate input when the form is submitted
registerForm.addEventListener('submit', (e) => {
  // Check if the inputs are empty
  if (email.value == '' || email.value == null) {
    e.preventDefault();
    errors.push('Sorry, the email address you entered has already been taken. Please try again.');
  }

  if (password.value == '' || password.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid password.');
  }

  if (pTitle.value == '' || pTitle.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid title.');
  }

  if (pForename.value == '' || pForename.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid forename.');
  }

  if (pSurname.value == '' || pSurname.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid surname.');
  }

  if (pSex.value == '' || pSex.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid sex.');
  }

  if (pDateOfBirth.value == '' || pDateOfBirth.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid date of birth.');
  }

  if ((pHouseName.value == '' || pHouseName.value == null) && (pHouseNo.value == '' || pHouseNo.value == null)){
    e.preventDefault();
    errors.push('Please enter either a house name or house number, or both.');
  }

  if (pStreet.value == '' || pStreet.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid street.');
  }

  if (pCity.value == '' || pCity.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid city.');
  }

  if (pCounty.value == '' || pCounty.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid county.');
  }

  if (pPostcode.value == '' || pPostcode.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid postcode.');
  }

  if ((pTelNo.value == '' || pTelNo.value == null) && (pMobNo.value == '' || pMobNo.value == null)) {
    e.preventDefault();
    errors.push('Please enter either your mobile number or telephone number, or both.');
  }

  if ((pNHSNo.value == '' || pNHSNo.value == null) && (pHCNo.value == '' || pHCNo.value == null)) {
    e.preventDefault();
    errors.push('Sorry, the NHS number or Health and Care number you entered has already been taken. Please check your input.');
  }

  if (nokRelationship.value == '' || nokRelationship.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid relationship.');
  }

  if (nokTitle.value == '' || nokTitle.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid title.');
  }

  if (nokForename.value == '' || nokForename.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid forename.');
  }

  if (nokSurname.value == '' || nokSurname.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid surname.');
  }

  if ((nokHouseName.value == '' || nokHouseName.value == null) && (nokHouseNo.value == '' || nokHouseNo.value == null)) {
    e.preventDefault();
    errors.push('Please enter either a house name or house number, or both.');
  }

  if (nokStreet.value == '' || nokStreet.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid street.');
  }

  if (nokCity.value == '' || nokCity.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid city.');
  }

  if (nokCounty.value == '' || nokCounty.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid county.');
  }

  if (nokPostcode.value == '' || nokPostcode.value == null) {
    e.preventDefault();
    errors.push('Please enter a valid postcode.');
  }

  if ((nokTelNo.value == '' || nokTelNo.value == null) && (nokMobNo.value == '' || nokMobNo.value == null)) {
    e.preventDefault();
    errors.push('Please enter either your mobile number or telephone number, or both.');
  }

  if (!consentBoxCheck.checked) {
    e.preventDefault();
    errors.push('Please tick the consent box.');
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
      main.insertBefore(errorList, registerForm);
    }
  }
});
