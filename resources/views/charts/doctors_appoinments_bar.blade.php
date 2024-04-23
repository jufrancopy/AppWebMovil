@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Reporte: Citas por Médico</h3>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div class="card-body">
            </div>
        </div>
        <div class="card-body">
            <div class="input-daterange datepicker row align-items-center" data-date-format="dd-mm-yyyy">
                <div class="col">
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="ni ni-calendar-grid-58"></i>
                                </div>
                                <input type="text" class="form-control" placeholder="Fecha Fin"
                                    value='{{ $end }}' id="startDate">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="ni ni-calendar-grid-58"></i>
                                </div>
                                <input type="text" class="form-control" placeholder="Fecha Inicio"
                                    value='{{ $start }}' id="endDate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="container">

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('js/charts/doctors.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection