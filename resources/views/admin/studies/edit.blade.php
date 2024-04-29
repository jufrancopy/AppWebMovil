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
                <h3 class="mb-0">Editar Estudio</h3>
            </div>
            <div class="col text-right">
                <a href="{{ url('studies') }}" class="btn btn-sm btn-default">
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
        <form action="{{ url('studies/' . $study->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre del Estudio</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $study->name) }}">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="texarea" name="description" class="form-control"
                    value="{{ old('', $study->description) }}">
            </div>

            <div class="form-group">
                <label for="price">Precio</label>
                <input type="text" name="price" class="form-control" value="{{ old('price', $study->price) }}">
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script></script>
@endsection
