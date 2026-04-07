<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. Мои интересы</title>
    @vite(['resources/css/main.min.css', 'resources/js/app.js'])
</head>

<body>
<header>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Главная страница</a></li>
            <li><a href="{{ url('/about') }}">Обо мне</a></li>
            <li class="dropdown">
                <a class="dropdown-link active" href="{{ url('/interests') }}">Мои интересы</a>
                <ul class="dropdown-menu">
                    @foreach($categories as $category)
                        <li><a href="{{ url('/interests#' . $category['id']) }}">{{ $category['title'] }}</a></li>
                    @endforeach
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
        <h1>Мои интересы</h1>
    </section>

    <section class="page-layout">
        <aside class="anchors">
            <ul>
                @foreach($categories as $category)
                    <li><a href="#{{ $category['id'] }}">{{ $category['title'] }}</a></li>
                @endforeach
            </ul>
        </aside>

        <section class="content" id="interests-content">
            @foreach($categories as $category)
                <div class="list-group" id="{{ $category['id'] }}">
                    <h3>{{ $category['title'] }}</h3>

                    <div class="list-container">
                        @foreach($category['items'] as $item)
                            <article class="item-card">
                                <p>{{ $item['name'] }}</p>
                                <span class="hover-text">{{ $item['description'] }}</span>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
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
