<header>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}" @if(request()->is('/')) class="active" @endif>Главная страница</a></li>
            <li><a href="{{ url('/about') }}" @if(request()->is('about')) class="active" @endif>Обо мне</a></li>
            <li class="dropdown">
                <a class="dropdown-link @if(request()->is('interests')) active @endif" href="{{ url('/interests') }}">Мои интересы</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/interests#hobby') }}">Моё хобби</a></li>
                    <li><a href="{{ url('/interests#books') }}">Любимые книги</a></li>
                    <li><a href="{{ url('/interests#music') }}">Любимая музыка</a></li>
                    <li><a href="{{ url('/interests#films') }}">Любимые фильмы</a></li>
                </ul>
            </li>
            <li><a href="{{ url('/study') }}" @if(request()->is('study')) class="active" @endif>Учёба</a></li>
            <li><a href="{{ url('/gallery') }}" @if(request()->is('gallery')) class="active" @endif>Фотоальбом</a></li>
            <li><a href="{{ url('/contacts') }}" @if(request()->is('contacts')) class="active" @endif>Контакты</a></li>
            <li><a href="{{ url('/guest-book') }}" @if(request()->is('guest-book')) class="active" @endif>Книга отзывов</a></li>
            <li><a href="{{ url('/history') }}" @if(request()->is('history')) class="active" @endif>История просмотра</a></li>
        </ul>
    </nav>
</header>
