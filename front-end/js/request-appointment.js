const slotsTable = document.querySelector('#slots-table');
const slotsPeriodSelector = document.querySelector('#period_choice');
const slotData = getSlots();

const today = new Date();
const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

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
      month: weekAhead[0].getMonth() < 10
        ? `0${weekAhead[0].getMonth()}` : weekAhead[0].getMonth(),
      year: weekAhead[0].getFullYear(),
    };

    sun = {
      day: weekAhead[weekAhead.length - 1].getDate() < 10
        ? `0${weekAhead[weekAhead.length - 1].getDate()}` : weekAhead[weekAhead.length - 1].getDate(),
      month: weekAhead[weekAhead.length - 1].getMonth() < 10
        ? `0${weekAhead[weekAhead.length - 1].getMonth()}` : weekAhead[weekAhead.length - 1].getMonth(),
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
        const slotEntry = document.createElement('button');
        slotEntry.textContent = `${shortStartTime} – ${shortEndTime}`;

        // Append slots to each day under their respective headings
        if (slotDate === heading.textContent) {
          heading.after(slotEntry);
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
  const res = await fetch('get-slots.php');

  return await res.json();
}

/**
 * Sets up the page once it has fully loaded.
 */
function init() {
  displayPeriods(today);

  slotsPeriodSelector.addEventListener('input', (e) => {
    // Extract day, month, and year from dd/mm/yyyy format
    const startDateParts = e.target.selectedOptions[0].value.split(' ')[0].split('/');
    const startDate = new Date(startDateParts[2], startDateParts[1], startDateParts[0]);

    // Show slots for the week
    displayWeek(selectWeek(startDate));
  });
}

window.addEventListener('load', init);
