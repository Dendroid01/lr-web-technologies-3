<?php

namespace App\Repositories;

use App\Models\TestResult;

class EloquentTestResultRepository implements TestResultRepositoryInterface
{
    public function save(
        string $fullname,
        string $group,
        array  $answers,
        array  $results,
        int    $total,
        int    $correct
    ): void
    {
        TestResult::create([
            'fullname' => $fullname,
            'group_name' => $group,
            'answers' => $answers,
            'results' => $results,
            'total' => $total,
            'correct' => $correct,
        ]);
    }

    public function paginate(int $perPage = 20)
    {
        return TestResult::latest()->paginate($perPage);
    }
}
