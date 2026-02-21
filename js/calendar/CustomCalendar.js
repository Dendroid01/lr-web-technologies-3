import { generateCalendarHTML } from './render-calendar.js';
import { bindCalendarEvents } from './calendar-events.js';

export class CustomCalendar {
    constructor(inputId, calendarId, onDateSelected) {
        this.input = document.getElementById(inputId);
        this.calendar = document.getElementById(calendarId);

        if (!this.input || !this.calendar) return;

        this.onDateSelected = onDateSelected;
        this.currentDate = new Date();
        this.selectedDate = { date: null };

        this.months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        this.weekdays = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];

        this.init();
    }

    init() {
        this.bindEvents();
        this.render();
    }

    bindEvents() {
        if (!this.input || !this.calendar) return;

        this.input.addEventListener('focus', () => this.show());

        document.addEventListener('click', e => {
            if (!this.calendar.contains(e.target) && e.target !== this.input) this.hide();
        });

        this.calendar.addEventListener('click', e => e.stopPropagation());
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && this.isVisible()) this.hide();
        });
    }

    show() { this.calendar.classList.add('active'); this.render(); }
    hide() { this.calendar.classList.remove('active'); }
    isVisible() { return this.calendar.classList.contains('active'); }

    render() {
        this.calendar.innerHTML = generateCalendarHTML(this.currentDate, this.selectedDate.date, this.months, this.weekdays);
        bindCalendarEvents(this.calendar, this.currentDate, this.selectedDate, dateStr => {
            if (this.input) this.input.value = dateStr;
            if (this.onDateSelected) this.onDateSelected(dateStr);
        }, this.months, this.weekdays, () => this.render());
    }
}