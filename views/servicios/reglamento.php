<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGLAMENTO INTERNO </title>
    <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/jquery-confirm.css">
    <script src="../../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../../assets/js/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../../assets/css/jquery-ui/jquery-ui.min.css">
    <script src="../../assets/js/jquery-ui.min.js"></script>
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>


    <style>
    .deneterScroll {
        overflow: hidden !important;
        height: '100%' !important;
    }

    .restoreScroll {
        overflow: auto !important;
        height: 'auto' !important;
    }
    </style>
    <script>
    let firmado = 0;
    let __url__ = localStorage.getItem("_URL_");

    $(document).ready(function() {
        // VALIDA SI HAY ID DE ENTRADA
        if (!getUrlParameter('entrada')) {
            alert("No hay datos de entrada, favor de validar");
            $("#btnGuardar").hide();
        }
        iniciaCanvas();

        document.getElementById("canvas").onwheel = function(event) {
            console.log("onwheel");
            event.preventDefault();
        };

        document.getElementById("canvas").mousemove = function(event) {
            console.log("touchmove");
            event.preventDefault();
        };

        $("#btnGuardar").click(function() {
            if (firmado == 0) {
                alert("Favor de firmar de conformidad");
            } else {
                guardarFirma();
            }

        });
    });

    function iniciaCanvas() {
        let limpiar = document.getElementById("limpiar");
        let canvas = document.getElementById("canvas");
        let ctx = canvas.getContext("2d");
        let cw = canvas.width = 250,
            cx = cw / 2;
        let ch = canvas.height = 250,
            cy = ch / 2;

        let dibujar = false;
        let factorDeAlisamiento = 5;
        let Trazados = [];
        let puntos = [];
        ctx.lineJoin = "round";

        function iniciarTrazado(evt) {
            $("html, body").addClass("deneterScroll");
            $("html, body").removeClass("restoreScroll");
            dibujar = true;
            //ctx.clearRect(0, 0, cw, ch);
            puntos.length = 0;
            ctx.beginPath();

        }

        function trazar(evt) {
            if (dibujar) {
                let m = oMousePos(canvas, evt);
                puntos.push(m);
                ctx.lineTo(m.x, m.y);
                ctx.stroke();
            }
        }

        canvas.addEventListener("wheel mousewheel mousemove", function(e) {
            console.log("wheel mousewheel mousemove");
            e.preventDefault()
        });

        canvas.addEventListener('mousedown', iniciarTrazado, false);
        canvas.addEventListener('touchstart', event => iniciarTrazado(event.touches[0]), false);

        canvas.addEventListener('mouseup', redibujarTrazados, false);
        canvas.addEventListener('touchend', event => redibujarTrazados(event.touches[0]), false);

        canvas.addEventListener("mouseout", redibujarTrazados, false);

        canvas.addEventListener("mousemove", trazar, false);
        canvas.addEventListener("touchmove", event => trazar(event.touches[0]), true);


        function reducirArray(n, elArray) {
            let nuevoArray = [];
            nuevoArray[0] = elArray[0];
            for (let i = 0; i < elArray.length; i++) {
                if (i % n == 0) {
                    nuevoArray[nuevoArray.length] = elArray[i];
                }
            }
            nuevoArray[nuevoArray.length - 1] = elArray[elArray.length - 1];
            Trazados.push(nuevoArray);
        }

        function calcularPuntoDeControl(ry, a, b) {
            let pc = {}
            pc.x = (ry[a].x + ry[b].x) / 2;
            pc.y = (ry[a].y + ry[b].y) / 2;
            return pc;
        }

        function alisarTrazado(ry) {
            if (ry.length > 1) {
                let ultimoPunto = ry.length - 1;
                ctx.beginPath();
                ctx.moveTo(ry[0].x, ry[0].y);
                for (let i = 1; i < ry.length - 2; i++) {
                    let pc = calcularPuntoDeControl(ry, i, i + 1);
                    ctx.quadraticCurveTo(ry[i].x, ry[i].y, pc.x, pc.y);
                }
                ctx.quadraticCurveTo(ry[ultimoPunto - 1].x, ry[ultimoPunto - 1].y, ry[ultimoPunto].x, ry[ultimoPunto].y);
                ctx.stroke();
            }
        }

        function redibujarTrazados() {
            dibujar = false;
            ctx.clearRect(0, 0, cw, ch);
            reducirArray(factorDeAlisamiento, puntos);
            for (let i = 0; i < Trazados.length; i++)
                alisarTrazado(Trazados[i]);


            $("html, body").removeClass("deneterScroll");
            $("html, body").addClass("restoreScroll");
            firmado = 1;
        }

        function oMousePos(canvas, evt) {
            let ClientRect = canvas.getBoundingClientRect();
            return { //objeto
                x: Math.round(evt.clientX - ClientRect.left),
                y: Math.round(evt.clientY - ClientRect.top)
            }
        }

    }
    /* Enviar el trazado */
    function getTrazado() {
        return document.getElementById('canvas').toDataURL('image/png');
        //document.forms['incineracionForm'].submit();
    }

    function guardarFirma() {
        $.ajax({
            // data: $("#formEnviarAlmacen").serialize(),
            data: {
                entrada_id: getUrlParameter('entrada'),
                firma: getTrazado(),


            },
            url: __url__ + "?ajax&controller=Servicios&action=guardarFirmaEntrada",
            type: "POST",
            dataType: "json",
            success: function(r) {
                console.log("respuesta");
                console.log(r);
                if (r.error == false) {
                    alert(r.mensaje);
                    setTimeout(() => {
                        console.log("se cierra");
                        window.close();
                    }, 3000);
                } else {
                    alert("Error: ", r.mensaje);
                }

            },
            error: function(r) {
                console.log(r);
                alert("Algo salio mal", r);
                // mensajeError("Algo salio mal,  contacte al administrador.");
            },
        });
    }

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };
    </script>
</head>

<body>
    <div class="container" id="container" style="width:90% !important">
        <div class='row'>
            <div class='col-12'>
                <h4 style="text-align: center;">REGLAMENTO INTERNO PARA OPERADORES DE TRANSPORTE</h4>
            </div>
            <div class='row' style="text-align: center;">
                <div class='col'>
                    <p>
                        1. LLEVAR PUESTA ROPA APROPIADA DENTRO DE LA TERMINAL: PANTALONES LARGOS, CAMISA MANGA LARGA EN INVIERNO Y CORTA EN VERANO. MAS, SU EQUIPO PROTECTIVO DE SEGURIDAD.
                    </p>
                    <p>
                        2. EL OPERADOR DE TRANSPORTE PODRÁ INGRESAR A LA PLANTA PARA CARGA DE ACEITE AL ÁREA DE ANDENES Y DEBERÁ REGRESAR AL ÁREA DE DESCANSO HASTA QUE LE LLAMEN PARA QUE RECOJA SU PEDIDO.
                    </p>
                    <p>
                        3. PROHIBIDO INGRESAR A LA PLANTA CON TELÉFONOS CELULARES, CÁMARAS FOTOGRÁFICAS O DE VIDEO. ESTOS EQUIPOS, SE DEBERÁN ENTREGAR AL ÁREA DE VIGILANCIA, LOS CUALES SE LOS DEVOLVERÁN AL SALIR.
                    </p>
                    <p>
                        4. PROHIBIDO INTRODUCIR BEBIDAS ALCOHÓLICAS, ARMA DE FUEGO O CUALQUIER OBJETO QUE PONGA EN RIESGO LA INTEGRIDAD DE LAS PERSONAS.
                    </p>
                    <p>
                        5. NO SE PERMITE EL ACCESO A LA PLANTA A LOS OPERADORES TRANSPORTISTAS QUE SE PRESENTEN EN ESTADO INCONVENIENTE.
                    </p>
                    <p>
                        6. PODRÁ PERMANECER EL CHOFER EN EL ÁREA DE CARGA SIEMPRE Y CUANDO EL MISMO REQUIERA REALIZAR MANIOBRAS CON PRODUCTOS PLÁSTICOS (POLIETILENO Y/O POLIURETANO), DE LO CONTRARIO DEBERÁ REGRESAR
                        AL
                        ÁREA
                        DE DESCANSO HASTA QUE SE HAYA CONCLUIDO LA CARGA DE SU PEDIDO.
                    </p>
                    <p>
                        7. SEGUIR PUNTUALMENTE LAS INDICACIONES DEL PERSONAL DE VIGILANCIA, OPERADORES DE BÁSCULA Y DE CARGA DURANTE SU PERMANENCIA EN EL INTERIOR DE LA PLANTA.
                    </p>
                    <p>
                        8. RESPETAR LOS SEÑALAMIENTOS Y ADVERTENCIAS EN EL INTERIOR DE LA TERMINAL.
                    </p>
                    <p>
                        9. PROHIBIDO TIRAR BASURA, SI TOMAN ALGÚN ALIMENTO, LA BASURA QUE SE GENERE DEBERÁN DEPOSITARLA EN LOS TAMBOS, TAMBIÉN SE PROHÍBE FUMAR O ENCENDER CERILLOS EN EL INTERIOR DE LA PLANTA.
                    </p>
                    <p>
                        10. ESTÁ PROHIBIDO PLATICAR CON EL PERSONAL OPERARIO DE LA PLANTA SALVO SI ESTÁ RELACIONADO A LA CARGA Y/O DESCARGA. (DOCUMENTACIÓN, CONDICIONES DE LA UNIDAD, SELLOS DE TOMAS, TAPAS, ETC.).
                    </p>
                    <p>
                        11. AL TERMINAR LA CARGA DEL CHOFER DEBERÁ REALIZAR INSPECCIÓN VISUAL A LAS CONDICIONES GENERALES DE LA UNIDAD Y SUS ALREDEDORES PONIENDO ATENCIÓN A FUGAS, DERRAMES O CUALQUIER PELIGRO QUE
                        NOTE EN
                        EL
                        ÁREA DE CARGA, SI EL CHOFER ENCUENTRA ALGÚN PROBLEMA AL RESPECTO DEBERÁ AVISAR INMEDIATAMENTE AL OPERARIO ENCARGADO, (LA UNIDAD NO SE DEBERÁ PONER EN MOVIMIENTO HASTA QUE SE RESUELVA EL
                        PROBLEMA).
                    </p>
                    <p>
                        12. CUALQUIER INCUMPLIMIENTO A LO SEÑALADO EN EL PRESENTE REGLAMENTO POR PARTE DEL OPERADOR, SERÁ REPORTADO A LA LÍNEA TRANSPORTISTA PARA QUE ESTA DE UNA SOLUCIÓN AL PROBLEMA.
                    </p>
                    <p>
                        13. FINALMENTE, SI EL OPERADOR DEL TRANSPORTE HACE CASO OMISO A LO QUE AQUÍ SE COMENTA E INCURRA EN HECHOS REPETITIVOS CAUSANDO PROBLEMAS GRAVES EN PERJUICIO DE LA EMPRESA, ESTE OPERADOR SERÁ
                        VETADO
                        PARA INGRESAR A LA PLANTA.
                    </p>

                </div>
            </div>
            <div class='row' style="text-align: center;">
                <div class='col-11'>
                    <h3>Firma de conformidad</h3>
                </div>
                <div class='col-11'>
                    <canvas id="canvas">Su navegador no soporta canvas :( </canvas>
                </div>
                <div class='col-11' style="text-align:center;">
                    <input type="button" value="Guardar" id="btnGuardar" class="btn btn-info">
                </div>
            </div>
            <br />

        </div>
    </div>


</body>
<script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>

</html>