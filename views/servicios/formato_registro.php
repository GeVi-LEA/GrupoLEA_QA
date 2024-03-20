<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= root_url ?>assets/libs/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">

    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>views/servicios/assets/css/servicios.css" type="text/css" />

    <!-- Select2 -->
    <link href="<?= root_url ?>assets/libs/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?= root_url ?>assets/libs/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= root_url ?>assets/js/sweetalert/sweetalert2.all.min.css">

    <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= root_url ?>assets/libs/bootstrap5/js/bootstrap.min.js"></script>
    <script src="<?= root_url ?>assets/libs/select2/js/select2.full.min.js"></script>

    <!-- Toastr -->
    <link href="<?= root_url ?>assets/libs/toastr/toastr.min.css" rel="stylesheet">
    <script src="<?= root_url ?>assets/libs/toastr/toastr.min.js"></script>

    <script src="<?= root_url ?>assets/js/sweetalert/sweetalert2.all.min.js"></script>
    <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>



    <title>Formato Entrada</title>

    <style>
    .caja {
        width: 90% !important;
        height: 90%;
        /* border: 1px solid black; */
        margin: auto;
        /* border-radius: 10px; */
        margin-top: 1%;
        padding: 10px;
    }

    .titulo {
        text-align: center;
        vertical-align: middle !important;
        margin: auto;
        font-size: xx-large;
    }

    .seccion {
        border: 1px solid #c3c3c3;
        margin: auto;
        border-radius: 10px;
        padding: 10px;
    }

    .seccion td {
        margin: auto;
        padding: 10px;
    }

    .center {
        text-align: center;

    }

    /* .twocol { */
    /* column-count: 2; */
    /* column-gap: 20px; */
    /* font-size: 0.5rem; */
    /* } */

    body {
        /* width: 900px; */
        /* height: 1200px; */
        /* font-size: 0.4rem; */
    }

    .keep-together {
        page-break-inside: avoid;
    }

    .contenedor {
        /* width: 90% !important; */
    }

    .nombrefirma {
        font-size: 0.8rem !important;
    }

    .twocol {
        column-count: 2 !important;
        column-gap: 15px !important;
        font-size: 0.5rem !important;
    }

    .imgfirma {
        width: 200px;
        margin-bottom: -50px;
    }

    @media screen and (max-width: 900px) {

        h4 {
            font-size: 0.8rem !important;
        }

        .twocol {
            column-count: 2 !important;
            column-gap: 10% !important;
            font-size: 0.3rem !important;
        }

        table td {
            font-size: 0.4rem !important;
        }

        .imgfirma {
            width: 100px;
            margin-bottom: -50px;
        }

        .nombrefirma {
            font-size: 0.4rem !important;
        }

        .titulo {
            text-align: center;
            vertical-align: middle !important;
            margin: auto;
            font-size: 1rem !important;
        }

        .fecha {
            font-size: 0.4rem !important;
        }

        .imglogo {
            height: 40px;
        }

    }
    </style>
</head>

<body>
    <!-- <page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm" pagegroup="new"> -->

    <div class='caja contenedor keep-together'>

        <table style="width:100%;">
            <tr>
                <td style="width:20%;"><img class="imglogo" src="<?= root_url ?>assets/images/logo_lea-sm.png" alt="" height="80"></td>
                <td style="width:80%;" class='col-10 titulo'><b>REGISTRO DE UNIDADES</b></td>
            </tr>
        </table>
        <div class='fecha'>
            <div class=''>
                <b>FECHA DE REGISTRO</b>
            </div>
            <div>
                <span><?= $servicios['fecha_entrada'] ?></span>
            </div>
        </div>
        <br />
        <table style="width:100%;">
            <tr>
                <td style="width:40%; padding: 10px;">
                    <div class='seccion'>
                        <table style="width:100%;">
                            <tr class=' center'>
                                <td>
                                    <table>
                                        <tr>
                                            <td> <b>TIPO DE MOVIMIENTO</b></td>
                                            <td> <b>TIPO DE UNIDAD</b></td>
                                        </tr>
                                        <tr>
                                            <td><span><?= ($servicios['entrada_salida'] == '0') ? 'DESCARGA' : 'CARGA' ?></span></td>
                                            <td><span><?= Utils::getTipoTransporte($servicios['tipo_transporte_id'])->nombre ?></span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width:60%; padding: 10px;">
                    <div class='seccion'>
                        <table style="width:100%;">
                            <tr class='row center'>
                                <td>
                                    <table>
                                        <tr>
                                            <td> <b>FOLIO DE LA CARGA</b></td>
                                            <td> <b>CLIENTE</b></td>
                                        </tr>
                                        <tr>
                                            <td><span><?= '' ?></span></td>
                                            <td><span><?= strtoupper($servicios['nombreCliente']) ?></span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <div class='row mt-3 seccion'>
            <div class='col-12'>
                <table style="width:100%">
                    <tr>
                        <td colspan="2">
                            <?php
                                if ($servicios['tipo_transporte_id'] != '12') {
                                    echo '<b>NOMBRE DEL OPERADOR: </b>' . strtoupper(isset(json_decode(Utils::getChofer($servicios['chofer']))->nombre) ? json_decode(Utils::getChofer($servicios['chofer']))->nombre : '...');
                                }
                            ?>
                        </td>

                        <td>
                            <?php
                                if ($servicios['tipo_transporte_id'] != '12') {
                                    echo '<b>LINEA TRANSPORTISTA: </b>' . strtoupper(isset(Utils::getTransportistaCliente($servicios['transportista'])->nombre) ? Utils::getTransportistaCliente($servicios['transportista'])->nombre : '...');
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>PLACAS DE UNIDAD/TRACTOR: </b><?= $servicios['numUnidad'] ?></td>
                        <td> <?= ($servicios['cant_puertas'] > 0) ? '<b>NO. ECONOMICO: </b>' . '' /* $servicios['num_economico'] */ : '' ?></td>
                        <td> <?= ($servicios['cant_puertas'] > 0) ? '<b>NO PUERTAS: </b>' . $servicios['cant_puertas'] : '' ?></td>
                    </tr>
                    <tr style="<?= ($servicios['placa1'] == '') ? 'display:none;' : '' ?>">
                        <td><b>PLACAS DEL TANQUE O CAJA: </b><?= $servicios['placa1'] ?></td>
                        <td><b>NO. ECONOMICO: </b> <?= '' /* $servicios['num_economico'] */ ?></td>
                        <td> <b>CAPACIDAD: </b> <?= Utils::getTipoTransporte($servicios['tipo_transporte_id'])->cap_maxima ?></td>
                    </tr>
                    <tr style="<?= ($servicios['placa2'] == '') ? 'display:none;' : '' ?>">
                        <td><b>PLACAS DEL TANQUE O CAJA: </b><?= $servicios['placa2'] ?></td>
                        <td><b>NO. ECONOMICO: </b> <?= '' /* $servicios['num_economico'] */ ?></td>
                        <td> <b>CAPACIDAD: </b> <?= Utils::getTipoTransporte($servicios['tipo_transporte_id'])->cap_maxima ?></td>
                    </tr>
                    <tr style="<?= ($servicios['observaciones'] == '') ? 'display:none;' : '' ?>">
                        <td colspan="3"><b>OBSERVACIONES: </b><?= $servicios['observaciones'] ?></td>
                    </tr>
                    <tr class="mt-5 center">
                        <!-- <td> </td> -->
                        <td colspan="3" style="width:100%; border-bottom:1px solid black; padding-top:50px;"> </td>
                        <!-- <td> </td> -->
                    </tr>
                    <tr class="center">
                        <td colspan="3"><b>NOMBRE Y FIRMA DEL GUARDIA EN TURNO</b></td>
                    </tr>
                    <tr style="text-align:right; font-size:0.5rem;">
                        <td colspan="3"><b>FO-EM-002 Ver. 1</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class='row mt-3 seccion'>
            <div class='col-12'>
                <div class='row'>
                    <div class='col-12'>
                        <h4 style="text-align: center;">REGLAMENTO INTERNO PARA OPERADORES DE TRANSPORTE</h4>
                    </div>
                    <div class='row' style="text-align: center;">
                        <!-- <div class='col-12 twocol2'> -->
                        <table style="width:100%; text-align: center;">
                            <tr>
                                <td style="width:50%;">
                                    <p>1. LLEVAR PUESTA ROPA APROPIADA DENTRO DE LA TERMINAL: PANTALONES LARGOS, CAMISA MANGA LARGA EN INVIERNO Y CORTA EN VERANO. MAS, SU EQUIPO PROTECTIVO DE SEGURIDAD.</p>
                                    <p>2. EL OPERADOR DE TRANSPORTE PODRÁ INGRESAR A LA PLANTA PARA CARGA DE ACEITE AL ÁREA DE ANDENES Y DEBERÁ REGRESAR AL ÁREA DE DESCANSO HASTA QUE LE LLAMEN PARA QUE RECOJA SU PEDIDO.</p>
                                    <p>3. PROHIBIDO INGRESAR A LA PLANTA CON TELÉFONOS CELULARES, CÁMARAS FOTOGRÁFICAS O DE VIDEO. ESTOS EQUIPOS, SE DEBERÁN ENTREGAR AL ÁREA DE VIGILANCIA, LOS CUALES SE LOS DEVOLVERÁN AL SALIR.</p>
                                    <p>4. PROHIBIDO INTRODUCIR BEBIDAS ALCOHÓLICAS, ARMA DE FUEGO O CUALQUIER OBJETO QUE PONGA EN RIESGO LA INTEGRIDAD DE LAS PERSONAS.</p>
                                    <p>5. NO SE PERMITE EL ACCESO A LA PLANTA A LOS OPERADORES TRANSPORTISTAS QUE SE PRESENTEN EN ESTADO INCONVENIENTE.</p>
                                    <p>6. PODRÁ PERMANECER EL CHOFER EN EL ÁREA DE CARGA SIEMPRE Y CUANDO EL MISMO REQUIERA REALIZAR MANIOBRAS CON PRODUCTOS PLÁSTICOS (POLIETILENO Y/O POLIURETANO), DE LO CONTRARIO DEBERÁ REGRESAR AL ÁREA DE DESCANSO HASTA QUE SE HAYA CONCLUIDO LA CARGA DE SU PEDIDO.</p>
                                    <p>7. SEGUIR PUNTUALMENTE LAS INDICACIONES DEL PERSONAL DE VIGILANCIA, OPERADORES DE BÁSCULA Y DE CARGA DURANTE SU PERMANENCIA EN EL INTERIOR DE LA PLANTA.</p>
                                </td>
                                <td style="width:50%;vertical-align: top;">
                                    <p>8. RESPETAR LOS SEÑALAMIENTOS Y ADVERTENCIAS EN EL INTERIOR DE LA TERMINAL.</p>
                                    <p>9. PROHIBIDO TIRAR BASURA, SI TOMAN ALGÚN ALIMENTO, LA BASURA QUE SE GENERE DEBERÁN DEPOSITARLA EN LOS TAMBOS, TAMBIÉN SE PROHÍBE FUMAR O ENCENDER CERILLOS EN EL INTERIOR DE LA PLANTA.</p>
                                    <p>10. ESTÁ PROHIBIDO PLATICAR CON EL PERSONAL OPERARIO DE LA PLANTA SALVO SI ESTÁ RELACIONADO A LA CARGA Y/O DESCARGA. (DOCUMENTACIÓN, CONDICIONES DE LA UNIDAD, SELLOS DE TOMAS, TAPAS, ETC.).</p>
                                    <p>11. AL TERMINAR LA CARGA DEL CHOFER DEBERÁ REALIZAR INSPECCIÓN VISUAL A LAS CONDICIONES GENERALES DE LA UNIDAD Y SUS ALREDEDORES PONIENDO ATENCIÓN A FUGAS, DERRAMES O CUALQUIER PELIGRO QUE NOTE EN EL ÁREA DE CARGA, SI EL CHOFER ENCUENTRA ALGÚN PROBLEMA AL RESPECTO DEBERÁ
                                        AVISAR INMEDIATAMENTE AL OPERARIO ENCARGADO, (LA UNIDAD NO SE DEBERÁ PONER EN MOVIMIENTO HASTA QUE SE RESUELVA EL PROBLEMA).</p>
                                    <p>12. CUALQUIER INCUMPLIMIENTO A LO SEÑALADO EN EL PRESENTE REGLAMENTO POR PARTE DEL OPERADOR, SERÁ REPORTADO A LA LÍNEA TRANSPORTISTA PARA QUE ESTA DE UNA SOLUCIÓN AL PROBLEMA.</p>
                                    <p>13. FINALMENTE, SI EL OPERADOR DEL TRANSPORTE HACE CASO OMISO A LO QUE AQUÍ SE COMENTA E INCURRA EN HECHOS REPETITIVOS CAUSANDO PROBLEMAS GRAVES EN PERJUICIO DE LA EMPRESA, ESTE OPERADOR SERÁ VETADO PARA INGRESAR A LA PLANTA.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- </div> -->
                    </div>
                    <div class='row' style="text-align: center;">
                        <div class='col-12'>

                        </div>
                        <div class='col-12'>
                            <img class="imgfirma" src="<?= $servicios['firma_entrada'] ?>">
                            <p><?= strtoupper(isset(Utils::getChofer($servicios['chofer'])->nombre) ? Utils::getChofer($servicios['chofer'])->nombre : '...') ?></p>
                            <p class="nombrefirma"><b>Nombre y firma del chofer</b></p>
                        </div>
                    </div>
                </div>
                <br />

            </div>
        </div>

    </div>
    <!-- </page> -->
</body>

</html>