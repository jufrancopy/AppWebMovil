$(document).ready(function () {
    function drawDiente(svg, parentGroup, diente) {
        if (!diente) throw new Error("Error no se ha especificado el diente.");

        var x = diente.x || 0,
            y = diente.y || 0;

        var defaultPolygon = {
            fill: "white",
            stroke: "navy",
            strokeWidth: 0.5,
        };
        var dienteGroup = createSVGElement("g", {
            transform: "translate(" + x + "," + y + ")",
        });
        $(parentGroup).append(dienteGroup);

        var caraSuperior = createPolygon(
            dienteGroup,
            [
                [0, 0],
                [20, 0],
                [15, 5],
                [5, 5],
            ],
            defaultPolygon
        );
        $(caraSuperior).data("cara", "S");


        var caraInferior = createPolygon(
            dienteGroup,
            [
                [5, 15],
                [15, 15],
                [20, 20],
                [0, 20],
            ],
            defaultPolygon
        );
        $(caraInferior).data("cara", "I");

        var caraDerecha = createPolygon(
            dienteGroup,
            [
                [15, 5],
                [20, 0],
                [20, 20],
                [15, 15],
            ],
            defaultPolygon
        );
        $(caraDerecha).data("cara", "D");

        var caraIzquierda = createPolygon(
            dienteGroup,
            [
                [0, 0],
                [5, 5],
                [5, 15],
                [0, 20],
            ],
            defaultPolygon
        );
        $(caraIzquierda).data("cara", "Z");

        var caraCentral = createPolygon(
            dienteGroup,
            [
                [5, 5],
                [15, 5],
                [15, 15],
                [5, 15],
            ],
            defaultPolygon
        );
        $(caraCentral).data("cara", "C");

        var caraCompleto = createText(
            dienteGroup,
            6,
            30,
            diente.id.toString(),
            {
                fill: "navy",
                stroke: "navy",
                strokeWidth: 0.1,
                style: "font-size: 6pt;font-weight:normal",
            }
        );
        $(caraCompleto).data("cara", "X");

        //Busco los tratamientos aplicados al diente
        var tratamientosAplicadosAlDiente = $.grep(vm.tratamientosAplicados(), function (t) {
            var dienteId = t.diente().id;
            if (!dienteId) {
                return false; // Si el tratamiento no tiene diente o diente.id, lo ignoramos
            }
            return diente.id === dienteId; // Comparación correcta de IDs de diente
        });

        var caras = [];
        caras["S"] = caraSuperior;
        caras["C"] = caraCentral;
        caras["X"] = caraCompleto;
        caras["Z"] = caraIzquierda;
        caras["D"] = caraDerecha;

        $.each(tratamientosAplicadosAlDiente, function (index, t) {
            if (caras[t.cara()]) {
                $(caras[t.cara()]).attr("fill", "red");
            } else {
                console.log("Cara no encontrada para el tratamiento:", t);
            }
        });
        [
            caraCentral,
            caraIzquierda,
            caraDerecha,
            caraInferior,
            caraSuperior,
            caraCompleto,
        ].forEach(function (value) {
            $(value).on("click", function () {
                var me = this;
                var cara = $(me).data("cara");

                if (!vm.tratamientoSeleccionado) {
                    alert("Debe seleccionar un tratamiento previamente.");
                    return false;
                }
                //Validamos el tratamiento
                var tratamiento = vm.tratamientoSeleccionado();

                if (cara == "X" && !tratamiento.aplicaDiente) {
                    alert(
                        "El tratamiento seleccionado no se puede aplicar a toda la pieza.",
                    );
                    return false;
                }
                if (cara != "X" && !tratamiento.aplicaCara) {
                    alert(
                        "El tratamiento seleccionado no se puede aplicar a una cara."
                    );
                    return false;
                }

                //TODO: Validaciones de si la cara tiene tratamiento o no, etc...
                vm.tratamientosAplicados.push({
                    diente: ko.observable(diente),
                    cara: ko.observable(cara),
                    tratamiento: ko.observable(tratamiento),
                });

                vm.tratamientoSeleccionado(null);

                //Actualizo el SVG
                renderSvg();
            });

            $(value).on("mouseenter", function () {
                var me = this;
                $(me).data("oldFill", $(me).attr("fill"));
                $(me).attr("fill", "yellow");
            });

            $(value).on("mouseleave", function () {
                var me = this;
                $(me).attr("fill", $(me).data("oldFill"));
            });
        });
    }

    function renderSvg() {
        var svg = $("#odontograma")[0];
        svg.innerHTML = "";
        var parentGroup = createSVGElement("g", {
            transform: "scale(1.5)",
        });
        $(svg).append(parentGroup);
        var dientes = vm.dientes;
        dientes.forEach(function (diente) {
            drawDiente(svg, parentGroup, diente);
        });
    }

    function createSVGElement(tag, attributes) {
        var element = document.createElementNS(
            "http://www.w3.org/2000/svg",
            tag
        );
        for (var attribute in attributes) {
            element.setAttribute(attribute, attributes[attribute]);
        }
        return element;
    }

    function createPolygon(parent, points, attributes) {
        var polygon = createSVGElement("polygon", attributes);
        var pointsString = points
            .map(function (point) {
                return point.join(",");
            })
            .join(" ");
        $(polygon).attr("points", pointsString);
        $(parent).append(polygon);
        return polygon;
    }

    function createText(parent, x, y, content, attributes) {
        var text = createSVGElement("text", attributes);
        $(text).attr("x", x);
        $(text).attr("y", y);
        text.textContent = content;
        $(parent).append(text);
        return text;
    }

    //View Models
    function DienteModel(id, x, y) {
        this.id = id;
        this.x = x;
        this.y = y;
    }

    function ViewModel() {
        var self = this; // Guardamos una referencia a "this" para usarla en el ámbito interno de ViewModel

        self.tratamientosPosibles = ko.observableArray([]);
        self.tratamientoSeleccionado = ko.observable(null);
        self.tratamientosAplicados = ko.observableArray([]); // Ahora tratamientosAplicados es un observable array

        self.quitarTratamiento = function (tratamiento) {
            self.tratamientosAplicados.remove(tratamiento); // Utilizamos el método remove de ko.observableArray
            renderSvg();
        };

        // Función para cargar los tratamientos desde el archivo JSON
        self.cargarTratamientos = function () {
            $.getJSON("/data/tratamientos.js", function (data) {
                self.tratamientosPosibles(data);
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Error al cargar tratamientos: " + err);
            });
        };

        // Llamar a la función para cargar tratamientos al inicializar el ViewModel
        self.cargarTratamientos();

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

        self.dientes = dientes;
    }


    var vm = new ViewModel();
    ko.applyBindings(vm);

    //Inicializo SVG
    var svgElement = $("#odontograma")[0];
    svgElement.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svgElement.setAttribute("width", "620px");
    svgElement.setAttribute("height", "250px");

    //Cargo el estado del odontograma
    renderSvg();
});
