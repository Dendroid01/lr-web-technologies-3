@extends('layouts.app')

@section('title', 'Тест по дисциплине «Физика»')

@section('content')
    <section class="page-title">
        <h1>Тест по дисциплине «Физика»</h1>
        <p>Пожалуйста, заполните форму и ответьте на вопросы.</p>
    </section>

    <section class="test-form">
        @if(session('auth_required'))
            <div class="alert alert-error">
                Для получения результатов теста необходимо
                <a href="{{ route('login') }}">войти</a> или
                <a href="{{ route('register') }}">зарегистрироваться</a>.
            </div>
        @endif

        @if(session('success'))
            <p class="valid">Форма успешно отправлена!</p>
        @endif

        @if ($errors->any())
            <ul class="form-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if(session('test_output'))
            @php $output = session('test_output') @endphp
            <div class="test-results">
                <p>Результат: {{ $output->correct }} из {{ $output->total }}</p>
                <ul>
                    @foreach($output->results as $field => $isCorrect)
                        <li>{{ $field }}: {{ $isCorrect ? 'верно' : 'неверно' }}</li>
                    @endforeach
                </ul>
            </div>
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
                    <option value="ИБ/б-25-2-о" {{ old('group') === 'ИБ/б-25-2-о' ? 'selected' : '' }}>ИБ/б-25-2-о</option>
                    <option value="ИИ/б-25-1-о" {{ old('group') === 'ИИ/б-25-1-о' ? 'selected' : '' }}>ИИ/б-25-1-о</option>
                    <option value="ИИ/б-25-2-о" {{ old('group') === 'ИИ/б-25-2-о' ? 'selected' : '' }}>ИИ/б-25-2-о</option>
                    <option value="ИИ/б-25-3-о" {{ old('group') === 'ИИ/б-25-3-о' ? 'selected' : '' }}>ИИ/б-25-3-о</option>
                    <option value="ИИ/б-25-4-о" {{ old('group') === 'ИИ/б-25-4-о' ? 'selected' : '' }}>ИИ/б-25-4-о</option>
                    <option value="ИИ/б-25-5-о" {{ old('group') === 'ИИ/б-25-5-о' ? 'selected' : '' }}>ИИ/б-25-5-о</option>
                    <option value="ИИ/б-25-6-о" {{ old('group') === 'ИИ/б-25-6-о' ? 'selected' : '' }}>ИИ/б-25-6-о</option>
                    <option value="ИИ/б-25-7-о" {{ old('group') === 'ИИ/б-25-7-о' ? 'selected' : '' }}>ИИ/б-25-7-о</option>
                    <option value="ИИ/б-25-8-о" {{ old('group') === 'ИИ/б-25-8-о' ? 'selected' : '' }}>ИИ/б-25-8-о</option>
                    <option value="УТС/б-25-1-о" {{ old('group') === 'УТС/б-25-1-о' ? 'selected' : '' }}>УТС/б-25-1-о</option>
                    <option value="ЦТ/б-25-1-о" {{ old('group') === 'ЦТ/б-25-1-о' ? 'selected' : '' }}>ЦТ/б-25-1-о</option>
                </optgroup>
                <optgroup label="2 курс">
                    <option value="УТС/б-24-1-о" {{ old('group') === 'УТС/б-24-1-о' ? 'selected' : '' }}>УТС/б-24-1-о</option>
                    <option value="ИБ/б-24-1-о" {{ old('group') === 'ИБ/б-24-1-о' ? 'selected' : '' }}>ИБ/б-24-1-о</option>
                    <option value="ИБ/б-24-2-о" {{ old('group') === 'ИБ/б-24-2-о' ? 'selected' : '' }}>ИБ/б-24-2-о</option>
                    <option value="ИТ/б-24-1-о" {{ old('group') === 'ИТ/б-24-1-о' ? 'selected' : '' }}>ИТ/б-24-1-о</option>
                    <option value="ИТ/б-24-2-о" {{ old('group') === 'ИТ/б-24-2-о' ? 'selected' : '' }}>ИТ/б-24-2-о</option>
                    <option value="ИТ/б-24-3-о" {{ old('group') === 'ИТ/б-24-3-о' ? 'selected' : '' }}>ИТ/б-24-3-о</option>
                    <option value="ИТ/б-24-4-о" {{ old('group') === 'ИТ/б-24-4-о' ? 'selected' : '' }}>ИТ/б-24-4-о</option>
                    <option value="ИТ/б-24-5-о" {{ old('group') === 'ИТ/б-24-5-о' ? 'selected' : '' }}>ИТ/б-24-5-о</option>
                    <option value="ИТ/б-24-6-о" {{ old('group') === 'ИТ/б-24-6-о' ? 'selected' : '' }}>ИТ/б-24-6-о</option>
                    <option value="ИТ/б-24-7-о" {{ old('group') === 'ИТ/б-24-7-о' ? 'selected' : '' }}>ИТ/б-24-7-о</option>
                    <option value="ИТ/б-24-8-о" {{ old('group') === 'ИТ/б-24-8-о' ? 'selected' : '' }}>ИТ/б-24-8-о</option>
                    <option value="ЦТ/б-24-1-о" {{ old('group') === 'ЦТ/б-24-1-о' ? 'selected' : '' }}>ЦТ/б-24-1-о</option>
                </optgroup>
                <optgroup label="3 курс">
                    <option value="УТС/б-23-1-о" {{ old('group') === 'УТС/б-23-1-о' ? 'selected' : '' }}>УТС/б-23-1-о</option>
                    <option value="УТС/б-23-2-о" {{ old('group') === 'УТС/б-23-2-о' ? 'selected' : '' }}>УТС/б-23-2-о</option>
                    <option value="ИБ/б-23-1-о" {{ old('group') === 'ИБ/б-23-1-о' ? 'selected' : '' }}>ИБ/б-23-1-о</option>
                    <option value="ИБ/б-23-2-о" {{ old('group') === 'ИБ/б-23-2-о' ? 'selected' : '' }}>ИБ/б-23-2-о</option>
                    <option value="ИВТ/б-23-1-о" {{ old('group') === 'ИВТ/б-23-1-о' ? 'selected' : '' }}>ИВТ/б-23-1-о</option>
                    <option value="ИВТ/б-23-2-о" {{ old('group') === 'ИВТ/б-23-2-о' ? 'selected' : '' }}>ИВТ/б-23-2-о</option>
                    <option value="ИС/б-23-1-о" {{ old('group') === 'ИС/б-23-1-о' ? 'selected' : '' }}>ИС/б-23-1-о</option>
                    <option value="ИС/б-23-2-о" {{ old('group') === 'ИС/б-23-2-о' ? 'selected' : '' }}>ИС/б-23-2-о</option>
                    <option value="ПИ/б-23-1-о" {{ old('group') === 'ПИ/б-23-1-о' ? 'selected' : '' }}>ПИ/б-23-1-о</option>
                    <option value="ПИ/б-23-2-о" {{ old('group') === 'ПИ/б-23-2-о' ? 'selected' : '' }}>ПИ/б-23-2-о</option>
                    <option value="ПИН/б-23-1-о" {{ old('group') === 'ПИН/б-23-1-о' ? 'selected' : '' }}>ПИН/б-23-1-о</option>
                    <option value="ПИН/б-23-2-о" {{ old('group') === 'ПИН/б-23-2-о' ? 'selected' : '' }}>ПИН/б-23-2-о</option>
                </optgroup>
                <optgroup label="4 курс">
                    <option value="ИБ/б-22-1-о" {{ old('group') === 'ИБ/б-22-1-о' ? 'selected' : '' }}>ИБ/б-22-1-о</option>
                    <option value="ИБ/б-22-2-о" {{ old('group') === 'ИБ/б-22-2-о' ? 'selected' : '' }}>ИБ/б-22-2-о</option>
                    <option value="ИВТ/б-22-1-о" {{ old('group') === 'ИВТ/б-22-1-о' ? 'selected' : '' }}>ИВТ/б-22-1-о</option>
                    <option value="ИВТ/б-22-2-о" {{ old('group') === 'ИВТ/б-22-2-о' ? 'selected' : '' }}>ИВТ/б-22-2-о</option>
                    <option value="ИС/б-22-1-о" {{ old('group') === 'ИС/б-22-1-о' ? 'selected' : '' }}>ИС/б-22-1-о</option>
                    <option value="ИС/б-22-2-о" {{ old('group') === 'ИС/б-22-2-о' ? 'selected' : '' }}>ИС/б-22-2-о</option>
                    <option value="ПИ/б-22-1-о" {{ old('group') === 'ПИ/б-22-1-о' ? 'selected' : '' }}>ПИ/б-22-1-о</option>
                    <option value="ПИ/б-22-2-о" {{ old('group') === 'ПИ/б-22-2-о' ? 'selected' : '' }}>ПИ/б-22-2-о</option>
                    <option value="ПИН/б-22-1-о" {{ old('group') === 'ПИН/б-22-1-о' ? 'selected' : '' }}>ПИН/б-22-1-о</option>
                    <option value="ПИН/б-22-2-о" {{ old('group') === 'ПИН/б-22-2-о' ? 'selected' : '' }}>ПИН/б-22-2-о</option>
                    <option value="УТС/б-22-1-о" {{ old('group') === 'УТС/б-22-1-о' ? 'selected' : '' }}>УТС/б-22-1-о</option>
                    <option value="УТС/б-22-2-о" {{ old('group') === 'УТС/б-22-2-о' ? 'selected' : '' }}>УТС/б-22-2-о</option>
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
@endsection
