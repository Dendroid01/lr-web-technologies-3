import {FormValidator} from "./FormValidator.js";
import {FieldErrorManager} from "./FieldErrorManager.js";

export class TestForm {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.errorManager = new FieldErrorManager(this.form);
        this.initEventListeners();
    }

    initEventListeners() {
        this.form.addEventListener('input', (event) => this.clearFieldError(event.target.name));
        this.form.addEventListener('submit', (event) => this.handleSubmit(event));
    }

    handleSubmit(event) {
        event.preventDefault();

        const validator = new FormValidator(this.form);
        const isValid = validator.validate();

        if (isValid) {
            alert('Тест готов к отправке! Все ответы заполнены корректно.');
        }
    }

    showFieldError(fieldName, message) {
        const fieldManager = new FieldErrorManager(this.form);
        fieldManager.show(fieldName, message);
    }

    clearFieldError(fieldName) {
        this.errorManager.clear(fieldName);
    }
}