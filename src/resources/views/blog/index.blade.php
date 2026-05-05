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
    @vite(['resources/js/blog/blog-comments.js'])
@endpush
