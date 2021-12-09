@extends('adminlte::page')

@section('title', 'Настройки - Создать вебхук')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Настройки - Создать вебхук</h1>
    </div>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('webhooks.store') }}" method="POST">
                    @csrf
                    {{-- URL --}}
                    <x-adminlte-input name="url" error-key="url" label="URL" value="{{ old('url') }}"
                        placeholder="Введите URL для отправки" />
                    {{-- Метод --}}
                    <x-adminlte-select2 id="method" name="method" error-key="method" label="Метод запроса">
                        <option value="get" @if (old('method') == 'get') selected @endif>GET</option>
                        <option value="post" @if (old('method') == 'post') selected @endif>POST</option>
                    </x-adminlte-select2>
                    {{-- Данные для отправки --}}
                    <x-adminlte-select2 id="data" name="data[]" error-key="data" label="Данные для отправки"
                        data-placeholder="Выберите данные" multiple>
                        @forelse ( $params as $param)
                            <option value="{{ $param->code ?? '' }}" @if (in_array($param->code, old('data', []))) selected @endif>
                                {{ $param->name ?? '' }}
                            </option>
                        @empty
                        @endforelse
                    </x-adminlte-select2>
                    {{-- Вкл/Откл вебхука --}}
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" id="enabled"
                            name="enabled" value="1" @if (old('enabled')) checked @endif>
                        <label class="custom-control-label" for="enabled">Включение/отключение
                            события</label>
                    </div>
                    @error('enabled')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="d-flex justify-content-start mt-3">
                        <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать" />
                        <a href="{{ route('webhooks.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
