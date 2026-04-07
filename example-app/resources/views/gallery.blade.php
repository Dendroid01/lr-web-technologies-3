@extends('layouts.app')

@section('title', 'Фотоальбом')

@push('scripts')
    <script>
        window.galleryData = @json($photos);
        window.assetUrl = '{{ asset('') }}';
    </script>
@endpush

@section('content')
    <section class="page-title">
        <h1>Фотоальбом</h1>
    </section>

    <section class="gallery" id="gallery" data-count="{{ $photoCount }}">
        @foreach($photos as $index => $photo)
            <div class="photo" data-index="{{ $index }}">
                <img
                    src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjM0MCIgdmlld0JveD0iMCAwIDMwMCAzNDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMzQwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMTUwIiB5PSIxNzAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4="
                    data-src="{{ asset($photo['src']) }}"
                    alt="{{ $photo['title'] }}"
                    loading="lazy"
                    class="lazy-image"
                >
                <p class="caption">{{ $photo['title'] }}</p>
                <span class="hover-text">{{ $photo['hover_text'] }}</span>
            </div>
        @endforeach
    </section>

    <div class="modal" id="photo-modal">
        <div class="modal-content">
            <span class="modal-close">X</span>
            <div class="modal-nav">
                <button class="nav-btn prev-btn">&larr;</button>
                <button class="nav-btn next-btn">&rarr;</button>
            </div>
            <img alt="" class="modal-image" src="">
            <div class="modal-info">
                <h3 class="modal-title"></h3>
                <p class="modal-description"></p>
                <div class="modal-counter"></div>
            </div>
        </div>
    </div>
@endsection
