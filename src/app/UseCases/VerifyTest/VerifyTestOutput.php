<?php

namespace App\UseCases\VerifyTest;

class VerifyTestOutput
{
    public function __construct(
        public readonly int   $total,
        public readonly int   $correct,
        public readonly array $results,
    ) {}
}
