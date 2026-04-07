import {formatDate} from './date-utils.js';

export function bindCalendarEvents(calendar, currentDate, selectedDate, setDateCallback, months, weekdays, renderCalendar) {
    const monthSelect = calendar.querySelector('#calendar-month');
    const yearSelect = calendar.querySelector('#calendar-year');

    if (monthSelect) monthSelect.addEventListener('change', e => {
        currentDate.setMonth(parseInt(e.target.value));
        renderCalendar();
    });

    if (yearSelect) yearSelect.addEventListener('change', e => {
        currentDate.setFullYear(parseInt(e.target.value));
        renderCalendar();
    });

    const dayElements = calendar.querySelectorAll('.calendar-day:not(.other-month)');
    dayElements.forEach(day => {
        day.addEventListener('click', e => {
            const dayNum = parseInt(e.target.dataset.day);
            selectedDate.date = new Date(currentDate.getFullYear(), currentDate.getMonth(), dayNum);
            setDateCallback(formatDate(selectedDate.date));
            renderCalendar();
            e.stopPropagation();
        });
    });

    const todayBtn = calendar.querySelector('#calendar-today');
    if (todayBtn) todayBtn.addEventListener('click', e => {
        const today = new Date();
        currentDate.setFullYear(today.getFullYear(), today.getMonth(), today.getDate());
        selectedDate.date = today;
        setDateCallback(formatDate(today));
        renderCalendar();
        e.stopPropagation();
    });

    const applyBtn = calendar.querySelector('#calendar-apply');
    if (applyBtn) applyBtn.addEventListener('click', e => {
        if (selectedDate.date) setDateCallback(formatDate(selectedDate.date));
        calendar.classList.remove('active');
        e.stopPropagation();
    });
}