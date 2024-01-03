<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/servicios/assets/css/servicios.css" />
    <link rel="stylesheet" href="<?= root_url ?>assets/libs/select2/css/select2.min.css" type="text/css">
    <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>
    <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?= root_url ?>assets/libs/select2/js/select2.min.js"></script>
    <title>Ensacado</title>
    <style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000 !important;
        background-color: #cfd7e9 !important;
    }

    .select2-container {
        z-index: 100000 !important;
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
                    <div class="datos mt-2 mb-1">
                        <div id="divRadios" class="div-radios">
                            <strong for="ferrotolva">Tren:</strong>
                            <input class="ml-1 mr-3" id="ferrotolva" type="radio" name="ferrotolva" value="F" />
                            <strong for="ferrotolvas">Camión:</strong>
                            <input class="ml-1" type="radio" name="ferrotolva" value="A" />
                        </div>
                        <div id="divRadios" class="div-radios">
                            <strong for="entrada_salida">Entrada:</strong>
                            <input class="ml-1 mr-3" id="entrada_salida" type="radio" name="entrada_salida" value="0" />
                            <strong for="entrada_salida">Salida:</strong>
                            <input class="ml-1" type="radio" name="entrada_salida" value="1" />
                        </div>

                        <div>
                            <strong class="mr-1"># Unidad:</strong>
                            <input type="text" id="numeroUnidad" name="numeroUnidad" class="item-small" />
                        </div>

                        <div><strong class="mr-1">Cliente:</strong>
                            <select name="cliente" class="item-big" id="cliente">
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
                    <section id="seccionCamion" hidden>
                        <div class="datos mt-2 mb-1">
                            <div>
                                <strong class="mr-1">Peso Cliente:</strong>
                                <input id="pesoCliente" name="pesoCliente" class="item-small " type="text" />
                            </div>
                            <div style="display:none">
                                <strong class="mr-1">Transporte por:</strong>
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
                            <div>
                                <strong class="mr-1">Transportista:</strong>
                                <!-- <input id="transportista" class="item-big" type="text" /> -->
                                <select name="transportista" class="item-big" id="transportista">
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
                            <div>
                                <strong class="mr-1">Chofer:</strong>
                                <!-- <input class="item-big" id="chofer" name="chofer" type="text" /> -->
                                <select name="chofer" class="item-big" id="chofer">
                                    <option value="" selected>--Selecciona--</option>
                                </select>
                            </div>
                        </div>
                        <div class="datos mt-2 mb-1">
                            <div>
                                <strong class="mr-1">Transporte:</strong>
                                <select name="transporte" class="item-medium" id="transporte">
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
                            <div>
                                <strong class="mr-1">Cant. Puertas:</strong>
                                <input id="cant_puertas" name="cant_puertas" class="item-small" type="number" />
                            </div>
                            <div>
                                <strong class="mr-1">Producto:</strong>
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

                            <div>
                                <strong class="mr-1">Placa tractor #1:</strong>
                                <input name="placa1" class="item-small" id="placa1" type="text" />
                            </div>
                            <div>
                                <strong class="mr-1">Placa tractor #2:</strong>
                                <input name="placa2" class="item-small" id="placa2" type="text" />
                            </div>
                        </div>
                    </section>
                    <section id="seccionFerrotolva" hidden>
                        <div class="datos mt-2 mb-1">
                            <div><strong class="mr-1">Transportista:</strong><input id="transportistaTren" class="item-big" type="text" /></div>
                            <div><strong class="mr-1">Transporte:</strong>
                                <select class="item-medium" id="transporteTren">
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
                    </section>
                    <div class="datos mt-2 mb-1">
                        <div><strong class="mr-1">Observaciones:</strong><input name="observaciones" class="item-bigger" id="observaciones" type="text" /></div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>

</html>