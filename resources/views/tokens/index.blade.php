@extends('adminlte::page')

@section('title', 'Токены')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Токены</h1>
        <a class="btn bg-success" href="{{ route('tokens.create') }}"><i class="fas fa-plus-circle"></i> Создать токен</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="tokens" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Код</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tokens as $token)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $token->name ?? '' }}</td>
                                    <td>{{ $token->uuid ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('tokens.edit', $token->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить {{ $token->name ?? 'выбраный' }}?"
                                            action-url="{{ route('tokens.destroy', $token->id)}}"
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
        $('#tokens').DataTable({
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
