<div class="row">
    <div class="col-12">
        @if ($message = Session::get('success'))
            <x-adminlte-alert theme="success" title="Успех" dismissable>
                {{ $message }}
            </x-adminlte-alert>
        @endif

        @if ($message = Session::get('warning'))
            <x-adminlte-alert theme="warning" title="Внимание" dismissable>
                {{ $message }}
            </x-adminlte-alert>
        @endif

        @if ($message = Session::get('error'))
            <x-adminlte-alert theme="danger" title="Ошибка" dismissable>
                {{ $message }}
            </x-adminlte-alert>
        @endif

        @if ($message = Session::get('info'))
            <x-adminlte-alert theme="info" title="Информация" dismissable>
                {{ $message }}
            </x-adminlte-alert>
        @endif

        {{-- @if ($errors->any())
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">Г—</button>
            <ul class="my-0">
                @foreach ($errors->all() as $error)
                <li class="mb-1"><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
        </div>
        @endif --}}
    </div>
</div>
