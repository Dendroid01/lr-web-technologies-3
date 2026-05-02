@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="auth-card">
        <h1>Создать аккаунт</h1>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="last_name">Фамилия *</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                       class="@error('last_name') invalid @enderror">
                @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="first_name">Имя *</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required
                       class="@error('first_name') invalid @enderror">
                @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="middle_name">Отчество</label>
                <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}">
                @error('middle_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="email">E-mail *</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="@error('email') invalid @enderror">
                @error('email')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="login">Логин *</label>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required
                       class="@error('login') invalid @enderror">
                @error('login')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль *</label>
                <input id="password" type="password" name="password" required
                       class="@error('password') invalid @enderror">
                @error('password')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Подтверждение пароля *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Зарегистрироваться</button>

            <div class="auth-footer">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </div>
        </form>
    </div>
@endsection
