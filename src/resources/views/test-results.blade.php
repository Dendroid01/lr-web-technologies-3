@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Результаты теста</h1>

        @if($results->isEmpty())
            <p>Нет данных</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>ФИО</th>
                    <th>Группа</th>
                    <th>Результат</th>
                    <th>%</th>
                    <th>Детали</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{ $result->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $result->fullname }}</td>
                        <td>{{ $result->group_name }}</td>
                        <td>{{ $result->correct }} / {{ $result->total }}</td>
                        <td>{{ $result->successRate() }}%</td>
                        <td>
                            @foreach($result->results as $value)
                                {{ $value ? '✅' : '❌' }}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $results->links() }}
        @endif
    </div>
@endsection
