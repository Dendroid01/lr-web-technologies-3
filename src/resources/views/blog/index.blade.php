@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="blog-posts">
            @if(session('import_stats'))
                <p class="valid">
                    Импортировано: {{ session('import_stats.imported') }},
                    пропущено: {{ session('import_stats.skipped') }}
                </p>
            @endif
            <h1>Мой Блог</h1>

            @forelse($posts as $post)
                <article class="blog-post">
                    <h2>{{ $post->title }}</h2>
                    <div class="blog-meta">
                        {{ $post->created_at->format('d.m.Y H:i') }} — {{ $post->author }}
                    </div>

                    @if($post->image)
                        <div class="blog-image">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="blog-message">
                        {{ $post->message }}
                    </div>
                </article>
            @empty
                <p class="empty-message">Записей пока нет.</p>
            @endforelse

            <div class="blog-pagination">
                {{ $posts->links() }}
            </div>

            <div class="back-link-wrapper">
                <a href="{{ route('admin.blog.editor') }}" class="back-link">Редактор блога →</a>
            </div>
        </section>
    </div>
@endsection
