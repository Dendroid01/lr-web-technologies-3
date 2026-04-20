@extends('layouts.app')

@section('content')
    <div class="csv-import-section">
        <h3>Загрузка сообщений из CSV</h3>

        <div class="csv-import-form">
    <form method="POST" action="{{ route('admin.guest-book.import.store') }}" enctype="multipart/form-data"
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
            <div class="back-link-wrapper">
                <a href="{{ route('guest-book.index') }}" class="back-link">Вернуться к гостевой книге</a>
            </div>
</div>
</div>
    @if(session('import_success'))
        <div class="alert alert-success">{{ session('import_success') }}</div>
    @endif

    @if(session('import_error'))
        <div class="alert alert-error">{{ session('import_error') }}</div>
    @endif
@endsection
