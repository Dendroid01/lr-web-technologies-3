<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname'  => [
                'required',
                'string',
                'regex:/^[А-Яа-яЁё]+\s[А-Яа-яЁё]+\s[А-Яа-яЁё]+$/u',
            ],
            'gender'    => ['required', 'in:Мужской,Женский'],
            'age'       => ['required', 'in:до 18,18-25,26-35,36-50,50+'],
            'email'     => ['required', 'email'],
            'phone'     => ['required', 'regex:/^\+([37]\d{8,11})$/'],
            'message'   => ['required', 'string'],
            'birthdate' => ['required', 'date_format:m/d/Y'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required'  => 'Введите ФИО.',
            'fullname.regex'     => 'ФИО должно содержать три слова на кириллице.',

            'gender.required'    => 'Выберите пол.',
            'gender.in'          => 'Недопустимое значение пола.',

            'age.required'       => 'Выберите возраст.',
            'age.in'             => 'Недопустимое значение возраста.',

            'email.required'     => 'Введите e-mail.',
            'email.email'        => 'Некорректный e-mail.',

            'phone.required'     => 'Введите телефон.',
            'phone.regex'        => 'Телефон должен начинаться с +7 или +3 и содержать 9–12 цифр.',

            'message.required'   => 'Введите сообщение.',

            'birthdate.required'     => 'Введите дату рождения.',
            'birthdate.date_format'  => 'Дата должна быть в формате мм/дд/гггг.',
        ];
    }
}
