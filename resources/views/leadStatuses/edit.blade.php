@extends('adminlte::page')

@section('title', 'Редактировать статусы')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать статусы</h1>
@stop

@section('plugins.Moment', true)
@section('plugins.Tempusdominus', true)
@section('plugins.BootstrapColorpicker', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('lead-statuses.update', $leadStatus->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <x-adminlte-input name="name" error-key="name" label="Название" value="{{ old('name', $leadStatus->name) }}" placeholder="Введите название статуса"/>
                        {{-- Выбор цвета статуса --}}
                        <x-adminlte-input-color name="color" error-key="color" label="Цвет" data-color="{{ old('color', $leadStatus->color) }}" placeholder="Выберите цвет">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-light">
                                    <i class="fas fa-lg fa-tint"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-color>
                        <div class="d-flex justify-content-start">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                            <a href="{{ route('lead-statuses.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
