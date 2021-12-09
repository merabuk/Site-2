@extends('adminlte::page')

@section('title', 'Редактировать группу')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать группу</h1>
@stop

@section('plugins.BootstrapSelect', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto" id="editUserGroupTab">
                            <li class="nav-item">
                                <a class="nav-link active" id="main-tab" href="#main" data-toggle="tab">
                                    <span>Данные</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="users-tab" href="#users" data-toggle="tab">
                                    <span>Участники</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="offices-tab" href="#offices" data-toggle="tab">
                                    <span>Офисы</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('user-groups.update', $userGroup->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="tab-content p-0">
                                    {{-- Содержимое основной вкладки --}}
                                    <div class="tab-pane active" id="main">
                                        {{-- Название --}}
                                        <x-adminlte-input name="display_name" error-key="display_name" label="Название"
                                            value="{{ old('display_name', $userGroup->display_name) }}" placeholder="Введите название группы"/>
                                        {{-- Описание --}}
                                        <x-adminlte-input name="description" error-key="description" label="Описание"
                                            value="{{ old('description', $userGroup->description) }}" placeholder="Введите описание группы"/>
                                        {{-- Иконка --}}
                                        <x-adminlte-input name="icon" error-key="icon" label="Иконка"
                                            value="{{ old('icon', $userGroup->icon) }}" placeholder="Введите код иконки">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="{{ old('icon', $userGroup->icon) }} text-lightblue"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        {{-- Разрешения --}}
                                        {{-- @php
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
                                            @forelse ($permissionGroups as $group)
                                                @if ($group->permissions->isNotEmpty())
                                                    <optgroup data-icon="{{ $group->icon }} text-info" label="{{ $group->display_name }}">
                                                        @foreach ($group->permissions as $permission)
                                                            <option data-icon="{{ $permission->icon }} text-info" data-subtext="{{ $permission->name }}" value="{{ $permission->name }}"
                                                                {{ (collect(old('permissions', $userGroup->permissions()->pluck('name')))->contains($permission->name)) ? 'selected' : '' }}>{{ $permission->display_name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @empty
                                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных разрешений</option>
                                            @endforelse
                                        </x-adminlte-select-bs> --}}
                                    </div>
                                    {{-- Конец содержимого основной вкладки --}}
                                    {{-- Содержимое вкладки Участники --}}
                                    <div class="tab-pane" id="users">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="button" id="removeGroupUsers" class="btn btn-danger btn-sm" title="Исключить из группы выбранных пользователей" disabled><i class="fas fa-fw fa-user-minus"></i></button>
                                        </div>
                                        <table id="groupUsers" class="table table-sm table-striped table-bordered w-100">
                                            <thead class="w-100">
                                                <tr>
                                                    <th class="d-none">id</th>
                                                    <th>#</th>
                                                    <th>Ф.И.О.</th>
                                                    <th>E-mail</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($userGroup->users as $user)
                                                    <tr>
                                                        <td class="d-none">{{ $user->id }}</td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->name ?? '' }}</td>
                                                        <td>{{ $user->email ?? '' }}</td>
                                                        <td class="text-right text-nowrap">
                                                            <btn-confirm-sweet type="danger"
                                                            btn-icon="fas fa-fw fa-user-minus"
                                                            action-text="Исключить"
                                                            title="Исключить"
                                                            text="Исключить {{ $user->name ?? 'выбранного' }} из группы?"
                                                            action-url="{{ route('user-groups.remove-user', [$userGroup->id, $user->id]) }}"
                                                            action-method="delete"></btn-confirm-sweet>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4">Записи отсутствуют</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{-- Пользователи --}}
                                        @php
                                            $configUnGroupUsers = [
                                                "title" => "Выберите пользователей, чтобы добавить к группе",
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
                                        <x-adminlte-select-bs id="unGroupUsers" name="users[]" label="Пользователи"
                                            :config="$configUnGroupUsers" error-key="users" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-fw fa-user-plus"></i>
                                                </div>
                                            </x-slot>
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button id="clearUnGroupUsers" theme="outline-dark" label="Очистить"
                                                    icon="fas fa-lg fa-ban text-danger"/>
                                                <x-adminlte-button id="addUnGroupUsers" theme="outline-dark" label="Добавить"
                                                    icon="fas fa-lg fa-user-plus text-success"/>
                                            </x-slot>
                                            @forelse ($unGroupUsers as $user)
                                                <option data-icon="{{ $user->roles->first()->icon }} text-info" data-subtext="{{ $user->roles->first()->name }}"
                                                    value="{{ $user->id }}" {{ (collect(old('users'))->contains($user->id)) ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @empty
                                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных пользователей</option>
                                            @endforelse
                                        </x-adminlte-select-bs>
                                    </div>
                                    {{-- Конец содержимого вкладки Участники --}}
                                    {{-- Содержимое вкладки Офисы --}}
                                    <div class="tab-pane" id="offices">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="button" id="removeGroupLeadGroups" class="btn btn-danger btn-sm" title="Открепить от группы выбранные офисы" disabled><i class="fas fa-fw fa-minus-square"></i></button>
                                        </div>
                                        <table id="leadGroups" class="table table-sm table-striped table-bordered w-100">
                                            <thead class="w-100">
                                                <tr>
                                                    <th class="d-none">id</th>
                                                    <th>#</th>
                                                    <th>Название офиса</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($userGroup->leadGroups as $leadGroup)
                                                    <tr>
                                                        <td class="d-none">{{ $leadGroup->id }}</td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $leadGroup->name ?? '' }}</td>
                                                        <td class="text-right text-nowrap">
                                                            <btn-confirm-sweet type="danger"
                                                            btn-icon="fas fa-minus-square"
                                                            action-text="Открепить"
                                                            title="Открепить"
                                                            text="Открепить {{ $leadGroup->name ?? 'выбранный' }} от группы?"
                                                            action-url="{{ route('user-groups.remove-lead-group', [$userGroup->id, $leadGroup->id]) }}"
                                                            action-method="delete"></btn-confirm-sweet>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">Записи отсутствуют</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{-- Офисы --}}
                                        @php
                                            $configUnAddedLeadGroups = [
                                                "title" => "Выберите офисы, чтобы прикрепить к группе",
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
                                        <x-adminlte-select-bs id="unAddedLeadGroups" name="leadGroups[]" label="Офисы"
                                            :config="$configUnAddedLeadGroups" error-key="leadGroups" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-fw fa-paperclip"></i>
                                                </div>
                                            </x-slot>
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button id="clearUnAddedLeadGroups" theme="outline-dark" label="Очистить"
                                                    icon="fas fa-lg fa-ban text-danger"/>
                                                <x-adminlte-button id="addUnAddedLeadGroups" theme="outline-dark" label="Добавить"
                                                    icon="fas fa-lg fa-plus-square text-success"/>
                                            </x-slot>
                                            @forelse ($unGroupLeadGroups as $leadGroup)
                                                <option data-icon="fas fa-fw fa-paperclip text-info" data-subtext="{{ $leadGroup->code }}"
                                                    value="{{ $leadGroup->id }}" {{ (collect(old('lead-groups'))->contains($leadGroup->id)) ? 'selected' : '' }}>{{ $leadGroup->name }}</option>
                                            @empty
                                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных офисов</option>
                                            @endforelse
                                        </x-adminlte-select-bs>
                                    </div>
                                    {{-- Конец содержимого вкладки Офисы --}}
                                </div>
                                <div class="d-flex justify-content-start">
                                    <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                                    <a href="{{ route('user-groups.index') }}" class="btn btn-default">Отмена</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        $('#clearPermissions').click(function() {
            $('#permissions').selectpicker('deselectAll');
        });

        $('#clearUnGroupUsers').click(function() {
            $('#unGroupUsers').selectpicker('deselectAll');
        });

        $('#clearUnAddedLeadGroups').click(function() {
            $('#unAddedLeadGroups').selectpicker('deselectAll');
        });

        $('#addUnGroupUsers').click(function() {
            let selectedUsersIds = $('#unGroupUsers').val();
            let userGroup_id = @json($userGroup->id);
            if (selectedUsersIds.length > 0) {
                axios.post(window.origin+'/user-groups/'+userGroup_id+'/add-users', {
                    usersIds: selectedUsersIds,
                })
                .then(function (response) {
                    if (response.data == 'added') {
                        location.reload();
                    } else if (response.data == 'fail') {
                        Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                    }
                })
                .catch(function (error) {
                    Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                });
            } else {
                Swal.fire('Внимание', 'Пожалуйста выберите пользователя(ей)', 'warning');
            }
        });

        $('#addUnAddedLeadGroups').click(function() {
            let selectedLeadGroupsIds = $('#unAddedLeadGroups').val();
            let userGroup_id = @json($userGroup->id);
            if (selectedLeadGroupsIds.length > 0) {
                axios.post(window.origin+'/user-groups/'+userGroup_id+'/add-lead-groups', {
                    leadGroupsIds: selectedLeadGroupsIds,
                })
                .then(function (response) {
                    if (response.data == 'added') {
                        location.reload();
                    } else if (response.data == 'fail') {
                        Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                    }
                })
                .catch(function (error) {
                    Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                });
            } else {
                Swal.fire('Внимание', 'Пожалуйста выберите офис(ы)', 'warning');
            }
        });

        //возврат на активную вкладку при редиректе
        var idTab = $('a[data-toggle="tab"]').parent().parent().attr('id');
        var hashArr = [];
        $('a[data-toggle="tab"]').map(function(index, element){
            hashArr.push($(element).attr('href'));
        });
        if ($.inArray(window.location.hash, hashArr) !== -1) {
            $('#'+idTab+' a[href="'+window.location.hash+'"]').tab('show');
        } else {
            $('#'+idTab+' a[href="'+hashArr[0]+'"]').tab('show');
            let hash = hashArr[0].split('#');
            window.location.hash = hash[1];
        }
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
            let hash = event.target.href.split('#');
            window.location.hash = hash[1];
        });

        // Кнопка исключить из группы выбранных пользователей
        $('#removeGroupUsers').click(async function () {
            //Индексы выбранных строк
            let selectedUsersRowIndexes = usersTable.rows('.selected').indexes();
            //Выбор id выбранных групп пользователя из колонки 0
            let selectedUsersIds = usersTable.cells(selectedUsersRowIndexes, 0).data().toArray();
            let user_group_id = @json($userGroup->id);
            Swal.fire({
                titleText: 'Исключить',
                text: 'Исключить из группы выбранных пользователей?',
                icon: 'error',
                showConfirmButton: true,
                confirmButtonText: 'Исключить',
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                focusCancel: true,
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    //OK
                    axios.post(window.origin+'/user-groups/'+user_group_id+'/remove-users', {
                        usersIds: selectedUsersIds,
                    })
                    .then(function (response) {
                        if (response.data == 'deleted') {
                            location.reload();
                        } else if (response.data == 'fail') {
                            Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                        }
                    })
                    .catch(function (error) {
                        Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                    });
                };
                if (result.dismiss) {
                    //Cancel
                };
            });
        });

        // Кнопка открепить от группы выбранные офисы
        $('#removeGroupLeadGroups').click(async function () {
            //Индексы выбранных строк
            let selectedLeadGroupsRowIndexes = leadGroupsTable.rows('.selected').indexes();
            //Выбор id выбранных лидов из колонки 0
            let selectedLeadGroupsIds = leadGroupsTable.cells(selectedLeadGroupsRowIndexes, 0).data().toArray();
            let user_group_id = @json($userGroup->id);
            Swal.fire({
                titleText: 'Открепить',
                text: 'Открепить от группы выбранные офисы?',
                icon: 'error',
                showConfirmButton: true,
                confirmButtonText: 'Открепить',
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                focusCancel: true,
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    //OK
                    axios.post(window.origin+'/user-groups/'+user_group_id+'/remove-lead-groups', {
                        leadGroupsIds: selectedLeadGroupsIds,
                    })
                    .then(function (response) {
                        if (response.data == 'deleted') {
                            location.reload();
                        } else if (response.data == 'fail') {
                            Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                        }
                    })
                    .catch(function (error) {
                        Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                    });
                };
                if (result.dismiss) {
                    //Cancel
                };
            });
        });

        //Инициализация таблицы
        var usersTable = $('#groupUsers').DataTable({
            // stateSave: true,
            // "scrollX": true,
            select: {
                style: 'os'
            },
            language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json'
            },
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] //Отключение сортировки по последнему полю (-1 - первое справа)
            }],
        });

        //Инициализация таблицы
        var leadGroupsTable = $('#leadGroups').DataTable({
            // stateSave: true,
            // "scrollX": true,
            select: {
                style: 'os'
            },
            language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json'
            },
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] //Отключение сортировки по последнему полю (-1 - первое справа)
            }],
        });

        //Активация-деактивация кнопок если есть-нет выбранные строки
        usersTable.on('select', function (e, dt, type, indexes) {
            $('#removeGroupUsers').removeAttr('disabled');
        });

        usersTable.on('deselect', function (e, dt, type, indexes) {
            $('#removeGroupUsers').attr('disabled', 'disabled');
        });

        leadGroupsTable.on('select', function (e, dt, type, indexes) {
            $('#removeGroupLeadGroups').removeAttr('disabled');
        });

        leadGroupsTable.on('deselect', function (e, dt, type, indexes) {
            $('#removeGroupLeadGroups').attr('disabled', 'disabled');
        });
    });
</script>
@endpush
