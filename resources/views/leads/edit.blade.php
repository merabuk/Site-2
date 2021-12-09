@extends('adminlte::page')

@section('title', 'Редактировать лид')

@section('content_header')
    <h1 class="mr-3 text-dark">Редактировать лид</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- UTM параметры --}}
                    @forelse ($utms as $utm)
                        <x-adminlte-input name="{{ $utm->code ?? '' }}" error-key="{{ $utm->code ?? '' }}" label="UTM {{ $utm->name ?? '' }}" value="{{ old($utm->code, $lead->utms->get($utm->code)) }}" placeholder="Введите параметр"/>
                    @empty
                    @endforelse
                    {{-- GET параметры --}}
                    @forelse ($gets as $get)
                        <x-adminlte-input name="{{ $get->code ?? '' }}" error-key="{{ $get->code ?? '' }}" label="GET {{ $get->name ?? '' }}" value="{{ old($get->code, $lead->gets->get($get->code)) }}" placeholder="Введите параметр"/>
                    @empty
                    @endforelse
                    <div class="d-flex justify-content-start">
                        <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Редактировать"/>
                        <a href="{{ route('leads.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
