<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный сайт Гордиенко Дениса. @yield('title')</title>
    @vite(['resources/css/main.min.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="main-content">
        <x-sidebar />

        <main style="padding: 20px;">
            @yield('content')
        </main>

</div>

@stack('scripts')
</body>
</html>
