@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Загрузка сообщений блога</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('blog.import.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label>Файл CSV (поля: title, message, author, created_at)</label>
                <input type="file" name="file" accept=".csv,.txt">
                @error('file') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit">Загрузить</button>
        </form>

        <p>Пример содержимого файла:</p>
        <pre>title,message,author,created_at
"тема 1","сообщение 1","Vasiliy","2019-01-01 14:00"
"тема 2","сообщение 2","Maria","2019-02-15 09:30"</pre>

        <p><a href="{{ route('blog.editor') }}">← Редактор блога</a></p>
    </div>
@endsection
