@extends('adminlte::page')

@section('title', 'Офисы')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Офисы</h1>
        <a class="btn bg-success" href="{{ route('lead-groups.create') }}"><i class="fas fa-plus-circle"></i> Создать офис</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BootstrapSelect', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="leadGroups" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Время начала работы</th>
                                <th>Время завершения работы</th>
                                <th>Коэффициент на количество лидов при автораспределении, 1..100%</th>
                                <th>Максимальное количество лидов при автораспределении</th>
                                <th>Включить/Отключить автораспределение лидов</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leadGroups as $leadGroup)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><lead-group-name :lead-group='@json($leadGroup)' :token='@json($token)' key={{ $leadGroup->id }}/></td>
                                    <td><lead-group-time :lead-group='@json($leadGroup)' :token='@json($token)' time='open' key={{ $leadGroup->id }}/></td>
                                    <td><lead-group-time :lead-group='@json($leadGroup)' :token='@json($token)' time='close' key={{ $leadGroup->id + $leadGroups->count() }}/></td>
                                    <td><lead-group-kleads :lead-group='@json($leadGroup)' :token='@json($token)' key={{ $leadGroup->id }}/></td>
                                    <td><lead-group-maxleads :lead-group='@json($leadGroup)' :token='@json($token)' key={{ $leadGroup->id }}/></td>
                                    <td><lead-group-enabled :lead-group='@json($leadGroup)' :token='@json($token)' key={{ $leadGroup->id }}/></td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('lead-groups.edit', $leadGroup->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить {{ $leadGroup->name ?? 'выбранную' }}?"
                                            action-url="{{ route('lead-groups.destroy', $leadGroup->id)}}"
                                            action-method="delete"></btn-confirm-sweet>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Записи отсутствуют</td>
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

        $('#leadGroups').DataTable({
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
