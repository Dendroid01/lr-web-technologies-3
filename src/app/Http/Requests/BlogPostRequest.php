<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'message' => ['required', 'string', 'min:5'],
            'author'  => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Введите тему сообщения',
            'message.required' => 'Введите текст сообщения',
            'message.min'      => 'Текст слишком короткий',
            'author.required'  => 'Введите имя автора',
            'image.image'      => 'Файл должен быть изображением',
            'image.max'        => 'Изображение слишком большое (макс. 2MB)',
        ];
    }
}
