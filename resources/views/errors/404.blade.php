@extends('adminlte::page')

@section('title', 404)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Страница ошибки 404</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning">404</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i>Упс! Страницу не найдено.</h3>
            <p>Мы не смогли найти страницу, которую Вы искали. Но, Вы можете <a href="{{ route('home') }}">вернуться на информационную панель</a></p>
        </div>
    </div>
@endsection
