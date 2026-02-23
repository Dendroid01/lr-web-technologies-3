import {CustomCalendar} from './CustomCalendar.js';

export {CustomCalendar}

document.addEventListener('DOMContentLoaded', function () {
    const birthdateInput = document.getElementById('birthdate');
    const calendarElement = document.getElementById('calendar');
    if (birthdateInput && calendarElement) {
        if (!window._calendarInitialized) {
            window._calendarInitialized = true;
            new CustomCalendar('birthdate', 'calendar', (dateStr) => {
                birthdateInput.value = dateStr;
            });
        }
    }
});