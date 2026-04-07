@extends('layouts.app')

@section('title', 'Контакты')

@push('styles')
    @vite(['resources/js/calendar/init-calendar.js'])
@endpush

@section('content')
    <section class="page-title">
        <h1>Контакты</h1>
        <p>Данная страница позволяет отправить сообщение на мой персональный почтовый ящик.</p>
    </section>

    <section class="contact-form">
        @if(session('success'))
            <p class="valid">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="form-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
            <div class="birthdate-container">
                <input id="birthdate" name="birthdate" placeholder="мм/дд/гггг" type="text" value="{{ old('birthdate') }}">
                <div class="calendar" id="calendar"></div>
            </div>

            <button type="submit">Отправить</button>
            <button type="reset">Очистить форму</button>
        </form>
    </section>
@endsection
