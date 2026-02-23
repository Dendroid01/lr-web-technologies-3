<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. Тест по дисциплине «Физика»</title>
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
            <li><a href="{{ url('/contacts') }}">Контакты</a></li>
            <li><a class="active" href="{{ url('/test') }}">Тест</a></li>
            <li><a href="{{ url('/history') }}">История просмотра</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="page-title">
        <h1>Тест по дисциплине «Физика»</h1>
        <p>Пожалуйста, заполните форму и ответьте на вопросы.</p>
    </section>

    <section class="test-form">
        @if(session('success'))
            <p class="valid">{{ session('success') }}</p>
        @endif

        @if(session('validation_html'))
            {!! session('validation_html') !!}
        @endif

        <form action="{{ route('test.submit') }}" method="post">
            @csrf

            <label for="fullname">Фамилия Имя Отчество:</label>
            <input id="fullname" name="fullname" type="text" value="{{ old('fullname') }}">

            <label for="group">Группа:</label>
            <select id="group" name="group">
                <option value="">-- выберите группу --</option>
                <optgroup label="1 курс">
                    <option value="ИБ/б-25-1-о" {{ old('group') === 'ИБ/б-25-1-о' ? 'selected' : '' }}>ИБ/б-25-1-о</option>
                    <option value="ИИ/б-25-1-о" {{ old('group') === 'ИИ/б-25-1-о' ? 'selected' : '' }}>ИИ/б-25-1-о</option>
                    <option value="УТС/б-25-1-о" {{ old('group') === 'УТС/б-25-1-о' ? 'selected' : '' }}>УТС/б-25-1-о</option>
                </optgroup>
                <optgroup label="2 курс">
                    <option value="УТС/б-24-1-о" {{ old('group') === 'УТС/б-24-1-о' ? 'selected' : '' }}>УТС/б-24-1-о</option>
                    <option value="ИБ/б-24-1-о" {{ old('group') === 'ИБ/б-24-1-о' ? 'selected' : '' }}>ИБ/б-24-1-о</option>
                    <option value="ИТ/б-24-1-о" {{ old('group') === 'ИТ/б-24-1-о' ? 'selected' : '' }}>ИТ/б-24-1-о</option>
                </optgroup>
            </select>

            <fieldset>
                <legend>Вопрос 1. Как называется закон, связывающий силу, массу и ускорение?</legend>
                <input name="q1" type="text" value="{{ old('q1') }}">
            </fieldset>

            <fieldset>
                <legend>Вопрос 2. Какие из перечисленных величин являются векторами? (выберите два варианта)</legend>
                <input id="force" name="q2[]" type="checkbox" value="Сила" {{ in_array('Сила', old('q2', []), true) ? 'checked' : '' }}>
                <label for="force">Сила</label><br>
                <input id="mass" name="q2[]" type="checkbox" value="Масса" {{ in_array('Масса', old('q2', []), true) ? 'checked' : '' }}>
                <label for="mass">Масса</label><br>
                <input id="velocity" name="q2[]" type="checkbox" value="Скорость" {{ in_array('Скорость', old('q2', []), true) ? 'checked' : '' }}>
                <label for="velocity">Скорость</label><br>
                <input id="time" name="q2[]" type="checkbox" value="Время" {{ in_array('Время', old('q2', []), true) ? 'checked' : '' }}>
                <label for="time">Время</label><br>
            </fieldset>

            <fieldset>
                <legend>Вопрос 3. Какой из законов относится к электродинамике?</legend>
                <select name="q3">
                    <option value="">-- выберите ответ --</option>
                    <optgroup label="Механика">
                        <option value="Закон Ньютона" {{ old('q3') === 'Закон Ньютона' ? 'selected' : '' }}>Закон Ньютона</option>
                        <option value="Закон сохранения импульса" {{ old('q3') === 'Закон сохранения импульса' ? 'selected' : '' }}>Закон сохранения импульса</option>
                    </optgroup>
                    <optgroup label="Электродинамика">
                        <option value="Закон Ома" {{ old('q3') === 'Закон Ома' ? 'selected' : '' }}>Закон Ома</option>
                        <option value="Закон Кулона" {{ old('q3') === 'Закон Кулона' ? 'selected' : '' }}>Закон Кулона</option>
                    </optgroup>
                </select>
            </fieldset>

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
