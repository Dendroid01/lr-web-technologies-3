class CustomCalendar {
    constructor(inputId, calendarId, onDateSelected) {
        this.input = document.getElementById(inputId);
        this.calendar = document.getElementById(calendarId);

        if (!this.input || !this.calendar) {
            console.warn('Calendar elements not found');
            return;
        }

        this.onDateSelected = onDateSelected;
        this.currentDate = new Date();
        this.selectedDate = null;

        this.months = [
            'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
        ];

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

        document.addEventListener('click', (e) => {
            if (!this.calendar.contains(e.target) && e.target !== this.input) {
                this.hide();
            }
        });

        this.calendar.addEventListener('click', (e) => e.stopPropagation());

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isVisible()) this.hide();
        });
    }

    show() {
        if (!this.calendar) return;
        this.calendar.classList.add('active');
        this.render();
    }

    hide() {
        if (!this.calendar) return;
        this.calendar.classList.remove('active');
    }

    isVisible() {
        return this.calendar && this.calendar.classList.contains('active');
    }

    render() {
        if (!this.calendar) return;

        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();

        this.calendar.innerHTML = this.generateCalendarHTML(year, month);
        this.bindCalendarEvents();
    }

    generateCalendarHTML(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay();
        const prevMonthLastDay = new Date(year, month, 0).getDate();

        let html = `<div class="calendar-header"><h3>Выберите дату</h3></div>`;
        html += `<div class="calendar-selects">
                    <select id="calendar-month">
                        ${this.months.map((m, i) => `<option value="${i}" ${i === month ? 'selected' : ''}>${m}</option>`).join('')}
                    </select>
                    <select id="calendar-year">
                        ${this.generateYearOptions(year).join('')}
                    </select>
                 </div>`;
        html += `<div class="calendar-grid">`;
        this.weekdays.forEach(day => html += `<div class="calendar-weekday">${day}</div>`);

        for (let i = startingDay - 1; i >= 0; i--) {
            const day = prevMonthLastDay - i;
            html += `<div class="calendar-day other-month">${day}</div>`;
        }

        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const isToday = this.isSameDate(date, today);
            const isSelected = this.selectedDate && this.isSameDate(date, this.selectedDate);
            const dayClass = `calendar-day ${isToday ? 'today' : ''} ${isSelected ? 'selected' : ''}`;
            html += `<div class="${dayClass}" data-day="${day}">${day}</div>`;
        }

        const totalCells = 42;
        const daysSoFar = startingDay + daysInMonth;
        const remainingCells = totalCells - daysSoFar;
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

    generateYearOptions(currentYear) {
        const years = [];
        for (let year = currentYear - 100; year <= currentYear + 100; year++) {
            const selected = year === currentYear ? 'selected' : '';
            years.push(`<option value="${year}" ${selected}>${year}</option>`);
        }
        return years;
    }

    bindCalendarEvents() {
        if (!this.calendar) return;

        const monthSelect = document.getElementById('calendar-month');
        const yearSelect = document.getElementById('calendar-year');

        if (monthSelect) monthSelect.addEventListener('change', e => {
            this.currentDate.setMonth(parseInt(e.target.value));
            this.render();
        });

        if (yearSelect) yearSelect.addEventListener('change', e => {
            this.currentDate.setFullYear(parseInt(e.target.value));
            this.render();
        });

        const dayElements = this.calendar.querySelectorAll('.calendar-day:not(.other-month)');
        dayElements.forEach(day => {
            day.addEventListener('click', (e) => {
                const selectedDay = parseInt(e.target.dataset.day);
                this.selectDate(selectedDay);
                e.stopPropagation();
            });
        });

        const todayBtn = document.getElementById('calendar-today');
        if (todayBtn) todayBtn.addEventListener('click', (e) => {
            const today = new Date();
            this.currentDate = today;
            this.selectDate(today.getDate());
            e.stopPropagation();
        });

        const applyBtn = document.getElementById('calendar-apply');
        if (applyBtn) applyBtn.addEventListener('click', (e) => {
            if (this.selectedDate && this.onDateSelected) {
                const y = this.selectedDate.getFullYear();
                const m = (this.selectedDate.getMonth() + 1).toString().padStart(2, '0');
                const d = this.selectedDate.getDate().toString().padStart(2, '0');
                this.onDateSelected(`${m}/${d}/${y}`);
            }
            this.hide();
            e.stopPropagation();
        });
    }

    selectDate(day) {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        this.selectedDate = new Date(year, month, day);

        if (this.input) {
            const monthStr = (month + 1).toString().padStart(2, '0');
            const dayStr = day.toString().padStart(2, '0');
            const dateStr = `${monthStr}/${dayStr}/${year}`;
            this.input.value = dateStr;

            const inputEvent = new Event('input', { bubbles: true });
            this.input.dispatchEvent(inputEvent);

        }

        this.render();
    }


    isSameDate(date1, date2) {
        return date1.getFullYear() === date2.getFullYear() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getDate() === date2.getDate();
    }
}


function initTestForm() {
    const form = document.querySelector('.test-form form');
    if (!form) return;

    form.addEventListener('input', function (event) {
        clearFieldError(event.target.name);
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        let isValid = true;

        const fullname = form.fullname.value.trim();
        const nameParts = fullname.split(/\s+/);

        if (!fullname) {
            showFieldError('fullname', 'Введите ФИО');
            isValid = false;
        } else if (nameParts.length !== 3) {
            showFieldError('fullname', 'ФИО должно содержать три слова (например: Иванов Иван Иванович)');
            isValid = false;
        } else {
            const hasShortWords = nameParts.some(part => part.length < 2);
            if (hasShortWords) {
                showFieldError('fullname', 'Каждая часть ФИО должна содержать минимум 2 символа');
                isValid = false;
            }
        }

        if (!form.group.value) {
            showFieldError('group', 'Выберите группу');
            isValid = false;
        }

        if (!form.q1.value.trim()) {
            showFieldError('q1', 'Ответьте на вопрос 1');
            isValid = false;
        }

        const q2Options = form.querySelectorAll('input[name="q2"]:checked');
        if (q2Options.length !== 2) {
            showFieldError('q2', 'Выберите ровно два варианта ответа');
            isValid = false;
        }

        if (!form.q3.value) {
            showFieldError('q3', 'Выберите ответ на вопрос 3');
            isValid = false;
        }

        if (isValid) {
            alert('Тест готов к отправке! Все ответы заполнены корректно.');
        }
    });

    function showFieldError(fieldName, message) {
        let field;
        if (fieldName === 'q2') {
            field = form.querySelector('input[name="q2"]');
        } else {
            field = form.querySelector(`[name="${fieldName}"]`);
        }

        if (field) {
            clearFieldError(fieldName);

            const errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            errorElement.textContent = message;
            errorElement.style.color = 'red';
            errorElement.style.fontSize = '0.9em';
            errorElement.style.marginTop = '5px';

            const container = field.closest('fieldset') || field.parentNode;
            container.appendChild(errorElement);

            if (fieldName === 'q2') {
                const fieldset = field.closest('fieldset');
                if (fieldset) {
                    fieldset.style.borderColor = 'red';
                }
            } else {
                field.style.borderColor = 'red';
            }
        }
    }

    function clearFieldError(fieldName) {
        let field;
        if (fieldName === 'q2') {
            field = form.querySelector('input[name="q2"]');
        } else {
            field = form.querySelector(`[name="${fieldName}"]`);
        }

        if (field) {
            const container = field.closest('fieldset') || field.parentNode;
            const existingError = container.querySelector('.field-error');
            if (existingError) {
                existingError.remove();
            }

            if (fieldName === 'q2') {
                const fieldset = field.closest('fieldset');
                if (fieldset) {
                    fieldset.style.borderColor = '';
                }
            } else {
                field.style.borderColor = '';
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const birthdateInput = document.getElementById('birthdate');
    const calendarElement = document.getElementById('calendar');
    if (birthdateInput && calendarElement) {
        new CustomCalendar('birthdate', 'calendar', (dateStr) => {
            birthdateInput.value = dateStr;
        });
    }
    initTestForm();
});