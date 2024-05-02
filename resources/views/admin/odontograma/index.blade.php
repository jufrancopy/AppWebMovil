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
        <div class="card-body">
            <div id="odontograma-container" style="width: 620px; height: 250px;">
                <svg id="odontograma" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>
            <div id="tratamiento">
                <h2>Tratamiento</h2>

                <select
                    data-bind="
                        options: tratamientosPosibles, 
                        optionsText: 'nombre', 
                        optionsValue: function(tratamiento) { return tratamiento; }, 
                        optionsCaption: 'Selecciona un tratamiento',
                        value: tratamientoSeleccionado
                    "
                    class="form-select"></select>


            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal de Ejemplo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¡Este es un modal de ejemplo! Puedes agregar aquí cualquier contenido que desees mostrar en el
                            modal.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Guardar cambios</button>
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
    <script src="{{ asset('js/odontograma.js') }}" defer></script>
@stop
