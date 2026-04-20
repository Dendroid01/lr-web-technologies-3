<?php

namespace App\Services;

class ResultsVerification implements ResultsVerificationInterface
{
    private array $questionsMap = [
        'q1' => [
            'type' => 'text',
            'correct' => 'Второй закон Ньютона',
        ],
        'q2' => [
            'type' => 'checkbox',
            'correct' => ['Сила', 'Скорость'],
        ],
        'q3' => [
            'type' => 'combobox',
            'correct' => 'Закон Ома',
        ],
    ];

    public function verify(array $answers): array
    {
        $results = [];

        foreach ($this->questionsMap as $field => $definition) {
            $type = $definition['type'];
            $correct = $definition['correct'];
            $userValue = $answers[$field] ?? null;

            $results[$field] = match ($type) {
                'text' => $this->checkTextAnswer($userValue, $correct),
                'radio', 'combobox' => $this->checkSingleChoiceAnswer($userValue, $correct),
                'checkbox' => $this->checkMultipleChoiceAnswer($userValue, $correct),
                default => false,
            };
        }

        return $results;
    }

    public function countCorrect(array $results): int
    {
        return count(array_filter($results));
    }

    private function checkTextAnswer(mixed $userValue, string $correctValue): bool
    {
        return is_string($userValue)
            && mb_strtolower(trim($userValue)) === mb_strtolower(trim($correctValue));
    }

    private function checkSingleChoiceAnswer(mixed $userValue, string $correctValue): bool
    {
        return is_string($userValue)
            && trim($userValue) === $correctValue;
    }

    private function checkMultipleChoiceAnswer(mixed $userValue, array $correctValue): bool
    {
        if (!is_array($userValue)) {
            return false;
        }

        sort($userValue);
        sort($correctValue);

        return $userValue === $correctValue;
    }
}
