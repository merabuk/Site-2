@extends('adminlte::page')

@section('title', 'Редактировать группу')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать группу</h1>
@stop

@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('permission-groups.update', $permissionGroup->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        {{-- Название --}}
                        <x-adminlte-input name="display_name" error-key="display_name" label="Название"
                            value="{{ old('display_name', $permissionGroup->display_name) }}" placeholder="Введите название группы"/>
                        {{-- Описание --}}
                        <x-adminlte-input name="description" error-key="description" label="Описание"
                            value="{{ old('description', $permissionGroup->description) }}" placeholder="Введите описание группы"/>
                        {{-- Иконка --}}
                        <x-adminlte-input name="icon" error-key="icon" label="Иконка"
                            value="{{ old('icon', $permissionGroup->icon) }}" placeholder="Введите код иконки">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="{{ old('icon', $permissionGroup->icon) }} text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        {{-- Разрешения --}}
                        @php
                            $configPermission = [
                                "title" => "Выберите разрешения доступные группе",
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
                            @forelse ($permissions as $permission)
                                <option data-icon="{{ $permission->icon }} text-info" data-subtext="{{ $permission->name }}" value="{{ $permission->id }}"
                                    {{ (collect(old('permissions', $permissionGroup->permissions->pluck('id')))->contains($permission->id)) ? 'selected' : '' }}>{{ $permission->display_name }}</option>
                            @empty
                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных разрешений</option>
                            @endforelse
                        </x-adminlte-select-bs>
                    <div class="d-flex justify-content-start">
                        <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                        <a href="{{ route('permission-groups.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        $('#clearPermissions').click(function() {
            $('#permissions').selectpicker('deselectAll');
        });
    });
</script>
@endpush
