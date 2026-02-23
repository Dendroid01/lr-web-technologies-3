<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. Контакты</title>
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
            <li><a href="{{ url('/gallery') }}">Фотоальбом</a></li>
            <li><a class="active" href="{{ url('/contacts') }}">Контакты</a></li>
            <li><a href="{{ url('/test') }}">Тест</a></li>
            <li><a href="{{ url('/history') }}">История просмотра</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="page-title">
        <h1>Контакты</h1>
        <p>Данная страница позволяет отправить сообщение на мой персональный почтовый ящик.</p>
    </section>

    <section class="contact-form">
        @if(session('success'))
            <p class="valid">{{ session('success') }}</p>
        @endif

        @if(session('validation_html'))
            {!! session('validation_html') !!}
        @endif

        <form action="{{ route('contacts.submit') }}" method="post">
            @csrf

            <label for="fullname">Фамилия Имя Отчество:</label>
            <input id="fullname" name="fullname" type="text" value="{{ old('fullname') }}">

            <label>Пол:</label>
            <div class="gender-options">
                <input id="male" name="gender" type="radio" value="Мужской" {{ old('gender') === 'Мужской' ? 'checked' : '' }}>
                <label for="male">Мужской</label>

                <input id="female" name="gender" type="radio" value="Женский" {{ old('gender') === 'Женский' ? 'checked' : '' }}>
                <label for="female">Женский</label>
            </div>

            <label for="age">Возраст:</label>
            <select id="age" name="age">
                <option value="">-- выберите --</option>
                <option value="до 18" {{ old('age') === 'до 18' ? 'selected' : '' }}>до 18</option>
                <option value="18-25" {{ old('age') === '18-25' ? 'selected' : '' }}>18–25</option>
                <option value="26-35" {{ old('age') === '26-35' ? 'selected' : '' }}>26–35</option>
                <option value="36-50" {{ old('age') === '36-50' ? 'selected' : '' }}>36–50</option>
                <option value="50+" {{ old('age') === '50+' ? 'selected' : '' }}>50+</option>
            </select>

            <label for="email">E-mail:</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}">

            <label for="phone">Телефон:</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone') }}">

            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" rows="5">{{ old('message') }}</textarea>

            <label for="birthdate">Дата рождения:</label>

            <input id="birthdate" name="birthdate" placeholder="мм/дд/гггг" type="text" value="{{ old('birthdate') }}">
            <button type="submit">Отправить</button>
            <button type="reset">Очистить форму</button>
        </form>
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
