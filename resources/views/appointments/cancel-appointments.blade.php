@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Cancelar Citas</h3>
            </div>
            <div class="col text-right">
                <a href="{{route('appointments.create')}}" class="btn btn-sm btn-success">Nueva Cita</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('notification'))
        <div class="alert alert-success" role="alert">
            {{session('notification')}}
        </div>
        @endif
        @if($role =='patient')
        <p>
            Estás a punto de cancelar tu cita reservada con el médico <strong>{{$appointment->doctor->name}}</strong>, de la especialidad <strong>{{$appointment->specialty->name}}</strong>, fijada para el día <strong>{{$appointment->scheduled_date}}</strong> 
        </p>
        @elseif($role == 'doctor')
        <p>
            Estás a punto de cancelar una cita reservada por el paciente <strong>{{$appointment->patient->name}}</strong>, para la especialidad <strong>{{$appointment->specialty->name}}</strong>, fijada para el día <strong>{{$appointment->scheduled_date}}</strong> a la hora <strong>{{$appointment->scheduled_time_12}}</strong>
        </p>
        @else
        <p>
            Estás a punto de cancelar la cita reservada por el paciente <strong>{{$appointment->patient->name}}</strong>, para el doctor <strong>{{$appointment->doctor->name}}</strong> de la especialidad <strong>{{$appointment->specialty->name}}</strong>, fijada dapara el día <strong>{{$appointment->scheduled_date}}</strong> a la hora <strong>{{$appointment->scheduled_time_12}}</strong> 
        </p>
        @endif
        <form action="{{url('appointments/'.$appointment->id.'/cancel')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="justification">Cuentanos el motivo de la cancelación</label>
                <textarea name="justification" id="justification" rows="3" class="form-control"></textarea>
            </div>  
            <button class="btn btn-danger" type="submit">Cancelar Cita</button>
            <a href="{{url('/appointments')}}" class="btn btn-default">Ir a Listado de Citas</a>
        </form>
    </div>
</div>
@endsection