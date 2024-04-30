@extends('layouts.panel')

@section('content')

@section('styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Editar Campo</h3>
            </div>
            <div class="col text-right">
                <a href="{{ url('form-fields') }}" class="btn btn-sm btn-default">
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
        <form action="{{ url('form-fields/' . $formField->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre del Campo</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $formField->name) }}">
            </div>

            <div class="form-group">
                <label for="form_template_id">Plantilla</label>
                <select name="form_template_id" class="form-control">
                    @foreach ($formTemplates as $template)
                        <option value="{{ $template->id }}" {{ $formField->form_template_id == $template->id ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control">
                    @foreach (getTypeInputs() as $value => $label)
                        <option value="{{ $value }}" {{ old('type', $formField->type) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
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
