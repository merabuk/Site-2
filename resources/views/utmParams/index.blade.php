@extends('adminlte::page')

@section('title', 'UTM-параметры')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">UTM-параметры</h1>
        <a class="btn bg-success" href="{{ route('utm-params.create') }}"><i class="fas fa-plus-circle"></i> Создать UTM-параметр</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="utmParams" class="table table-sm table-striped table-bordered w-100">
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
                            @forelse ($utmParams as $utmParam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $utmParam->name ?? '' }}</td>
                                    <td>{{ $utmParam->code ?? '' }}</td>
                                    <td>{{ $utmParam->order ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('utm-params.edit', $utmParam->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить {{ $utmParam->name ?? 'выбраный' }}?"
                                            action-url="{{ route('utm-params.destroy', $utmParam->id)}}"
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
        $('#utmParams').DataTable({
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
