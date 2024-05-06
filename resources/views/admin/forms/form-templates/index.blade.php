@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="templates-tab" data-toggle="tab" href="#templates" role="tab"
                                aria-controls="templates" aria-selected="true">Formulario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trash-tab" data-toggle="tab" href="#trash" role="tab"
                                aria-controls="trash" aria-selected="false">
                                Papelera
                                @if ($trashedTemplates->count() > 0)
                                    <span class="badge badge-danger">{{ $trashedTemplates->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col text-right">
                    <a href="{{ url('form-templates/create') }}" class="btn btn-sm btn-success">Nueva Plantilla</a>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="templates" role="tabpanel" aria-labelledby="templates-tab">
                <div class="table-responsive">
                    <div class="card-body">
                        @if (session('notification'))
                            <div class="alert alert-success" id="notification" role="alert">
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
                                <th scope="col">Odontograma</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                                <tr>
                                    <th scope="row">
                                        {{ $template->name }}
                                    </th>
                                    <td>{{ $template->description }}</td>
                                    @if ($template->with_odontogram == true)
                                        <td><i class="fa fa-tooth text-success" aria-hidden="true"></i></td>
                                    @else
                                        <td><i class="fa fa-tooth text-danger" aria-hidden="true"></i></td>
                                    @endif
                                    <td>
                                        <form action="{{ url('form-templates/' . $template->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ url('form-templates/' . $template->id . '/edit') }}"
                                                class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>

                                            <a href="{{ route('form-templates.confirmDelete', $template->id) }}"
                                                class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    {{ $templates->links() }}
                </div>
            </div>

            <!-- Papelera -->
            <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Motivo</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashedTemplates as $template)
                                <tr>
                                    <th scope="row">
                                        {{ $template->name }}
                                    </th>
                                    <td>
                                        @switch($template->delete_reason)
                                            @case('sin_uso')
                                                Sin USO
                                            @break

                                            @case('expired')
                                                Expirado
                                            @break

                                            @default
                                                {{ $template->delete_reason }}
                                        @endswitch
                                    </td>
                                    <td>
                                        <form action="{{ route('form-templates.restore', $template->id) }}" method="POST">
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
                    {{ $trashedTemplates->links() }}
                </div>
            </div>

        </div>

    </div>
@endsection
