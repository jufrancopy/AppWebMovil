@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Editar Paciente</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('patients')}}" class="btn btn-sm btn-default">
                    Cancelar y Volver
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <form action="{{route('patients.update', $patient->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre del Médico</label>
                <input type="text" name="name" class="form-control" value="{{old('name',$patient->name)}}">
            </div>

            <div class="form-group">
                <label for="email   ">Correo Electrónico</label>
                <input type="text" name="email" class="form-control" value="{{old('email',$patient->email)}}">
            </div>

            <div class="form-group">
                <label for="ci">Cédula de Identidad</label>
                <input type="text" name="ci" class="form-control" value="{{old('ci',$patient->ci)}}">
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{old('address',$patient->address)}}">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{old('phone',$patient->phone)}}">
            </div>

            <div class="form-group">
                <label for="password">Contraseña </label>
                <input type="text" name="password" class="form-control" value="">
                <p>Ingrese un valor solo si va modificar la Contraseña</p>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection