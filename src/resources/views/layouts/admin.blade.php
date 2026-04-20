<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <style>
        .admin-wrapper { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .admin-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header h1 { margin: 0; font-size: 22px; }
        .admin-nav {
            background: #f0f4f8;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .admin-nav a {
            text-decoration: none;
            color: #333;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid #ddd;
        }
        .admin-nav a:hover { background: #0056b3; color: #fff; border-color: #0056b3; }
        .admin-logout {
            background: #dc3545;
            color: #fff !important;
            border-color: #dc3545 !important;
        }
        .admin-logout:hover { background: #c82333 !important; }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <div class="admin-header">
        <h1>Панель администратора</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background:#dc3545;color:#fff;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;">
                Выход
            </button>
        </form>
    </div>

    <div class="admin-nav">
        <a href="{{ route('admin.visits') }}">Статистика посещений</a>
        <a href="{{ route('admin.blog.editor') }}">Редактор блога</a>
        <a href="{{ route('admin.blog.import') }}">Импорт блога</a>
        <a href="{{ route('admin.guest-book.import') }}">Импорт гостевой книги</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <p style="margin:0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
