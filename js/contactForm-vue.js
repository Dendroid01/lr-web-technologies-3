const {createApp} = Vue;

import {CustomCalendar} from './calendar/CustomCalendar.js';

createApp({
    data() {
        return {
            form: {
                fullname: '',
                gender: '',
                age: '',
                email: '',
                phone: '',
                message: '',
                birthdate: ''
            },
            errors: {
                fullname: '',
                gender: '',
                age: '',
                email: '',
                phone: '',
                message: '',
                birthdate: ''
            }
        };
    },
    computed: {
        isFormValid() {
            return Object.values(this.errors).every(err => !err) &&
                Object.values(this.form).every(val => val);
        }
    },
    methods: {
        validateField(field) {
            switch (field) {
                case 'fullname':
                    const parts = this.form.fullname.trim().split(/\s+/);
                    if (parts.length !== 3) {
                        this.errors.fullname = 'ФИО должно содержать три слова';
                    } else if (parts.some(p => p.length < 2)) {
                        this.errors.fullname = 'Каждая часть ФИО должна быть минимум 2 символа';
                    } else {
                        this.errors.fullname = '';
                    }
                    break;

                case 'gender':
                    this.errors.gender = this.form.gender ? '' : 'Выберите пол';
                    break;

                case 'age':
                    this.errors.age = this.form.age ? '' : 'Выберите возраст';
                    break;

                case 'email':
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    this.errors.email = emailPattern.test(this.form.email) ? '' : 'Некорректный e-mail';
                    break;

                case 'phone':
                    const phonePattern = /^\+([37]\d{8,11})$/;
                    this.errors.phone = phonePattern.test(this.form.phone) ? '' : 'Телефон должен начинаться с +7 или +3 и содержать 9–12 цифр';
                    break;

                case 'message':
                    this.errors.message = this.form.message.trim() ? '' : 'Введите сообщение';
                    break;

                case 'birthdate':
                    const datePattern = /^\d{2}\/\d{2}\/\d{4}$/;
                    console.log('Проверяем дату:', this.form.birthdate, 'Результат:', datePattern.test(this.form.birthdate));
                    this.errors.birthdate = datePattern.test(this.form.birthdate) ? '' : 'Дата должна быть в формате мм/дд/гггг';
                    break;
            }
        },

        validateForm() {
            for (const field in this.form) {
                this.validateField(field);
            }
            return Object.values(this.errors).every(err => !err);
        },

        handleSubmit() {
            if (this.validateForm()) {
                console.log('Данные формы:', this.form);
                alert('Форма готова к отправке!');
                this.resetForm();
            } else {
                alert('Пожалуйста, исправьте ошибки в форме.');
            }
        },

        resetForm() {
            this.form = {
                fullname: '',
                gender: '',
                age: '',
                email: '',
                phone: '',
                message: '',
                birthdate: ''
            };
            this.errors = {
                fullname: '',
                gender: '',
                age: '',
                email: '',
                phone: '',
                message: '',
                birthdate: ''
            };
        },

        setBirthdate(dateStr) {
            const [month, day, year] = dateStr.split('/');
            const formattedDate = `${month.padStart(2, '0')}/${day.padStart(2, '0')}/${year}`;
            this.form.birthdate = formattedDate;
            this.$nextTick(() => {
                this.validateField('birthdate');
            });
        }
    },
    mounted() {
        if (document.getElementById('birthdate') && document.getElementById('calendar')) {
            new CustomCalendar('birthdate', 'calendar', (dateStr) => {
                console.log('CustomCalendar onDateSelected вызван', dateStr);
                this.setBirthdate(dateStr);
            });
        }
    }

}).mount('#contactApp');
