<?php

namespace App\Services;

class CustomFormValidation extends FormValidation
{

    private array $allowedGroups = [
        'ИБ/б-25-1-о',
        'ИИ/б-25-1-о',
        'УТС/б-25-1-о',
        'УТС/б-24-1-о',
        'ИБ/б-24-1-о',
        'ИТ/б-24-1-о',
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

    public function isValidSelectionSet(mixed $data, array $allowed): ?string
    {
        if (!is_array($data) || $data === []) {
            return 'Выберите хотя бы один вариант.';
        }

        foreach ($data as $item) {
            if (!is_string($item) || !in_array($item, $allowed, true)) {
                return 'Поле содержит недопустимое значение.';
            }
        }

        return null;
    }

    public function configureTestRules(): void
    {
        $this->Rules = [];

        $this->SetRule('fullname', 'isFullName');
        $this->SetRule('group', 'isIn', $this->allowedGroups);
        $this->SetRule('q1', 'isNotEmpty');
        $this->SetRule('q2', 'isValidSelectionSet', $this->allowedQ2Answers);
        $this->SetRule('q2', 'hasExactlySelected', 2);
        $this->SetRule('q3', 'isIn', $this->allowedQ3Answers);
    }

    public function validateTestForm(array $postArray): bool
    {
        $this->configureTestRules();

        return $this->Validate($postArray);
    }
}
