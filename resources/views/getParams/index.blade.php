@extends('adminlte::page')

@section('title', 'GET-параметры')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">GET-параметры</h1>
        <a class="btn bg-success" href="{{ route('get-params.create') }}"><i class="fas fa-plus-circle"></i> Создать GET-параметр</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="getParams" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Код</th>
                                <th>Порядок</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($getParams as $getParam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getParam->name ?? '' }}</td>
                                    <td>{{ $getParam->code ?? '' }}</td>
                                    <td>{{ $getParam->order ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('get-params.edit', $getParam->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить {{ $getParam->name ?? 'выбраный' }}?"
                                            action-url="{{ route('get-params.destroy', $getParam->id)}}"
                                            action-method="delete"></btn-confirm-sweet>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Записи отсутствуют</td>
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
    $(document).ready(function() {
        $('#getParams').DataTable({
            language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json'
            },
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] //Отключение сортировки по последнему полю (-1 - первое справа)
            }],
        });
    } );
</script>
@endpush
