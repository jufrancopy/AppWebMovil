@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-study">
                            <a class="nav-link active" id="studies-tab" data-toggle="tab" href="#studies" role="tab"
                                aria-controls="studies" aria-selected="true">Estudios</a>
                        </li>
                        <li class="nav-study">
                            <a class="nav-link" id="trash-tab" data-toggle="tab" href="#trash" role="tab"
                                aria-controls="trash" aria-selected="false">
                                Papelera
                                @if ($trashedStudies->count() > 0)
                                    <span class="badge badge-danger">{{ $trashedStudies->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col text-right">
                    <a href="{{ url('studies/create') }}" class="btn btn-sm btn-success">Nuevo Estudio</a>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="studies" role="tabpanel" aria-labelledby="studies-tab">
                <div class="table-responsive">
                    <div class="card-body">
                        @if (session('notification'))
                            <div class="alert alert-success" id="notification" role="alert">
                                {{ session('notification') }}
                            </div>
                        @endif
                    </div>

                    <!-- Projects table -->
                    <table class="table align-studies-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Tipo</th>
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
                                                class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a>

                                            <a href="{{ route('studies.confirmDelete', $study->id) }}"
                                                class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></a>

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

            <!-- Papelera -->
            <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                <div class="tab-pane fade show active" id="studies" role="tabpanel" aria-labelledby="studies-tab">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-studies-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedStudies as $study)
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
                                            @switch($study->delete_reason)
                                                @case('sin_uso')
                                                    'Sin USO'
                                                    {{ $study->delete_reason }}
                                                @break

                                                @case('sin_uso')
                                                    'Sin USO'
                                                    {{ $study->delete_reason }}
                                                @break

                                                @default
                                                    <!-- Aquí va el contenido para cualquier otro caso -->
                                                    {{ $study->delete_reason }} <!-- Puedes cambiar esto según lo necesites -->
                                            @endswitch
                                        </td>

                                        <td>
                                            <form action="{{ route('studies.restore', $study->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-circle">
                                                    <i class="fa fa-undo"></i>
                                                </button>
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
            </div>
        </div>

    </div>
@endsection
