const slotsTable = document.querySelector('#slots-table');
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
 * Displays the days of the week on the appointment bookings request page.
 * @param {Array} week The days in the week.
 */
function displayWeek(week) {
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

displayWeek(selectWeek(today));
