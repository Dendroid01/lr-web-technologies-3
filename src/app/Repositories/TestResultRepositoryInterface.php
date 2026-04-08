<?php

namespace App\Repositories;

interface TestResultRepositoryInterface
{
    public function save(
        string $fullname,
        string $group,
        array  $answers,
        array  $results,
        int    $total,
        int    $correct
    ): void;

    public function paginate(int $perPage = 20);
}
