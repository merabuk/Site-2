@extends('adminlte::page')

@section('title', 'Редактировать GET-параметр')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать GET-параметр</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('get-params.update', $getParam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <x-adminlte-input name="name" error-key="name" label="Название" value="{{ old('name', $getParam->name) }}" placeholder="Введите название для GET-параметра"/>
                        <x-adminlte-input name="code" error-key="code" label="Код" value="{{ old('code', $getParam->code) }}" placeholder="Введите GET-параметр"/>
                        <x-adminlte-input type="number" min="0" name="order" error-key="order" label="Порядок отображения параметра в таблице лидов" value="{{ old('order', $getParam->order) }}" placeholder="Введите индекс столбца для отображения"/>
                        <div class="d-flex justify-content-start">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                            <a href="{{ route('get-params.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
