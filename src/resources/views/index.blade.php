@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <section class="page-title">
        <h1>Главная страница</h1>
    </section>

    <section class="content">
        <div class="profile">
            <img alt="Моё фото" src="{{ asset('images/me.jpg') }}">
        </div>

        <div class="info">
            <p>
                ФИО: Гордиенко Денис Олегович <br>
                Группа: ИС/б-23-1-о
            </p>
            <br>
            <p>Лабораторная работа №1 &laquo;Исследование возможностей языка разметки гипертекстов HTML и каскадных таблиц стилей CSS&raquo;</p>
        </div>
    </section>
@endsection
