@extends('layouts.app')

@section('content')
    <div style="max-width:600px;margin:0 auto;">
        <h1>Регистрация</h1>

        <form method="POST" action="{{ route('register.submit') }}" class="contact-form">
            @csrf

            <div>
                <label>Фамилия *</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>Имя *</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>Отчество</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}">
                @error('middle_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>E-mail *</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>Логин *</label>
                <input type="text" name="login" value="{{ old('login') }}" required>
                @error('login')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>Пароль *</label>
                <input type="password" name="password" required>
                @error('password')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label>Подтверждение пароля *</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Зарегистрироваться</button>

            <p style="text-align:center;margin-top:15px;">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </p>
        </form>
    </div>
@endsection
