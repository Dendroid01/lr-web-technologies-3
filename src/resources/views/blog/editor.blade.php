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

    {{-- Модальное окно редактирования --}}
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('edit-post-btn')) {
                        const postId = e.target.dataset.postId;

                        if (!postId) {
                            alert('Ошибка: ID поста не найден');
                            return;
                        }

                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', '/admin/blog/' + postId + '/edit', true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                const data = JSON.parse(xhr.responseText);
                                document.getElementById('edit-post-id').value = data.id;
                                document.getElementById('edit-title').value = data.title;
                                document.getElementById('edit-message').value = data.message;
                                document.getElementById('edit-modal').classList.add('show');
                            } else {
                                alert('Ошибка при загрузке данных записи');
                            }
                        };
                        xhr.onerror = function () {
                            alert('Ошибка соединения с сервером');
                        };
                        xhr.send();
                    }
                });

                document.getElementById('save-edit-btn').addEventListener('click', function () {
                    const postId = document.getElementById('edit-post-id').value;
                    const title = document.getElementById('edit-title').value.trim();
                    const message = document.getElementById('edit-message').value.trim();


                    if (!title || !message) {
                        alert('Заполните тему и текст сообщения');
                        return;
                    }

                    if (!postId) {
                        alert('Ошибка: ID поста не найден');
                        return;
                    }

                    const xhr = new XMLHttpRequest();
                    xhr.open('PUT', '/admin/blog/' + postId, true);
                    xhr.setRequestHeader('Content-Type', 'application/json');

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
                    } else {
                        console.error('CSRF-токен не найден');
                        alert('Ошибка безопасности: CSRF-токен не найден');
                        return;
                    }

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const resp = JSON.parse(xhr.responseText);
                            if (resp.success) {
                                const row = document.getElementById('post-row-' + resp.post.id);
                                if (row) {
                                    row.querySelector('.post-title').textContent = resp.post.title;
                                }
                                closeEditModal();
                                showNotification('Запись успешно обновлена');
                            }
                        } else if (xhr.status === 422) {
                            const errors = JSON.parse(xhr.responseText);
                            let errorMsg = 'Ошибки валидации:\n';
                            for (const key in errors.errors) {
                                errorMsg += errors.errors[key].join('\n') + '\n';
                            }
                            alert(errorMsg);
                        } else {
                            alert('Ошибка при сохранении. Код: ' + xhr.status);
                        }
                    };
                    xhr.onerror = function () {
                        alert('Ошибка соединения с сервером');
                    };
                    xhr.send(JSON.stringify({
                        title: title,
                        message: message,
                        author: '{{ auth()->user()->name ?? "Admin" }}'
                    }));
                });
            });

            function closeEditModal() {
                document.getElementById('edit-modal').classList.remove('show');
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.textContent = message;
                notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: fadeIn 0.3s ease;
    `;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }

            document.addEventListener('click', function (e) {
                if (e.target.id === 'edit-modal') {
                    closeEditModal();
                }
            });
            
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && document.getElementById('edit-modal').classList.contains('show')) {
                    closeEditModal();
                }
            });
        </script>
    @endpush
@endsection
