<?php

namespace App\Services;

class CustomFormValidation extends FormValidation
{
//Базовый класс formrequest - в нем можно прописывать правила валидации !! - реализовать

//Пользовательский слой - работа с данными + бизнес логика - инфраструктурный слой - БД
//Formrequest лучше в http т.к это инфраструктурный слой
//middleware  посредник между запросом и методом контроллера в http
//Поянтие entity(сущность) таблички в базе сопоставляются с сущностью, но при нормализации
//
// Usecase - класс с единой зоной ответственности (1 действие - execute) input - output !! - применить для тестовой формы
// input и output - DTO
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

        $isValid = $this->Validate($postArray);

        if ($isValid) {
            $this->verifyAnswers($postArray);
        }

        return $this->Validate($postArray);
    }
}
