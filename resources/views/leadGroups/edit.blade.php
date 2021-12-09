@extends('adminlte::page')

@section('title', 'Редактировать офис')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать офис</h1>
@stop

@section('plugins.Moment', true)
@section('plugins.Tempusdominus', true)
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
                                    <span>Данные</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="user-groups-tab" href="#user-groups" data-toggle="tab">
                                    <span>Группы пользователей</span>
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
                            <form action="{{ route('lead-groups.update', $leadGroup->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="tab-content p-0">
                                    {{-- Содержимое основной вкладки --}}
                                    <div class="tab-pane active" id="main">
                                        {{-- Название --}}
                                        <x-adminlte-input name="name" error-key="name" label="Название" value="{{ old('name', $leadGroup->name) }}" placeholder="Введите название группы"/>
                                        {{-- Время начала работы группы --}}
                                        <x-adminlte-input-date id="open" name="open" error-key="open" label="Время начала работы" value="{{ old('open', $leadGroup->open) }}" placeholder="Выбирите время" autocomplete="off">
                                            <x-slot name="appendSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                        {{-- Время конца работы группы --}}
                                        <x-adminlte-input-date id="close" name="close" error-key="close" label="Время завершения работы" value="{{ old('close', $leadGroup->close) }}" placeholder="Выбирите время" autocomplete="off">
                                            <x-slot name="appendSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                        {{-- Коэффициент на количество лидов при автораспределении --}}
                                        <x-adminlte-input type="number" name="k_leads" error-key="k_leads" label="Коэффициент на количество лидов при автораспределении, 1..100%" value="{{ old('k_leads', $leadGroup->k_leads) }}" min="1" max="100" placeholder="Введите коэффициент"/>
                                        {{-- Максимальное количество лидов при автораспределении --}}
                                        <x-adminlte-input type="number" name="max_leads" error-key="max_leads" label="Максимальное количество лидов при автораспределении" value="{{ old('max_leads', $leadGroup->max_leads) }}" min="1" placeholder="Введите количество лидов"/>
                                        {{-- Автораспределение для группы вкл/откл --}}
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="enabled" name="enabled" value="1" @if (old('enabled', $leadGroup->enabled)) checked @endif>
                                            <label class="custom-control-label" for="enabled">Включить/Отключить автораспределение лидов</label>
                                        </div>
                                        @error('enabled')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- Конец содержимого основной вкладки --}}
                                    {{-- Содержимое вкладки Группы пользователей --}}
                                    <div class="tab-pane" id="user-groups">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="button" id="removeUserGroups" class="btn btn-danger btn-sm" title="Открепить от офиса выбранные группы пользователей" disabled><i class="fas fa-fw fa-minus-square"></i></button>
                                        </div>
                                        <table id="userGroups-table" class="table table-sm table-striped table-bordered w-100">
                                            <thead class="w-100">
                                                <tr>
                                                    <th class="d-none">id</th>
                                                    <th>#</th>
                                                    <th>Название</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($leadGroup->userGroups as $group)
                                                    <tr>
                                                        <td class="d-none">{{ $group->id }}</td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $group->display_name ?? '' }}</td>
                                                        <td class="text-right text-nowrap">
                                                            <btn-confirm-sweet type="danger"
                                                            btn-icon="fas fa-minus-square"
                                                            action-text="Открепить"
                                                            title="Открепить"
                                                            text='Открепить "{{ $group->display_name ?? 'выбранную' }}" группу пользоветелей от этого офиса?'
                                                            action-url="{{ route('lead-groups.remove-user-group', [$leadGroup->id, $group->id]) }}"
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
                                        {{-- Группы пользователей --}}
                                        @php
                                            $configUnLeadGroupUserGroups = [
                                                "title" => "Выберите группу пользователей",
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
                                        <x-adminlte-select-bs id="unLeadGroupUserGroups" name="unLeadGroupUserGroups[]" label="Группы пользователей"
                                            :config="$configUnLeadGroupUserGroups" error-key="unLeadGroupUserGroups" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-fw fa-user-friends"></i>
                                                </div>
                                            </x-slot>
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button id="clearUnLeadGroupUserGroups" theme="outline-dark" label="Очистить"
                                                    icon="fas fa-lg fa-ban text-danger"/>
                                                <x-adminlte-button id="addUnLeadGroupUserGroups" theme="outline-dark" label="Добавить"
                                                    icon="fas fa-lg fa-plus-square text-success"/>
                                            </x-slot>
                                            @forelse ($unLeadGroupUserGroups as $group)
                                                <option data-icon="{{ $group->icon }} text-info" data-subtext="{{ $group->name }}" value="{{ $group->id }}"
                                                    {{ (collect(old('unLeadGroupUserGroups'))->contains($group->id)) ? 'selected' : '' }}>{{ $group->display_name }}</option>
                                            @empty
                                                <option data-icon="fas fa-fw fa-info text-info" data-subtext="">Нет доступных групп</option>
                                            @endforelse
                                        </x-adminlte-select-bs>
                                    </div>
                                    {{-- Конец содержимого вкладки Группы пользователей --}}
                                    {{-- Содержимое вкладки Лиды --}}
                                    <div class="tab-pane" id="leads">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="button" id="removeLeads" class="btn btn-danger btn-sm" title="Открепить выбранные лиды от офиса" disabled><i class="fas fa-fw fa-minus-square"></i></button>
                                        </div>
                                        <table id="leads-table" class="table table-sm table-striped table-bordered w-100">
                                            <thead class="w-100">
                                                <tr>
                                                    <th>#</th>
                                                    @forelse ($params as $param)
                                                        <th>{{ $param->name }}</th>
                                                    @empty
                                                    @endforelse
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($leadGroup->leads as $lead)
                                                    <tr>
                                                        <td>{{ $lead->id }}</td>
                                                        @forelse ($params as $param)
                                                            <td>{{ $lead->gets->get($param->code) }}</td>
                                                        @empty
                                                        @endforelse
                                                        <td class="text-right text-nowrap">
                                                            <btn-confirm-sweet type="danger"
                                                            btn-icon="fas fa-minus-square"
                                                            action-text="Отвязать"
                                                            title="Отвязать"
                                                            text="Отвязать {{ $lead->name ?? 'лид' }} от группы лидов?"
                                                            action-url="{{ route('lead-groups.remove-lead', [$lead->id]) }}"
                                                            action-method="delete"></btn-confirm-sweet>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">Записи отсутствуют</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{-- Лиды --}}
                                        @php
                                            $configNewLeads = [
                                                "title" => "Выберите лиды, чтобы прикрепить к группе лидов",
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
                                        <x-adminlte-select-bs id="newLeads" name="newLeads[]" label="Лиды"
                                            :config="$configNewLeads" error-key="newLeads" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-fw fa-link"></i>
                                                </div>
                                            </x-slot>
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button id="clearNewLeads" theme="outline-dark" label="Очистить"
                                                    icon="fas fa-lg fa-ban text-danger"/>
                                                <x-adminlte-button id="addNewLeads" theme="outline-dark" label="Добавить"
                                                    icon="fas fa-lg fa-plus-square text-success"/>
                                            </x-slot>
                                            @forelse ($newLeads as $lead)
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
                                    </div>
                                    {{-- Конец содержимого вкладки Лиды --}}
                                </div>
                                <div class="d-flex justify-content-start mt-2">
                                    <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                                    <a href="{{ route('lead-groups.index') }}" class="btn btn-default">Отмена</a>
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
        $('#open, #close').datetimepicker(
            {
                format: "HH:mm",
                locale: moment.locale('ru'),
            }
        );
        //автозакрытие при потере фокуса
        $("body, body *").not('#open, #close').click(function(e) {
            $('#open, #close').datetimepicker('hide');
        });
    $(document).ready(function() {
        $('#clearUnLeadGroupUserGroups').click(function() {
            $('#unLeadGroupUserGroups').selectpicker('deselectAll');
        });

        $('#clearNewLeads').click(function() {
            $('#newLeads').selectpicker('deselectAll');
        });

        $('#addUnLeadGroupUserGroups').click(function() {
            let selectedUserGroupsIds = $('#unLeadGroupUserGroups').val();
            let lead_group_id = @json($leadGroup->id);
            if (selectedUserGroupsIds.length > 0) {
                axios.post(window.origin+'/lead-groups/'+lead_group_id+'/add-user-groups', {
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
                Swal.fire('Внимание', 'Пожалуйста выберите группу(ы) пользователей', 'warning');
            }
        });

        $('#addNewLeads').click(function() {
            let selectedLeadsIds = $('#newLeads').val();
            let lead_group_id = @json($leadGroup->id);
            if (selectedLeadsIds.length > 0) {
                axios.post(window.origin+'/lead-groups/'+lead_group_id+'/add-leads', {
                    ids: selectedLeadsIds,
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

        // Кнопка открепить от офиса выбранные группы пользователей
        $('#removeUserGroups').click(async function () {
            //Индексы выбранных строк
            let selectedUserGroupsRowIndexes = userGroupsTable.rows('.selected').indexes();
            //Выбор id выбранных групп пользователя из колонки 0
            let selectedUserGroupsIds = userGroupsTable.cells(selectedUserGroupsRowIndexes, 0).data().toArray();
            let lead_group_id = @json($leadGroup->id);
            Swal.fire({
                titleText: 'Открепить',
                text: 'Открепить от офиса выбранные группы пользователей?',
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
                    axios.post(window.origin+'/lead-groups/'+lead_group_id+'/remove-user-groups', {
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

        // Кнопка открепить выбранные лиды от офиса
        $('#removeLeads').click(async function () {
            //Индексы выбранных строк
            let selectedLeadsRowIndexes = leadsTable.rows('.selected').indexes();
            //Выбор id выбранных лидов из колонки 0
            let selectedLeadsIds = leadsTable.cells(selectedLeadsRowIndexes, 0).data().toArray();
            Swal.fire({
                titleText: 'Открепить',
                text: 'Открепить выбранные лиды от офиса?',
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
                    axios.post(window.origin+'/lead-groups/remove-leads', {
                        leadsIds: selectedLeadsIds,
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
        var leadsTable = $('#leads-table').DataTable({
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

        leadsTable.on('select', function (e, dt, type, indexes) {
            $('#removeLeads').removeAttr('disabled');
        });

        leadsTable.on('deselect', function (e, dt, type, indexes) {
            $('#removeLeads').attr('disabled', 'disabled');
        });
    });
</script>
@endpush
