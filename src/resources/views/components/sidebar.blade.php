@php $currentRoute = Route::currentRouteName(); @endphp

<div class="sidebar">
    <div class="sidebar-nav">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}"
                   class="sidebar-link {{ $currentRoute === 'home' ? 'active' : '' }}">
                    <span class="nav-text">Главная</span>
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                   class="sidebar-link {{ $currentRoute === 'about' ? 'active' : '' }}">
                    <span class="nav-text">О себе</span>
                </a>
            </li>
            <li>
                <a href="{{ route('interests') }}"
                   class="sidebar-link {{ $currentRoute === 'interests' ? 'active' : '' }}">
                    <span class="nav-text">Мои интересы</span>
                </a>
            </li>
            <li>
                <a href="{{ route('study') }}"
                   class="sidebar-link {{ $currentRoute === 'study' ? 'active' : '' }}">
                    <span class="nav-text">Учёба</span>
                </a>
            </li>
            <li>
                <a href="{{ route('gallery') }}"
                   class="sidebar-link {{ $currentRoute === 'gallery' ? 'active' : '' }}">
                    <span class="nav-text">Фотоальбом</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contacts') }}"
                   class="sidebar-link {{ $currentRoute === 'contacts' ? 'active' : '' }}">
                    <span class="nav-text">Контакты</span>
                </a>
            </li>
            <li>
                <a href="{{ route('test') }}"
                   class="sidebar-link {{ $currentRoute === 'test' ? 'active' : '' }}">
                    <span class="nav-text">Тест</span>
                </a>
            </li>
            <li>
                <a href="{{ route('guest-book.index') }}"
                   class="sidebar-link {{ str_starts_with($currentRoute, 'guest-book') ? 'active' : '' }}">
                    <span class="nav-text">Гостевая книга</span>
                </a>
            </li>
            <li>
                <a href="{{ route('blog.index') }}"
                   class="sidebar-link {{ str_starts_with($currentRoute, 'blog') ? 'active' : '' }}">
                    <span class="nav-text">Блог</span>
                </a>
            </li>
            @auth
            <li>
                <a href="{{ route('test.results') }}"
                   class="sidebar-link {{ $currentRoute === 'test.results' ? 'active' : '' }}">
                    <span class="nav-text">Результаты тестов</span>
                </a>
            </li>
            @endauth
            <li>
                <a href="{{ route('history') }}"
                   class="sidebar-link {{ $currentRoute === 'history' ? 'active' : '' }}">
                    <span class="nav-text">История</span>
                </a>
            </li>
        </ul>

        <div style="margin-top:30px;padding:15px 20px;border-top:1px solid rgba(255,255,255,0.1);">
            @auth
                <div style="color:#e0e0e0;font-size:0.85rem;margin-bottom:12px;line-height:1.4;">
                    👤 Пользователь:<br>
                    <strong style="color:#fff;">{{ Auth::user()->full_name }}</strong>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width:100%;padding:8px;background:#dc3545;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:700;">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   style="display:block;text-align:center;padding:9px;background:#0056b3;color:#fff;text-decoration:none;border-radius:6px;font-weight:700;margin-bottom:8px;">
                    Войти
                </a>
                <a href="{{ route('register') }}"
                   style="display:block;text-align:center;padding:9px;background:#28a745;color:#fff;text-decoration:none;border-radius:6px;font-weight:700;">
                    Регистрация
                </a>
            @endauth
        </div>
    </div>
</div>
