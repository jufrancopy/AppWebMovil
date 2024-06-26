<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Especialidad</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historialAppointments as $appointment)
            <tr>
                <td>
                    {{$appointment->specialty->name}}
                </td>
                <td>
                    {{$appointment->scheduled_date}}
                </td>
                <td>
                    {{$appointment->scheduled_time_12}}
                </td>
                <td>
                    {{$appointment->status}}
                    
                </td>
                <td>
                    <a href="{{url('/appointments/'.$appointment->id)}}" class="btn btn-primary btn-sm btn-circle"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{$historialAppointments->links()}}
</div>