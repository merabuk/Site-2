@extends('adminlte::page')

@section('title', 'Создать разрешение')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать разрешение</h1>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                        {{-- Кодировка --}}
                        <x-adminlte-input name="name" error-key="name" label="Кодировка"
                            value="{{ old('name') }}" placeholder="Введите кодировку разрешения"/>
                        {{-- Название --}}
                        <x-adminlte-input name="display_name" error-key="display_name" label="Название"
                            value="{{ old('display_name') }}" placeholder="Введите название разрешения"/>
                        {{-- Описание --}}
                        <x-adminlte-input name="description" error-key="description" label="Описание"
                            value="{{ old('description') }}" placeholder="Введите описание группы"/>
                        {{-- Иконка --}}
                        <x-adminlte-input name="icon" error-key="icon" label="Иконка"
                            value="{{ old('icon') }}" placeholder="Введите код иконки">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="{{ old('icon', 'fas fa-fw fa-info') }} text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        {{-- Группа разрешений --}}
                        @php
                            $configPermissionGroups = [
                                "title" => "Выберите группу разрешений",
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Поиск...",
                                "noneResultsText" => 'Ничего не найдено',
                                "showTick" => true,
                                "tickIcon" => 'far fa-check-square',
                            ];
                        @endphp
                        <x-adminlte-select-bs name="permission_group_id" label="Группа разрешений"
                            :config="$configPermissionGroups" error-key="permission_group_id">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-fw fa-user-lock"></i>
                                </div>
                            </x-slot>
                            @forelse ($permissionGroups as $group)
                                <option data-icon="{{ $group->icon }} text-info" data-subtext="{{ $group->name }}" value="{{ $group->id }}"
                                    {{ (collect(old('permissions'))->contains($group->id)) ? 'selected' : '' }}>{{ $group->display_name }}</option>
                            @empty
                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных групп</option>
                            @endforelse
                        </x-adminlte-select-bs>
                        <div class="d-flex justify-content-start">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать"/>
                            <a href="{{ route('permissions.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
