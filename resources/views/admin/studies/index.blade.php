@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Estudios</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('studies/create') }}" class="btn btn-sm btn-success">Nuevo Estudio</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div class="card-body">
                @if (session('notification'))
                    <div class="alert alert-success" role="alert">
                        {{ session('notification') }}
                    </div>
                @endif
            </div>

            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studies as $study)
                        <tr>
                            <th scope="row">
                                {{ $study->name }}
                            </th>
                            <td>
                                {{ $study->description }}
                            </td>
                            <td>
                                {{ $study->price }}
                            </td>
                            <td>
                                <form action="{{ url('studies/' . $study->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('studies/' . $study->id . '/edit') }}"
                                        class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger btn-circle" type="submit"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body">
            {{ $studies->links() }}
        </div>

    </div>
@endsection
