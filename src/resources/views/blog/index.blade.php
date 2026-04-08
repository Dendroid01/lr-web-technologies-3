@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Мой Блог</h1>

        @forelse($posts as $post)
            <div class="blog-post">
                <h2>{{ $post->title }}</h2>
                <p class="meta">
                    {{ $post->created_at->format('d.m.Y H:i') }} — {{ $post->author }}
                </p>

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         alt="{{ $post->title }}"
                         style="max-width: 400px;">
                @endif

                <p>{{ $post->message }}</p>
            </div>
            <hr>
        @empty
            <p>Записей пока нет.</p>
        @endforelse

        {{ $posts->links() }}

        <p><a href="{{ route('blog.editor') }}">Редактор блога →</a></p>
    </div>
@endsection
