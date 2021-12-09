@extends('adminlte::page')

@section('title', 'Создать роль')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать роль</h1>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                        {{-- Название --}}
                        <x-adminlte-input name="display_name" error-key="display_name" label="Название"
                            value="{{ old('display_name') }}" placeholder="Введите название роли"/>
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
                        {{-- Разрешения --}}
                        @php
                            $configPermission = [
                                "title" => "Выберите разрешения доступные пользователю",
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Поиск...",
                                "noneResultsText" => 'Ничего не найдено',
                                "showTick" => true,
                                "tickIcon" => 'far fa-check-square',
                                "actionsBox" => true,
                                "deselectAllText" => 'Снять все',
                                "selectAllText" => 'Выделить все',
                                //"virtualScroll" => true,
                            ];
                        @endphp
                        <x-adminlte-select-bs id="permissions" name="permissions[]" label="Разрешения"
                            :config="$configPermission" error-key="permissions" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-fw fa-user-lock"></i>
                                </div>
                            </x-slot>
                            <x-slot name="appendSlot">
                                <x-adminlte-button id="clearPermissions" theme="outline-dark" label="Очистить"
                                    icon="fas fa-lg fa-ban text-danger"/>
                            </x-slot>
                            @forelse ($permissionGroups as $group)
                                @if ($group->permissions->isNotEmpty())
                                    <optgroup data-icon="{{ $group->icon }} text-info" label="{{ $group->display_name }}">
                                        @foreach ($group->permissions as $permission)
                                            <option data-icon="{{ $permission->icon }} text-info" data-subtext="{{ $permission->name }}" value="{{ $permission->name }}"
                                                {{ (collect(old('permissions'))->contains($permission->name)) ? 'selected' : '' }}>{{ $permission->display_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @empty
                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных разрешений</option>
                            @endforelse
                        </x-adminlte-select-bs>
                        <div class="d-flex justify-content-start">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать"/>
                            <a href="{{ route('roles.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
