@extends('adminlte::page')

@section('title', 'Редактировать пользователя')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать пользователя</h1>
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
                        <ul class="nav nav-pills ml-auto" id="editUserTab">
                            <li class="nav-item">
                                <a class="nav-link active" id="main-tab" href="#main" data-toggle="tab">
                                    <span>Профиль</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="groups-tab" href="#groups" data-toggle="tab">
                                    <span>Группы</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="leads-tab" href="#leads" data-toggle="tab">
                                    <span>Лиды</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                    <div class="tab-content p-0">
                                        {{-- Содержимое основной вкладки --}}
                                        <div class="tab-pane active" id="main">
                                            {{-- Ф.И.О. --}}
                                            <x-adminlte-input name="name" error-key="name" label="Ф.И.О."
                                                value="{{ old('name', $user->name) }}" placeholder="Введите Ф.И.О."/>
                                            {{-- E-mail --}}
                                            <x-adminlte-input name="email" error-key="email" label="E-mail"
                                                value="{{ old('email', $user->email) }}" placeholder="Введите E-mail"/>
                                            {{-- Пароль --}}
                                            <x-adminlte-input name="password" error-key="password" label="Пароль"
                                                type="password" placeholder="Введите пароль"/>
                                            {{-- Подтвердите пароль --}}
                                            <x-adminlte-input name="password_confirmation" error-key="password_confirmation"
                                            type="password" label="Подтверждение пароля" placeholder="Подтвердите пароль"/>
                                            @role('administrator')
                                                {{-- Роли --}}
                                                @php
                                                    $configRole = [
                                                        "title" => "Выберите роль пользователю",
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
                                                <x-adminlte-select-bs id="role" name="role" label="Роль"
                                                    :config="$configRole" error-key="role">
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text bg-gradient-info">
                                                            <i class="fas fa-fw fa-user-tag"></i>
                                                        </div>
                                                    </x-slot>
                                                    @foreach ($roles as $role)
                                                        <option data-icon="{{ $role->icon }} text-info" data-subtext="{{ $role->name }}" value="{{ $role->name }}"
                                                            {{ (collect(old('roles', $user->roles->pluck('name')))->contains($role->name)) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                                    @endforeach
                                                </x-adminlte-select-bs>
                                                {{-- Разрешения --}}
                                                @if (!$user->hasRole('administrator'))
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
                                                                            {{ (collect(old('permissions', $user->permissions()->pluck('name')))->contains($permission->name)) ? 'selected' : '' }}>{{ $permission->display_name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif
                                                        @empty
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных разрешений</option>
                                                        @endforelse
                                                    </x-adminlte-select-bs>
                                                @endif
                                            @endrole
                                        </div>
                                        {{-- Конец содержимого основной вкладки --}}
                                        {{-- Содержимое вкладки Группы --}}
                                        <div class="tab-pane" id="groups">
                                            @role('administrator')
                                                <div class="d-flex justify-content-end mb-2">
                                                    <button type="button" id="removeUserGroups" class="btn btn-danger btn-sm" title="Исключить пользователя из выбранных групп" disabled><i class="fas fa-fw fa-minus-square"></i></button>
                                                </div>
                                            @endrole
                                            <table id="userGroups-table" class="table table-sm table-striped table-bordered w-100">
                                                <thead class="w-100">
                                                    <tr>
                                                        <th class="d-none">id</th>
                                                        <th>#</th>
                                                        <th>Название группы</th>
                                                        @role('administrator')
                                                            <th></th>
                                                        @endrole
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($user->userGroups as $group)
                                                        <tr>
                                                            <td class="d-none">{{ $group->id }}</td>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $group->display_name ?? '' }}</td>
                                                            @role('administrator')
                                                                <td class="text-right text-nowrap">
                                                                    <btn-confirm-sweet type="danger"
                                                                    btn-icon="fas fa-fw fa-minus-square"
                                                                    action-text="Исключить"
                                                                    title="Исключить"
                                                                    text='Исключить пользователя из группы "{{ $group->display_name ?? 'выбранного' }}"?'
                                                                    action-url="{{ route('user.remove-group', [$user->id, $group->id]) }}"
                                                                    action-method="delete"></btn-confirm-sweet>
                                                                </td>
                                                            @endrole
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            @if (auth()->user()->hasRole('administrator'))
                                                                <td colspan="3">Записи отсутствуют</td>
                                                            @else
                                                                <td colspan="2">Записи отсутствуют</td>
                                                            @endif
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            @role('administrator')
                                                {{-- Группы --}}
                                                @php
                                                    $configGroupsUser = [
                                                        "title" => "Выберите группу",
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
                                                <x-adminlte-select-bs id="unGroupsUser" name="unGroupsUser[]" label="Группы"
                                                    :config="$configGroupsUser" error-key="unGroupsUser" multiple>
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text bg-gradient-info">
                                                            <i class="fas fa-fw fa-user-friends"></i>
                                                        </div>
                                                    </x-slot>
                                                    <x-slot name="appendSlot">
                                                        <x-adminlte-button id="clearUnGroupsUser" theme="outline-dark" label="Очистить"
                                                            icon="fas fa-lg fa-ban text-danger"/>
                                                        <x-adminlte-button id="addUnGroupsUser" theme="outline-dark" label="Добавить"
                                                            icon="fas fa-lg fa-plus-square text-success"/>
                                                    </x-slot>
                                                    @forelse ($unUserGroups as $group)
                                                        <option data-icon="{{ $group->icon }} text-info" data-subtext="{{ $group->name }}" value="{{ $group->id }}"
                                                            {{ (collect(old('userGroups'))->contains($group->id)) ? 'selected' : '' }}>{{ $group->display_name }}</option>
                                                    @empty
                                                        <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных групп</option>
                                                    @endforelse
                                                </x-adminlte-select-bs>
                                            @endrole
                                        </div>
                                        {{-- Конец содержимого вкладки Группы --}}
                                        {{-- Содержимое вкладки Лиды --}}
                                        <div class="tab-pane" id="leads">
                                            @role('administrator')
                                                <div class="d-flex justify-content-end mb-2">
                                                    <button type="button" id="removeUserLeads" class="btn btn-danger btn-sm" title="Открепить выбранные лиды от пользователя" disabled><i class="fas fa-fw fa-minus-square"></i></button>
                                                </div>
                                            @endrole
                                            <table id="userLeads" class="table table-sm table-striped table-bordered w-100">
                                                <thead class="w-100">
                                                    <tr>
                                                        <th>#</th>
                                                        @forelse ($params as $param)
                                                            <th>{{ $param->name }}</th>
                                                        @empty
                                                        @endforelse
                                                        @role('administrator')
                                                            <th></th>
                                                        @endrole
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($user->leads as $lead)
                                                        <tr>
                                                            <td>{{ $lead->id }}</td>
                                                            @forelse ($params as $param)
                                                                <td>{{ $lead->gets->get($param->code) }}</td>
                                                            @empty
                                                            @endforelse
                                                            @role('administrator')
                                                                <td class="text-right text-nowrap">
                                                                    <btn-confirm-sweet type="danger"
                                                                    btn-icon="fas fa-minus-square"
                                                                    action-text="Открепить"
                                                                    title="Открепить"
                                                                    text="Открепить {{ $lead->name ?? 'лид' }} от пользователя?"
                                                                    action-url="{{ route('user.remove-lead', [$user->id, $lead->id]) }}"
                                                                    action-method="delete"></btn-confirm-sweet>
                                                                </td>
                                                            @endrole
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            @if (auth()->user()->hasRole('administrator'))
                                                                <td colspan="3">Записи отсутствуют</td>
                                                            @else
                                                                <td colspan="2">Записи отсутствуют</td>
                                                            @endif
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            @role('administrator')
                                                {{-- Лиды --}}
                                                @php
                                                    $configUnAddedLeadsUser = [
                                                        "title" => "Выберите лиды, чтобы прикрепить к пользователю",
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
                                                <x-adminlte-select-bs id="unAddedLeadsUser" name="leads[]" label="Лиды"
                                                    :config="$configUnAddedLeadsUser" error-key="leads" multiple>
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text bg-gradient-info">
                                                            <i class="fas fa-fw fa-link"></i>
                                                        </div>
                                                    </x-slot>
                                                    <x-slot name="appendSlot">
                                                        <x-adminlte-button id="clearUnAddedLeadsUser" theme="outline-dark" label="Очистить"
                                                            icon="fas fa-lg fa-ban text-danger"/>
                                                        <x-adminlte-button id="addUnAddedLeadsUser" theme="outline-dark" label="Добавить"
                                                            icon="fas fa-lg fa-plus-square text-success"/>
                                                    </x-slot>
                                                    @forelse ($unUserLeads as $lead)
                                                        <option data-icon="fas fa-fw fa-link text-info" data-subtext="lead{{ $lead->id ?? '' }}"
                                                            value="{{ $lead->id }}" {{ (collect(old('leads'))->contains($lead->id)) ? 'selected' : '' }}>
                                                            @forelse ($params as $param)
                                                                @if ($lead->gets->get($param->code))
                                                                    {{ $param->name }}: {{ $lead->gets->get($param->code).'; ' }}
                                                                @endif
                                                            @empty
                                                                Нет доступных данных
                                                            @endforelse
                                                        </option>
                                                    @empty
                                                        <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных лидов</option>
                                                    @endforelse
                                                </x-adminlte-select-bs>
                                            @endrole
                                        </div>
                                        {{-- Конец содержимого вкладки Лиды --}}
                                    </div>
                                <div class="d-flex justify-content-start">
                                    <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                                    <a href="{{ route('users.index') }}" class="btn btn-default">Отмена</a>
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

        $('#clearUnGroupsUser').click(function() {
            $('#unGroupsUser').selectpicker('deselectAll');
        });

        $('#clearUnAddedLeadsUser').click(function() {
            $('#unAddedLeadsUser').selectpicker('deselectAll');
        });

        $('#addUnGroupsUser').click(function() {
            let selectedUserGroupsIds = $('#unGroupsUser').val();
            let user_id = @json($user->id);
            if (selectedUserGroupsIds.length > 0) {
                axios.post(window.origin+'/user/'+user_id+'/add-groups', {
                    userGroupsIds: selectedUserGroupsIds,
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
                Swal.fire('Внимание', 'Пожалуйста выберите группу(ы)', 'warning');
            }
        });

        $('#addUnAddedLeadsUser').click(function() {
            let selectedLeadsIds = $('#unAddedLeadsUser').val();
            let user_id = @json($user->id);
            if (selectedLeadsIds.length > 0) {
                axios.post(window.origin+'/user/'+user_id+'/add-leads', {
                    leadsIds: selectedLeadsIds,
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
                Swal.fire('Внимание', 'Пожалуйста выберите лида(ов)', 'warning');
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

        // Кнопка исключить пользователя из выбранных групп
        $('#removeUserGroups').click(async function () {
            //Индексы выбранных строк
            let selectedUserGroupsRowIndexes = userGroupsTable.rows('.selected').indexes();
            //Выбор id выбранных групп пользователя из колонки 0
            let selectedUserGroupsIds = userGroupsTable.cells(selectedUserGroupsRowIndexes, 0).data().toArray();
            let user_id = @json($user->id);
            Swal.fire({
                titleText: 'Исключить',
                text: 'Исключить пользователя из выбранных групп?',
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
                    axios.post(window.origin+'/user/'+user_id+'/remove-groups', {
                        userGroupsIds: selectedUserGroupsIds,
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

        // Кнопка открепить выбранные лиды от пользователя
        $('#removeUserLeads').click(async function () {
            //Индексы выбранных строк
            let selectedUserLeadsRowIndexes = userLeadsTable.rows('.selected').indexes();
            //Выбор id выбранных лидов из колонки 0
            let selectedUserLeadsIds = userLeadsTable.cells(selectedUserLeadsRowIndexes, 0).data().toArray();
            let user_id = @json($user->id);
            Swal.fire({
                titleText: 'Открепить',
                text: 'Открепить выбранные лиды от пользователя?',
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
                    axios.post(window.origin+'/user/'+user_id+'/remove-leads', {
                        leadsIds: selectedUserLeadsIds,
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
        var userGroupsTable = $('#userGroups-table').DataTable({
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
        var userLeadsTable = $('#userLeads').DataTable({
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
        userGroupsTable.on('select', function (e, dt, type, indexes) {
            $('#removeUserGroups').removeAttr('disabled');
        });

        userGroupsTable.on('deselect', function (e, dt, type, indexes) {
            $('#removeUserGroups').attr('disabled', 'disabled');
        });

        userLeadsTable.on('select', function (e, dt, type, indexes) {
            $('#removeUserLeads').removeAttr('disabled');
        });

        userLeadsTable.on('deselect', function (e, dt, type, indexes) {
            $('#removeUserLeads').attr('disabled', 'disabled');
        });
    });
</script>
@endpush
