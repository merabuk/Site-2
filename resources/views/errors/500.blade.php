@extends('adminlte::page')

@section('title', 500)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Страница ошибки 500</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-danger">500</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i>Упс! Что-то пошло не так.</h3>
            <p>Мы работаем над исправление в данную минуту. Но, Вы можете <a href="{{ route('home') }}">вернуться на информационную панель</a></p>
        </div>
    </div>
@endsection
