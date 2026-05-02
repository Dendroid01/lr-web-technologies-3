<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админ-панель</title>
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <style>
        body { background: #f0f4f8; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 { text-align: center; margin-bottom: 30px; color: #1a1a2e; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 700; color: #333; }
        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus { border-color: #0056b3; outline: none; }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-submit:hover { background: #0056b3; }
        .error-msg { color: #dc3545; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Вход в админ-панель</h2>

    @if($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="{{ old('login') }}" required autofocus>
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-submit">Войти</button>
    </form>
</div>
</body>
</html>
