<?php

namespace App\UseCases\VerifyTest;

use App\Services\ResultsVerificationInterface;
use App\Repositories\TestResultRepositoryInterface;

class VerifyTestUseCase
{
    public function __construct(
        private readonly ResultsVerificationInterface  $verifier,
        private readonly TestResultRepositoryInterface $repository
    )
    {
    }

    public function execute(VerifyTestInput $input): VerifyTestOutput
    {
        $answers = $input->answers();

        $results = $this->verifier->verify($answers);

        $total = count($results);
        $correct = $this->verifier->countCorrect($results);

        $this->repository->save(
            $input->fullname,
            $input->group,
            $answers,
            $results,
            $total,
            $correct
        );

        return new VerifyTestOutput($total, $correct, $results);
    }
}
