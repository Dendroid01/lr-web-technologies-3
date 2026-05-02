@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="blog-posts">
            @if(session('import_stats'))
                <div class="alert alert-success">
                    Импортировано: {{ session('import_stats.imported') }},
                    пропущено: {{ session('import_stats.skipped') }}
                </div>
            @endif

            <h1>Мой блог</h1>

            @forelse($posts as $post)
                <article class="blog-post" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">
                    <h2>{{ $post->title }}</h2>
                    <div class="blog-meta">
                        {{ $post->created_at->format('d.m.Y H:i') }} — {{ $post->author }}
                    </div>

                    @if($post->image)
                        <div class="blog-image">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="{{ $post->title }}"
                                 onerror="this.style.display='none'">
                        </div>
                    @endif

                    <div class="blog-message">
                        {!! nl2br(e($post->message)) !!}
                    </div>

                    {{-- Блок комментариев внутри article --}}
                    <div class="comments-section" id="comments-{{ $post->id }}">
                        <h4 style="margin-bottom: 10px; color: #333;">Комментарии</h4>
                        <div class="comments-list">
                            <p class="loading-comments">Загрузка комментариев...</p>
                        </div>
                        @auth
                            <button class="add-comment-btn" data-post-id="{{ $post->id }}" type="button">
                                💬 Добавить комментарий
                            </button>
                        @endauth
                    </div>
                </article>
            @empty
                <div class="empty-message"
                     style="text-align: center; padding: 60px 20px; background: #f9f5f0; border-radius: 24px;">
                    <p style="font-size: 1.2rem; margin-bottom: 15px;">Пока нет записей в блоге</p>
                </div>
            @endforelse

            <div class="blog-pagination">
                {{ $posts->links() }}
            </div>

            {{-- Модальное окно для добавления комментария --}}
            <div class="blur-modal" id="comment-modal">
                <div class="blur-modal-content">
                    <span class="blur-modal-close">&times;</span>
                    <div class="blur-modal-body">
                        <h2>Новый комментарий</h2>
                        <div class="form-group">
                            <label for="comment-text">Текст комментария:</label>
                            <textarea id="comment-text" rows="4" placeholder="Введите ваш комментарий..."></textarea>
                            <small style="color: #666; display: block; margin-top: 5px;">
                                Минимум 3 символа • Ctrl+Enter для отправки
                            </small>
                        </div>
                        <div class="form-actions">
                            <button type="button" id="submit-comment-btn">Отправить</button>
                            <button type="button" class="cancel-btn">Отмена</button>
                        </div>
                    </div>
                </div>
            </div>

            @auth
                <div class="back-link-wrapper" style="margin-top: 30px; text-align: center;">
                    <a href="{{ route('admin.blog.editor') }}" class="back-link">Редактор блога →</a>
                </div>
            @endauth
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // ============================
        // ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
        // ============================

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        // ============================
        // ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ
        // ============================

        var currentCommentPostId = null;
        var commentsLoaded = {};

        // ============================
        // ОТОБРАЖЕНИЕ КОММЕНТАРИЕВ
        // ============================

        function displayComments(postId, comments) {
            var container = document.querySelector('#comments-' + postId + ' .comments-list');
            if (!container) return;

            container.innerHTML = '';

            if (!comments || comments.length === 0) {
                container.innerHTML = '<p style="color:#999;font-size:0.9em;margin:10px 0;">Пока нет комментариев. Будьте первым!</p>';
                return;
            }

            comments.forEach(function(c) {
                var div = document.createElement('div');
                div.className = 'comment-item';
                div.id = 'comment-' + c.id;
                div.innerHTML =
                    '<div class="comment-header">' +
                    '<strong>' + escapeHtml(c.author) + '</strong>' +
                    ' <span class="comment-date">' + c.date + '</span>' +
                    '</div>' +
                    '<div class="comment-text">' + escapeHtml(c.text) + '</div>';
                container.appendChild(div);
            });
        }

        function addNewComment(postId, commentId, author, text, date) {
            console.log('Добавление комментария:', {postId, commentId, author, text, date});

            var container = document.querySelector('#comments-' + postId + ' .comments-list');
            if (!container) {
                console.error('Контейнер для комментариев не найден: #comments-' + postId);
                return;
            }

            // Убираем сообщение о загрузке или "нет комментариев"
            var emptyMsg = container.querySelector('.loading-comments');
            if (emptyMsg) emptyMsg.remove();

            var noCommentsMsg = container.querySelector('p');
            if (noCommentsMsg && noCommentsMsg.textContent.includes('Пока нет комментариев')) {
                noCommentsMsg.remove();
            }

            // Проверяем, не добавлен ли уже этот комментарий
            if (document.getElementById('comment-' + commentId)) {
                console.warn('Комментарий #' + commentId + ' уже существует');
                return;
            }

            var div = document.createElement('div');
            div.className = 'comment-item comment-new';
            div.id = 'comment-' + commentId;
            div.innerHTML =
                '<div class="comment-header">' +
                '<strong>' + escapeHtml(author) + '</strong>' +
                ' <span class="comment-date">' + date + '</span>' +
                '</div>' +
                '<div class="comment-text">' + escapeHtml(text) + '</div>';

            // Добавляем в начало списка (новые сверху)
            container.insertBefore(div, container.firstChild);

            // Анимация появления
            setTimeout(function() {
                div.classList.remove('comment-new');
            }, 100);

            // Плавно прокручиваем к новому комментарию
            div.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function showCommentError(message) {
            alert('Ошибка: ' + message);
        }

        // ============================
        // ЗАГРУЗКА КОММЕНТАРИЕВ ПРИ ЗАГРУЗКЕ СТРАНИЦЫ
        // ============================

        function loadCommentsForPost(postId) {
            if (commentsLoaded[postId]) return;

            var container = document.querySelector('#comments-' + postId + ' .comments-list');
            if (container) {
                container.innerHTML = '<p class="loading-comments">Загрузка комментариев...</p>';
            }

            // Создаем уникальное имя callback функции для этого поста
            var callbackName = 'loadCommentsForPost_' + postId;

            // Определяем глобальную функцию, которую вызовет сервер
            window[callbackName] = function(comments) {
                displayComments(postId, comments);
                commentsLoaded[postId] = true;
                // Удаляем функцию после использования
                delete window[callbackName];
            };

            var script = document.createElement('script');
            script.src = '/blog/' + postId + '/comments?callback=' + callbackName;
            script.onerror = function() {
                if (container) {
                    container.innerHTML = '<p style="color:red;">Ошибка загрузки комментариев</p>';
                }
                delete window[callbackName];
                script.remove();
            };
            document.body.appendChild(script);
        }

        // Загружаем комментарии после загрузки страницы
        document.addEventListener('DOMContentLoaded', function() {
            var posts = document.querySelectorAll('.blog-post');
            posts.forEach(function(post) {
                var postId = post.getAttribute('data-post-id');
                if (postId) {
                    loadCommentsForPost(postId);
                }
            });
        });

        // ============================
        // МОДАЛЬНОЕ ОКНО
        // ============================

        function openCommentModal(postId) {
            currentCommentPostId = postId;
            var textarea = document.getElementById('comment-text');
            var modal = document.getElementById('comment-modal');

            if (textarea) textarea.value = '';
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                setTimeout(function() {
                    if (textarea) textarea.focus();
                }, 100);
            }
        }

        function closeCommentModal() {
            var modal = document.getElementById('comment-modal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
            currentCommentPostId = null;
        }

        // Открытие по кнопке
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-comment-btn')) {
                var postId = e.target.getAttribute('data-post-id');
                if (postId) {
                    openCommentModal(postId);
                }
            }
        });

        // Закрытие по клику на крестик
        var closeBtn = document.querySelector('#comment-modal .blur-modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeCommentModal);
        }

        // Закрытие по клику на фон
        document.addEventListener('click', function(e) {
            if (e.target.id === 'comment-modal') {
                closeCommentModal();
            }
        });

        // Закрытие по Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var modal = document.getElementById('comment-modal');
                if (modal && modal.classList.contains('show')) {
                    closeCommentModal();
                }
            }
        });

        // Кнопка "Отмена" в модальном окне
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('cancel-btn')) {
                closeCommentModal();
            }
        });

        // ============================
        // ОТПРАВКА КОММЕНТАРИЯ (ТОЛЬКО SCRIPT ТЕГ)
        // ============================

        function submitComment() {
            if (!currentCommentPostId) {
                alert('Ошибка: не выбран пост для комментирования');
                return false;
            }

            var textarea = document.getElementById('comment-text');
            if (!textarea) return false;

            var text = textarea.value.trim();

            if (!text) {
                alert('Введите текст комментария');
                textarea.focus();
                return false;
            }

            if (text.length < 3) {
                alert('Комментарий должен содержать минимум 3 символа');
                textarea.focus();
                return false;
            }

            // Блокируем кнопку на время отправки
            var submitBtn = document.getElementById('submit-comment-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            // Создаем уникальное имя callback для ответа
            var callbackName = 'addCommentCallback_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            // Определяем функцию, которая обработает ответ от сервера
            window[callbackName] = function(response) {
                if (response.success) {
                    // Добавляем новый комментарий на страницу
                    addNewComment(
                        response.comment.blog_post_id,
                        response.comment.id,
                        response.comment.author,
                        response.comment.text,
                        response.comment.date
                    );
                    closeCommentModal();
                } else {
                    alert('Ошибка: ' + response.message);
                }

                // Удаляем callback функцию
                delete window[callbackName];

                // Разблокируем кнопку
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить';
                }
            };

            // Создаем script тег для отправки комментария
            // Используем GET запрос с параметрами
            var script = document.createElement('script');
            script.src = '/blog/add-comment?blog_post_id=' + encodeURIComponent(currentCommentPostId) +
                '&text=' + encodeURIComponent(text) +
                '&callback=' + callbackName;

            script.onerror = function() {
                alert('Не удалось отправить комментарий. Проверьте подключение к интернету.');
                delete window[callbackName];
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить';
                }
                script.remove();
            };

            document.body.appendChild(script);
            return true;
        }

        // Привязываем обработчик кнопки "Отправить"
        document.addEventListener('DOMContentLoaded', function() {
            var submitBtn = document.getElementById('submit-comment-btn');
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    submitComment();
                });
            }

            // Обработка Ctrl+Enter в textarea
            var textarea = document.getElementById('comment-text');
            if (textarea) {
                textarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        submitComment();
                    }
                });
            }
        });

        // ============================
        // СТИЛИ ДЛЯ КОММЕНТАРИЕВ
        // ============================

        (function addCommentStyles() {
            if (document.getElementById('comment-custom-styles')) return;

            var style = document.createElement('style');
            style.id = 'comment-custom-styles';
            style.textContent = `
            .comments-section {
                margin-top: 25px;
                padding-top: 20px;
                border-top: 2px solid #edf2f7;
            }

            .comments-section h4 {
                margin-bottom: 15px;
                color: #2d3748;
                font-size: 1.1em;
            }

            .comments-list {
                margin-bottom: 15px;
                min-height: 40px;
            }

            .comment-item {
                padding: 12px 15px;
                margin-bottom: 8px;
                background: #f8fafc;
                border-radius: 8px;
                border-left: 3px solid #0056b3;
                transition: all 0.3s ease;
            }

            .comment-item:hover {
                background: #edf2f7;
                border-left-color: #004494;
            }

            .comment-item.comment-new {
                background: #e3f2fd;
                border-left-color: #2196F3;
                animation: commentHighlight 2s ease;
            }

            @keyframes commentHighlight {
                0% { background: #bbdefb; }
                100% { background: #f8fafc; }
            }

            .comment-header {
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .comment-header strong {
                color: #0056b3;
                font-size: 0.95em;
            }

            .comment-date {
                color: #718096;
                font-size: 0.85em;
            }

            .comment-text {
                color: #2d3748;
                font-size: 0.95em;
                line-height: 1.5;
            }

            .loading-comments {
                color: #999;
                font-size: 0.9em;
                font-style: italic;
            }

            .add-comment-btn {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background: linear-gradient(135deg, #0056b3, #004494);
                color: #fff;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 0.95em;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(0,86,179,0.2);
            }

            .add-comment-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,86,179,0.3);
            }

            .add-comment-btn:active {
                transform: translateY(0);
            }

            #comment-modal .form-group {
                margin-bottom: 20px;
            }

            #comment-modal label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: #333;
            }

            #comment-modal textarea {
                width: 100%;
                padding: 12px;
                border: 2px solid #d2b48c;
                border-radius: 8px;
                font-size: 16px;
                font-family: inherit;
                resize: vertical;
                outline: none;
                transition: border-color 0.3s, box-shadow 0.3s;
            }

            #comment-modal textarea:focus {
                border-color: #a67c52;
                box-shadow: 0 0 8px rgba(166, 124, 82, 0.3);
            }

            #comment-modal .form-actions {
                display: flex;
                gap: 10px;
            }

            #submit-comment-btn {
                flex: 1;
                padding: 12px 24px;
                background: #5a3e36;
                color: #fff;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                font-weight: 700;
                transition: all 0.3s;
            }

            #submit-comment-btn:hover {
                background: #7a5544;
            }

            #submit-comment-btn:disabled {
                background: #ccc;
                cursor: not-allowed;
            }

            .cancel-btn {
                padding: 12px 24px;
                background: #e2e8f0;
                color: #333;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                font-weight: 600;
                transition: all 0.3s;
            }

            .cancel-btn:hover {
                background: #cbd5e0;
            }
        `;
            document.head.appendChild(style);
        })();
    </script>
@endpush
