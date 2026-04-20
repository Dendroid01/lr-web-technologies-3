@extends('layouts.app')

@section('title', 'История просмотра')

@push('scripts')
    @vite(['resources/js/history-tracker/history-tracker-init.js'])
@endpush

@section('content')
    <section class="page-title">
        <h1>История просмотра</h1>
    </section>

    <section class="history-section">
        <h2>История текущего сеанса</h2>
        <p>Данные хранятся в Local Storage и сбрасываются при закрытии браузера</p>
        <table class="history-table" id="session-history">
            <thead>
            <tr>
                <th>Страница</th>
                <th>Количество посещений</th>
                <th>Последнее посещение</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <section class="history-section">
        <h2>История за все время</h2>
        <p>Данные хранятся в Cookies и сохраняются между сеансами</p>
        <table class="history-table" id="total-history">
            <thead>
            <tr>
                <th>Страница</th>
                <th>Количество посещений</th>
                <th>Последнее посещение</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <div class="history-actions">
        <button class="history-btn" id="clear-session">Очистить историю сеанса</button>
        <button class="history-btn" id="clear-total">Очистить всю историю</button>
    </div>
@endsection
