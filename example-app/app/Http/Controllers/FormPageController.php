<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\TestFormRequest;
use App\Services\ResultsVerification;
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

    public function submitTest(TestFormRequest $request): RedirectResponse
    {
        $verifier = new ResultsVerification();
        $verifier->verifyAnswers($request->validated());

        return back()
            ->withInput()
            ->with('success', 'Тест успешно проверен на сервере.')
            ->with('validation_html', $verifier->showVerificationResults());
    }
}
