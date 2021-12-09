@extends('adminlte::page')

@section('title', 'Методы')

@section('content_header')
    <div>
        <h1 class="mr-3 text-dark">Методы</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-card title="Прием лида" theme="danger" icon="fas fa-lg fa-code">
                <div class="accordion" id="leadStore">
                    {{-- URL --}}
                    <div class="card">
                      <div class="card-header" id="leadStoreUrl">
                        <h2 class="m-0">
                          <button class="btn btn-link btn-block text-left p-0" type="button" data-toggle="collapse" data-target="#leadStoreUrlPanel" aria-expanded="true" aria-controls="leadStoreUrlPanel">
                            URL
                          </button>
                        </h2>
                      </div>
                      <div id="leadStoreUrlPanel" class="collapse" aria-labelledby="leadStoreUrl" data-parent="#leadStoreUrl">
                        <div class="card-body">
                            <b>{{ url('/') }}/api/lead</b>
                        </div>
                      </div>
                    </div>
                    {{-- Методы --}}
                    <div class="card">
                        <div class="card-header" id="leadStoreMethod">
                          <h2 class="m-0">
                            <button class="btn btn-link btn-block text-left p-0" type="button" data-toggle="collapse" data-target="#leadStoreMethodPanel" aria-expanded="true" aria-controls="leadStoreMethodPanel">
                              Тип
                            </button>
                          </h2>
                        </div>
                        <div id="leadStoreMethodPanel" class="collapse" aria-labelledby="leadStoreMethod" data-parent="#leadStoreMethod">
                          <div class="card-body">
                              <b>POST, GET</b>
                          </div>
                        </div>
                    </div>
                    {{-- Описание --}}
                    <div class="card">
                        <div class="card-header" id="leadStoreDescr">
                          <h2 class="m-0">
                            <button class="btn btn-link btn-block text-left p-0" type="button" data-toggle="collapse" data-target="#leadStoreDescrPanel" aria-expanded="true" aria-controls="leadStoreDescrPanel">
                              Описание
                            </button>
                          </h2>
                        </div>
                        <div id="leadStoreDescrPanel" class="collapse" aria-labelledby="leadStoreDescr" data-parent="#leadStoreDescr">
                          <div class="card-body">
                              <p>URL защищен токеном, который нужно добавить в заголовок запроса <code>Authorization: Bearer ТОКЕН</code></p>
                              <p>Метод создает лида из параметров запроса. При создании лида принимают участие только те параметры, которые были заданы
                              в разделах GET-параметы и UTM-параметры. Остальные параметры запроса игнорируются.</p>
                          </div>
                        </div>
                    </div>
                  </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
