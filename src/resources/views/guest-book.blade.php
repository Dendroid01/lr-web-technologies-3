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

        <div class="csv-import-section">
            <h3>Загрузка сообщений из CSV</h3>

            @if(session('import_success'))
                <div class="alert alert-success">{{ session('import_success') }}</div>
            @endif

            @if(session('import_error'))
                <div class="alert alert-error">{{ session('import_error') }}</div>
            @endif

            <div class="csv-import-form">
                <form method="POST" action="{{ route('guest-book.import.store') }}" enctype="multipart/form-data"
                      id="csvImportForm">
                    @csrf

                    <div class="file-input-group">
                        <label>
                            Файл messages.inc
                            <span class="file-hint">(формат CSV, разделитель «;»)</span>
                            <span class="required">*</span>
                        </label>
                        <input type="file"
                               name="file"
                               id="csvFile"
                               accept=".csv,.inc"
                               class="{{ $errors->has('file') ? 'invalid' : (old('file') ? 'valid' : '') }}">
                        @error('file')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="file-info">
                            <span class="file-format">Поддерживаемые форматы: CSV, INC, TXT</span>
                            <span class="file-separator">Разделитель: точка с запятой (;)</span>
                        </div>
                    </div>

                    <div class="import-actions">
                        <button type="submit" id="submitBtn">Загрузить и импортировать</button>
                        <button type="reset" onclick="resetForm()">🗑 Очистить</button>
                    </div>
                </form>
            </div>
        </div>

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
                            <td>{{ $msg->created_at->format('d.m.Y H:i') }}</td>
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
