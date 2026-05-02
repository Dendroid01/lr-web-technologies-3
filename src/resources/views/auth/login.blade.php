@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="auth-card">
        <h1>Добро пожаловать</h1>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            @if($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <label for="login">Логин</label>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                       class="@error('login') invalid @enderror">
                @error('login')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required
                       class="@error('password') invalid @enderror">
                @error('password')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <button type="submit">Войти</button>

            <div class="auth-footer">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </form>
    </div>
@endsection
