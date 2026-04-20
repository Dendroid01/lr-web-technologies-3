@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="csv-import-section">
            <h3>Загрузка сообщений блога из CSV</h3>

            <div class="csv-import-form">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('blog.import.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="file-input-group">
                        <label>
                            Файл CSV
                            <span class="file-hint">(формат CSV, разделитель «;»)</span>
                            <span class="required">*</span>
                        </label>
                        <input type="file"
                               name="file"
                               id="csvFile"
                               accept=".csv,.txt"
                               class="{{ $errors->has('file') ? 'invalid' : '' }}">
                        @error('file')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="file-info">
                            <span class="file-format">Поддерживаемые форматы: CSV, TXT</span>
                            <span class="file-separator">Разделитель: точка с запятой (;)</span>
                        </div>
                    </div>

                    <div class="import-actions">
                        <button type="submit" id="submitBtn">Загрузить и импортировать</button>
                        <button type="reset">🗑 Очистить</button>
                    </div>
                </form>

                <div class="back-link-wrapper">
                    <a href="{{ route('blog.editor') }}" class="back-link">← Редактор блога</a>
                </div>
            </div>
        </div>

        <div class="csv-import-section">
            <h3>Пример содержимого файла</h3>
            <div class="csv-import-form">
                <pre style="background: #f5f5f5; padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 13px;">
title;message;author;created_at
"тема 1";"сообщение 1";"Василий Петров";"2019-01-01 14:00:00"
"тема 2";"сообщение 2";"Мария Иванова";"2019-02-15 09:30:00"
"тема 3";"еще одно сообщение";"Анна Сидорова";"2020-03-20 18:45:00"</pre>
                <p style="margin-top: 10px; font-size: 13px; color: #666;">
                    <strong>Примечание:</strong> Разделитель — точка с запятой (;).
                    Первая строка — заголовки (обязательны).
                    Дата должна быть в формате <code>YYYY-MM-DD HH:MM:SS</code>.
                </p>
            </div>
        </div>
    </div>
@endsection
