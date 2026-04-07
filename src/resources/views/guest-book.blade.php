@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="page-title">
            <h1>Гостевая книга</h1>
            <p>Оставьте свой отзыв или пожелание.</p>
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

            <form method="POST" action="{{ route('guest-book.store') }}">
                @csrf

                <label for="last_name">Фамилия:</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}">

                <label for="first_name">Имя:</label>
                <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}">

                <label for="middle_name">Отчество:</label>
                <input id="middle_name" name="middle_name" type="text" value="{{ old('middle_name') }}">

                <label for="email">E-mail:</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}">

                <label for="message">Текст отзыва:</label>
                <textarea id="message" name="message" rows="5">{{ old('message') }}</textarea>

                <button type="submit">Отправить</button>
                <button type="reset">Очистить форму</button>
            </form>
        </section>

        <section class="guestbook-list">
            <h2>Отзывы</h2>
            @if($messages->isEmpty())
                <p class="empty-message">Пока нет ни одного отзыва.</p>
            @else
                <table class="guestbook-table">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>ФИО</th>
                        <th>E-mail</th>
                        <th>Отзыв</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $msg)
                        <tr>
                            <td>{{ $msg->created_at->format('d.m.Y') }}</td>
                            <td>{{ $msg->last_name }} {{ $msg->first_name }} {{ $msg->middle_name }}</td>
                            <td>{{ $msg->email }}</td>
                            <td>{{ $msg->message }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </div>
@endsection
