@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Médicos</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('doctors/create')}}" class="btn btn-sm btn-success">Nuevo Médico</a>
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
                @foreach ($doctors as $doctor)
                <tr>
                    <th scope="row">
                        {{$doctor->name}}
                    </th>
                    <td>
                        {{$doctor->email}}
                    </td>
                    <td>
                        {{$doctor->ci}}
                    </td>
                    <td>
                        <form action="{{url('doctors/'.$doctor->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{url('doctors/'.$doctor->id.'/edit')}}" class="btn btn-primary btn-sm btn-circle"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger btn-circle" type="submit"><i class="fa fa-trash"></i></button>
                            <a href="{{route('asignHour', $doctor->id)}}" class="btn btn-sm btn-info btn-circle"><i class="fa fa-calendar"></i></a>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{$doctors->links()}}
    </div>

</div>
@endsection