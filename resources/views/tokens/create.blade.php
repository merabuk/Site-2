@extends('adminlte::page')

@section('title', 'Создать токен')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать токен</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('tokens.store') }}" method="POST">
                    @csrf
                        <x-adminlte-input name="name" error-key="name" label="Название" value="{{ old('name') }}" placeholder="Введите название для токена"/>
                        <x-adminlte-input name="uuid" error-key="uuid" label="Код" value="{{ old('uuid') }}" placeholder="Введите или сгенерируйте токен">
                            <x-slot name="appendSlot">
                                <x-adminlte-button id='genTokenBtn' theme="info" icon="fas fa-fw fa-key"/>
                            </x-slot>
                        </x-adminlte-input>
                        <div class="d-flex justify-content-start">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать"/>
                            <a href="{{ route('tokens.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        //Генератор токена
        $('#genTokenBtn').click(
            function() {
                const token = new TokenGenerator(256, TokenGenerator.BASE62);
                $('#uuid').val(token.generate());
            }
        );
    });
</script>
@stop
