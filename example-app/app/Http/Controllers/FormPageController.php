<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\TestFormRequest;
use App\Services\ResultsVerification;
use App\UseCases\VerifyTest\VerifyTestInput;
use App\UseCases\VerifyTest\VerifyTestUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FormPageController extends Controller
{
    public function showContacts(): View
    {
        return view('contacts');
    }

    public function submitContacts(ContactFormRequest $request): RedirectResponse
    {
        // Сюда код дойдёт только если валидация прошла
        return back()->with('success', 'Форма контактов успешно прошла валидацию на сервере.');
    }

    public function showTest(): View
    {
        return view('test');
    }

    public function submitTest(TestFormRequest $request, VerifyTestUseCase $verifyTestUseCase): RedirectResponse
    {
        $input = new VerifyTestInput(
            fullname: $request->input('fullname'),
            group: $request->input('group'),
            q1: $request->input('q1'),
            q2: $request->input('q2', []),
            q3: $request->input('q3'),
        );

        $output = $verifyTestUseCase->execute($input);

        return back()
            ->withInput()
            ->with('success', 'Тест успешно проверен.')
            ->with('test_output', $output);
    }
}
