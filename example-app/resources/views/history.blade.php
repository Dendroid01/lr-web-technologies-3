<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. История просмотра</title>
    @vite(['resources/css/main.min.css', 'resources/js/app.js', 'resources/js/history-tracker/history-tracker-init.js'])
</head>

<body>
<header>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Главная страница</a></li>
            <li><a href="{{ url('/about') }}">Обо мне</a></li>
            <li class="dropdown">
                <a class="dropdown-link" href="{{ url('/interests') }}">Мои интересы</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/interests#hobby') }}">Моё хобби</a></li>
                    <li><a href="{{ url('/interests#books') }}">Любимые книги</a></li>
                    <li><a href="{{ url('/interests#music') }}">Любимая музыка</a></li>
                    <li><a href="{{ url('/interests#films') }}">Любимые фильмы</a></li>
                </ul>
            </li>
            <li><a href="{{ url('/study') }}">Учёба</a></li>
            <li><a href="{{ url('/gallery') }}">Фотоальбом</a></li>
            <li><a href="{{ url('/contacts') }}">Контакты</a></li>
            <li><a class="active" href="{{ url('/history') }}">История просмотра</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="page-title">
        <h1>История просмотра</h1>
    </section>

    <section class="history-section">
        <h2>История текущего сеанса</h2>
        <p>Данные хранятся в Local Storage и сбрасываются при закрытии браузера</p>
        <table class="history-table" id="session-history">
            <thead>
            <tr>
                <th>Страница</th>
                <th>Количество посещений</th>
                <th>Последнее посещение</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <section class="history-section">
        <h2>История за все время</h2>
        <p>Данные хранятся в Cookies и сохраняются между сеансами</p>
        <table class="history-table" id="total-history">
            <thead>
            <tr>
                <th>Страница</th>
                <th>Количество посещений</th>
                <th>Последнее посещение</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <div class="history-actions">
        <button class="history-btn" id="clear-session">Очистить историю сеанса</button>
        <button class="history-btn" id="clear-total">Очистить всю историю</button>
    </div>
</main>

<footer>
    <div class="footer-content">
        <p>&copy; Gordienko D.O, 2025</p>
        <div class="datetime" id="datetime"></div>
    </div>
</footer>
</body>
</html>
