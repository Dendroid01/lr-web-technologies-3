@extends('layouts.app')

@section('content')
    <div style="max-width:400px;margin:0 auto;">
        <h1>Вход</h1>

        <form method="POST" action="{{ route('login.submit') }}" class="contact-form">
            @csrf

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <div>
                <label>Логин</label>
                <input type="text" name="login" value="{{ old('login') }}" required autofocus>
            </div>

            <div>
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Войти</button>

            <p style="text-align:center;margin-top:15px;">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </p>
        </form>
    </div>
@endsection
