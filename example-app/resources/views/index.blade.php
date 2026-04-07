<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. Главная страница</title>
    @vite(['resources/css/main.min.css', 'resources/js/app.js'])
</head>

<body>
<header>
    <nav>
        <ul>
            <li><a class="active" href="{{ url('/') }}">Главная страница</a></li>
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
            <li><a href="{{ url('/history') }}">История просмотра</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="page-title">
        <h1>Главная страница</h1>
    </section>

    <section class="content">
        <div class="profile">
            <img alt="Моё фото" src="{{ asset('images/me.jpg') }}">
        </div>

        <div class="info">
            <p>
                ФИО: Гордиенко Денис Олегович <br>
                Группа: ИС/б-23-1-о
            </p>
            <br>
            <p>Лабораторная работа №1 &laquo;Исследование возможностей языка разметки гипертекстов HTML и каскадных
                таблиц стилей CSS&raquo;</p>
        </div>
    </section>
</main>

<footer>
    <div class="footer-content">
        <p>&copy; Gordienko D.O, 2025</p>
        <div class="datetime" id="datetime"></div>
    </div>
</footer>
</body>
</html>
