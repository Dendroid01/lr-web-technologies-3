<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. Фотоальбом</title>
    @vite(['resources/css/main.min.css', 'resources/js/app.js'])
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
            <li><a href="{{ url('/gallery') }}" class="active">Фотоальбом</a></li>
            <li><a href="{{ url('/contacts') }}">Контакты</a></li>
            <li><a href="{{ url('/history') }}">История просмотра</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="page-title">
        <h1>Фотоальбом</h1>
    </section>

    <section class="gallery" id="gallery" data-count="{{ $photoCount }}">
        @foreach($photos as $index => $photo)
            <div class="photo" data-index="{{ $index }}">
                <img
                    src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjM0MCIgdmlld0JveD0iMCAwIDMwMCAzNDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMzQwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMTUwIiB5PSIxNzAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4="
                    data-src="{{ asset($photo['src']) }}"
                    alt="{{ $photo['title'] }}"
                    loading="lazy"
                    class="lazy-image"
                >
                <p class="caption">{{ $photo['title'] }}</p>
                <span class="hover-text">{{ $photo['hover_text'] }}</span>
            </div>
        @endforeach
    </section>
</main>

<div class="modal" id="photo-modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="modal-nav">
            <button class="nav-btn prev-btn">&larr;</button>
            <button class="nav-btn next-btn">&rarr;</button>
        </div>
        <img alt="" class="modal-image" src="">
        <div class="modal-info">
            <h3 class="modal-title"></h3>
            <p class="modal-description"></p>
            <div class="modal-counter"></div>
        </div>
    </div>
</div>

<footer>
    <div class="footer-content">
        <p>&copy; Gordienko D.O, 2025</p>
        <div class="datetime" id="datetime"></div>
    </div>
</footer>

<script>
    window.galleryData = @json($photos);
    window.assetUrl = '{{ asset('') }}';
</script>

</body>
</html>
