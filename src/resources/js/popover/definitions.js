export const popoverFields = {
    '#fullname': 'ФИО должно содержать три слова (например: Иванов Иван Иванович)',
    '#email': 'Введите корректный e-mail адрес (example@mail.com)',
    '#phone': 'Телефон должен начинаться с +7, +3 и содержать 9–12 цифр',
    '#birthdate': 'Формат даты: месяц/день/год (MM/DD/YYYY)',
    '#message': 'Введите текст сообщения',
    '.gender-options': 'Выберите ваш пол',
    '#age': 'Выберите вашу возрастную категорию',
    '.test-form input[name="fullname"]': 'ФИО должно содержать три слова',
    '.test-form input[name="q1"]': 'Ответьте на вопрос по физике',
    '.test-form input[name="q2"]': 'Выберите ровно два варианта ответа',
    '.test-form select[name="q3"]': 'Выберите правильный ответ'
};

export function bindPopoverAttributes() {
    Object.entries(popoverFields).forEach(([selector, text]) => {
        document.querySelectorAll(selector).forEach(el => el.setAttribute('data-popover', text));
    });
}