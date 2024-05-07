@extends('layouts.panel')

@section('content')



    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Crear Formulario</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('form-templates') }}" class="btn btn-sm btn-default">
                        Cancelar y Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" id="notification" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url('form-templates/') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre de la Plantilla</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <input type="textaare" name="description" class="form-control" value="{{ old('description') }}">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="with_odontogram" id="with_odontogram">
                        <label class="form-check-label" for="with_odontogram">
                            Con Odontograma
                        </label>
                    </div>
                </div>

                <div id="app">
                    <form-builder></form-builder>
                </div>

                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
