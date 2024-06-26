<!-- Navigation -->
<h6 class="navbar-heading text-muted">
    @if (auth()->user()->role == 'admin')
        Gestionar Datos
    @else
        Menú
    @endif
</h6>
<ul class="navbar-nav">

    @include('includes.panel.menu.' . auth()->user()->role)


    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
            <i class="ni ni-key-25"></i> Cerrar Sesión
            <form action="{{ route('logout') }}" method="POST" style="display:none;" id="formLogout">
                @csrf
            </form>
        </a>
    </li>

    <!-- Divider -->
    @if (auth()->user()->role == 'admin')
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">Reportes</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/charts/appoinments/line') }}">
                    <i class="ni ni-sound-wave text-yellow"></i> Frecuencia de Citas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/charts/doctors/column') }}">
                    <i class="ni ni-spaceship text-orange"></i> Médicos + activos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/charts/doctors/column') }}">
                    <i class="ni ni-spaceship text-orange"></i> Otros
                </a>
            </li>
        </ul>
    @endif
</ul>
