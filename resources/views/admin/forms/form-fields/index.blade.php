@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="fields-tab" data-toggle="tab" href="#fields" role="tab"
                                aria-controls="fields" aria-selected="true">Campos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trash-tab" data-toggle="tab" href="#trash" role="tab"
                                aria-controls="trash" aria-selected="false">
                                Papelera
                                @if ($trashedFields->count() > 0)
                                    <span class="badge badge-danger">{{ $trashedFields->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col text-right">
                    <a href="{{ url('form-fields/create') }}" class="btn btn-sm btn-success">Nuevo Campo</a>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="fields" role="tabpanel" aria-labelledby="fields-tab">
                <div class="table-responsive">
                    <div class="card-body">
                        @if (session('notification'))
                            <div class="alert alert-success" id="notification" role="alert">
                                {{ session('notification') }}
                            </div>
                        @endif
                    </div>

                    <!-- Fields table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Campo</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Plantilla</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fields as $field)
                                <tr>
                                    <th scope="row">
                                        {{ $field->name }}
                                    </th>
                                    <th scope="row">
                                        {{ $field->type }}
                                    </th>
                                    <td>{{ $field->template->name }}</td>
                                    <td>
                                        <form action="{{ url('form-fields/' . $field->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ url('form-fields/' . $field->id . '/edit') }}"
                                                class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>

                                            <a href="{{ route('form-fields.confirmDelete', $field->id) }}"
                                                class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    {{ $fields->links() }}
                </div>
            </div>

            <!-- Papelera -->
            <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                <div class="table-responsive">
                    <!-- Fields table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Motivo</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashedFields as $field)
                                <tr>
                                    <th scope="row">
                                        {{ $field->name }}
                                    </th>
                                    <td>
                                        @switch($field->delete_reason)
                                            @case('sin_uso')
                                                Sin USO
                                            @break

                                            @case('expired')
                                                Expirado
                                            @break

                                            @default
                                                {{ $field->delete_reason }}
                                        @endswitch
                                    </td>
                                    <td>
                                        <form action="{{ route('form-fields.restore', $field->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm btn-circle">
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
                    {{ $trashedFields->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
