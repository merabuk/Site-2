@extends('adminlte::page')

@section('title', 'Настройки - Общие')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Настройки - Общие</h1>
    </div>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('options.save') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                {{-- Автораспределение лидов --}}
                                <div class="tab-pane @if (session('tab') == 'auto' || session('tab') == '') active @endif" id="auto">
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="auto_leads_ctrl"
                                                name="auto_leads_ctrl" value="1" @if (old('auto_leads_ctrl', option('auto_leads_ctrl', 0))) checked @endif>
                                            <label class="custom-control-label" for="auto_leads_ctrl">Автораспределение
                                                лидов по группам</label>
                                        </div>
                                        @error('auto_leads_ctrl')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Сохранить" />
                                    <a href="{{ route('home') }}" class="btn btn-default">Отмена</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
