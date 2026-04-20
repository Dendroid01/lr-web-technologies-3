<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\TestFormRequest;
use App\Repositories\TestResultRepositoryInterface;
use App\Services\ResultsVerification;
use App\UseCases\VerifyTest\VerifyTestInput;
use App\UseCases\VerifyTest\VerifyTestUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FormPageController extends Controller
{
    public function showContacts(): View
    {
        return view('contacts');
    }

    public function submitContacts(ContactFormRequest $request): RedirectResponse
    {
        return back()->with('success', true);
    }

    public function showTest(): View
    {
        return view('test');
    }

    public function submitTest(TestFormRequest $request, VerifyTestUseCase $useCase): RedirectResponse
    {
        if(!Auth::check()){
            return back()->withInput()->with('auth_required', true);
        }

        $input = new VerifyTestInput(
            fullname: $request->input('fullname'),
            group: $request->input('group'),
            q1: $request->input('q1'),
            q2: $request->input('q2', []),
            q3: $request->input('q3'),
        );

        $output = $useCase->execute($input);

        return back()
            ->withInput()
            ->with('success', true)
            ->with('test_output', $output);
    }
}
