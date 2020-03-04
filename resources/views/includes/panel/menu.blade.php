<!-- Navigation -->
<h6 class="navbar-heading text-muted">
    @if(auth()->user()->role == 'admin')
    Gestionar Datos
    @else
    Menú
    @endif
</h6>
<ul class="navbar-nav">
    @if(auth()->user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="/home">
            <i class="ni ni-tv-2 text-danger"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/specialties">
            <i class="ni ni-planet text-blue"></i> Especialidad
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('doctors.index')}}">
            <i class="ni ni-single-02 text-blue"></i> Médicos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('patients.index')}}">
            <i class="ni ni-satisfied text-info"></i> Pacientes
        </a>
    </li>
    @elseif(auth()->user()->role == 'doctor')
    <li class="nav-item">
        <a class="nav-link" href="/schedule">
            <i class="ni ni-calendar-grid-58 text-danger"></i> Gestionar Horario
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('patients.index')}}">
            <i class="ni ni-time-alarm text-primary"></i> Mis Citas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('patients.index')}}">
            <i class="ni ni-satisfied text-info"></i> Mis Pacientes
        </a>
    </li>
    @else {{--patient--}}
    <li class="nav-item">
        <a class="nav-link" href="{{route('patients.index')}}">
            <i class="ni ni-send text-danger"></i> Reservar Citas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('patients.index')}}">
            <i class="ni ni-time-alarm text-primary"></i> Mis Citas
        </a>
    </li>
    @endif
    {{-- <li class="nav-item">
        <a class="nav-link" href="./examples/profile.html">
            <i class="ni ni-single-02 text-yellow"></i> Horarios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="./examples/tables.html">
            <i class="ni ni-bullet-list-67 text-red"></i> Tables
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{route('logout')}}"
            onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
            <i class="ni ni-key-25"></i> Cerrar Sesión
            <form action="{{route('logout')}}" method="POST" style="display:none;" id="formLogout">
                @csrf
            </form>
        </a>
    </li>

</ul>
<!-- Divider -->
@if(auth()->user()->role == 'admin')
<hr class="my-3">
<!-- Heading -->
<h6 class="navbar-heading text-muted">Reportes</h6>
<!-- Navigation -->
<ul class="navbar-nav mb-md-3">
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="ni ni-sound-wave text-yellow"></i> Frecuencia de Citas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="ni ni-spaceship text-orange"></i> Médicos + activos
        </a>
    </li>
    @endif
</ul>