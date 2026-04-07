@extends('layouts.app')

@section('title', 'Мои интересы')

@section('content')
    <section class="page-title">
        <h1>Мои интересы</h1>
    </section>

    <section class="page-layout">
        <aside class="anchors">
            <ul>
                @foreach($categories as $category)
                    <li><a href="#{{ $category['id'] }}">{{ $category['title'] }}</a></li>
                @endforeach
            </ul>
        </aside>

        <section class="content" id="interests-content">
            @foreach($categories as $category)
                <div class="list-group" id="{{ $category['id'] }}">
                    <h3>{{ $category['title'] }}</h3>

                    <div class="list-container">
                        @foreach($category['items'] as $item)
                            <article class="item-card">
                                <p>{{ $item['name'] }}</p>
                                <span class="hover-text">{{ $item['description'] }}</span>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
    </section>
@endsection
