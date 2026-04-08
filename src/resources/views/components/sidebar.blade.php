<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/') }}" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}"
                   data-page="index">
                    <span class="nav-text">Главная</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/about') }}" class="sidebar-link {{ request()->is('about') ? 'active' : '' }}"
                   data-page="about">
                    <span class="nav-text">Обо мне</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="{{ url('/interests') }}"
                   class="sidebar-link dropdown-link {{ request()->is('interests') ? 'active' : '' }}"
                   data-page="interests">
                    <span class="nav-text">Мои интересы</span>
                    <span class="dropdown-arrow">▶</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/interests#hobby') }}" data-page="interests-hobby">Моё хобби</a></li>
                    <li><a href="{{ url('/interests#books') }}" data-page="interests-books">Любимые книги</a></li>
                    <li><a href="{{ url('/interests#music') }}" data-page="interests-music">Любимая музыка</a></li>
                    <li><a href="{{ url('/interests#films') }}" data-page="interests-films">Любимые фильмы</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('/study') }}" class="sidebar-link {{ request()->is('study') ? 'active' : '' }}"
                   data-page="study">
                    <span class="nav-text">Учёба</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/test') }}"
                   class="sidebar-link {{ request()->is('test') ? 'active' : '' }}" data-page="test">
                    <span class="nav-text">Тест по дисциплине "Физика"</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/test/results') }}"
                   class="sidebar-link {{ request()->is('test.results') ? 'active' : '' }}" data-page="test.results">
                    <span class="nav-text">Результаты теста</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/gallery') }}" class="sidebar-link {{ request()->is('gallery') ? 'active' : '' }}"
                   data-page="gallery">
                    <span class="nav-text">Фотоальбом</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/contacts') }}" class="sidebar-link {{ request()->is('contacts') ? 'active' : '' }}"
                   data-page="contacts">
                    <span class="nav-text">Контакты</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/guest-book') }}"
                   class="sidebar-link {{ request()->is('guest-book') ? 'active' : '' }}" data-page="guest-book">
                    <span class="nav-text">Книга отзывов</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/guest-book/import') }}"
                   class="sidebar-link {{ request()->is('importPage') ? 'active' : '' }}" data-page="importPage">
                    <span class="nav-text">Редактор книги отзывов</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/history') }}" class="sidebar-link {{ request()->is('history') ? 'active' : '' }}"
                   data-page="history">
                    <span class="nav-text">История</span>
                </a>
            </li>

        </ul>
    </nav>
</div>
