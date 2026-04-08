<?php

namespace App\UseCases\VerifyTest;

class VerifyTestInput
{
    public function __construct(
        public readonly string $fullname,
        public readonly string $group,
        public readonly string $q1,
        public readonly array  $q2,
        public readonly string $q3,
    )
    {
    }

    public function answers(): array
    {
        return [
            'q1' => $this->q1,
            'q2' => $this->q2,
            'q3' => $this->q3,
        ];
    }
}


