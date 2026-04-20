@extends('layouts.admin')

@section('content')
    <div style="background:#fff;padding:25px;border-radius:15px;box-shadow:0 5px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom:20px;">Статистика посещений</h2>

        <div style="overflow-x:auto;">
            <table class="guestbook-table">
                <thead>
                <tr>
                    <th>Дата и время</th>
                    <th>Страница</th>
                    <th>IP-адрес</th>
                    <th>Хост</th>
                    <th>Браузер</th>
                </tr>
                </thead>
                <tbody>
                @forelse($visits as $visit)
                    <tr>
                        <td style="white-space:nowrap;">{{ $visit->visited_at->format('d.m.Y H:i:s') }}</td>
                        <td style="max-width:250px;word-break:break-all;">{{ $visit->page }}</td>
                        <td>{{ $visit->ip_address }}</td>
                        <td>{{ $visit->hostname ?? '—' }}</td>
                        <td style="max-width:250px;word-break:break-word;font-size:0.85em;">{{ $visit->user_agent ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:#999;">
                            Посещений пока нет
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="blog-pagination" style="margin-top:20px;">
            {{ $visits->links() }}
        </div>
    </div>
@endsection
