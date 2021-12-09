@extends('adminlte::page')

@section('title', 419)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>419 Время сессии истекло</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning">419</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i>Время сессии истекло.</h3>
            <p>Извините, Ваш сеанс закончился. Пожалуйста, обновитесь и повторите попытку. <a href="{{ route('home') }}">На информационную панель</a></p>
        </div>
    </div>
@endsection
