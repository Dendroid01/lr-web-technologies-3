<?php

namespace App\Services;

interface ResultsVerificationInterface
{
    public function verify(array $answers): array;
    public function countCorrect(array $results): int;
}
