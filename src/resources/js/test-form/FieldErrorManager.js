export class FieldErrorManager {
    constructor(form) {
        this.form = form;
    }

    show(fieldName, message) {
        const field = this.getField(fieldName);
        if (!field) return;

        this.clear(fieldName);

        const errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.textContent = message;
        Object.assign(errorElement.style, {
            color: 'red',
            fontSize: '0.9em',
            marginTop: '5px'
        });

        const container = field.closest('fieldset') || field.parentNode;
        container.appendChild(errorElement);

        if (fieldName === 'q2') {
            const fieldset = field.closest('fieldset');
            if (fieldset) fieldset.style.borderColor = 'red';
        } else {
            field.style.borderColor = 'red';
        }
    }

    clear(fieldName) {
        const field = this.getField(fieldName);
        if (!field) return;

        const container = field.closest('fieldset') || field.parentNode;
        const existingError = container.querySelector('.field-error');
        if (existingError) existingError.remove();

        if (fieldName === 'q2') {
            const fieldset = field.closest('fieldset');
            if (fieldset) fieldset.style.borderColor = '';
        } else {
            field.style.borderColor = '';
        }
    }

    getField(fieldName) {
        if (fieldName === 'q2') {
            return this.form.querySelector('input[name="q2"]');
        }
        return this.form.querySelector(`[name="${fieldName}"]`);
    }
}