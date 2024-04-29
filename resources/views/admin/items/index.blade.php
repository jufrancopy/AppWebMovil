@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab"
                                aria-controls="items" aria-selected="true">Ítems</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trash-tab" data-toggle="tab" href="#trash" role="tab"
                                aria-controls="trash" aria-selected="false">
                                Papelera
                                @if ($trashedItems->count() > 0)
                                    <span class="badge badge-danger">{{ $trashedItems->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col text-right">
                    <a href="{{ url('items/create') }}" class="btn btn-sm btn-success">Nuevo Ítem</a>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
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
                                <th scope="col">Precio</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <th scope="row">
                                        {{ $item->name }}
                                    </th>
                                    <td>
                                        {{ $item->description }}
                                    </td>
                                    <td>
                                        {{ $item->price }}
                                    </td>
                                    @switch($item->type)
                                        @case('medicines')
                                            <td>Medicamentos</td>
                                        @break

                                        @case('supplies')
                                            <td>Insumos</td>
                                        @break

                                        @default
                                            <td>Desconocido</td>
                                    @endswitch
                                    <td>
                                        <form action="{{ url('items/' . $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ url('items/' . $item->id . '/edit') }}"
                                                class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>

                                            <a href="{{ route('items.confirmDelete', $item->id) }}"
                                                class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    {{ $items->links() }}
                </div>
            </div>

            <!-- Papelera -->
            <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedItems as $item)
                                    <tr>
                                        <th scope="row">
                                            {{ $item->name }}
                                        </th>
                                        <td>
                                            {{ $item->description }}
                                        </td>
                                        <td>
                                            {{ $item->price }}
                                        </td>
                                        @switch($item->type)
                                            @case('medicines')
                                                <td>Medicamentos</td>
                                            @break

                                            @case('supplies')
                                                <td>Insumos</td>
                                            @break

                                            @default
                                                <td>Desconocido</td>
                                        @endswitch
                                        <td>{{ $item->delete_reason }}</td>
                                        <td>
                                            <form action="{{ route('items.restore', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm btn-circle">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
