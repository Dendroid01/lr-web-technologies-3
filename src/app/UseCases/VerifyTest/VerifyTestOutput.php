<?php

// app/UseCases/VerifyTest/VerifyTestOutput.php

namespace App\UseCases\VerifyTest;

class VerifyTestOutput
{
    public function __construct(
        public readonly int   $total,
        public readonly int   $correct,
        public readonly array $results,
    ) {}

    public function successRate(): float
    {
        if ($this->total === 0) {
            return 0;
        }

        return round(($this->correct / $this->total) * 100, 2);
    }
}
