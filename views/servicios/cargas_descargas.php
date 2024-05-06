<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css"> -->
    <link href="<?php echo URL; ?>assets/libs/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/servicios/assets/css/servicios.css" />
    <link rel="stylesheet" href="<?= root_url ?>assets/libs/select2/css/select2.min.css" type="text/css">
    <link href="<?php echo URL; ?>assets/libs/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>

    <!-- <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> -->
    <script src="<?php echo URL; ?>assets/libs/bootstrap5/js/bootstrap.min.js"></script>
    <script src="<?= root_url ?>assets/libs/select2/js/select2.min.js"></script>
    <!-- Toastr -->
    <link href="<?php echo URL; ?>assets/libs/toastr/toastr.min.css" rel="stylesheet">
    <script src="<?php echo URL; ?>assets/libs/toastr/toastr.min.js"></script>
    <script src="<?= root_url ?>assets/js/sweetalert/sweetalert2.all.min.js"></script>

    <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>

    <title>Ensacado</title>
    <style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000 !important;
        background-color: #cfd7e9 !important;
    }

    .select2-container {
        z-index: 100000 !important;
    }

    #observaciones {
        width: 93vw;
    }
    </style>
</head>

<body>
    <div class="contenedor h-25" id="contenedor">
        <header class='d-flex'>
            <div>
                <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" />
            </div>
            <div class="text-center w-75 mt-3">
                <h4>ENTRADAS Y SALIDAS</h4>
            </div>
            <div class="d-flex pt-3">
                <div><button class="boton" id="btnGuardar" title="Guardar"><span class="material-icons btn-icon i-save">save</span></button></div>
                <div><button class="boton" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button></div>
            </div>
        </header>
        <section id="sectionForm">
            <form id="ensacadoForm" enctype="multipart/form-data">
                <div class="div-datos pb-2">
                    <span class="titulo-div">Registro de unidades</span>
                    <div class="datoss mt-2 mb-1" style="padding: 10px;">
                        <div class='row'>
                            <div class='col-6'>
                                <div id="divRadios" class="div-radios">
                                    <div class='row'>
                                        <div class='col-12 mb-3'>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <strong for="ferrotolva">Tren:</strong>
                                                </div>
                                                <div class='col-6'>
                                                    <strong for="ferrotolvas">Camión:</strong>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <input class="ml-1 mr-3" id="ferrotolva" type="radio" name="ferrotolva" value="F" />
                                                </div>
                                                <div class='col-6'>
                                                    <input class="ml-1" type="radio" name="ferrotolva" value="A" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6'>
                                <div id="divRadios" class="div-radios">
                                    <div class='row'>
                                        <div class='col-12 mb-3'>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <strong for="entrada_salida">Entrada:</strong>
                                                </div>
                                                <div class='col-6'>
                                                    <strong for="entrada_salida">Salida:</strong>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <input class="ml-1 mr-3" id="entrada_salida" type="radio" name="entrada_salida" value="0" />
                                                </div>
                                                <div class='col-6'>
                                                    <input class="ml-1" type="radio" name="entrada_salida" value="1" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-4' hidden>
                                <div>
                                    <label for="empresa" class="form-label"><strong># Empresa:</strong></label>
                                    <select name="empresa" class="item-big" id="empresa">
                                        <option value="" selected>--Selecciona--</option>
                                        <?php
                                            if (!empty(empresas)):
                                                foreach (empresas as $cli):
                                        ?>
                                        <option data-cli="<?= $cli ?>" value="<?= $cli['id'] ?>"><?= $cli['nombre'] ?> </option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class='row mt-2'>
                            <div class='col-4'>
                                <div>
                                    <label for="numeroUnidad" class="form-label"><strong># Placa Tractor:</strong></label>
                                    <input type="text" id="numeroUnidad" name="numeroUnidad" class="form-control" />
                                    <p><span class="emsg hidden">Número de UNIDAD no Válido (ABCD123456)</span></p>
                                </div>

                            </div>
                            <div class='col-8'>
                                <div>
                                    <label for="cliente" class="form-label"><strong># Cliente:</strong></label>
                                    <select name="cliente" class="form-select" id="cliente">
                                        <option value="" selected>--Selecciona--</option>
                                        <?php
                                            if (!empty($clientes)):
                                                foreach ($clientes as $cli):
                                        ?>
                                        <option value="<?= $cli->id ?>"><?= $cli->nombre ?> </option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class='row mt-2' id="seccionCamion" hidden>
                            <div class="col-4">
                                <label for="pesoCliente" class="form-label"><strong class="mr-1">Peso Cliente:</strong></label>
                                <input id="pesoCliente" name="pesoCliente" class="form-control " type="text" />
                            </div>
                            <div class="col" style="display:none">
                                <label for="div-radiosT" class="form-label"><strong class="mr-1">Transporte por:</strong></label>
                                <div id="divRadiosT" class="div-radiosT">
                                    <div class='row'>
                                        <div class='col'>
                                            <strong for="transp_lea_cliente">LEA:</strong>
                                        </div>
                                        <div class='col'>
                                            <input class="ml-1 mr-3" id="transp_lea_cliente" type="radio" name="transp_lea_cliente" value="0" />

                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>
                                            <strong for="transp_lea_clientec">Cliente:</strong>

                                        </div>
                                        <div class='col'>
                                            <input class="ml-1" type="radio" id="transp_lea_clientec" name="transp_lea_cliente" value="1" />

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-4">
                                <label for="transportista" class="form-label"><strong class="mr-1">Transportista:</strong></label>
                                <!-- <input id="transportista" class="item-big" type="text" /> -->
                                <select name="transportista" class="form-select" id="transportista">
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                        if (!empty($cat_transportistas)):
                                            foreach ($cat_transportistas as $t):
                                    ?>
                                    <option value="<?= $t->id ?>"><?= $t->nombre ?> </option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="chofer" class="form-label"><strong class="mr-1">Chofer:</strong></label>
                                <!-- <input class="item-big" id="chofer" name="chofer" type="text" /> -->
                                <select name="chofer" class="form-select" id="chofer">
                                    <option value="" selected>--Selecciona--</option>
                                </select>
                            </div>
                            <!-- </div> -->
                            <!-- <div class='row' id="seccionCamion" hidden> -->
                            <div class="col-2 mt-4">
                                <label for="transporte" class="form-label"><strong class="mr-1">Tipo de Unidad:</strong></label>
                                <select name="transporte" class="form-select" id="transporte">
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                        if (!empty($transportes)):
                                            foreach ($transportes as $t):
                                    ?>
                                    <option value="<?= $t->id ?>" data-puertas="<?= $t->puertas ?>" data-cap_max="<?= $t->cap_maxima ?>"><?= $t->nombre ?> </option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                            <div class="col-1">
                                <label for="cant_puertas" class="form-label"><strong class="mr-1">Cant. Puertas:</strong></label>
                                <input id="cant_puertas" name="cant_puertas" class="form-control" type="number" />
                            </div>
                            <div class="col-2">
                                <label for="divRadiosT" class="form-label"><strong class="mr-1">Producto:</strong></label>
                                <div id="divRadiosT" class="div-radiosT">
                                    <div class='row'>
                                        <div class='col'>
                                            <strong for="tipo_producto">Polietileno:</strong>
                                        </div>
                                        <div class='col'>
                                            <input class="ml-1 mr-3" id="tipo_producto" type="radio" name="tipo_producto" value="0" />
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>
                                            <strong for="tipo_productoL">Lubricante:</strong>
                                        </div>
                                        <div class='col'>
                                            <input class="ml-1" type="radio" id="tipo_productoL" name="tipo_producto" value="1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 mt-4">
                                <label for="placa1" class="form-label"><strong class="mr-1">Placa Caja/Tanque #1:</strong></label>
                                <input name="placa1" class="form-control" id="placa1" type="text" />
                            </div>
                            <div class="col-2 mt-4">
                                <label for="placa2" class="form-label"><strong class="mr-1">Placa Caja/Tanque #2:</strong></label>
                                <input name="placa2" class="form-control" id="placa2" type="text" />
                            </div>
                        </div>
                        <div class='row mt-2' id="seccionFerrotolva" hidden>
                            <div class='col'>
                                <div>
                                    <label for="transportistaTren" class="form-label"><strong class="mr-1">Transportista:</strong></label>
                                    <input id="transportistaTren" class="form-control" type="text" />
                                </div>

                            </div>
                            <div class='col'>
                                <div>

                                    <label for="transporteTren" class="form-label"><strong class="mr-1">Tipo de Unidad:</strong></label>
                                    <select class="form-select" id="transporteTren">
                                        <option value="" selected>--Selecciona--</option>
                                        <?php
                                            if (!empty($transportes)):
                                                foreach ($transportes as $t):
                                        ?>
                                        <option value="<?= $t->id ?>"><?= $t->nombre ?> </option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class='row'>
                            <div class='col-12'>
                                <div><label for="observaciones" class="form-label"><strong class="mr-1">Observaciones:</strong></label><input name="observaciones" class="form-control" id="observaciones" type="text" /></div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>

</html>