import {FieldErrorManager} from "./FieldErrorManager.js";

export class FormValidator {
    constructor(form) {
        this.form = form;
        this.errorManager = new FieldErrorManager(form);
        this.isValid = true;
    }

    validate() {
        this.isValid = true;
        this.validateFullname();
        this.validateGroup();
        this.validateQ1();
        this.validateQ2();
        this.validateQ3();
        return this.isValid;
    }

    validateFullname() {
        const fullname = this.form.fullname.value.trim();
        const nameParts = fullname.split(/\s+/);

        if (!fullname) {
            this.error('fullname', 'Введите ФИО');
        } else if (nameParts.length !== 3) {
            this.error('fullname', 'ФИО должно содержать три слова (например: Иванов Иван Иванович)');
        } else if (nameParts.some(part => part.length < 2)) {
            this.error('fullname', 'Каждая часть ФИО должна содержать минимум 2 символа');
        }
    }

    validateGroup() {
        if (!this.form.group.value) this.error('group', 'Выберите группу');
    }

    validateQ1() {
        if (!this.form.q1.value.trim()) this.error('q1', 'Ответьте на вопрос 1');
    }

    validateQ2() {
        const q2Options = this.form.querySelectorAll('input[name="q2"]:checked');
        if (q2Options.length !== 2) this.error('q2', 'Выберите ровно два варианта ответа');
    }

    validateQ3() {
        if (!this.form.q3.value) this.error('q3', 'Выберите ответ на вопрос 3');
    }

    error(fieldName, message) {
        this.errorManager.show(fieldName, message);
        this.isValid = false;
    }
}
