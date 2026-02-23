<?php

namespace App\Services;

class FormValidation
{

    public array $Rules = [];

    public array $Errors = [];

    public function isNotEmpty(mixed $data): ?string
    {
        if (!is_string($data) || trim($data) === '') {
            return 'Поле не должно быть пустым.';
        }

        return null;
    }

    public function isInteger(mixed $data): ?string
    {
        if (!is_string($data) || !preg_match('/^-?\d+$/', trim($data))) {
            return 'Значение должно быть строковым представлением целого числа.';
        }

        return null;
    }

    public function isLess(mixed $data, int $value): ?string
    {
        if ($error = $this->isInteger($data)) {
            return $error;
        }

        if ((int)trim((string)$data) < $value) {
            return "Значение должно быть не меньше {$value}.";
        }

        return null;
    }

    public function isGreater(mixed $data, int $value): ?string
    {
        if ($error = $this->isInteger($data)) {
            return $error;
        }

        if ((int)trim((string)$data) > $value) {
            return "Значение должно быть не больше {$value}.";
        }

        return null;
    }

    public function isEmail(mixed $data): ?string
    {
        if (!is_string($data) || !preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', trim($data))) {
            return 'Некорректный e-mail.';
        }

        return null;
    }

    public function isFullName(mixed $data): ?string
    {
        if ($error = $this->isNotEmpty($data)) {
            return 'Введите ФИО.';
        }

        $parts = preg_split('/\s+/', trim((string)$data));
        if (count($parts) !== 3) {
            return 'ФИО должно содержать три слова.';
        }

        foreach ($parts as $part) {
            if (mb_strlen($part) < 2) {
                return 'Каждая часть ФИО должна быть минимум 2 символа.';
            }
        }

        return null;
    }

    public function isPhone(mixed $data): ?string
    {
        if (!is_string($data) || !preg_match('/^\+([37]\d{8,11})$/', trim($data))) {
            return 'Телефон должен начинаться с +7 или +3 и содержать 9–12 цифр.';
        }

        return null;
    }

    public function isBirthdate(mixed $data): ?string
    {
        if (!is_string($data) || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', trim($data))) {
            return 'Дата должна быть в формате мм/дд/гггг.';
        }

        return null;
    }

    public function isIn(mixed $data, array $allowed): ?string
    {
        if (!is_string($data) || !in_array($data, $allowed, true)) {
            return 'Поле содержит недопустимое значение.';
        }

        return null;
    }

    public function hasExactlySelected(mixed $data, int $requiredCount): ?string
    {
        if (!is_array($data) || count($data) !== $requiredCount) {
            return "Должно быть выбрано ровно {$requiredCount} вариантов.";
        }

        return null;
    }

    public function SetRule(string $field_name, string $validator_name, mixed $value = null): void
    {
        $this->Rules[$field_name][] = [
            'validator' => $validator_name,
            'value' => $value,
        ];
    }

    public function Validate(array $post_array): bool
    {
        $this->Errors = [];

        foreach ($this->Rules as $field => $validators) {
            $fieldValue = $post_array[$field] ?? null;

            foreach ($validators as $rule) {
                $validator = $rule['validator'];
                $value = $rule['value'];

                if (!method_exists($this, $validator)) {
                    $this->Errors[] = "Для поля '{$field}' указан неизвестный валидатор '{$validator}'.";
                    continue;
                }

                $error = $value !== null
                    ? $this->{$validator}($fieldValue, $value)
                    : $this->{$validator}($fieldValue);

                if ($error !== null) {
                    $this->Errors[] = "{$field}: {$error}";
                    break;
                }
            }
        }

        return $this->Errors === [];
    }

    public function ShowErrors(): string
    {
        if ($this->Errors === []) {
            return '';
        }

        $items = array_map(
            static fn(string $error): string => '<li>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>',
            $this->Errors
        );

        return '<ul class="form-errors">' . implode('', $items) . '</ul>';
    }
}
