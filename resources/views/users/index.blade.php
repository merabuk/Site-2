@extends('adminlte::page')

@section('title', 'Пользователи')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Пользователи</h1>
        <a class="btn bg-success" href="{{ route('users.create') }}"><i class="fas fa-plus-circle"></i> Создать пользователя</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="users" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ф.И.О.</th>
                                <th>E-mail</th>
                                <th>Роль</th>
                                <th>Группы пользователя</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->email ?? '' }}</td>
                                    <td>{{ $user->roles->first()->display_name }}</td>
                                    <td>
                                        @forelse ($user->userGroups as $group)
                                            {{ ($loop->iteration != 1) ? '; '.$group->display_name : $group->display_name }}
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @if (auth()->user()->id != $user->id)
                                            <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить пользователя {{ $user->name ?? 'выбранного' }}?"
                                            action-url="{{ route('users.destroy', $user->id)}}"
                                            action-method="delete"></btn-confirm-sweet>
                                        @endif
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
        $('#users').DataTable({
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
