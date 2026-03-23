<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestFormRequest extends FormRequest
{
    private array $allowedGroups = [

        'ИБ/б-25-1-о', 'ИБ/б-25-2-о', 'ИИ/б-25-1-о', 'ИИ/б-25-2-о',
        'ИИ/б-25-3-о', 'ИИ/б-25-4-о', 'ИИ/б-25-5-о', 'ИИ/б-25-6-о',
        'ИИ/б-25-7-о', 'ИИ/б-25-8-о', 'УТС/б-25-1-о', 'ЦТ/б-25-1-о',

        'УТС/б-24-1-о', 'ИБ/б-24-1-о', 'ИБ/б-24-2-о', 'ИТ/б-24-1-о',
        'ИТ/б-24-2-о', 'ИТ/б-24-3-о', 'ИТ/б-24-4-о', 'ИТ/б-24-5-о',
        'ИТ/б-24-6-о', 'ИТ/б-24-7-о', 'ИТ/б-24-8-о', 'ЦТ/б-24-1-о',

        'УТС/б-23-1-о', 'УТС/б-23-2-о', 'ИБ/б-23-1-о', 'ИБ/б-23-2-о',
        'ИВТ/б-23-1-о', 'ИВТ/б-23-2-о', 'ИС/б-23-1-о', 'ИС/б-23-2-о',
        'ПИ/б-23-1-о', 'ПИ/б-23-2-о', 'ПИН/б-23-1-о', 'ПИН/б-23-2-о',

        'ИБ/б-22-1-о', 'ИБ/б-22-2-о', 'ИВТ/б-22-1-о', 'ИВТ/б-22-2-о',
        'ИС/б-22-1-о', 'ИС/б-22-2-о', 'ПИ/б-22-1-о', 'ПИ/б-22-2-о',
        'ПИН/б-22-1-о', 'ПИН/б-22-2-о', 'УТС/б-22-1-о', 'УТС/б-22-2-о',
    ];

    private array $allowedQ2Answers = [
        'Сила',
        'Масса',
        'Скорость',
        'Время',
    ];

    private array $allowedQ3Answers = [
        'Закон Ньютона',
        'Закон сохранения импульса',
        'Закон Ома',
        'Закон Кулона',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => ['required|string', 'regex:/^[А-Яа-яЁё]+\s[А-Яа-яЁё]+\s[А-Яа-яЁё]+$/u'],

            'group' => ['required', Rule::in($this->allowedGroups)],

            'q1' => ['required'],

            'q2' => ['required','array','size:2'],
            'q2.*' => [Rule::in($this->allowedQ2Answers)],

            'q3' => ['required',Rule::in($this->allowedQ3Answers)],

        ];
    }
}
