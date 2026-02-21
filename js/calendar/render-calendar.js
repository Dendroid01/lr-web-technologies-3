import { isSameDate } from './date-utils.js';

export function generateCalendarHTML(currentDate, selectedDate, months, weekdays) {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay();
    const prevMonthLastDay = new Date(year, month, 0).getDate();

    let html = `<div class="calendar-header"><h3>Выберите дату</h3></div>`;
    html += `<div class="calendar-selects">
                <select id="calendar-month">
                    ${months.map((m, i) => `<option value="${i}" ${i === month ? 'selected' : ''}>${m}</option>`).join('')}
                </select>
                <select id="calendar-year">
                    ${generateYearOptions(year).join('')}
                </select>
             </div>`;
    html += `<div class="calendar-grid">`;
    weekdays.forEach(day => html += `<div class="calendar-weekday">${day}</div>`);

    for (let i = startingDay - 1; i >= 0; i--) {
        html += `<div class="calendar-day other-month">${prevMonthLastDay - i}</div>`;
    }

    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const isToday = isSameDate(date, today);
        const isSelected = selectedDate && isSameDate(date, selectedDate);
        html += `<div class="calendar-day ${isToday ? 'today' : ''} ${isSelected ? 'selected' : ''}" data-day="${day}">${day}</div>`;
    }

    const totalCells = 42;
    const remainingCells = totalCells - (startingDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        html += `<div class="calendar-day other-month">${day}</div>`;
    }

    html += `</div>`;
    html += `<div class="calendar-actions">
                <button class="calendar-btn" id="calendar-today">Сегодня</button>
                <button class="calendar-btn primary" id="calendar-apply">Применить</button>
             </div>`;
    return html;
}

function generateYearOptions(currentYear) {
    const years = [];
    for (let year = currentYear - 100; year <= currentYear + 100; year++) {
        const selected = year === currentYear ? 'selected' : '';
        years.push(`<option value="${year}" ${selected}>${year}</option>`);
    }
    return years;
}