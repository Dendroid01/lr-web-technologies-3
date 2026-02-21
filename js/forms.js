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
    initTestForm();
});