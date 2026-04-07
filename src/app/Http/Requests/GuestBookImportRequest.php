<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestBookImportRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Выберите файл для загрузки',
            'file.mimes'    => 'Файл должен быть формата CSV',
            'file.max'      => 'Файл слишком большой (макс. 2MB)',
        ];
    }
}
