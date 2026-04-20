<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestBookRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'last_name'   => ['required', 'string', 'regex:/^[А-ЯЁа-яё\-]+$/u', 'max:100'],
            'first_name'  => ['required', 'string', 'regex:/^[А-ЯЁа-яё\-]+$/u', 'max:100'],
            'middle_name' => ['required', 'string', 'regex:/^[А-ЯЁа-яё\-]+$/u', 'max:100'],
            'email'       => ['required', 'email', 'max:255'],
            'message'     => ['required', 'string', 'min:5', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'last_name.required'   => 'Введите фамилию',
            'last_name.regex'      => 'Фамилия должна содержать только кириллицу',
            'first_name.required'  => 'Введите имя',
            'first_name.regex'     => 'Имя должно содержать только кириллицу',
            'middle_name.required' => 'Введите отчество',
            'middle_name.regex'    => 'Отчество должно содержать только кириллицу',
            'email.required'       => 'Введите e-mail',
            'email.email'          => 'Некорректный e-mail',
            'message.required'     => 'Введите текст отзыва',
            'message.min'          => 'Отзыв слишком короткий',
        ];
    }
}
