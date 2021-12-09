@extends('adminlte::page')

@section('title', 'Создать лид')

@section('content_header')
    <h1 class="mr-3 text-dark">Создать лид</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <form action="{{ route('leads.store') }}" method="POST">
                    @csrf
                    {{-- UTM параметры --}}
                    @forelse ($utms as $utm)
                        <x-adminlte-input name="{{ $utm->code ?? '' }}" error-key="{{ $utm->code ?? '' }}" label="UTM {{ $utm->name ?? '' }}" value="{{ old($utm->code) }}" placeholder="Введите параметр"/>
                    @empty
                    @endforelse
                    {{-- GET параметры --}}
                    @forelse ($gets as $get)
                        <x-adminlte-input name="{{ $get->code ?? '' }}" error-key="{{ $get->code ?? '' }}" label="GET {{ $get->name ?? '' }}" value="{{ old($get->code) }}" placeholder="Введите параметр"/>
                    @empty
                    @endforelse
                    <div class="d-flex justify-content-start">
                        <x-adminlte-button type="submit" theme="primary" class="mr-1" label="Создать"/>
                        <a href="{{ route('leads.index') }}" class="btn btn-default">Отмена</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

