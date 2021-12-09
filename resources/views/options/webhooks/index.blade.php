@extends('adminlte::page')

@section('title', 'Настройки - Вебхуки')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Настройки - Вебхуки</h1>
        <a class="btn bg-success" href="{{ route('webhooks.create') }}"><i class="fas fa-plus-circle"></i> Создать вебхук</a>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card>
                <div class="table-responsive">
                    <table id="webhooks" class="table table-sm table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>URL</th>
                                <th>Метод</th>
                                <th>Даные</th>
                                <th>Активность</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($webhooks as $webhook)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $webhook->url ?? '' }}</td>
                                    <td class="text-uppercase">{{ $webhook->method ?? '' }}</td>
                                    <td>
                                        @forelse ($webhook->data as $data )
                                            <span class="badge badge-primary">{{ $params->firstWhere('code',$data)->name ?? '' }}</span>
                                        @empty
                                        @endforelse
                                    </td>
                                    <td class="text-center">
                                        @if ($webhook->enabled)
                                            <i class="fas fa-check-circle text-success"></i>
                                        @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <a class="btn btn-info btn-sm" href="{{ route('webhooks.edit', $webhook->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <btn-confirm-sweet type="danger"
                                            btn-icon="fas fa-trash"
                                            title="Удалить"
                                            text="Удалить выбранный вебхук?"
                                            action-url="{{ route('webhooks.destroy', $webhook->id)}}"
                                            action-method="delete"></btn-confirm-sweet>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Записи отсутствуют</td>
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
        $('#webhooks').DataTable({
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
