@extends('adminlte::page')

@section('title', 'Группы пользователей')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Группы пользователей</h1>
        <a class="btn bg-success" href="{{ route('user-groups.create') }}"><i class="fas fa-plus-circle"></i> Создать группу</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="userGroups" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userGroups as $userGroup)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $userGroup->display_name ?? '' }}</td>
                                    <td>{{ $userGroup->description ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('user-groups.edit', $userGroup->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить группу {{ $userGroup->display_name ?? 'выбранную' }}?"
                                            action-url="{{ route('user-groups.destroy', $userGroup->id)}}"
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
        $('#userGroups').DataTable({
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
