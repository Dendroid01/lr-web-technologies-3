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
                    <div class="blog-post-preview" id="post-row-{{ $post->id }}">
                        <div class="preview-header">
                            <div class="preview-info">
                                <strong>{{ $post->created_at->format('d.m.Y H:i') }}</strong>
                                — <span class="post-title">{{ $post->title }}</span>
                                <em>({{ $post->author }})</em>
                            </div>
                            <div class="preview-actions">
                                <button type="button" class="edit-post-btn" data-post-id="{{ $post->id }}"
                                        style="margin-right: 8px; padding: 6px 12px; background: #0056b3; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    Изменить
                                </button>
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

    <div class="blur-modal" id="edit-modal">
        <div class="blur-modal-content">
            <span class="blur-modal-close" onclick="closeEditModal()">&times;</span>
            <div class="blur-modal-body">
                <h2>Редактирование записи</h2>
                <input type="hidden" id="edit-post-id">
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 700; color: #5a3e36; display: block; margin-bottom: 6px;">Тема
                        сообщения:</label>
                    <input type="text" id="edit-title"
                           style="width:100%; padding: 10px 15px; font-size: 16px; border: 2px solid #d2b48c; border-radius: 8px; outline: none;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 700; color: #5a3e36; display: block; margin-bottom: 6px;">Текст
                        сообщения:</label>
                    <textarea id="edit-message" rows="6"
                              style="width:100%; padding: 10px 15px; font-size: 16px; border: 2px solid #d2b48c; border-radius: 8px; outline: none; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeEditModal()"
                            style="padding: 10px 20px; background: #6c757d; color: #fff; border: none; border-radius: 6px; cursor: pointer;">
                        Отмена
                    </button>
                    <button type="button" id="save-edit-btn"
                            style="padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 6px; cursor: pointer;">
                        Сохранить изменения
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
    @push('scripts')
        <meta name="user-name" content="{{ auth()->user()->name ?? 'Admin' }}">
        @vite(['resources/js/blog/blog-editor.js'])
    @endpush
