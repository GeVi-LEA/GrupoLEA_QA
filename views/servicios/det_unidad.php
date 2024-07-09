<?php

function ROFinaliza($estatus)
{
    if ((($estatus == 5) || ($estatus == 15)) && Utils::isAdmin() == false) {
        echo ' readonly disabled ';
    } else {
        echo '';
    }
}

// include 'assets/js/det_unidad_js.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo URL; ?>assets/libs/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-ui/jquery-ui.min.css">

    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?= root_url ?>views/servicios/assets/css/servicios.css" type="text/css" />


    <!-- Select2 -->
    <link href="<?php echo URL; ?>assets/libs/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>assets/libs/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">


    <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo URL; ?>assets/libs/bootstrap5/js/bootstrap.min.js"></script>
    <script src="<?= root_url ?>assets/libs/select2/js/select2.full.min.js"></script>

    <!-- Toastr -->
    <link href="<?php echo URL; ?>assets/libs/toastr/toastr.min.css" rel="stylesheet">
    <script src="<?php echo URL; ?>assets/libs/toastr/toastr.min.js"></script>

    <link rel="stylesheet" href="<?= root_url ?>assets/js/sweetalert/sweetalert2.all.min.css">
    <script src="<?= root_url ?>assets/js/sweetalert/sweetalert2.all.min.js"></script>


    <!-- <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script> -->
    <script src="<?= root_url ?>views/servicios/assets/js/det_unidad.js?v=1.2.0"></script>



    <title>Detalle de Unidad <?= isset($ensacado) ? $ensacado['numUnidad'] : ''; ?></title>

    <style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        background-color: #cfd7e9;
    }

    .sombra {
        -webkit-box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);
        -moz-box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);
        box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);

        border-radius: 10px !important;
        margin-top: 10px;
        padding: 10px;

    }
    </style>

</head>

<body>
    <div class="contenedor1 h-100" id="contenedor" style="height: 99vh !important; margin-top:1px;padding-right:2%;">
        <div class='row' style="min-height: 95vh;">
            <div class='col-xl-6 col-12 sombra1' id="datos_unidad" style="padding-right: 4%;">
                <form id="ensacadoForm" <?php ROFinaliza($ensacado['estatus_id']) ?> onsubmit="return toSubmit();" enctype="multipart/form-data">
                    <input type="hidden" id="isferrotolva" data-isTren="<?= $isTren ?>" value="<?= $isTren ? 'F' : 'C' ?>" />
                    <input type="hidden" name="serv_pendientes" id="serv_pendientes" value="<?= $ensacado['serv_pendientes'] ?>">
                    <input type="hidden" name="totalensacado" id="totalensacado" value="<?= $ensacado['totalensacado'] ?>">
                    <input type="hidden" name="id" value="<?= isset($ensacado) && $ensacado['id'] != '' ? $ensacado['id'] : ''; ?>" id="id" />
                    <div class='row'>
                        <div class='col-md-2 col-12'>
                            <div>
                                <button class="boton" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button>
                                <!-- <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" /> -->
                            </div>
                        </div>
                        <div class='col-md-8 col-12'>
                            <div class="text-center mt-1" style="margin-bottom:20px;">
                                <h4>DATOS DE LA UNIDAD</h4>
                                <!-- -- BOTONES DE ACCIONES -- -->
                                <div class="btn-group" role="group">
                                    <div><button class="boton" id="btnFolder" title="Carpeta Documentos"><span class="material-icons i-green btn-icon" title="Carpeta Documentos">topic</span></button></div>
                                    <div><button class="boton" id="btnRefresh" title="Recargar" onClick="recargaPag()"><span class="fa-solid fa-arrows-rotate  material-icons i-green btn-icon"></span></button></div>

                                    <?php if ($ensacado['fecha_entrada'] != '' && $ensacado['estatus_id'] != '5' && $ensacado['estatus_id'] != '15' && Utils::permisosVigilancia()): ?>
                                    <div><button class="boton" id="btnSalida" title="Salida de unidad"><span class="fa-solid fa-truck-arrow-right rotarHorizontal material-icons i-danger btn-icon  pr-1"></span></button></div>
                                    <?php endif; ?>
                                    <?php if ($ensacado['estatus_id'] == '5' && Utils::permisosVigilancia()): ?>
                                    <div><button class="boton" id="btnLiberar" title="Liberar unidad"><span class="fa-solid fa-truck-arrow-right rotarHorizontal material-icons i-liberar btn-icon  pr-1"></span></button></div>
                                    <?php endif; ?>
                                    <?php if ($ensacado['estatus_id'] == '1'): ?>
                                    <div><button class="boton" id="btnTransito" title="Poner unidad en transito"><span class="fa-solid fa-arrow-right-arrow-left material-icons i-transit btn-icon pr-1 mr-1"></span></button></div>
                                    <?php endif; ?>
                                    <?php if ($ensacado['fecha_entrada'] == ''): ?>
                                    <div><button class="boton" id="btnIngresar" title="Ingresar unidad"><span class="fa-solid fa-truck-arrow-right material-icons i-iniciar btn-icon pr-1"></span></button></div>
                                    <?php endif; ?>
                                    <?php if ($ensacado['fecha_entrada'] != '' && $ensacado['estatus_id'] != '5' && $ensacado['estatus_id'] != '15' && Utils::permisosLogistica()): ?>
                                    <div><button class="boton" id="btnNuevoServicio" title="Agregar nuevo servicio"><span class="material-icons i-add btn-icon">add_circle</span></button></div>
                                    <?php endif; ?>
                                    <?php if ((($ensacado['fecha_entrada'] != '' && $ensacado['estatus_id'] != '5' && $ensacado['estatus_id'] != '15' && Utils::permisosLogistica()) || ($ensacado['estatus_id'] == '1')) || Utils::isAdmin()): ?>
                                    <div><button class="boton" id="btnGuardar" title="Guardar"><span class="material-icons btn-icon i-save">save</span></button></div>
                                    <!-- <div><button class="boton" id="btnEliminar" title="Eliminar"><span class="far i-delete material-icons fa-trash-alt btn-icon-s"></span></button></div> -->
                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>
                        <div class='col-md-2 col-12 '>
                            <div id="tdEstatus" style="height: 80px;line-height: 80px;" class="<?= Utils::getClaseEstado($ensacado['clave']); ?> estatus text-center collapsed">
                                <span id="estatus"><?= $ensacado['estatus']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-6 col-12'>
                            <label for="numeroUnidad" class="form-label">Número de Unidad</label>
                            <div class="input-group mb-3">
                                <input type="text" id="numeroUnidad" name="numeroUnidad" class="form-control" placeholder="Número de Unidad" aria-label="Número de Unidad" aria-describedby="basic-addon2" value="<?= isset($ensacado) && $ensacado['numUnidad'] != '' ? $ensacado['numUnidad'] : ''; ?>">
                                <label id="addDocumento" title="Agregar Bill of lading" for="documentoBill" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;" class="inputFile input-group-text"><i class="fas fa-cloud-upload-alt"></i></label>
                                <input id="documentoBill" name="documentoBill" type="file" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden />
                                <input <?php ROFinaliza($ensacado['estatus_id']) ?> class="input-group-text" type="hidden" id="archivoBill" name="archivoBill" value="<?= isset($ensacado) && $ensacado['doc_remision'] != '' ? $ensacado['doc_remision'] : ''; ?>">
                                <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf input-group-text" title="Ver Bill of lading" hidden></i>
                                <i id="delete" class="far i-delete material-icons fa-trash-alt input-group-text" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden></i>
                            </div>
                        </div>
                        <div class='col-xl-4 col-6'>
                            <div class='row'>
                                <div class='col-6 mt-4'>
                                    <div class="form-check form-check-reverse">
                                        <input class="ml-1 mr-3 form-check-input" id="entrada_salida" type="radio" name="entrada_salida" value="0" <?= ($ensacado['entrada_salida'] == 0) ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="entrada_salida"><strong for="entrada_salida">Entrada</strong></label>
                                    </div>
                                </div>
                                <div class='col-6 mt-4'>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="entrada_salida"><strong for="entrada_salida">Salida</strong></label>
                                        <input class="ml-1 form-check-input" type="radio" name="entrada_salida" value="1" <?= ($ensacado['entrada_salida'] == 1) ? 'checked' : ''; ?> />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-xl-2 col-6'>
                            <div class='form-check form-switch mt-3'>
                                <label class="form-check-label" for="peso_obligatorio">Pesaje Obligatorio</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="peso_obligatorio" name="peso_obligatorio" <?= ($ensacado['peso_obligatorio'] == 1) ? 'checked' : ''; ?>>

                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-6 col-md-12'>
                            <label for="cliente" class="form-label">Cliente</label>
                            <select name="cliente" class="form-select" id="cliente" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> <?php ROFinaliza($ensacado['estatus_id']) ?>>
                                <option value="" selected>--Selecciona--</option>
                                <?php
                                    if (!empty($clientes)):
                                        foreach ($clientes as $cli):
                                ?>
                                <option value="<?= $cli->id ?>" <?= isset($ensacado) && $cli->id == $ensacado['cliente_id'] ? 'selected' : ''; ?>><?= $cli->nombre ?> </option>
                                <?php
                                        endforeach;
                                    endif;
                                                                    ?>
                            </select>
                        </div>
                        <div class='col-xl-3 col-md-6'>
                            <label for="pesoCliente" class="form-label">Peso cliente</label>
                            <div class="input-group mb-3">
                                <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="pesoCliente" id="pesoCliente" <?php ROFinaliza($ensacado['estatus_id']) ?> value="<?= isset($ensacado) && $ensacado['peso_cliente'] != null ? UtilsHelp::numero2Decimales($ensacado['peso_cliente']) : ''; ?>"
                                    class="form-control numhtml" style="text-align: right;" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> />
                                <span class="input-group-text">kgs.</span>
                            </div>
                        </div>
                        <div class='col-xl-3 col-md-6'>
                            <label for="transp_lea_cliente" class="form-label">Transporte por</label>
                            <div class='row'>
                                <div class='col-6'>
                                    <div class="form-check form-check-reverse">
                                        <input class="ml-1 mr-3 form-check-input" id="transp_lea_cliente" type="radio" name="transp_lea_cliente" value="0" disabled <?= ($ensacado['transp_lea_cliente'] == 0) ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="transp_lea_cliente">
                                            <strong for="transp_lea_cliente">LEA</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class='col-6'>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="transp_lea_cliente">
                                            <strong for="transp_lea_cliente">Cliente</strong>
                                        </label>
                                        <input class="ml-1 form-check-input" id="transp_lea_clientec" type="radio" name="transp_lea_cliente" value="1" disabled <?= ($ensacado['transp_lea_cliente'] == 1) ? 'checked' : ''; ?> />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-6 col-md-6'>
                            <label for="tipo_producto" class="form-label">Producto</label>
                            <div class='row'>
                                <div class='col-6 mt-2'>
                                    <div class="form-check form-check-reverse">
                                        <input class="ml-1 mr-3 form-check-input" id="tipo_producto" type="radio" name="tipo_producto" value="0" <?= ($ensacado['tipo_producto'] == 0) ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="tipo_producto">
                                            <strong for="tipo_producto">Polietileno</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class='col-6 mt-2'>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="tipo_producto">
                                            <strong for="tipo_producto">Lubricante</strong>
                                        </label>
                                        <input class="ml-1 form-check-input" id="tipo_productoL" type="radio" name="tipo_producto" value="1" <?= ($ensacado['tipo_producto'] == 1) ? 'checked' : ''; ?> />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-xl-6 col-md-12'>
                            <label for="transporte" class="form-label">Transporte</label>
                            <select name="transporte" class="form-select" id="transporte" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> <?php ROFinaliza($ensacado['estatus_id']) ?>>
                                <option value="" selected>--Selecciona--</option>
                                <?php
                                    if (!empty($transportes)):
                                        foreach ($transportes as $t):
                                ?>
                                <option value="<?= $t->id ?>" <?= isset($ensacado) && $t->id == $ensacado['tipo_transporte_id'] ? 'selected' : ''; ?> data-bascula="<?= $t->bascula ?>" data-cap_max="<?= $t->cap_maxima ?>"><?= $t->nombre ?>
                                </option>
                                <?php
                                        endforeach;
                                    endif;
                                                                    ?>
                            </select>
                        </div>
                        <div class='col-12'>
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <input <?php ROFinaliza($ensacado['estatus_id']) ?> type="text" id="observaciones" name="observaciones" value="<?= isset($ensacado) ? $ensacado['observaciones'] : ''; ?>" class="form-control" />
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class="accordion" id="accordionDatos">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#secTransportista" aria-expanded="false" aria-controls="secTransportista">
                                        Datos Transporte
                                    </button>
                                </h2>
                                <div id="secTransportista" class="accordion-collapse collapse" data-bs-parent="#accordionDatos">
                                    <div class="accordion-body">
                                        <div class='row'>
                                            <div class='<?= $isTren ? 'col-xl-12' : 'col-xl-6' ?> col-md-12'>
                                                <label for="transportista" class="form-label">Transportista</label>
                                                <?php if ($isTren) { ?>
                                                <input <?php ROFinaliza($ensacado['estatus_id']) ?> type="text" name="transportista" value="KANSAS CITY SOUTHERN DE MEXICO" id="transportista" class="form-control" disabled />
                                                <?php } else { ?>
                                                <select <?php ROFinaliza($ensacado['estatus_id']) ?> name="transportista" class="form-select" id="transportista" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?>>
                                                    <option value="" selected>--Selecciona--</option>
                                                    <option value="nuevo" selected>--Nuevo Transportista--</option>
                                                    <?php
                                                    if (!empty($cat_transportistas)):
                                                        foreach ($cat_transportistas as $t):
                                                    ?>
                                                    <option value="<?= $t->id ?>" <?= ($ensacado['transportista'] == $t->id) ? 'selected' : ''; ?>><?= $t->nombre ?> </option>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                                                                    ?>
                                                </select>
                                                <?php } ?>
                                            </div>
                                            <div class='col-xl-6 col-md-12' <?= $isTren ? 'hidden' : '' ?>>
                                                <label for="chofer" class="form-label">Chofer</label>
                                                <?php if ($isTren) { ?>
                                                <input <?php ROFinaliza($ensacado['estatus_id']) ?>type="text" name="chofer" value="<?= isset($ensacado['chofer']) ? $ensacado['chofer'] : ''; ?>" id="chofer" class="form-control" <?= $isTren ? 'disabled' : '' ?> />
                                                <?php } else { ?>
                                                <select <?php ROFinaliza($ensacado['estatus_id']) ?> name="chofer" class="form-select" id="chofer" <?= $isTren ? 'disabled' : '' ?>>
                                                    <option value="" selected>--Selecciona--</option>
                                                    <?php
                                                    if (!empty($cat_choferes)):
                                                        foreach ($cat_choferes as $t):
                                                    ?>
                                                    <option value="<?= $t->chof_id ?>" <?= ($ensacado['chofer'] == $t->chof_id) ? 'selected' : ''; ?>><?= $t->chof_nombres . ' ' . $t->chof_apellidos ?> </option>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                                                                    ?>
                                                </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class='row' <?= $isTren ? 'hidden' : '' ?>>
                                            <div class='col-xl-6 col-12'>
                                                <label for="placa1" class="form-label">Placa caja #1</label>
                                                <input <?php ROFinaliza($ensacado['estatus_id']) ?> type="text" name="placa1" value="<?= isset($ensacado) ? $ensacado['placa1'] : ''; ?>" id="placa1" class="form-control" />
                                            </div>
                                            <div class='col-xl-6 col-12'>
                                                <label for="placa2" class="form-label">Placa caja #2</label>
                                                <input <?php ROFinaliza($ensacado['estatus_id']) ?> type="text" name="placa2" value="<?= isset($ensacado) ? $ensacado['placa2'] : ''; ?>" id="placa2" class="form-control" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#secFechas" aria-expanded="false" aria-controls="secFechas">
                                        Datos Fechas
                                    </button>
                                </h2>
                                <div id="secFechas" class="accordion-collapse collapse" data-bs-parent="#accordionDatos">
                                    <div class="accordion-body">
                                        <div class='row'>
                                            <div class='col-md-6 col-12'>
                                                <label for="fecha_entrada_fecha" class="form-label">Fecha Entrada</label>
                                                <table>
                                                    <tr>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_entrada']) ? '' : 'disabled') ?> type="text" id="fecha_entrada_fecha" name="fecha_entrada_fecha" style="max-width:120px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? explode(' ', UtilsHelp::fechaHora($ensacado['fecha_entrada']))[0] : ''; ?>">
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_entrada']) ? '' : 'disabled') ?> type="number" id="fecha_entrada_hora" name="fecha_entrada_hora" min="0" max="23" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? explode(':', explode(' ', $ensacado['fecha_entrada'])[1])[0] : ''; ?>" />
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_entrada']) ? '' : 'disabled') ?> type="number" id="fecha_entrada_minuto" name="fecha_entrada_minuto" min="0" max="59" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? explode(':', explode(' ', $ensacado['fecha_entrada'])[1])[1] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class='col-md-6 col-12'>
                                                <label for="fecha_salida_fecha" class="form-label">Fecha finalizado</label>
                                                <table>
                                                    <tr>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_salida']) ? '' : 'disabled') ?> type="text" id="fecha_salida_fecha" name="fecha_salida_fecha" style="max-width:120px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_salida'] != '' ? explode(' ', UtilsHelp::fechaHora($ensacado['fecha_entrada']))[0] : ''; ?>">
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_salida']) ? '' : 'disabled') ?> type="number" id="fecha_salida_hora" name="fecha_salida_hora" min="0" max="23" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? explode(':', explode(' ', $ensacado['fecha_salida'])[1])[0] : ''; ?>" />
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_salida']) ? '' : 'disabled') ?> type="number" id="fecha_salida_minuto" name="fecha_salida_minuto" min="0" max="59" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? explode(':', explode(' ', $ensacado['fecha_salida'])[1])[1] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class='col-md-6 col-12'>
                                                <label for="fecha_liberaciona_fecha" class="form-label">Fecha Salida</label>
                                                <table>
                                                    <tr>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_liberacion']) ? '' : 'disabled') ?> type="text" id="fecha_liberacion_fecha" name="fecha_liberacion_fecha" style="max-width:120px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_liberacion'] != '' ? explode(' ', UtilsHelp::fechaHora($ensacado['fecha_liberacion']))[0] : ''; ?>">
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_liberacion']) ? '' : 'disabled') ?> type="number" id="fecha_liberacion_hora" name="fecha_liberacion_hora" min="0" max="23" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_liberacion'] != '' ? explode(':', explode(' ', $ensacado['fecha_liberacion'])[1])[0] : ''; ?>" />
                                                        </td>
                                                        <td> <input class="form-control" <?php ROFinaliza($ensacado['estatus_id']) ?> <?= (isset($ensacado['fecha_liberacion']) ? '' : 'disabled') ?> type="number" id="fecha_liberacion_minuto" name="fecha_liberacion_minuto" min="0" max="59" style="max-width:80px;"
                                                                value="<?= isset($ensacado) && $ensacado['fecha_liberacion'] != '' ? explode(':', explode(' ', $ensacado['fecha_liberacion'])[1])[1] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class='col-md-6 col-12'>
                                                <label for="dias" class="form-label">Tiempo en planta</label>
                                                <div class='mt-2'>
                                                    <span id="dias"><strong>Dias:</strong> </span><span><?= isset($tiempo) ? $tiempo['dias'] : ''; ?></span>
                                                    <span><strong>Horas:</strong> </span><span><?= isset($tiempo) ? $tiempo['horas'] : ''; ?></span>
                                                    <span><strong>Minutos:</strong> </span><span><?= isset($tiempo) ? $tiempo['minutos'] : ''; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" id="ticket-group">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#secBascula" aria-expanded="false" aria-controls="secBascula">
                                        Datos Báscula
                                    </button>
                                </h2>
                                <div id="secBascula" class="accordion-collapse collapse" data-bs-parent="#accordionDatos">
                                    <div class="accordion-body">
                                        <div class='row'>
                                            <div class='col-xl-3 col-6'>
                                                <label for=" ticket" class="form-label">Número de Ticket</label>
                                                <div class="input-group mb-3">
                                                    <input <?php ROFinaliza($ensacado['estatus_id']) ?> type="text" id="ticket" name="ticket" class="form-control" placeholder="Número de ticket" aria-label="Número de ticket" aria-describedby="basic-addon2" value="<?= isset($ensacado) ? $ensacado['ticket'] : ''; ?>"
                                                        <?= (Utils::permisosLogistica() || Utils::permisosEnsacado()) ? '' : 'disabled' ?> />
                                                    <label id="addDocumento" title="Agregar ticket" for="documentoTicket" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;" class="inputFile input-group-text" <?php ROFinaliza($ensacado['estatus_id']) ?>><i
                                                            class="fas fa-cloud-upload-alt"></i></label>
                                                    <input id="documentoTicket" name="documentoTicket" type="file" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden />
                                                    <input <?php ROFinaliza($ensacado['estatus_id']) ?> class="input-group-text" type="hidden" id="archivoTicket" name="archivoTicket" value="<?= isset($ensacado) && $ensacado['doc_ticket'] != '' ? $ensacado['doc_ticket'] : ''; ?>">
                                                    <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf input-group-text" title="Ver ticket" hidden></i>
                                                    <i id="delete" class="far i-delete material-icons fa-trash-alt input-group-text" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden></i>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6' id="tara-group">
                                                <label for="tara" class="form-label">Tara Unidad</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="tara" id="tara" value="<?= isset($ensacado) && $ensacado['peso_tara'] != null ? UtilsHelp::numero2Decimales($ensacado['peso_tara']) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">lbs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="taraKilos" class="form-label">Tara Kilos</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="taraKilos" id="taraKilos" value="<?= isset($ensacado) && $ensacado['pesoTaraKg'] != null ? UtilsHelp::numero2Decimales($ensacado['pesoTaraKg']) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="pesoTeorico" class="form-label">Peso Teórico</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="pesoTeorico" id="pesoTeorico" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['peso_teorico'], true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="tolerable" class="form-label">% Tolerable</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="tolerable" id="tolerable" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['tolerable'], true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6' title="Diferencia entre peso teorico y peso cliente.">
                                                <label for="diferenciaTeorica" class="form-label">Diferencia teorica</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="diferenciaTeorica" id="diferenciaTeorica" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['diferenciaTeorica'], true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="pesoBruto" class="form-label">Peso bruto</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="pesoBruto" id="pesoBruto" value="<?= isset($pesaje) ? UtilsHelp::numero2Decimales($pesaje['EntPesoB'], true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="pesoVacio" class="form-label">Peso en vacio</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="pesoVacio" id="pesoVacio" value="<?= isset($pesaje) ? UtilsHelp::numero2Decimales($pesaje['EntPesoT'], true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="pesoNeto" class="form-label">Peso neto</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="pesoNeto" id="pesoNeto" value="<?= isset($pesoNeto) ? UtilsHelp::numero2Decimales($pesoNeto, true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="diferenciaReal" class="form-label">Diferencia real</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="diferenciaReal" id="diferenciaReal" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($diferenciaReal, true, 0) : ''; ?>" class="form-control numhtml" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="fechaPeso" class="form-label">Fecha peso</label>
                                                <table>
                                                    <tr>
                                                        <td style="width:55%;"><input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="fechaPeso" id="fechaPeso" value="<?= isset($pesaje) ? UtilsHelp::formatoFecha($pesaje['EntFechaE']) : ''; ?>" class="form-control numhtml" disabled /></td>
                                                        <td style="width:45%;"><input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="horaPeso" id="horaPeso" value="<?= isset($pesaje) ? UtilsHelp::formatoHora($pesaje['EntHoraE']) : ''; ?>" class="form-control numhtml" disabled /></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="fechaPesoSalida" class="form-label">Fecha peso salida</label>
                                                <table>
                                                    <tr>
                                                        <td style="width:55%;"><input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="fechaPesoSalida" id="fechaPesoSalida" value="<?= isset($pesaje) ? UtilsHelp::formatoFecha($pesaje['EntFechaS']) : ''; ?>" class="form-control numhtml" disabled /></td>
                                                        <td style="width:45%;"><input type="text" <?php ROFinaliza($ensacado['estatus_id']) ?> name="horaPesoSalida" id="horaPesoSalida" value="<?= isset($pesaje) ? UtilsHelp::formatoHora($pesaje['EntHoraS']) : ''; ?>" class="form-control numhtml" disabled /></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" <?= isset($ensacado['sellos']) && $ensacado['sellos'] != '' ? '' : 'hidden' ?>>
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#secSellos" aria-expanded="false" aria-controls="secSellos">
                                        Datos Sellos
                                    </button>
                                </h2>
                                <div id="secSellos" class="accordion-collapse collapse" data-bs-parent="#accordionDatos">
                                    <div class="accordion-body">
                                        <div class='row'>
                                            <?php
                                                $sellos = json_decode($ensacado['sellos'], true);
                                                if (isset($ensacado['sellos']) && $ensacado['sellos'] != '') {
                                                    for ($x = 1; $x < $ensacado['cant_puertas'] + 1; $x++) {
                                                        echo '
                                                        <div class="col-xl-6 col-12">
                                                            <label for="sello' . $x . '" class="form-label">Sello #' . $x . '</label>
                                                            <input ' . ROFinaliza($ensacado['estatus_id']) . ' type="text" id="sello' . $x . '" name="sello' . $x . '" value="' . (isset($ensacado['sellos']) ? $sellos['sellos'][$x - 1]['sello' . strval($x)] : '') . '" class="form-control" /></div>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class='col-xl-6 col-12 sombra' id="det_servicios" style="padding-left: 30px;">
                <div class="text-center mt-1">
                    <h4>DETALLE DE SERVICIOS</h4>
                </div>
                <div class='row' id="seccionServicios">
                    <div class="accordion" id="accordionServicios">
                        <?php if (isset($ensacado) && count($ensacado['servicio']) > 0): ?>
                        <?php $x = 0;
                        foreach ($ensacado['servicio'] as $serv):
                            if ($serv['clave'] != 'FIN' && $x == 0) {
                                $x++;
                            } ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button  foliohead <?= ($x == 1) ? ' show ' : ' collapsed' ?> <?= Utils::getClaseEstado($serv['clave']); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $serv['folio'] ?>" aria-expanded="<?= ($x == 1) ? 'true' : 'false' ?>"
                                    aria-controls="<?= $serv['folio'] ?>">
                                    Folio <?= $serv['folio'] ?> - Lote <?= $serv['lote'] ?>
                                </button>
                            </h2>
                            <div id="<?= $serv['folio'] ?>" class="accordion-collapse collapse <?php if ($x == 1) { echo ' show '; $x = 2; } else { echo ' collapsed'; } ?>" data-bs-parent="#accordionServicios">
                                <div class="accordion-body">
                                    <input type="hidden" id="idServicio" value="<?= $serv['id'] ?>" />
                                    <input type="hidden" id="almacen_id" value="<?= $serv['almacen_id'] ?>" css="almacen_id" name="almacen_id">
                                    <input type="hidden" id="idNombreServicio" value="<?= $serv['servicio_id'] ?> " />
                                    <div>
                                        <div class='row'>
                                            <div class='col-7'>
                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    <?php if ($serv['fecha_inicio'] == '' && $serv['fecha_programacion'] != '' && $serv['fecha_programacion'] != '0000-00-00 00:00:00'): ?>
                                                    <button type="button" id="iniciarServicio" class="btn btn-transparent" data-idservicio="<?= $serv['id'] ?>" data-nombreservicio="<?= $serv['nombreServ'] ?>"><span class="material-icons i-iniciar">play_arrow</span></button>
                                                    <?php endif; ?>
                                                    <?php if ($serv['estatus_id'] == 3 || $serv['estatus_id'] == 133): ?>
                                                    <button id="detenerServicio" type="button" class="btn btn-transparent" data-nombreserv="<?= $serv['nombreServ'] ?>" data-folio="<?= $serv['folio'] ?>" data-idservicio="<?= $serv['id'] ?>"><span class="fa-regular fa-circle-stop material-icons i-pdf "></span></button>
                                                    <?php endif; ?>
                                                    <?php if ($serv['estatus_id'] != 5 && (Utils::permisosGerente() or Utils::permisosSupervisor())): ?>
                                                    <button id="editarServicio" type="button" class="btn btn-transparent" data-idservicio="<?= $serv['id'] ?>"><span class="material-icons i-edit" title="Editar">edit</span></button>
                                                    <button id="deleteServicio" type="button" class="btn btn-transparent" data-idservicio="<?= $serv['id'] ?>"><span class="material-icons i-delete" title="Eliminar">delete_forever</span></button>
                                                    <?php endif; ?>
                                                    <button id="imprimirServicio" type="button" class="btn btn-transparent" data-servicio="<?= $serv['id'] ?>"><span class=" i-document material-icons mr-1" data-servicio="<?= $serv['id'] ?>">description</span></button>
                                                </div>
                                            </div>
                                            <div class='col-1 mb-1'>
                                                <span><strong>Estatus</strong></span>
                                            </div>
                                            <div class='col-4 mb-1'>
                                                <div class="<?= Utils::getClaseEstado($serv['clave']); ?> estatus text-center collapsed"><span id="estatus"><?= $serv['estatus']; ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class='detalles_serv'>
                                        <div class='row'>
                                            <div class='col-xl-4 col-6'>
                                                <label for="nombreServ" class="form-label">Servicio</label>
                                                <input type="text" name="nombreServ" id="nombreServ" value="<?= $serv['nombreServ'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-xl-2 col-6'>
                                                <label for="empaque_id" class="form-label">Empaque</label>
                                                <input type="text" name="empaque_id" id="empaque_id" value="<?= $serv['empaque'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="cantidad" id="cantidad_det" value="<?= UtilsHelp::numero2Decimales($serv['cantidad']) ?>" class="form-control numhtml sumcantidad" disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-xl-3 col-6'>
                                                <label for="orden" class="form-label">Orden</label>
                                                <div class="input-group mb-3" <?= (isset($serv['doc_orden']) && $serv['doc_orden'] != '') ? $serv['doc_orden'] : 'hidden' ?>>
                                                    <input type="text" id="orden" name="orden" class="form-control" placeholder="Número de orden" aria-label="Número de orden" aria-describedby="basic-addon2" value="<?= (isset($serv) && isset($serv['orden'])) ? $serv['orden'] : ''; ?>" disabled>
                                                    <input id="doc_orden" name="doc_orden" type="file" value="<?= (isset($serv) && isset($serv['doc_orden'])) ? $serv['doc_orden'] : ''; ?>" hidden />
                                                    <input <?php ROFinaliza($ensacado['estatus_id']) ?> class="input-group-text" type="hidden" id="doc_orden" name="doc_orden" value="<?= (isset($serv) && isset($serv['doc_orden'])) ? $serv['doc_orden'] : ''; ?>">
                                                    <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf input-group-text" title="Ver orden" value="<?= (isset($serv) && isset($serv['doc_orden'])) ? $serv['doc_orden'] : ''; ?>"
                                                        data-documento="<?= (isset($serv) && isset($serv['doc_orden'])) ? $serv['doc_orden'] : ''; ?>"></i>
                                                </div>
                                                <input <?= (isset($serv['doc_orden']) && $serv['doc_orden'] != '') ? 'hidden' : '' ?> type="text" id="orden" name="orden" class="form-control" placeholder="Número de orden" aria-label="Número de orden" aria-describedby="basic-addon2"
                                                    value="<?= (isset($serv) && isset($serv['orden'])) ? $serv['orden'] : ''; ?>" disabled>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class='row'>
                                            <div class='col-6'>
                                                <label for="lote" class="form-label">Lote</label>
                                                <input type="text" name="lote" id="lote" value="<?= $serv['lote'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-6'>
                                                <label for="producto" class="form-label">Producto</label>
                                                <input type="text" name="producto" id="producto" value="<?= $serv['producto'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-12'>
                                                <label for="alias" class="form-label">Rótulo</label>
                                                <input type="text" name="alias" id="alias" value="<?= $serv['alias'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-6 mt-4'>
                                                <?php $transcurrido = UtilsHelp::tiempoTranscurrido(intval($serv['transcurrido'])) ?>
                                                <label for="fecha_programacion" class="form-label">Fecha programación</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="fecha_programacion" id="fecha_programacion"
                                                        value="<?= $serv['fecha_programacion'] != null && $serv['fecha_programacion'] != '' && $serv['fecha_programacion'] != '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($serv['fecha_programacion'])) : ''; ?>" class="form-control" disabled />
                                                    <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class='col-6 mt-4'>
                                                <label for="dias" class="form-label">Duración</label>
                                                <div class='row'>
                                                    <div class='col'>
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="dias" id="dias" value="<?= isset($transcurrido) ? $transcurrido['dias'] : '0'; ?>" class="form-control" disabled />
                                                            <span class="input-group-text">D</span>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4 col-12'>
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="horas" id="horas" value="<?= isset($transcurrido) ? $transcurrido['horas'] : '0'; ?>" class="form-control" disabled />
                                                            <span class="input-group-text">HRS</span>
                                                        </div>
                                                    </div>
                                                    <div class='col'>
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="minutos" id="minutos" value="<?= isset($transcurrido) ? $transcurrido['minutos'] : '0'; ?>" class="form-control" disabled />
                                                            <span class="input-group-text">MIN</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class='row'>
                                            <div class='col-6'>
                                                <label for="usuario_inicio_nombre" class="form-label">Operador Inicio</label>
                                                <input type="text" name="usuario_inicio_nombre" id="usuario_inicio_nombre" value="<?= $serv['usuario_inicio_nombre'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-6'>
                                                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?= $serv['fecha_inicio'] ?>" class="form-control " disabled />
                                                    <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class='col-6'>
                                                <label for="usuario_fin_nombre" class="form-label">Operador Fin</label>
                                                <input type="text" name="usuario_fin_nombre" id="usuario_fin_nombre" value="<?= $serv['usuario_fin_nombre'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-6'>
                                                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="fecha_fin" id="fecha_fin" value="<?= $serv['fecha_fin'] ?>" class="form-control " disabled />
                                                    <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class='col-3'>
                                                <label for="barredura_sucia" class="form-label">Barredura sucia</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="barredura_sucia" id="barredura_sucia" value="<?= UtilsHelp::string2Entero($serv['barredura_sucia']) ?>" class="form-control " disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-3'>
                                                <label for="barredura_limpia" class="form-label">Barredura limpia</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="barredura_limpia" id="barredura_limpia" value="<?= UtilsHelp::string2Entero($serv['barredura_limpia']) ?>" class="form-control " disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-3'>
                                                <label for="total_sucia" class="form-label">Total barredura</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="total_sucia" id="total_sucia" value="<?= UtilsHelp::string2Entero($serv['barredura_sucia'] + $serv['barredura_limpia']); ?>" class="form-control " disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-3'>
                                                <label for="total_ensacado" class="form-label">Total ensacado</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="total_ensacado" id="total_ensacado" value="<?= UtilsHelp::string2Entero($serv['total_ensacado']) ?>" class="form-control " disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-2'>
                                                <label for="tipo_tarima" class="form-label">Tarima</label>
                                                <?php
                                                foreach (tipo_tarimas as $i => $m):
                                                    if ($i == $serv['tipo_tarima']) {
                                                        echo '<input type="text" name="tipo_tarima" id="tipo_tarima" value="' . $m . '" class="form-control " disabled />';
                                                    }
                                                endforeach;
                                                                    ?>

                                            </div>
                                            <div class='col-2'>
                                                <label for="sacoxtarima" class="form-label">Sacos x Tarima</label>
                                                <input type="text" name="sacoxtarima" id="sacoxtarima" value="<?= $serv['sacoxtarima'] != '' ? UtilsHelp::string2Entero($serv['sacoxtarima']) : ''; ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-2'>
                                                <label for="peso_empaque" class="form-label">Peso Empaque</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="peso_empaque" id="peso_empaque" value="<?= $serv['peso_empaque'] ?>" class="form-control " disabled />
                                                    <span class="input-group-text">kgs.</span>
                                                </div>
                                            </div>
                                            <div class='col-2' <?= ($serv['empaque'] != 'Sacos') ? 'hidden' : '' ?>>
                                                <label for="bultos" class="form-label">Bultos</label>
                                                <input type="text" name="bultos" id="bultos" value="<?= $serv['bultos'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-2' <?= ($serv['empaque'] != 'Sacos') ? 'hidden' : '' ?>>
                                                <label for="tarimas" class="form-label">Tarimas</label>
                                                <input type="text" name="tarimas" id="tarimas" value="<?= $serv['tarimas'] ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-2' <?= ($serv['empaque'] != 'Sacos') ? 'hidden' : '' ?>>
                                                <label for="parcial" class="form-label">Parcial</label>
                                                <input type="text" name="parcial" id="parcial" value="<?= $serv['parcial'] != '' ? UtilsHelp::string2Entero($serv['parcial']) : ''; ?>" class="form-control " disabled />
                                            </div>
                                            <div class='col-12'>
                                                <label for="observaciones" class="form-label">Observaciones</label>
                                                <input type="text" name="observaciones" id="observaciones" value="<?= $serv['observaciones'] ?>" class="form-control " disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- </div> -->
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Documento modal -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDocumento">
        <div class="modal-dialog m-dialog">
            <div class="modal-content m-content" id="viewDoc">
                <div class="modal-header m-header">
                    <h5 class="modal-title" id="tituloDocumento"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal agregar servicio-->
    <div class="modal fade modal-servicio" id="agregarServicioModal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog m-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header m-title justify-content-between">
                    <h5 class="modal-title ml-2">
                        <span class="material-icons far fa-file-alt i-new"></span>
                        </a>
                        <span class="ml-2">Agregar nuevo servicio</span>
                        <p>
                            <span class="ml-2"><strong class="mr-1">Número FT/AT:</strong> <?= isset($ensacado) ? $ensacado['numUnidad'] : ''; ?>
                                <br />
                                <span class="ml-2"><strong class="mr-1">Cliente:</strong>
                                    <?php
                                        if (!empty($clientes)) {
                                            foreach ($clientes as $cli) {
                                                if (isset($ensacado) && $cli->id == $ensacado['cliente_id']) {
                                                    echo $cli->nombre;
                                                }
                                            }
                                        }
                                    ?>
                                </span>
                        </p>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="border-modal modal-body">
                    <form id="formAgregarServicio" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="idEntrada" name="idEntrada" />
                        <input type="hidden" id="estatus" name="estatus" value="1" />
                        <input type="hidden" id="almacen_id" css="almacen_id" name="almacen_id">
                        <input type="hidden" id="producto_id" css="producto_id" name="producto_id">
                        <div class='row'>
                            <div class='row'>

                                <div class='col-md-4 col-12'>
                                    <label for="idTipoServicio" class="form-label">Servicio</label>
                                    <select name="idTipoServicio" class="form-select" id="idTipoServicio">
                                        <option value="" selected>--Selecciona--</option>
                                        <?php
                                            if (!empty($servicios)):
                                                foreach ($servicios as $s):
                                        ?>
                                        <option value="<?= $s->id ?>"><?= $s->clave . ' - ' . $s->nombre ?> </option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                                <div class='col-md-4 col-12'>
                                    <div class='row'>
                                        <div class='col-md-6 col-12'>
                                            <label for="idEmpaque" class="form-label">Empaque</label>
                                            <select name="idEmpaque" class="form-select" id="idEmpaque">
                                                <option value="" selected>--Selecciona--</option>
                                                <option value="">N/A</option>
                                                <?php
                                                    if (!empty($tiposEmpaques)):
                                                        foreach ($tiposEmpaques as $tp):
                                                ?>
                                                <option value="<?= $tp->id ?>" data-pesosugerido="<?= $tp->peso_sugerido ?>"><?= $tp->nombre ?> </option>
                                                <?php
                                                        endforeach;
                                                    endif;
                                                                                                    ?>
                                            </select>
                                        </div>
                                        <div class='col-md-6 col-12'>
                                            <div class='row'>
                                                <label for="insumos_por" class="form-label">Insumo por</label>
                                            </div>
                                            <div class='row' style="font-size: 0.9rem; margin-top: 0.5rem;">
                                                <div class='col-12'>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="insumos_por" id="insumos_por_0" value="0" checked>
                                                        <label class="form-check-label" for="insumos_por_0">LEADER</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="insumos_por" id="insumos_por_1" value="1">
                                                        <label class="form-check-label" for="insumos_por_1">Cliente</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class='col-md-4 col-12'>
                                    <div class='row'>

                                        <div class='col-12'>

                                            <div class='row'>
                                                <div class='col-md-6 col-12'>
                                                    <label for="cantidad" class="form-label">Cantidad</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="cantidad" id="cantidad" class="form-control numhtml" disabled />
                                                        <span class="input-group-text">kgs.</span>
                                                    </div>
                                                </div>
                                                <div class='col-md-6 col-12'>
                                                    <label for="cantidad_lbs" class="form-label"> </label>
                                                    <div class="input-group mb-3 mt-2">
                                                        <input type="text" name="cantidad_lbs" id="cantidad_lbs" class="form-control numhtml" disabled />
                                                        <span class="input-group-text">lbs.</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class='col-12'>
                                            <div class='row disponible_div' hidden>
                                                <div class='col-4'>
                                                    <span id="disponible" style="font-size: xx-small;margin-top: 2%;">
                                                        <div class="input-group mb-3">
                                                            <strong>Disponible:</strong>
                                                            <span class="input-group-text" style="margin-right: 4px;">
                                                                <?php
                                                                    if (isset($pesaje) && ($pesaje['EntPesoT'] > 0)) {
                                                                        echo UtilsHelp::numero2Decimales((intval(Utils::quitarComas($pesoNeto)) - intval(Utils::quitarComas($ensacado['total_por_ensacar']))), true, 0);
                                                                    } else {
                                                                        echo UtilsHelp::numero2Decimales(($ensacado['peso_cliente'] - $ensacado['total_por_ensacar']), true, 0);
                                                                    }
                                                                ?></span>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class='col-4'>
                                                    <span id="peso_cliente" style="font-size: xx-small;margin-top: 2%;">
                                                        <div class="input-group mb-3">
                                                            <strong>Peso Cliente:</strong>
                                                            <span class="input-group-text"><?php echo UtilsHelp::numero2Decimales($ensacado['peso_cliente']); ?></span>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class='col-4'>
                                                    <span id="peso_bruto_real" style="font-size: xx-small;margin-top: 2%;">
                                                        <div class="input-group mb-3">
                                                            <strong>Peso Bruto/Real:</strong>
                                                            <span class="input-group-text">
                                                                <?php
                                                                    if (isset($pesaje) && ($pesaje['EntPesoT'] > 0)) {
                                                                        echo UtilsHelp::numero2Decimales($pesaje['EntPesoT'], true, 0);
                                                                    } else if (isset($pesaje)) {
                                                                        echo UtilsHelp::numero2Decimales($pesaje['EntPesoB'], true, 0);
                                                                    } else {
                                                                        echo '0';
                                                                    }
                                                                ?>
                                                            </span>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                </div>
                <div class='row'>
                    <div class='col-md-4 col-12'>
                        <label for="orden" class="form-label">Orden</label>
                        <div class="input-group ">
                            <input type="text" name="orden" id="orden" class="form-control" value="<?= isset($ensacado) && isset($ensacado['doc_orden']) ? $ensacado['doc_orden'] : ''; ?>" />
                            <span class=" input-group-text igt-r ">
                                <label id="addDocumento" title="Agregar orden" for="documentoOrden_e" class="inputFile mb-1">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </label>
                                <input id="documentoOrden_e" <?php ROFinaliza($ensacado['estatus_id']) ?>name="documentoOrden_e" type="file" hidden />


                                <!-- <label id="addDocumento" title="Agregar orden" for="documentoOrden_e" class="inputFile mb-1"><i class="fas fa-cloud-upload-alt"></i></label> -->

                                <input type="hidden" id="archivoOrden_e" name="archivoOrden_e">
                                <i id="show" class="input-group-text i-pdf material-icons fa-solid fa-file-pdf" title="Ver Bill of lading" hidden></i>
                                <i id="delete" class="input-group-text far i-delete material-icons fa-trash-alt" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden></i>
                            </span>
                        </div>
                    </div>
                    <div class='col-md-8 col-12'>
                        <div class='col-md- <?= ($ensacado['entrada_salida'] == '0') ? '12' : '8' ?> col-12'>
                            <div class='row'>
                                <div class='col'>
                                    <label for="loteSelect" class="form-label">Lote</label>
                                    <input type="text" name="lote" id="lote" class="form-control" />
                                    <select name="loteSelect" id="loteSelect" class="form-select loteSelect" hidden>
                                        <option>--Selecciona--</option>
                                    </select>
                                </div>
                                <div class='col' hidden>
                                    <label for="disponible_lote" class="form-label">Disponible</label>
                                    <input type="text" name="disponible_lote" id="disponible_lote" class="form-control" />
                                </div>
                                <div class='col' hidden>
                                    <label for="lote_confirm" class="form-label">Confirmar Lote</label>
                                    <input type="text" name="lote_confirm" id="lote_confirm" class="form-control" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- </div> -->
                    <div class='col-12' id="div_producto">
                        <label for="producto" class="form-label">Producto</label>
                        <select name="producto" class="form-select producto_sel" id="producto" style="">
                            <option value="" selected>--Selecciona--</option>
                            <option value="nuevo"> >>Nuevo Producto<< </option>
                                    <?php
                                        if (!empty($productos)):
                                            foreach ($productos as $p):
                                    ?>
                            <option value="<?= $p->id ?>"><?= $p->nombre ?> </option>
                            <?php
                                            endforeach;
                                        endif;
                                                                    ?>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-12'>
                        <label for="alias" class="form-label">Rotulo</label>
                        <input type="text" name="alias" id="alias" class="form-control" />
                    </div>
                </div>
                <div class='row programacion' style="display:none !important;">
                    <div class='col-md-2 col-12'>
                        <label for="fechaPrograma" class="form-label  mt-3">Fecha programación</label>
                        <div class="input-group mb-3">
                            <input type="text" name="fechaPrograma" id="fechaPrograma1" class="form-control fechaPrograma" readonly>
                        </div>
                    </div>
                    <div class='col-md-2 col-12'>
                        <label for="tipoTarima" class="form-label  mt-3">Tipo Tarima</label>
                        <select name="tipoTarima" class="form-select" id="tipoTarima">
                            <option value="">-Selecciona-</option>
                            <?php
                                foreach (tipo_tarimas as $i => $m):
                            ?>
                            <option value="<?= $i ?>"><?= $m ?></option>
                            <?php
                                endforeach;
                                                            ?>
                        </select>
                    </div>
                    <div class='col-md-2 col-12'>
                        <label for="cantidad" class="form-label  mt-3">Sacos X Tarima</label>
                        <input type="number" name="sacoxtarima" id="sacoxtarima" class="form-control numhtml" />

                    </div>
                    <div class='col-md-2 col-12'>
                        <div class='row'>
                            <label for="tarima_por" class="form-label  mt-3">Tarimas por</label>
                        </div>
                        <!-- <div class='row' style="font-size: 0.9rem; margin-top: 0.5rem;"> -->
                        <!-- <div class='col-12'> -->
                        <div class="form-check form-check">
                            <input class="form-check-input" type="radio" name="tarima_por" id="tarima_por_0" value="0" checked>
                            <label class="form-check-label" for="tarima_por_0">LEADER</label>
                        </div>
                        <div class="form-check form-check">
                            <input class="form-check-input" type="radio" name="tarima_por" id="tarima_por_1" value="1">
                            <label class="form-check-label" for="tarima_por_1">Cliente</label>
                        </div>
                        <!-- </div> -->
                        <!-- </div> -->
                    </div>
                    <div class='col-md-4 col-12'>
                        <div class='row'>
                            <div class='col-md-6 col-12'>
                                <label for="pesounidad_cantidad" class="form-label  mt-3">Peso por </label>
                                <div class="input-group mb-3">
                                    <input type="text" name="pesounidad_cantidad" id="pesounidad_cantidad" class="form-control numhtml" />
                                    <span class="input-group-text">kgs.</span>
                                </div>
                            </div>
                            <div class='col-md-6 col-12'>
                                <label for="pesounidad_cantidad_lbs" class="form-label  mt-3">unidad</label>
                                <div class="input-group">
                                    <input type="text" name="pesounidad_cantidad_lbs" id="pesounidad_cantidad_lbs" class="form-control numhtml" />
                                    <span class="input-group-text">lbs.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row calctarimas'>
                    <div class='col-md-4 col-12'>
                        <label for="bultos" class="form-label">Bultos</label>
                        <input type="text" name="bultos" id="bultos" class="form-control " readonly disabled />
                    </div>
                    <div class='col-md-4 col-12'>
                        <label for="tarimas" class="form-label">Tarimas</label>
                        <input type="text" name="tarimas" id="tarimas" class="form-control " readonly disabled />
                    </div>
                    <div class='col-md-4 col-12'>
                        <label for="parcial" class="form-label">Parcial</label>
                        <input type="text" name="parcial" id="parcial" class="form-control " readonly disabled />
                    </div>
                </div>
                <div class='row'>
                    <div class='col-12'>
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" />
                    </div>
                </div>

                </form>
                <div class=" border-modal modal-footer text-center">
                    <button type="button" class="btn btn-funcion btn-rojo" data-bs-dismiss="modal"><span class="material-icons pr-2">close</span><span>Cancelar</span></button>
                    <button class="btn btn-funcion btn-azul" id="btnGenerarServicio"><span class="material-icons pr-2">save</span><span>Guardar</span></button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal editar servicio-->
    <div class="modal fade modal-servicio" id="editarServicioModal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog m-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header m-title justify-content-between">
                    <h5 class="modal-title ml-2">
                        <span class="material-icons far fa-file-alt i-new"></span>
                        </a><span class="ml-2">Folio servicio:</span>
                        <span class="ml-2" id="folioServicio"></span>
                        <p>
                            <span class="ml-2"><strong class="mr-1">Número FT/AT:</strong> <?= isset($ensacado) ? $ensacado['numUnidad'] : ''; ?>
                                <br />
                                <span class="ml-2"><strong class="mr-1">Cliente:</strong>
                                    <?php
                                        if (!empty($clientes)) {
                                            foreach ($clientes as $cli) {
                                                if (isset($ensacado) && $cli->id == $ensacado['cliente_id']) {
                                                    echo $cli->nombre;
                                                }
                                            }
                                        }
                                    ?>
                                </span>
                        </p>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="border-modal modal-body">
                    <form id="formEditarServicio" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" id="idEntrada" name="idEntrada" />
                        <input type="hidden" id="estatus" name="estatus" />
                        <input type="hidden" id="almacen_id" css="almacen_id" name="almacen_id">
                        <input type="hidden" id="producto_id" css="producto_id" name="producto_id">
                        <input type="hidden" id="_lote" css="lote" name="lote">
                        <input type="hidden" id="_alias" css="alias" name="alias">
                        <div class='row'>
                            <div class='col-md-4 col-12'>
                                <label for="idTipoServicio" class="form-label">Servicio</label>
                                <select name="idTipoServicio" class="form-select" id="idTipoServicio" disabled>
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                        if (!empty($servicios)):
                                            foreach ($servicios as $s):
                                    ?>
                                    <option value="<?= $s->id ?>"><?= $s->clave . ' - ' . $s->nombre ?> </option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                            <div class='col-md-4 col-12'>
                                <div class='row'>
                                    <div class='col-md-6 col-12'>
                                        <label for="idEmpaque" class="form-label">Empaque</label>
                                        <select name="idEmpaque" class="form-select" id="idEmpaque">
                                            <option value="" selected>--Selecciona--</option>
                                            <option value="">N/A</option>
                                            <?php
                                                if (!empty($tiposEmpaques)):
                                                    foreach ($tiposEmpaques as $tp):
                                            ?>
                                            <option value="<?= $tp->id ?>"><?= $tp->nombre ?> </option>
                                            <?php
                                                    endforeach;
                                                endif;
                                                                                            ?>
                                        </select>
                                    </div>
                                    <div class='col-md-6 col-12'>
                                        <div class='row'>
                                            <label for="insumo_por" class="form-label">Insumo por</label>
                                        </div>
                                        <div class='row' style="font-size: 0.9rem; margin-top: 0.5rem;">
                                            <div class='col-12'>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="insumo_por" id="insumo_por_0" value="0">
                                                    <label class="form-check-label" for="insumo_por_0">LEADER</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="insumo_por" id="insumo_por_1" value="1">
                                                    <label class="form-check-label" for="insumo_por_1">Cliente</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class='col-md-2 col-12'>
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="cantidad" id="cantidad" class="form-control numhtml" />
                                    <span class="input-group-text">kgs.</span>
                                </div>

                                <span id="disponible" style="font-size: xx-small;margin-right: 10%;position: absolute;margin-top: 2%;" hidden>
                                    Disponible :
                                    <?php
                                        if (isset($pesaje) && ($pesaje['EntPesoT'] > 0)) {
                                            echo UtilsHelp::numero2Decimales((intval(Utils::quitarComas($pesoNeto)) - intval(Utils::quitarComas($ensacado['totalensacado']))), true, 0);
                                        } else {
                                            echo UtilsHelp::numero2Decimales(($ensacado['peso_cliente'] - $ensacado['totalensacado']), true, 0);
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class='col-md-2 col-12'>
                                <label for="orden" class="form-label">Orden</label>
                                <div class="input-group ">
                                    <input type="text" name="orden" id="orden" class="form-control" value="<?= isset($ensacado) && isset($ensacado['doc_orden']) ? $ensacado['doc_orden'] : ''; ?>" />
                                    <span class="input-group-text igt-r  inputFile" id="addDocumento" title="Agregar orden" for="documentoOrden_e">
                                        <!-- <label id="addDocumento" title="Agregar orden" for="documentoOrden_e" class="inputFile mb-1"> -->
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <!-- </label> -->
                                    </span>
                                    <input id="documentoOrden_e" <?php ROFinaliza($ensacado['estatus_id']) ?>name="documentoOrden_e" type="file" hidden />
                                    <input type="hidden" id="archivoOrden_e" name="archivoOrden_e">
                                    <i id="show" class="input-group-text i-pdf material-icons fa-solid fa-file-pdf" title="Ver Bill of lading" hidden></i>
                                    <i id="delete" class="input-group-text far i-delete material-icons fa-trash-alt" <?= (Utils::permisosLogistica()) ? '' : 'disabled' ?> hidden></i>
                                </div>
                            </div>

                        </div>
                        <div class='row'>
                            <div class='col-xl-8 col-12'>
                                <label for="lote" class="form-label">Lote</label>
                                <select name="lote" id="loteSelect" class="form-select loteSelect" hidden>
                                    <option>--Selecciona--</option>
                                </select>
                                <input type="text" name="lote" id="lote" class="form-control" hidden />

                            </div>
                            <div class='col-xl-2 col-12'>
                                <label for="existencia" class="form-label">Existencia</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="existencia" id="existencia" class="form-control numhtml" readonly disabled />
                                    <span class="input-group-text">kgs.</span>
                                </div>
                            </div>
                            <div class='col-xl-3 col-12 div_producto'>
                                <label for="producto" class="form-label">Producto</label>
                                <select name="producto" class="form-select" id="producto" style="">
                                    <option value="" selected>--Selecciona--</option>
                                    <option value="nuevo"> >>Nuevo Producto<< </option>
                                            <?php
                                                if (!empty($productos)):
                                                    foreach ($productos as $p):
                                            ?>
                                    <option value="<?= $p->id ?>"><?= $p->nombre ?> </option>
                                    <?php
                                                    endforeach;
                                                endif;
                                                                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row div-form" hidden>
                            <div class='col-12'>
                                <label for="alias" class="form-label">Rótulo</label>
                                <input type="text" name="alias" id="alias" class="form-control" />
                            </div>
                        </div>

                        <div class="row div-form" hidden>
                            <div class='col-md-4 col-12'>
                                <label for="fechaPrograma" class="form-label">Fecha programación</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="fechaPrograma" id="fechaPrograma" class="form-control fechaPrograma" readonly>
                                </div>
                            </div>
                            <div class='col-md-2 col-12'>
                                <label for="tipoTarima" class="form-label">Tipo Tarima</label>
                                <select name="tipoTarima" class="form-select" id="tipoTarima">
                                    <option value="">-Selecciona-</option>
                                    <?php
                                        foreach (tipo_tarimas as $i => $m):
                                    ?>
                                    <option value="<?= $i ?>"><?= $m ?></option>
                                    <?php
                                        endforeach;
                                                                            ?>
                                </select>
                            </div>
                            <div class='col-md-2 col-12'>
                                <label for="sacoxtarima" class="form-label">Sacos X Tarima</label>
                                <input type="number" name="sacoxtarima" id="sacoxtarima" class="form-control numhtml" />

                            </div>
                            <div class='col-md-4 col-12'>
                                <div class='row'>
                                    <label for="tarima_por" class="form-label">Tarimas por</label>
                                </div>
                                <div class='row' style="font-size: 0.9rem; margin-top: 0.5rem;">
                                    <div class='col-12'>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tarima_por" id="tarima_por_0" value="0">
                                            <label class="form-check-label" for="tarima_por_0">LEADER</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tarima_por" id="tarima_por_1" value="1">
                                            <label class="form-check-label" for="tarima_por_1">Cliente</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between mb-2 calctarimas">
                                <div class="col">
                                    <strong class="mr-1 ">Bultos:</strong>
                                    <input type="text" name="bultos" id="bultos" class="form-control " readonly disabled />
                                </div>
                                <div class="col">
                                    <strong class="mr-1 ">Tarimas:</strong>
                                    <input type="text" name="tarimas" id="tarimas" class="form-control " readonly disabled />
                                </div>
                                <div class="col">
                                    <strong class="mr-1 ">Parcial:</strong>
                                    <input type="text" name="parcial" id="parcial" class="form-control " readonly disabled />
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between mb-2">
                                <div>
                                    <strong class="mr-1">Observaciones:</strong>
                                    <input type="text" name="observaciones" class="form-control" style="width:100%;" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class=" border-modal modal-footer text-center">
                        <button type="button" class="btn btn-funcion1 btn-danger" data-bs-dismiss="modal"><span class="material-icons pr-2">close</span><span>Cancelar</span></button>
                        <button class="btn btn-funcion1 btn-success" id="btnEditarServicio"><span class="material-icons pr-2">save</span><span>Guardar</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal enviar a almacen -->
    <div class="modal fade" id="enviarAlmacenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Enviar a almacen y finalizar servicio:</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="pr-2 pl-2" id="formEnviarAlmacen">
                        <div>
                            <input type="hidden" id="idServicioEnviar" name="idServicioEnviar" />
                            <input type="hidden" id="operacionEnviar" name="operacionEnviar" />
                        </div>
                        <div class=" " id="divAlmacenes">
                            <div class='row'>
                                <div class='col-md-6 col-12'>
                                    <label for="selectAlmacen" class="pt-1 pr-1"><strong>Almacen:</strong></label>
                                    <select class="item-medium form-control mt-4" name="almacen[]" id="selectAlmacen" required>
                                        <option value="">-Selecciona</option>
                                    </select>
                                </div>
                                <div class='col-md-6 col-12'>
                                    <label for="cantidadTotal" class="pt-1 pr-1"><strong>Cantidad Cliente:</strong></label>
                                    <div class="input-group mt-4">
                                        <input type="text" name="cantidadTotal[]" class="item-small form-control numhtml" id="cantidadCliente" readonly required />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-12'>
                                    <div class='row'>
                                        <div class='col-md-4 col-12'>
                                            <label for="cantidadEnviar" class="pt-1 pr-1"><strong>Cantidad Total:</strong></label>
                                            <div class="input-group mt-4">
                                                <input type="text" name="cantidadAlmacen[]" class="item-small form-control numhtml convertilbs" id="cantidadEnviar" readonly required />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Kg.</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class='col-md-4 col-12'>
                                            <label for="cantidadTarimas" class="pt-1 pr-1"><strong>Cantidad</strong></label>
                                            <div class="input-group mt-4">
                                                <input type="text" name="cantidadTarimas[]" class="item-small form-control numhtml" id="cantidadTarimas" required />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tarimas</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class='col-md-4 col-12'>
                                            <label for="cantidadSacos" class="pt-1 pr-1"><strong>Ensacado:</strong></label>
                                            <div class="input-group mt-4">
                                                <input type="text" name="cantidadSacos[]" class="item-small form-control numhtml" id="cantidadSacos" required />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Sacos</div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-4 col-12'>
                                            <div class="input-group mt-4">
                                                <input type="text" class="item-small form-control numhtml convertilbs" id="cantidadLBS1" readonly />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Lbs.</div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class='row'>
                                <div class='col-md-6 col-12'>
                                    <label for="BarreduraSucia" class="pt-1 pr-1"><strong>Barredura sucia:</strong></label>
                                    <div class="input-group">
                                        <input type="text" name="BarreduraSucia[]" class="item-small form-control numhtml" id="BarreduraSucia" required />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg.</div>
                                        </div>

                                    </div>
                                </div>
                                <div class='col-md-6 col-12'>
                                    <label for="BarreduraLimpia" class="pt-1 pr-1"><strong>Barredura limpia:</strong></label>
                                    <div class="input-group">
                                        <input type="text" name="BarreduraLimpia[]" class="item-small form-control numhtml" id="BarreduraLimpia" required />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg.</div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">

                    <div><button id="agregarAlmacen" type="button" class="btn-azul folio p-1">Agregar almacén</button></div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="enviarFinalizarServicio">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>