@extends('adminlte::page')

@section('title', 'Статусы')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Статусы</h1>
        <a class="btn bg-success" href="{{ route('lead-statuses.create') }}"><i class="fas fa-plus-circle"></i> Создать статус</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BootstrapColorpicker', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="leadStatuses" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Цвет</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leadStatuses as $leadStatus)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $leadStatus->name ?? '' }}</td>
                                    <td class="text-center">
                                        <i class="fas fa-circle fa-2x" style="color: {{ $leadStatus->color }}"></i>
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('lead-statuses.edit', $leadStatus->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить {{ $leadStatus->name ?? 'выбранную' }}?"
                                            action-url="{{ route('lead-statuses.destroy', $leadStatus->id)}}"
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
        $('#leadStatuses').DataTable({
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
