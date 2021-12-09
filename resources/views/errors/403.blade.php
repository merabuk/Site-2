@extends('adminlte::page')

@section('title', 403)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>403 Запрещено</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning">403</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i>Запрос отклонён.</h3>
            <p>У Вас нет прав доступа к этой странице. Пожалуйста вернитесь на <a href="{{ route('home') }}">информационную панель</a></p>
        </div>
    </div>
@endsection

