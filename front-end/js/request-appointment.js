const slotsTable = document.querySelector('#slots-table');

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
 * Displays the days of the week on the appointment bookings request page.
 * @param {Array} week The days in the week.
 */
function displayWeek(week) {
  const slotsTableHead = slotsTable.querySelector('thead');
  const headerRow = document.createElement('tr');

  // Add empty header column (for times)
  headerRow.append(document.createElement('th'));

  // Add a header column for each day of the week
  for (const day of week) {
    let dayDate = day.getDate();
    const dayName = weekdays[day.getDay()];

    // Prepend zeroes to single-digit day numbers
    if (dayDate < 10) {
      dayDate = `0${dayDate}`;
    }

    const th = document.createElement('th');
    th.textContent = `${dayName} ${dayDate}`;

    headerRow.append(th);
  }

  slotsTableHead.append(headerRow);
}

displayWeek(selectWeek(today));
