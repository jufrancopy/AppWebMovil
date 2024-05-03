@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Odontograma</h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div id="controls" class="panel panel-default">
                                <div class="panel-body">
                                    
                                    <select id="options" name="options" class="form-control select2" style="width: 100%;">
                                        <option value="fractura" id="option1" selected>Fractura</option>
                                        <option value="restauracion" id="option2">Obturación</option>
                                        <option value="extraccion" id="option3">Extracción</option>
                                        <option value="extraer" id="option4">A Extraer</option>
                                        <option value="puente" id="option5">Puente</option>
                                        <option value="borrar" id="option6">Borrar</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div id="tr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div id="tl" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div id="tlr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        </div>
                        <div id="tll" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                    </div>
                    <div class="row">
                        <div id="blr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        </div>
                        <div id="bll" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div id="br" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div id="bl" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div style="height: 20px; width:20px; display:inline-block;" class="click-red">
                                            </div>
                                            Fractura/Carie
                                            <br>
                                            <div style="height: 5px; width:20px; display:inline-block;" class="click-red">
                                            </div>
                                            Puente Entre Piezas
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                            <div style="height: 20px; width:20px; display:inline-block;" class="click-blue">
                                            </div>
                                            Obturación
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                                            <span style="display:inline:block;"> Pieza Extraída</span>
                                            <img style="display:inline:block;"
                                                src="{{ asset('img/odontograma/extraccion.png') }}">
                                            <br> Indicada Para Extracción <i style="color:red;"
                                                class="fa fa-times fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('styles')
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#options').select2();
            });
        </script>

    @stop
