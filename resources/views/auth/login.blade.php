@extends('layouts.form')
@section('title', 'Inicio de Sesión')
@section('subtitle', 'Ingrese sus credenciales')
@section('content')
<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                {{-- <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><small>Sign in with</small></div>
                    <div class="btn-wrapper text-center">
                        <a href="#" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon"><img src="{{asset('img/icons/common/github.svg')}}"></span>
                <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon"><img src="{{asset('img/icons/common/google.svg')}}"></span>
                    <span class="btn-inner--text">Google</span>
                </a>
            </div>
        </div> --}}
        <div class="card-body px-lg-5 py-lg-5">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{$errors->first()}}
                </div>
            @endif
            <form role="form" method="POST" action="{{route('login')}}">
                @csrf

                <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control" placeholder="Email" type="email" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" placeholder="Password" type="password" name="password" required
                            autocomplete="current-password">
                    </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input name="remember" class="custom-control-input" id=" remember" type="checkbox"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for=" customCheckLogin">
                        <span class="text-muted">Recuerdame</span>
                    </label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary my-4">Loguearse</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <a href="{{route('password.request')}}" class="text-light"><small>Olvidaste tu clave?</small></a>
        </div>
        <div class="col-6 text-right">
            <a href="{{route('register')}}" class="text-light"><small>Crear cuenta nueva</small></a>
        </div>
    </div>
</div>
</div>
</div>

@endsection