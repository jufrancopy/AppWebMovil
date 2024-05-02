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

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Abrir Modal
            </button> --}}

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function drawDiente(svg, parentGroup, diente) {
                if (!diente) throw new Error('Error no se ha especificado el diente.');

                var x = diente.x || 0,
                    y = diente.y || 0;

                var defaultPolygon = {
                    fill: 'white',
                    stroke: 'navy',
                    strokeWidth: 0.5
                };
                var dienteGroup = createSVGElement('g', {
                    transform: 'translate(' + x + ',' + y + ')'
                });
                parentGroup.appendChild(dienteGroup);

                var caraSuperior = createPolygon(dienteGroup,
                    [
                        [0, 0],
                        [20, 0],
                        [15, 5],
                        [5, 5]
                    ],
                    defaultPolygon);
                caraSuperior.dataset.cara = 'S';

                var caraInferior = createPolygon(dienteGroup,
                    [
                        [5, 15],
                        [15, 15],
                        [20, 20],
                        [0, 20]
                    ],
                    defaultPolygon);
                caraInferior.dataset.cara = 'I';

                var caraDerecha = createPolygon(dienteGroup,
                    [
                        [15, 5],
                        [20, 0],
                        [20, 20],
                        [15, 15]
                    ],
                    defaultPolygon);
                caraDerecha.dataset.cara = 'D';

                var caraIzquierda = createPolygon(dienteGroup,
                    [
                        [0, 0],
                        [5, 5],
                        [5, 15],
                        [0, 20]
                    ],
                    defaultPolygon);
                caraIzquierda.dataset.cara = 'Z';

                var caraCentral = createPolygon(dienteGroup,
                    [
                        [5, 5],
                        [15, 5],
                        [15, 15],
                        [5, 15]
                    ],
                    defaultPolygon);
                caraCentral.dataset.cara = 'C';

                var caraCompleto = createText(dienteGroup, 6, 30, diente.id.toString(), {
                    fill: 'navy',
                    stroke: 'navy',
                    strokeWidth: 0.1,
                    style: 'font-size: 6pt;font-weight:normal'
                });
                caraCompleto.dataset.cara = 'X';

                //Busco los tratamientos aplicados al diente
                var tratamientosAplicadosAlDiente = vm.tratamientosAplicados.filter(function(t) {
                    return t.diente.id == diente.id;
                });
                var caras = [];
                caras['S'] = caraSuperior;
                caras['C'] = caraCentral;
                caras['X'] = caraCompleto;
                caras['Z'] = caraIzquierda;
                caras['D'] = caraDerecha;

                tratamientosAplicadosAlDiente.forEach(function(t) {
                    caras[t.cara].setAttribute('fill', 'red');
                });

                [caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto].forEach(
                    function(value) {
                        value.addEventListener('click', function() {
                            var me = this;
                            var cara = me.dataset.cara;

                            if (!vm.tratamientoSeleccionado) {
                                alert('Debe seleccionar un tratamiento previamente.');
                                return false;
                            }

                            //Validaciones
                            //Validamos el tratamiento
                            var tratamiento = vm.tratamientoSeleccionado;

                            if (cara == 'X' && !tratamiento.aplicaDiente) {
                                alert(
                                    'El tratamiento seleccionado no se puede aplicar a toda la pieza.');
                                return false;
                            }
                            if (cara != 'X' && !tratamiento.aplicaCara) {
                                alert('El tratamiento seleccionado no se puede aplicar a una cara.');
                                return false;
                            }
                            //TODO: Validaciones de si la cara tiene tratamiento o no, etc...

                            vm.tratamientosAplicados.push({
                                diente: diente,
                                cara: cara,
                                tratamiento: tratamiento
                            });
                            vm.tratamientoSeleccionado = null;

                            //Actualizo el SVG
                            renderSvg();
                        });

                        value.addEventListener('mouseenter', function() {
                            var me = this;
                            me.dataset.oldFill = me.getAttribute('fill');
                            me.setAttribute('fill', 'yellow');
                        });

                        value.addEventListener('mouseleave', function() {
                            var me = this;
                            me.setAttribute('fill', me.dataset.oldFill);
                        });
                    });
            }

            function renderSvg() {
                console.log('update render');

                var svg = document.getElementById('odontograma');
                svg.innerHTML = '';
                var parentGroup = createSVGElement('g', {
                    transform: 'scale(1.5)'
                });
                svg.appendChild(parentGroup);
                var dientes = vm.dientes;
                dientes.forEach(function(diente) {
                    drawDiente(svg, parentGroup, diente);
                });
            }

            function createSVGElement(tag, attributes) {
                var element = document.createElementNS('http://www.w3.org/2000/svg', tag);
                for (var attribute in attributes) {
                    element.setAttribute(attribute, attributes[attribute]);
                }
                return element;
            }

            function createPolygon(parent, points, attributes) {
                var polygon = createSVGElement('polygon', attributes);
                var pointsString = points.map(function(point) {
                    return point.join(',');
                }).join(' ');
                polygon.setAttribute('points', pointsString);
                parent.appendChild(polygon);
                return polygon;
            }

            function createText(parent, x, y, content, attributes) {
                var text = createSVGElement('text', attributes);
                text.setAttribute('x', x);
                text.setAttribute('y', y);
                text.textContent = content;
                parent.appendChild(text);
                return text;
            }

            //View Models
            function DienteModel(id, x, y) {
                this.id = id;
                this.x = x;
                this.y = y;
            }

            function ViewModel() {
                this.tratamientosPosibles = [];
                this.tratamientoSeleccionado = null;
                this.tratamientosAplicados = [];

                this.quitarTratamiento = function(tratamiento) {
                    this.tratamientosAplicados.splice(this.tratamientosAplicados.indexOf(tratamiento), 1);
                    renderSvg();
                }

                //Cargo los dientes
                var dientes = [];
                //Dientes izquierdos
                for (var i = 0; i < 8; i++) {
                    dientes.push(new DienteModel(18 - i, i * 25, 0));
                }
                for (var i = 3; i < 8; i++) {
                    dientes.push(new DienteModel(55 - i, i * 25, 1 * 40));
                }
                for (var i = 3; i < 8; i++) {
                    dientes.push(new DienteModel(85 - i, i * 25, 2 * 40));
                }
                for (var i = 0; i < 8; i++) {
                    dientes.push(new DienteModel(48 - i, i * 25, 3 * 40));
                }
                //Dientes derechos
                for (var i = 0; i < 8; i++) {
                    dientes.push(new DienteModel(21 + i, i * 25 + 210, 0));
                }
                for (var i = 0; i < 5; i++) {
                    dientes.push(new DienteModel(61 + i, i * 25 + 210, 1 * 40));
                }
                for (var i = 0; i < 5; i++) {
                    dientes.push(new DienteModel(71 + i, i * 25 + 210, 2 * 40));
                }
                for (var i = 0; i < 8; i++) {
                    dientes.push(new DienteModel(31 + i, i * 25 + 210, 3 * 40));
                }

                this.dientes = dientes;
            }

            var vm = new ViewModel();

            //Inicializo SVG
            var svgElement = document.getElementById('odontograma');
            svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            svgElement.setAttribute('width', '620px');
            svgElement.setAttribute('height', '250px');

            //Cargo el estado del odontograma
            renderSvg();

            //Cargo los tratamientos (código de carga de tratamientos)
        });
    </script>
@stop
