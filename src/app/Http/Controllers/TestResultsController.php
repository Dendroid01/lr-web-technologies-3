<?php

namespace App\Http\Controllers;

use App\Models\TestResult;

use App\Repositories\TestResultRepositoryInterface;

class TestResultsController extends Controller
{
    public function __construct(
        private TestResultRepositoryInterface $repository
    ) {}

    public function index()
    {
        $results = $this->repository->paginate();

        return view('test-results', compact('results'));
    }
}
