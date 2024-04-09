<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Descripción</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Médico</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingAppointments as $appointment)
            <tr>
                <th scope="row">
                    {{$appointment->description}}
                </th>
                <td>
                    {{$appointment->specialty->name}}
                </td>
                <td>
                    {{$appointment->doctor->name}}
                </td>
                <td>
                    {{$appointment->scheduled_date}}
                </td>
                <td>
                    {{$appointment->scheduled_time_12}}
                </td>
                <td>
                    {{$appointment->type}}
                </td>
                <td>
                    @if($role== "admin")
                    <a class="btn btn-sm btn-info" title="Ver citas" href="{{url('/appointments/'.$appointment->id)}}">
                        <i class="fas fa-eye"></i>
                    </a>
                    @endif
                    @if($role == 'doctor' || $role == 'admin')
                    <form action="{{url('/appointments/'.$appointment->id.'/confirm')}}" method="POST"
                        class="d-inline-block">
                        @csrf
                        <button class="btn btn-sm btn-success btn-circle" type="submit" data-toggle="tooltip"
                            title="Confirmar Cita">
                            <i class="ni ni-check-bold"></i>
                        </button>
                    </form>
                    <a href="{{'/appointments/'.$appointment->id.'/cancel'}}" class="btn btn-sm btn-danger">
                        <i class="ni ni-fat-detele btn-circle"></i>
                    </a>
                    
                    @else
                    <form action="{{url('/appointments/'.$appointment->id.'/cancel')}}" method="POST"
                        class="d-inline-block">
                        @csrf
                        <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="Cancelar Cita">
                            <i class="ni ni-fat-delete"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card-body">
    {{$pendingAppointments->links()}}
</div>