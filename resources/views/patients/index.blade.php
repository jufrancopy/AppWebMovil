@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Pacientes</h3>
            </div>
            <div class="col text-right">
                <a href="{{route('patients.create')}}" class="btn btn-sm btn-success">Nuevo Paciente</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <div class="card-body">
            @if(session('notification'))
            <div class="alert alert-success" role="alert">
                {{session('notification')}}
            </div>
            @endif
        </div>

        <!-- Projects table -->
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <th scope="row">
                        {{$patient->name}}
                    </th>
                    <td>
                        {{$patient->email}}
                    </td>
                    <td>
                        {{$patient->ci}}
                    </td>
                    <td>

                        <form action="{{url('patients/'.$patient->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{url('patients/'.$patient->id.'/edit')}}"
                                class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger btn-circle" type="submit"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{$patients->links()}}
    </div>
</div>
@endsection