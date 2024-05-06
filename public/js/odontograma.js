function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, "g"), replace);
}

function createOdontogram() {
    var htmlLecheLeft = "",
        htmlLecheRight = "",
        htmlLeft = "",
        htmlRight = "",
        a = 1;
    for (var i = 9 - 1; i >= 1; i--) {
        //Dientes Definitivos Cuandrante Derecho (Superior/Inferior)
        htmlRight +=
            '<div data-name="value" id="dienteindex' +
            i +
            '" class="diente">' +
            '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' +
            i +
            "</span>" +
            '<div id="tindex' +
            i +
            '" class="cuadro click tderecho">' +
            "</div>" +
            '<div id="lindex' +
            i +
            '" class="cuadro izquierdo click">' +
            "</div>" +
            '<div id="bindex' +
            i +
            '" class="cuadro debajo click bderecho">' +
            "</div>" +
            '<div id="rindex' +
            i +
            '" class="cuadro derecha click click">' +
            "</div>" +
            '<div id="cindex' +
            i +
            '" class="centro click">' +
            "</div>" +
            "</div>";
        //Dientes Definitivos Cuandrante Izquierdo (Superior/Inferior)
        htmlLeft +=
            '<div id="dienteindex' +
            a +
            '" class="diente">' +
            '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' +
            a +
            "</span>" +
            '<div id="tindex' +
            a +
            '" class="cuadro click tizquierdo">' +
            "</div>" +
            '<div id="lindex' +
            a +
            '" class="cuadro izquierdo click">' +
            "</div>" +
            '<div id="bindex' +
            a +
            '" class="cuadro debajo click bizquierdo">' +
            "</div>" +
            '<div id="rindex' +
            a +
            '" class="cuadro derecha click click">' +
            "</div>" +
            '<div id="cindex' +
            a +
            '" class="centro click">' +
            "</div>" +
            "</div>";
        if (i <= 5) {
            //Dientes Temporales Cuandrante Derecho (Superior/Inferior)
            htmlLecheRight +=
                '<div id="dienteLindex' +
                i +
                '" style="left: -25%;" class="diente-leche">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' +
                i +
                "</span>" +
                '<div id="tlecheindex' +
                i +
                '" class="cuadro-leche top-leche click">' +
                "</div>" +
                '<div id="llecheindex' +
                i +
                '" class="cuadro-leche izquierdo-leche click">' +
                "</div>" +
                '<div id="blecheindex' +
                i +
                '" class="cuadro-leche debajo-leche click">' +
                "</div>" +
                '<div id="rlecheindex' +
                i +
                '" class="cuadro-leche derecha-leche click click">' +
                "</div>" +
                '<div id="clecheindex' +
                i +
                '" class="centro-leche click">' +
                "</div>" +
                "</div>";
        }
        if (a < 6) {
            //Dientes Temporales Cuandrante Izquierdo (Superior/Inferior)
            htmlLecheLeft +=
                '<div id="dienteLindex' +
                a +
                '" class="diente-leche">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' +
                a +
                "</span>" +
                '<div id="tlecheindex' +
                a +
                '" class="cuadro-leche top-leche click">' +
                "</div>" +
                '<div id="llecheindex' +
                a +
                '" class="cuadro-leche izquierdo-leche click">' +
                "</div>" +
                '<div id="blecheindex' +
                a +
                '" class="cuadro-leche debajo-leche click">' +
                "</div>" +
                '<div id="rlecheindex' +
                a +
                '" class="cuadro-leche derecha-leche click click">' +
                "</div>" +
                '<div id="clecheindex' +
                a +
                '" class="centro-leche click">' +
                "</div>" +
                "</div>";
        }
        a++;
    }
    $("#tr").append(replaceAll("index", "1", htmlRight));
    $("#tl").append(replaceAll("index", "2", htmlLeft));
    $("#tlr").append(replaceAll("index", "5", htmlLecheRight));
    $("#tll").append(replaceAll("index", "6", htmlLecheLeft));

    $("#bl").append(replaceAll("index", "3", htmlLeft));
    $("#br").append(replaceAll("index", "4", htmlRight));
    $("#bll").append(replaceAll("index", "7", htmlLecheLeft));
    $("#blr").append(replaceAll("index", "8", htmlLecheRight));
}
var arrayPuente = [];
$(document).ready(function () {
    createOdontogram();

    $(document).on("click", ".click", function () {
        var control = $("#options").val();

        var dienteID = $(this).closest('.diente, .diente-leche').attr('id');
        var lado = $(this).attr("id");

        $(this).removeClass("click-red click-blue");

        switch (control) {
            case "fractura":
                $(this).addClass("click-red");
                guardarInformacion(dienteID, lado, "fractura");
                break;

            case "restauracion":
                $(this).addClass("click-blue");
                guardarInformacion(dienteID, lado, "restauracion");
                break;

            case "extraccion":
                var dienteSeleccionado = $(this).closest(
                    ".diente, .diente-leche"
                );
                guardarInformacion(dienteID, 'all', "extraccion");
                dienteSeleccionado.find(".click").addClass("click-delete");
                break;

            case "extraer":
                guardarInformacion(dienteID, 'all', "extraer");
                var dienteSeleccionado = $(this).closest(
                    ".diente, .diente-leche"
                ); // Selecciona tanto dientes permanentes como temporales
                var crossHtml =
                    '<i style="color:red; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);" class="fa fa-times fa-3x fa-fw'; // Clase base de la cruz
                if (dienteSeleccionado.hasClass("diente-leche")) {
                    // Agrega una clase adicional si es un diente temporal
                    crossHtml += " cruz-temporal";
                }
                crossHtml += '"></i>'; // Cierre de la etiqueta <i>
                dienteSeleccionado
                    .find(".centro, .centro-leche")
                    .append(crossHtml); // Selecciona tanto centro de dientes permanentes como temporales
                break;

            case "puente":
                var dientePosition = $(this).offset(), leftPX;
                var noDiente = $(this).parent().children().first().text();
                var cuadrante = $(this).parent().parent().attr("id");
                var left = 0,
                    width = 0;

                $(this).parent().children(".cuadro").css("border-color", "red");
                arrayPuente.push({
                    diente: noDiente,
                    cuadrante: cuadrante,
                    left: $(this)[0].offsetLeft,
                    father: null,
                });

                var diferencia = Math.abs(
                    parseInt(arrayPuente[1].diente) -
                    parseInt(arrayPuente[1].father)
                );
                if (diferencia == 1) width = diferencia * 60;
                else width = diferencia * 50;

                if (arrayPuente[0].cuadrante == arrayPuente[1].cuadrante) {
                    if (
                        arrayPuente[0].cuadrante == "tr" ||
                        arrayPuente[0].cuadrante == "tlr" ||
                        arrayPuente[0].cuadrante == "br" ||
                        arrayPuente[0].cuadrante == "blr"
                    ) {
                        if (arrayPuente[0].diente > arrayPuente[1].diente) {
                            leftPX = parseInt(arrayPuente[0].left) + 10 + "px";
                        } else {
                            leftPX = parseInt(arrayPuente[1].left) + 10 + "px";
                        }
                    } else {
                        if (arrayPuente[0].diente < arrayPuente[1].diente) {
                            leftPX = "-45px";
                        } else {
                            leftPX = "45px";
                        }
                    }
                }

                $(this)
                    .parent()
                    .append(
                        '<div style="z-index: 9999; height: 5px; width:' +
                        width +
                        'px;" id="puente" class="click-red"></div>'
                    );
                $(this).parent().children().last().css({
                    position: "absolute",
                    top: "80px",
                    left: leftPX,
                });
                break;
            default:
                console.log("borrar case");
        }
        return false;
    });
    return false;
});

function guardarInformacion(idDiente, lado, accion) {

    // Por ejemplo, podrías enviar estos datos al servidor utilizando AJAX
    // $.post("/guardar-informacion", { idDiente: idDiente, lado: lado, accion: accion });
}
