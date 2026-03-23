<?php

namespace App\UseCases\VerifyTest;

use App\Services\ResultsVerification;

class VerifyTestUseCase
{
    public function __construct(
        private readonly ResultsVerification $verifier,
    ) {}

    public function execute(VerifyTestInput $input): VerifyTestOutput
    {
        $data = [
            'q1' => $input->q1,
            'q2' => $input->q2,
            'q3' => $input->q3,
        ];

        $this->verifier->verifyAnswers($data);

        $total   = count($this->verifier->VerificationResults);
        $correct = $this->verifier->countCorrectAnswers();

        $results = [];
        foreach ($this->verifier->VerificationResults as $result) {
            [$field, $verdict] = explode(': ', $result, 2);
            $results[$field] = $verdict === 'верно';
        }

        return new VerifyTestOutput(
            total:   $total,
            correct: $correct,
            results: $results,
        );
    }
}
