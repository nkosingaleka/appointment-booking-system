// Select slots and slot-related elements
const slotsTable = document.querySelector('#slots-table');
const slotsPeriodSelector = document.querySelector('#period_choice');
const slotData = getSlots();

const selected = [];
const REQUESTS_LIMIT = 5;

// Define days of the week
const today = new Date();
const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// Select page elements
const main = document.querySelector('main');
const requestSection = document.querySelector('#request-section');
const requestAppointmentForm = document.querySelector('#request-form');
const transRequired = document.querySelector('#translation_choice');
const prefStaff = document.querySelector('#staff_choice');

// Define array for displaying errors
const errors = [];

/**
 * Retrieves the week from Monday to Sunday using a given start date.
 * @param {Date} startDate Date from which to start the week.
 * @return {Array} The days in the week.
 */
function selectWeek(startDate) {
  const dayOfWeek = startDate.getDay();

  // Get the date for the given week's Monday
  const daysApart = startDate.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
  const monday = new Date(startDate.setDate(daysApart));

  const week = [new Date(monday)];

  while (monday.setDate(monday.getDate() + 1) && monday.getDay() !== 1) {
    // Add all days of the current week
    week.push(new Date(monday));
  }

  return week;
}

/**
 * Displays the available booking periods (weeks), up to three weeks from the current date.
 * @param {Array} week The days in the week.
 */
function displayPeriods(startDate) {
  // Retrieve next 3 weeks
  for (let i = 0; i <= 3; i += 1) {
    // Retrieve one week ahead from the start date
    const dateWeekAhead = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + (7 * i));
    const weekAhead = selectWeek(dateWeekAhead);

    // Extract human-readable date format from the start and end of the week
    mon = {
      day: weekAhead[0].getDate() < 10
        ? `0${weekAhead[0].getDate()}` : weekAhead[0].getDate(),
      month: weekAhead[0].getMonth() + 1 < 10
        ? `0${weekAhead[0].getMonth() + 1}` : weekAhead[0].getMonth() + 1,
      year: weekAhead[0].getFullYear(),
    };

    sun = {
      day: weekAhead[weekAhead.length - 1].getDate() < 10
        ? `0${weekAhead[weekAhead.length - 1].getDate()}` : weekAhead[weekAhead.length - 1].getDate(),
      month: weekAhead[weekAhead.length - 1].getMonth() + 1 < 10
        ? `0${weekAhead[weekAhead.length - 1].getMonth() + 1}` : weekAhead[weekAhead.length - 1].getMonth() + 1,
      year: weekAhead[weekAhead.length - 1].getFullYear(),
    };

    // Add option for each period ahead
    const period = document.createElement('option');
    period.value,
      period.textContent = `${mon.day}/${mon.month}/${mon.year} – ${sun.day}/${sun.month}/${sun.year}`;

    slotsPeriodSelector.append(period);
  }

  // Select the period for the current week
  slotsPeriodSelector[0].selected = true;

  // Show slots for the week
  displayWeek(selectWeek(startDate));
}

/**
 * Displays the days of the week on the appointment bookings request page.
 * @param {Array} week The days in the week.
 */
function displayWeek(week) {
  slotsTable.innerHTML = '';

  for (const day of week) {
    // Add a header column for each day of the week
    let dayDate = day.getDate();
    const dayName = weekdays[day.getDay()];

    // Prepend zeroes to single-digit day numbers
    if (dayDate < 10) {
      dayDate = `0${dayDate}`;
    }

    const dayColumn = document.createElement('div');
    const heading = document.createElement('h2');

    // Add human-readable date to headings
    heading.textContent = `${dayName} ${dayDate}`;

    dayColumn.append(heading);
    slotsTable.append(dayColumn);

    slotData.then(slots => {
      for (const slot of slots) {
        const startTime = new Date(slot['start_time']);
        const endTime = new Date(slot['end_time']);

        // Extract human-readable date for comparison with headings
        const slotDate = `${startTime.toString().split(' ')[0]} ${startTime.toString().split(' ')[2]}`;

        // Extract hours and minutes
        const shortStartTime = startTime.toString().split(' ')[4].substr(0, 5);
        const shortEndTime = endTime.toString().split(' ')[4].substr(0, 5);

        // Add clickable buttons to request appointment bookings
        const slotEntry = document.createElement('div');
        slotEntry.classList.add('slot');

        const slotEntryCheck = document.createElement('input');
        slotEntryCheck.setAttribute('type', 'checkbox');
        slotEntryCheck.id = `${slot['id']}`;
        slotEntryCheck.value = `${shortStartTime} – ${shortEndTime}`;

        const slotEntryLabel = document.createElement('label');
        slotEntryLabel.textContent = `${shortStartTime} – ${shortEndTime}`;
        slotEntryLabel.setAttribute('for', `${slot['id']}`);

        slotEntry.append(slotEntryCheck);
        slotEntry.append(slotEntryLabel);

        // Append slots to each day under their respective headings
        if (slotDate === heading.textContent) {
          heading.after(slotEntry);
        }

        // Check if slot is held before the current time
        if (startTime <= new Date()) {
          slotEntryCheck.disabled = true;
          slotEntry.classList.add('disabled');
        } else {
          slotEntry.addEventListener('click', (e) => {
            // Select clicked slots if within the requests limit (5)
            if (selected.length <= REQUESTS_LIMIT) {
              selectSlot(slot['id']);
            } else {
              // Prevent checkbox from being checked
              e.preventDefault();
            }
          });

          // Retrieve previously-selected slots
          const urlParams = window.location.search.split('slots[]');

          for (let param of urlParams) {
            // Remove unneeded charactes from IDs
            param = param.replace('=', '');
            param = param.replace('&', '');

            if (param === slot['id']) {
              // Check the checkbox for the relevant slot
              slotEntryCheck.checked = true;

              // Select any slots already selected (e.g. from other period or form submission)
              if (selected.length <= REQUESTS_LIMIT && !selected.includes(slot['id'])) {
                selectSlot(slot['id']);
              }
            }
          }
        }
      }
    });
  }
}

/**
 * Retrieves the available time slots for which appointment booking requests can be made.
 * @return {Object} The slots available.
 */
async function getSlots() {
  const res = await fetch('scripts/get-slots.php');

  return await res.json();
}

/**
 * Selects the clicked slot.
 * @param {String} id 
 */
function selectSlot(id) {
  if (!selected.includes(id)) {
    // Add the slot if it has not already been selected
    selected.push(id);
  } else {
    let slotIds = '';

    for (const slot of selected) {
      // Construct query string with slot IDs
      if (selected.indexOf(slot) < selected.length - 1) {
        slotIds += `slots[]=${slot}&`;
      } else {
        slotIds += `slots[]=${slot}`;
      }
    }

    // Add query string for accessing slot IDs
    window.history.replaceState({}, '', `${location.pathname}?${slotIds}`);
  }
}

/**
 * Checks whether the request form details are not empty.
 * @param {Object} e Submit event, fired when the form is submitted.
 */
function validateRequestForm(e) {
  if (transRequired.value == '' || transRequired.value == null) {
    e.preventDefault();
    errors.push('Please enter a translation.')
  }

  if (prefStaff.value == '' || prefStaff.value == null) {
    e.preventDefault();
    errors.push('Please enter a preferred staff.')
  }

  if (selected.length === 0) {
    e.preventDefault();
    errors.push('Please select at least one slot.')
  }

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
      main.insertBefore(errorList, requestSection);
    }
  }
}

/**
 * Sets up the page once it has fully loaded.
 */
function init() {
  displayPeriods(today);

  slotsPeriodSelector.addEventListener('input', (e) => {
    // Extract day, month, and year from dd/mm/yyyy format
    const startDateParts = e.target.selectedOptions[0].value.split(' ')[0].split('/');
    const startDate = new Date(startDateParts[2], startDateParts[1] - 1, startDateParts[0]);

    // Show slots for the week
    displayWeek(selectWeek(startDate));
  });

  requestAppointmentForm.addEventListener('submit', validateRequestForm);
}

window.addEventListener('load', init);
