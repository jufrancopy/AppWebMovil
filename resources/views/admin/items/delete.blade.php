@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Confirmar Eliminación</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p>
                ¿Estás seguro de que deseas eliminar el item <strong>{{ $item->name }}</strong>?
            </p>
            <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <label for="delete_reason">Motivo de la eliminación (opcional)</label>
                    <textarea name="delete_reason" id="delete_reason" rows="3" class="form-control"></textarea>
                </div>
                <button class="btn btn-danger" type="submit">Eliminar Item</button>
                <a href="{{ url('/items') }}" class="btn btn-default">Cancelar</a>

            </form>
        </div>
    </div>
@endsection
