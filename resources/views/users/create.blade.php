@extends('adminlte::page')

@section('title', 'Создать пользователя')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать пользователя</h1>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                        {{-- Ф.И.О. --}}
                        <x-adminlte-input name="name" error-key="name" label="Ф.И.О."
                            value="{{ old('name') }}" placeholder="Введите Ф.И.О."/>
                        {{-- E-mail --}}
                        <x-adminlte-input name="email" error-key="email" label="E-mail"
                            value="{{ old('email') }}" placeholder="Введите E-mail"/>
                        {{-- Пароль --}}
                        <x-adminlte-input name="password" error-key="password" label="Пароль"
                            type="password" placeholder="Введите пароль"/>
                        {{-- Подтвердите пароль --}}
                        <x-adminlte-input name="password_confirmation" error-key="password_confirmation"
                            type="password" label="Подтверждение пароля" placeholder="Подтвердите пароль"/>
                        {{-- Роли --}}
                        @php
                            $configRole = [
                                "title" => "Выберите роль пользователю",
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Поиск...",
                                "noneResultsText" => 'Ничего не найдено',
                                "showTick" => true,
                                "tickIcon" => 'far fa-check-square',
                            ];
                        @endphp
                        <x-adminlte-select-bs id="role" name="role" label="Роль"
                            :config="$configRole" error-key="role">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-fw fa-user-tag"></i>
                                </div>
                            </x-slot>
                            @foreach ($roles as $role)
                                <option data-icon="{{ $role->icon }} text-info" data-subtext="{{ $role->name }}" value="{{ $role->name }}"
                                    {{ (collect(old('roles'))->contains($role->name)) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                            @endforeach
                        </x-adminlte-select-bs>
                        {{-- Группы --}}
                        @php
                            $configUserGroup = [
                                "title" => "Выберите группу пользователю",
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Поиск...",
                                "noneResultsText" => 'Ничего не найдено',
                                "showTick" => true,
                                "tickIcon" => 'far fa-check-square',
                                "actionsBox" => true,
                                "deselectAllText" => 'Снять все',
                                "selectAllText" => 'Выделить все',
                            ];
                        @endphp
                        <x-adminlte-select-bs id="userGroups" name="userGroups[]" label="Группы"
                            :config="$configUserGroup" error-key="userGroups" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-fw fa-users"></i>
                                </div>
                            </x-slot>
                            <x-slot name="appendSlot">
                                <x-adminlte-button id="clearUserGroups" theme="outline-dark" label="Очистить"
                                    icon="fas fa-lg fa-ban text-danger"/>
                            </x-slot>
                            @forelse ($userGroups as $userGroup)
                                <option data-icon="{{ $userGroup->icon }} text-info" data-subtext="{{ $userGroup->name }}" value="{{ $userGroup->name }}"
                                    {{ (collect(old('userGroups'))->contains($userGroup->name)) ? 'selected' : '' }}>{{ $userGroup->display_name }}</option>
                            @empty
                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных групп</option>
                            @endforelse
                        </x-adminlte-select-bs>
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
                            <a href="{{ route('users.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {

        $('#clearUserGroups').click(function() {
            $('#userGroups').selectpicker('deselectAll');
        });

        $('#clearPermissions').click(function() {
            $('#permissions').selectpicker('deselectAll');
        });

    } );
</script>
@endpush
