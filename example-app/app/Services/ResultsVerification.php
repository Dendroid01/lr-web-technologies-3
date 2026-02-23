<?php

namespace App\Services;

class ResultsVerification extends CustomFormValidation
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

    public array $VerificationResults = [];

    public function verifyAnswers(array $postArray): array
    {
        $this->VerificationResults = [];

        foreach ($this->questionsMap as $field => $definition) {
            $type = $definition['type'];
            $correct = $definition['correct'];
            $userValue = $postArray[$field] ?? null;

            $isCorrect = match ($type) {
                'text' => $this->checkTextAnswer($userValue, $correct),
                'radio', 'combobox' => $this->checkSingleChoiceAnswer($userValue, $correct),
                'checkbox' => $this->checkMultipleChoiceAnswer($userValue, $correct),
                default => false,
            };

            $this->VerificationResults[] = $isCorrect
                ? "{$field}: верно"
                : "{$field}: неверно";
        }

        return $this->VerificationResults;
    }

    public function countCorrectAnswers(): int
    {
        return count(array_filter(
            $this->VerificationResults,
            static function (string $item): bool {
                $parts = explode(': ', $item, 2);

                return ($parts[1] ?? '') === 'верно';
            }
        ));
    }

    public function showVerificationResults(): string
    {
        if ($this->VerificationResults === []) {
            return '';
        }

        $total = count($this->VerificationResults);
        $correct = $this->countCorrectAnswers();

        $items = array_map(
            static fn(string $result): string => '<li>' . htmlspecialchars($result, ENT_QUOTES, 'UTF-8') . '</li>',
            $this->VerificationResults
        );

        return '<div class="test-results">'
            . '<p>Результат теста: ' . $correct . ' из ' . $total . '.</p>'
            . '<ul>' . implode('', $items) . '</ul>'
            . '</div>';
    }

    private function checkTextAnswer(mixed $userValue, string|array $correctValue): bool
    {
        if (!is_string($userValue) || !is_string($correctValue)) {
            return false;
        }

        return mb_strtolower(trim($userValue)) === mb_strtolower(trim($correctValue));
    }

    private function checkSingleChoiceAnswer(mixed $userValue, string|array $correctValue): bool
    {
        if (!is_string($userValue) || !is_string($correctValue)) {
            return false;
        }

        return trim($userValue) === $correctValue;
    }

    private function checkMultipleChoiceAnswer(mixed $userValue, string|array $correctValue): bool
    {
        if (!is_array($userValue) || !is_array($correctValue)) {
            return false;
        }

        sort($userValue);
        sort($correctValue);

        return $userValue === $correctValue;
    }
}
