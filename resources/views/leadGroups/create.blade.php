@extends('adminlte::page')

@section('title', 'Создать офис')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать офис</h1>
@stop

@section('plugins.Moment', true)
@section('plugins.Tempusdominus', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('lead-groups.store') }}" method="POST">
                    @csrf
                        {{-- Название группы --}}
                        <x-adminlte-input name="name" error-key="name" label="Название" value="{{ old('name') }}" placeholder="Введите название группы"/>
                        {{-- Время начала работы группы --}}
                        <x-adminlte-input-date id="open" name="open" error-key="open" label="Время начала работы" value="{{ old('open') }}" placeholder="Выбирите время" autocomplete="off">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        {{-- Время конца работы группы --}}
                        <x-adminlte-input-date id="close" name="close" error-key="close" label="Время завершения работы" value="{{ old('close') }}" placeholder="Выбирите время" autocomplete="off">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        {{-- Коэффициент на количество лидов при автораспределении --}}
                        <x-adminlte-input type="number" name="k_leads" error-key="k_leads" label="Коэффициент на количество лидов при автораспределении, 1..100%" value="{{ old('k_leads') }}" min="1" max="100" placeholder="Введите коэффициент"/>
                        {{-- Максимальное количество лидов при автораспределении --}}
                        <x-adminlte-input type="number" name="max_leads" error-key="max_leads" label="Максимальное количество лидов при автораспределении" value="{{ old('max_leads') }}" min="1" placeholder="Введите количество лидов"/>
                        {{-- Автораспределение для группы вкл/откл --}}
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="enabled" name="enabled" value="1" @if (old('enabled')) checked @endif>
                            <label class="custom-control-label" for="enabled">Включить/Отключить автораспределение лидов</label>
                        </div>
                        @error('enabled')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-start mt-2">
                            <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать"/>
                            <a href="{{ route('lead-groups.index') }}" class="btn btn-default">Отмена</a>
                        </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
    <script>
        $('#open, #close').datetimepicker(
            {
                format: "HH:mm",
                locale: moment.locale('ru'),
                showClear: true,
                showClose: true
            }
        );
        //автозакрытие при потере фокуса
        $("body, body *").not('#open, #close').click(function(e) {
            $('#open, #close').datetimepicker('hide');
        });
    </script>
@endpush
