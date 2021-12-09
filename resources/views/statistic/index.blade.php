@extends('adminlte::page')

@section('title', 'Статистика')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Статистика</h1>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BootstrapSelect', true)
@section('plugins.Moment', true)
@section('plugins.DateRangePicker', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div>
					<form action="{{ route('statistic.filter') }}" method="POST">
						@csrf
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Параметры Фильтра</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="accordion" id="accordionExample">

                                                {{-- Label and placeholder --}}
                                                <x-adminlte-date-range name="dateRange" placeholder="Выберите период..."
                                                label="Период">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-gradient-danger">
                                                        <i class="far fa-lg fa-calendar-alt"></i>
                                                    </div>
                                                </x-slot>
                                                </x-adminlte-date-range>
                                                {{-- ************************* --}}

                                            @php
                                                $configPermission1 = [
                                                    "title" => "Выберите группы для фильтрации",
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
                                            <x-adminlte-select-bs id="lead_group" name="lead_group[]" label="Группы"
                                                :config="$configPermission1" error-key="permissions" multiple>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-gradient-info">
                                                        <i class="fas fa-fw fa-user-lock"></i>
                                                    </div>
                                                </x-slot>
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button id="clearLead_group" theme="outline-dark" label="Очистить"
                                                        icon="fas fa-lg fa-ban text-danger"/>
                                                </x-slot>
                                                    <optgroup data-icon="fas fa-fw fa-info text-info" label="Группы">
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="Без группы" value="WithoutGroup"
                                                            @if(is_array(old('lead_group')) && in_array('WithoutGroup', old('lead_group'))) selected @endif
                                                            > Без группы </option>
                                                        @foreach ($leadGroups as $leadGroup)
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="{{ $leadGroup->name }}" value="{{ $leadGroup->code }}"
                                                            @if(is_array(old('lead_group')) && in_array($leadGroup->code, old('lead_group'))) selected @endif
                                                            > {{ $leadGroup->name }} </option>
                                                        @endforeach
                                                    </optgroup>
                                            </x-adminlte-select-bs>

                                            @php
                                                $configPermission2 = [
                                                    "title" => "Выберите статусы для фильтрации",
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
                                            <x-adminlte-select-bs id="lead_status" name="lead_status[]" label="Статусы"
                                                :config="$configPermission2" error-key="permissions" multiple>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-gradient-info">
                                                        <i class="fas fa-fw fa-user-lock"></i>
                                                    </div>
                                                </x-slot>
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button id="clearLead_status" theme="outline-dark" label="Очистить"
                                                        icon="fas fa-lg fa-ban text-danger"/>
                                                </x-slot>
                                                    <optgroup data-icon="fas fa-fw fa-info text-info" label="Cтатусы">
                                                        <option data-icon="fas fa-fw fa-info text-info" data-subtext="Новый" value="Новый"
                                                        @if(is_array(old('lead_status')) && in_array('Новый', old('lead_status'))) selected @endif
                                                        > Новый </option>
                                                        @foreach ($leadStatuses as $leadStatus)
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="{{ $leadStatus->name }}" value="{{ $leadStatus->code }}"
                                                            @if(is_array(old('lead_status')) && in_array($leadStatus->code, old('lead_status'))) selected @endif
                                                            > {{ $leadStatus->name }} </option>
                                                        @endforeach
                                                    </optgroup>
                                            </x-adminlte-select-bs>

                                            @php
                                                $configPermission3 = [
                                                    "title" => "Выберите UTM параметры для фильтрации",
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
                                            <x-adminlte-select-bs id="utms" name="utms[]" label="UTM параметры"
                                                :config="$configPermission3" error-key="permissions" multiple>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-gradient-info">
                                                        <i class="fas fa-fw fa-user-lock"></i>
                                                    </div>
                                                </x-slot>
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button id="clearUtms" theme="outline-dark" label="Очистить"
                                                        icon="fas fa-lg fa-ban text-danger"/>
                                                </x-slot>
                                                    <optgroup data-icon="fas fa-fw fa-info text-info" label="UTM параметры">
                                                        @foreach ($utms as $utm)
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="{{ $utm->name }}" value="{{ $utm->code }}"
                                                            @if(is_array(old('utms')) && in_array($utm->code, old('utms'))) selected @endif
                                                            > {{ $utm->name }} </option>
                                                        @endforeach
                                                    </optgroup>
                                            </x-adminlte-select-bs>

                                            @php
                                                $configPermission4 = [
                                                    "title" => "Выберите GET параметры для фильтрации",
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
                                            <x-adminlte-select-bs id="gets" name="gets[]" label="GET параметры"
                                                :config="$configPermission4" error-key="permissions" multiple>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-gradient-info">
                                                        <i class="fas fa-fw fa-user-lock"></i>
                                                    </div>
                                                </x-slot>
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button id="clearGets" theme="outline-dark" label="Очистить"
                                                        icon="fas fa-lg fa-ban text-danger"/>
                                                </x-slot>
                                                    <optgroup data-icon="fas fa-fw fa-info text-info" label="get параметры">
                                                        @foreach ($gets as $get)
                                                            <option data-icon="fas fa-fw fa-info text-info" data-subtext="{{ $get->name }}" value="{{ $get->code }}"
                                                            @if(is_array(old('gets')) && in_array($get->code, old('gets'))) selected @endif
                                                            > {{ $get->name }} </option>
                                                        @endforeach
                                                    </optgroup>
                                            </x-adminlte-select-bs>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="filterbtn" class="btn btn-primary" title="Задать фильтр"> Применить фильтр</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-md-flex justify-content-md-between justify-content-sm-center">
                        {{-- количество показанных записей --}}
                        <div class="flex-grow-1 p-2">
                            <div class="card h-100">
                                <div class="text-center">
                                    {{ "Показано {$leads->count()} из {$allLeads->count()} лидов" }}
                                </div>
                            </div>
                        </div>
                        {{-- Открытие диалогового окна фильтра --}}
                        <div class="d-md-flex p-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-filter"> Применить фильтр</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="leads" class="table table-sm table-striped table-bordered w-100 small">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Офис</th>
                                <th>Статус</th>
                                @forelse ($params as $param)
                                    <th>{{ $param->name }}</th>
                                @empty
                                @endforelse
                                @role('administrator')
                                    <th>Создан</th>
                                @endrole
                                <th>Изменен</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>
                                    <td>{{ $lead->id ?? ''}}</td>
                                    <td>
                                        {{ $lead->leadGroup->name ?? '' }}
                                    </td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $params->count()+5 }}">Записи отсутствуют</td>
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
        // Установка периода для отображения лидов
        // если период ранее уже был выбран, устанавливаем выбранные значения, иначе берем значения за текущий месяц
        let oldDateRange = {!! json_encode(old('dateRange')) !!};
        let startDate = '';
        let endDate = '';

        if(oldDateRange) {
            let arr = oldDateRange.split('/');
            startDate = arr[0]
            endDate = arr[1]
        } else {
            let date = new Date();
            // получаем текущий месяц, формат от 0 до 11
            let currentMonth = date.getMonth() + 1;
            // получаем текущий год
            let currentYear = date.getFullYear();
            // получаем последний день месяца
            date = new Date(currentYear, currentMonth + 1, 0);
            let lastDayOfMonth = date.getDate();

            startDate = `01-${currentMonth}-${currentYear}`;
            endDate = `${lastDayOfMonth}-${currentMonth}-${currentYear}`;
        }
		//Выбор периода
		$('#dateRange').daterangepicker({
			"locale": {
            "format": "DD-MM-YYYY",
            "separator": " / ",
            "applyLabel": "Применить",
            "cancelLabel": "Отмена",
            "fromLabel": "С",
            "toLabel": "По",
            "customRangeLabel": "Custom",
            "weekLabel": "Н",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        },
            "startDate": startDate,
            "endDate": endDate,
        });

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
                'aTargets': [0] //Отключение сортировки по последнему полю (-1 - первое справа)
            }],
        });


        //Кнопка очистить параметры группы
        $('#clearLead_group').click(function() {
            $('#lead_group').selectpicker('deselectAll');
        });
        //Кнопка очистить параметры статусов
        $('#clearLead_status').click(function() {
            $('#lead_status').selectpicker('deselectAll');
        });
        //Кнопка очистить параметры UTM
        $('#clearUtms').click(function() {
            $('#utms').selectpicker('deselectAll');
        });
        //Кнопка очистить параметры GET
        $('#clearGets').click(function() {
            $('#gets').selectpicker('deselectAll');
        });
    });



</script>
@endpush
