@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="blog-posts">
            <h1>Редактор блога</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    Пост успешно добавлен!
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Ошибка!</strong> Пожалуйста, исправьте следующие ошибки:
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="blog-editor-form">
                <h3 style="margin-bottom: 20px; color: #5a3e36;">Новая запись</h3>
                <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                    @csrf


                    <div class="form-field">
                        <label for="title">Тема сообщения *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               placeholder="Введите заголовок...">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-field">
                        <label for="image">Изображение</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small class="field-hint">Поддерживаются: JPG, PNG, GIF (макс. 2MB)</small>
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-field">
                        <label for="message">Текст сообщения *</label>
                        <textarea id="message" name="message" rows="6"
                                  placeholder="Напишите содержание поста...">{{ old('message') }}</textarea>
                        @error('message') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-field">
                        <label for="author">Автор *</label>
                        <input type="text" id="author" name="author" value="{{ old('author') }}"
                               placeholder="Ваше имя...">
                        @error('author') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit">Опубликовать</button>
                        <button type="reset" class="btn-reset">🗑 Очистить</button>
                    </div>
                </form>
            </div>

            <div class="blog-preview-list">
                <h3>Все записи блога ({{ $posts->total() }})</h3>

                @forelse($posts as $post)
                    <div class="blog-post-preview">
                        <div class="preview-header">
                            <div class="preview-info">
                                <strong>{{ $post->created_at->format('d.m.Y H:i') }}</strong>
                                — {{ $post->title }}
                                <em>({{ $post->author }})</em>
                            </div>
                            <div class="preview-actions">
                                <a href="{{ route('blog.index') }}?post={{ $post->id }}"
                                   class="preview-link"
                                   target="_blank">
                                    Просмотр
                                </a>
                            </div>
                        </div>
                        @if($post->image)
                            <div class="preview-image-hint">
                                Изображение: {{ basename($post->image) }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-message">
                        Пока нет ни одной записи. Создайте первую!
                    </div>
                @endforelse

                <div class="blog-pagination">
                    {{ $posts->links() }}
                </div>
            </div>

            <div class="back-link-wrapper">
                <a href="{{ route('admin.blog.import') }}" class="back-link">Импорт из CSV →</a>
                <a href="{{ route('blog.index') }}" class="back-link" style="margin-left: 15px;">Просмотр блога →</a>
            </div>
        </section>
    </div>
@endsection
