@extends('adminlte::page')

@section('title', 'Просмот лида')

@section('content_header')
    <h1 class="mr-3 text-dark">Просмотр лида</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form>
                    <x-adminlte-input name="id" label="Номер лида" placeholder="Нет данных" value="{{ $lead->id }}"/>
                    @role('administrator')
                        <x-adminlte-input name="created_at" label="Создан" placeholder="Нет данных" value="{{ $lead->created_at }}"/>
                    @endrole
                    <x-adminlte-input name="updated_at" label="Обновлен" placeholder="Нет данных" value="{{ $lead->updated_at }}"/>
                    <x-adminlte-input name="buyer" label="Покупатель" placeholder="Нет данных" value="{{ $lead->gets->get('buyer') }}"/>
                    @if (auth()->user()->hasPermission('lead-show-get-param-phone') || auth()->user()->roles->first()->hasPermission('lead-show-get-param-phone'))
                        <x-adminlte-input name="phone" label="Телефон" placeholder="Нет данных" value="{{ $lead->gets->get('phone') }}"/>
                    @endif
                    @if (auth()->user()->hasPermission('lead-show-get-param-email') || auth()->user()->roles->first()->hasPermission('lead-show-get-param-email'))
                        <x-adminlte-input name="email" label="Email" placeholder="Нет данных" value="{{ $lead->gets->get('email') }}"/>
                    @endif
                    <x-adminlte-input name="product" label="Товар" placeholder="Нет данных" value="{{ $lead->gets->get('product') }}"/>
                    @role('administrator')
                        <x-adminlte-input name="price" label="Сумма" placeholder="Нет данных" value="{{ $lead->gets->get('price') }}"/>
                    @endrole
                    <x-adminlte-input name="group" label="Группа" placeholder="Нет данных" value="{{ $lead->leadGroup->name ?? 'Нет группы' }}"/>
                    <x-adminlte-input name="status" label="Статус" placeholder="Нет данных" value="{{ $lead->leadStatus->name ?? 'Нет статуса' }}"/>
                    <x-adminlte-textarea name="comments" label="Комментарии" placeholder="Нет данных">
                        {{ $lead->gets->get('comments') }}
                    </x-adminlte-textarea>
                    @role('administrator')
                        {{-- UTM --}}
                        @forelse ($utms as $utm)
                            <x-adminlte-input name="{{ $utm->code }}" label="{{ $utm->name }}" placeholder="Нет данных" value="{{ $lead->utms->get($utm->code) }}"/>
                        @empty
                        @endforelse
                        {{-- GET --}}
                        @forelse ($gets as $get)
                            <x-adminlte-input name="{{ $get->code }}" label="{{ $get->name }}" placeholder="Нет данных" value="{{ $lead->gets->get($get->code) }}"/>
                        @empty
                        @endforelse
                        {{-- IP --}}
                        <x-adminlte-input name="domen" label="Домен" placeholder="Нет данных" value="{{ $lead->domain }}"/>
                        <x-adminlte-input name="url" label="URL" placeholder="Нет данных" value="{{ $lead->url }}"/>
                    @endrole

                    <div class="d-flex justify-content-start">
                        <a href="{{ route('leads.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

