@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="blog-posts">
            <h1>Редактор Блога</h1>

            @if(session('success'))
                <p class="valid">
                    Ваш пост успешно добавлен!
                </p>
            @endif

            <div class="blog-editor-form">
                <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label>Тема сообщения *</label>
                        <input type="text" name="title" value="{{ old('title') }}">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Изображение</label>
                        <input type="file" name="image" accept="image/*">
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Текст сообщения *</label>
                        <textarea name="message" rows="6">{{ old('message') }}</textarea>
                        @error('message') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Автор *</label>
                        <input type="text" name="author" value="{{ old('author') }}">
                        @error('author') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit">Добавить запись</button>
                </form>
            </div>

            <div class="blog-preview-list">
                <h3>Все записи</h3>

                @forelse($posts as $post)
                    <div class="blog-post-preview">
                        <strong>{{ $post->created_at->format('d.m.Y H:i') }}</strong>
                        — {{ $post->title }}
                        <em>({{ $post->author }})</em>
                    </div>
                @empty
                    <p>Записей пока нет.</p>
                @endforelse

                {{ $posts->links() }}
            </div>

            <div class="back-link-wrapper">
                <a href="{{ route('admin.blog.import') }}" class="back-link">Загрузить из CSV →</a>
            </div>
        </section>
    </div>
@endsection
