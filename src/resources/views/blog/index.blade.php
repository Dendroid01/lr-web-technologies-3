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
                <article class="blog-post" id="post-{{ $post->id }}">
                    <h2>{{ $post->title }}</h2>
                    <div class="blog-meta">
                        {{ $post->created_at->format('d.m.Y H:i') }} — ✍{{ $post->author }}
                    </div>

                    @if($post->image)
                        <div class="blog-image">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="{{ $post->title }}"
                                 onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22400%22%20height%3D%22300%22%20viewBox%3D%220%200%20400%20300%22%3E%3Crect%20width%3D%22400%22%20height%3D%22300%22%20fill%3D%22%23f0f0f0%22%2F%3E%3Ctext%20x%3D%22200%22%20y%3D%22150%22%20text-anchor%3D%22middle%22%20fill%3D%22%23999%22%3E%D0%98%D0%B7%D0%BE%D0%B1%D1%80%D0%B0%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5%20%D0%BD%D0%B5%20%D0%B4%D0%BE%D1%81%D1%82%D1%83%D0%BF%D0%BD%D0%BE%3C%2Ftext%3E%3C%2Fsvg%3E'">
                        </div>
                    @endif

                    <div class="blog-message">
                        {!! nl2br(e($post->message)) !!}
                    </div>
                </article>
            @empty
                <div class="empty-message"
                     style="text-align: center; padding: 60px 20px; background: #f9f5f0; border-radius: 24px;">
                    <p style="font-size: 1.2rem; margin-bottom: 15px;">Пока нет записей в блоге</p>
                    <p style="color: #8a6e5e;">Загляните позже или <a href="{{ route('admin.blog.editor') }}"
                                                                      style="color: #5a3e36; font-weight: bold;">добавьте
                            первую запись</a></p>
                </div>
            @endforelse

            <div class="blog-pagination">
                {{ $posts->links() }}
            </div>

            @auth
                <div class="back-link-wrapper" style="margin-top: 30px; text-align: center;">
                    <a href="{{ route('admin.blog.editor') }}" class="back-link">Редактор блога →</a>
                </div>
            @endauth
        </section>
    </div>
@endsection
