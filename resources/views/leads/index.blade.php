@extends('adminlte::page')

@section('title', 'Лиды')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Лиды</h1>
        @role('administrator')
        <a class="btn bg-success" href="{{ route('leads.create') }}"><i class="fas fa-plus-circle"></i> Создать лид</a>
        @endrole
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="d-flex justify-content-between mb-2">
                    {{-- Группы лидов --}}
                    <div class="text-nowrap overflow-auto">
                        {{-- Все --}}
                        <a href="{{ route('leads.index', ['group' => 'all'])}}"
                           class="btn btn-sm {{ ((url()->full() == route('leads.index', ['group' => 'all'])) || (url()->full() == route('leads.index'))) ? "btn-primary" : "btn-default" }}">
                           Все (<b>{{ $allLeadsCount }}</b>)
                        </a>
                        {{-- Новые --}}
                        <a href="{{ route('leads.index', ['group' => 'new'])}}"
                            class="btn btn-sm {{ (url()->full() == route('leads.index', ['group' => 'new'])) ? "btn-primary" : "btn-default" }}">
                            Новые (<b>{{ $newLeadsCount }}</b>)
                        </a>
                        {{-- Группы лидов --}}
                        @forelse ($leadGroups as $leadGroup)
                            @if (auth()->user()->hasRole('administrator') || $leadGroup->leads->count() > 0)
                                <a href="{{ route('leads.index', ['group' => $leadGroup->code])}}"
                                    class="btn btn-sm {{ (url()->full() == route('leads.index', ['group' => $leadGroup->code])) ? "btn-primary" : "btn-default" }}">
                                    {{ $leadGroup->name }} (<b>{{ $leadGroup->leads->where('lead_status_id', null)->count() }}</b>/<b>{{ $leadGroup->max_leads }}</b>)
                                </a>
                            @endif
                        @empty
                        @endforelse
                    </div>
                    {{-- Групповое управление лидами --}}
                    <div class="d-flex align-items-center">
                        @role('administrator')<button type="button" id="changeLeadUserBtn" class="btn btn-success btn-sm mr-1" title="Прикрепить пользователей к выбранным лидам" disabled><i class="fa fa-fw fa-user-plus"></i></button>@endrole
                        @role('administrator')<button type="button" id="changeLeadGroupBtn" class="btn btn-success btn-sm mr-1" title="Изменить группу для выбранных лидов" disabled><i class="fa fa-fw fa-user-friends"></i></button>@endrole
                        <button type="button" id="changeLeadStatusBtn" class="btn btn-success btn-sm mr-1" title="Изменить статус для выбранных лидов" disabled><i class="fa fa-fw fa-user-check"></i></button>
                        @role('administrator')<button type="button" id="deleteLeadBtn" class="btn btn-danger btn-sm mr-1" title="Удалить выбранных лидов" disabled><i class="fa fa-fw fa-trash"></i></button>@endrole
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="leads" class="table table-sm table-striped table-bordered w-100 small">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Статус</th>
                                @forelse ($params as $param)
                                    <th>{{ $param->name }}</th>
                                @empty
                                @endforelse
                                @role('administrator')
                                    <th>Создан</th>
                                @endrole
                                <th>Изменен</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>
                                    <td>{{ $lead->id }}</td>
                                    <td>
                                        @if ($lead->leadStatus)
                                            <span class="badge" style="color: #fff; background-color: {{$lead->leadStatus->color}}">{{ $lead->leadStatus->name }}</span>
                                        @else
                                            <span class="badge badge-danger">Новый</span>
                                        @endif
                                    </td>
                                    @forelse ($params as $param)
                                        <td>{{ $lead->utms->get($param->code) }}{{ $lead->gets->get($param->code) }}</td>
                                    @empty
                                    @endforelse
                                    @role('administrator')
                                        <td>{{ $lead->created_at ?? '' }}</td>
                                    @endrole
                                    <td>{{ $lead->updated_at ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <a title="Просмотреть лид" class="btn btn-primary btn-sm" href="{{ route('leads.show', $lead->id)}}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @role('administrator')
                                            <a title="Редактировать лид" class="btn btn-info btn-sm" href="{{ route('leads.edit', $lead->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <btn-confirm-sweet type="danger"
                                                btn-icon="fas fa-trash"
                                                title="Удалить"
                                                text="Удалить лида № {{ $lead->id ?? 'выбранный' }}?"
                                                action-url="{{ route('leads.destroy', $lead->id)}}"
                                                action-method="delete"></btn-confirm-sweet>
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $params->count()+4 }}">Записи отсутствуют</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function () {
        //******** Кнопка присвоить группу выбранным лидам
        $('#changeLeadGroupBtn').click(async function () {
            //Выбор группы в алерте
            const { value: leadGroup_id } = await Swal.fire({
                    title: 'Добавить выбранные лиды в группу:',
                    input: 'select',
                    inputOptions: _.merge({'0':'Новые'}, @json($leadGroups->pluck('name', 'id'))),
                    inputPlaceholder: 'Выберите группу',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                        if (value) {
                            resolve();
                        } else {
                            resolve('Вы должны выбрать группу');
                        }
                        })
                    }
            });
            //Группа выбрана - присваиваем группе выбранные лиды
            if (leadGroup_id) {
                //Индексы выбранных строк
                let selectedLeadRowIndexes = dataTable.rows('.selected').indexes();
                //Выбор id выбранных лидов из колонки 0
                let selectedLeadIds = dataTable.cells(selectedLeadRowIndexes, 0).data().toArray();
                //Привязка выбранных лидов к группе
                axios.post('/lead-groups/'+leadGroup_id+'/add-leads', {
                    ids: selectedLeadIds,
                })
                .then(function (response) {
                    location.reload();
                })
                .catch(function (error) {
                    Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                });

            };
        });

        //******** Кнопка присвоить статус выбранным лидам
        $('#changeLeadStatusBtn').click(async function () {
            //Выбор статуса в алерте
            const { value: leadStatus_id } = await Swal.fire({
                    title: 'Установить выбранным лидам статус:',
                    input: 'select',
                    inputOptions: _.merge({'0':'Новый'}, @json($leadStatuses->pluck('name', 'id'))),
                    inputPlaceholder: 'Выберите статус',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                        if (value) {
                            resolve();
                        } else {
                            resolve('Вы должны выбрать статус');
                        }
                        })
                    }
            });
            //Статус выбран - присваиваем статусу выбранные лиды
            if (leadStatus_id) {
                //Индексы выбранных строк
                let selectedLeadRowIndexes = dataTable.rows('.selected').indexes();
                //Выбор id выбранных лидов из колонки 0
                let selectedLeadIds = dataTable.cells(selectedLeadRowIndexes, 0).data().toArray();
                //Привязка выбранных лидов к группе
                axios.post('/lead-statuses/'+leadStatus_id+'/change-lead-status', {
                    ids: selectedLeadIds,
                })
                .then(function (response) {
                    if (response.data == 'cahged') {
                        location.reload();
                    } else if (response.data == 'fail') {
                        Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                    }
                })
                .catch(function (error) {
                    Swal.fire('Ошибка', 'Повторите попытку снова', 'error');
                });

            };
        });

        //******** Кнопка присвоить пользователя выбранным лидам
        $('#deleteLeadBtn').click(async function () {
            //Выбор группы в алерте
            Swal.fire({
                    title: 'Удалить',
                    text: 'Удалить выбраные лиды?',
                    icon: 'error',
                    showConfirmButton: true,
                    confirmButtonText: 'Удалить',
                    focusConfirm: false,
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    focusCancel: true,
                }).then((result) => {
                    if (result.value) {
                        //OK
                        //Индексы выбранных строк
                        let selectedLeadRowIndexes = dataTable.rows('.selected').indexes();
                        //Выбор id выбранных лидов из колонки 0
                        let selectedLeadIds = dataTable.cells(selectedLeadRowIndexes, 0).data().toArray();
                        //Удаляем лиды
                        axios.post('/leads/deleteMany', {ids: selectedLeadIds,})
                                .then(res => {
                                if (res.data == 'deleted') {
                                    document.location.reload();
                                };
                                });
                    };
                });
        });

        //******** Кнопка удалить выбранных лидов

        //Инициализация таблицы
        var dataTable = $('#leads').DataTable({
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
        dataTable.on('select', function (e, dt, type, indexes) {
            $('#changeLeadGroupBtn').removeAttr('disabled');
            $('#changeLeadStatusBtn').removeAttr('disabled');
            $('#changeLeadUserBtn').removeAttr('disabled');
            $('#deleteLeadBtn').removeAttr('disabled');
        });

        dataTable.on('deselect', function (e, dt, type, indexes) {
            $('#changeLeadGroupBtn').attr('disabled', 'disabled');
            $('#changeLeadStatusBtn').attr('disabled', 'disabled');
            $('#changeLeadUserBtn').attr('disabled', 'disabled');
            $('#deleteLeadBtn').attr('disabled', 'disabled');
        });

    });
</script>
@endpush
