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

        //сделать вердикт булевым
        $results = $this->verifier->VerificationResults;

        return new VerifyTestOutput(
            total:   $total,
            correct: $correct,
            results: $results,
        );
    }
}
//ПРИ ВЫПОЛНЕНИИ ЛР2 НЕ НУЖНО ПИСАТЬ КЛАСС ACTIVERECORD
//ОРГАНИЗОВАТЬ ГОСТЕВУЮ СТРАНИЧКУ В БД, ИМПОРТ CSV ФАЙЛА С СОХРАНЕНИЕМ ИДЕМПОТЕНТНОСТИ
