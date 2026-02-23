<?php

namespace App\Http\Controllers;

use App\Services\FormValidation;
use App\Services\ResultsVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormPageController extends Controller
{
    public function showContacts(): View
    {
        return view('contacts');
    }

    public function submitContacts(Request $request): RedirectResponse
    {
        $validator = new FormValidation();

        $validator->SetRule('fullname', 'isFullName');
        $validator->SetRule('gender', 'isIn', ['Мужской', 'Женский']);
        $validator->SetRule('age', 'isIn', ['до 18', '18-25', '26-35', '36-50', '50+']);
        $validator->SetRule('email', 'isEmail');
        $validator->SetRule('phone', 'isPhone');
        $validator->SetRule('message', 'isNotEmpty');
        $validator->SetRule('birthdate', 'isBirthdate');

        if (!$validator->Validate($request->all())) {
            return back()
                ->withInput()
                ->with('validation_errors', $validator->Errors)
                ->with('validation_html', $validator->ShowErrors());
        }

        return back()->with('success', 'Форма контактов успешно прошла валидацию на сервере.');
    }

    public function showTest(): View
    {
        return view('test');
    }

    public function submitTest(Request $request): RedirectResponse
    {
        $validator = new ResultsVerification();


        if (!$validator->ValidateTestForm($request->all())) {
            return back()
                ->withInput()
                ->with('validation_errors', $validator->Errors)
                ->with('validation_html', $validator->ShowErrors());
        }

        return back()
            ->withInput()
            ->with('success', 'Тест успешно проверен на сервере.')
            ->with('validation_html', $validator->showVerificationResults());
    }
}
