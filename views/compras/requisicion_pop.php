<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= (isset($_SESSION['title'])) ? $_SESSION['title'] : '' ?> | LEAGroup ERP <?php echo (AMBIENTE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="LEAGroup ERP" name="description" />
    <meta content="LEA" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo URL; ?>assets/images/favicon.ico">

    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-confirm.css">
    <script src="<?php echo URL; ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/popper.min.js"></script>
    <!-- Bootstrap -->
    <link href="<?php echo URL; ?>assets/libs/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-ui/jquery-ui.min.css">
    <!-- FontAwesome -->
    <link href="<?php echo URL; ?>assets/master/css/fontawesome/css/all.min.css" rel="stylesheet">
    <!-- MaterialIcons -->
    <link href="<?php echo URL; ?>assets/master/css/material-icons/material-icons.css" rel="stylesheet">
    <!-- SweetAlert -->
    <link href="<?php echo URL; ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>assets/libs/sweetalert2/animate.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo URL; ?>assets/libs/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>assets/libs/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo URL; ?>assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php echo URL; ?>assets/fonts/fontawesome/css/all.min.css">

    <?php
        include 'assets/js/requisicion_js.php';
    ?>


    <!-- JS App -->
    <script src="<?php echo URL; ?>assets/js/jquery.js"></script>
    <script src="<?php echo URL; ?>assets/js/funciones.js"></script>

    <!-- Moment -->
    <script src="<?php echo URL; ?>assets/js/moment.js"></script>
    <script src="<?php echo URL; ?>assets/js/jquery-confirm.js"></script>

    <!-- Jquery UI -->
    <script src="<?php echo URL; ?>assets/libs/jquery-ui/jquery-ui.js"></script>

    <!-- <script src="<?php echo URL; ?>assets/js/jquery.js"></script> -->

    <!-- Bootstrap -->
    <script src="<?php echo URL; ?>assets/libs/bootstrap5/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>assets/vendor/moment.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="<?php echo URL; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo URL; ?>assets/libs/select2/js/select2.min.js"></script>

    <!-- DataTables -->
    <script src="<?php echo URL; ?>assets/libs/datatables/datatables.js"></script>

    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/style.css">

    <style>

    </style>
    <script>
    var rowedit;
    $(document).ready(function() {
        setTimeout(() => {
            $(".form-select").select2({
                theme: 'bootstrap-5'
            });

        }, 100);
        $(".datepick").datepicker();


    });
    </script>

</head>

<body style="width: 97%;margin: auto;">
    <div class='row' style="margin-left: 5%;">
        <div class='col-md-11 col-12'>

            <div class='row'>
                <div class='col-12' style="text-align:center;">
                    <h1>REQUISICIÓN DE MATERIALES Y/O SERVICIOS</h1>
                    <?php if (isset($req)): ?>
                    <span class="mr-5">Folio:<?= $req['folio'] ?> </span>
                    <?php else: ?>
                    <div></div>
                    <?php endif; ?>


                </div>
            </div>
            <div class='row'>
                <div class='col'>
                    <form id="formRequisicion" action="<?= root_url ?>?controller=Compras&action=generarRequisicion" method="POST" enctype="multipart/form-data">
                        <!-- GENERALES -->
                        <fieldset>
                            <legend>Datos generales</legend>

                            <div class='row'>
                                <div class="mb-3 col">
                                    <label for="empresa" class="form-label">Empresa</label>
                                    <!-- <input type="text" id="empresa" name="empresa" class="form-control" placeholder="Empresa" value=""> -->
                                    <select name="empresa" class="form-select" id="empresaReq">
                                        <option value="">Selecciona</option>
                                        <?php
                                            foreach (empresas as $i => $e):
                                        ?>
                                        <option value="<?= $i ?>" <?= isset($req) && $i == $req['empresa'] ? 'selected' : ''; ?>><?= $e['clave'] ?></option>
                                        <?php
                                            endforeach;
                                                                                    ?>
                                    </select>
                                </div>
                                <div class="mb-3 col">
                                    <label for="solicitud" class="form-label">Solicitud</label>
                                    <!-- <input type="text" id="solicitud" name="solicitud" class="form-control" placeholder="Solicitud" value=""> -->
                                    <select name="solicitud" id="solicitud" class="form-select">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                            if (!empty($solicitudes)):
                                                foreach ($solicitudes as $s):
                                        ?>
                                        <option value="<?= $s->id ?>" <?= isset($req) && $s->id == $req['solicitud_id'] ? 'selected' : ''; ?>><?= $s->tipo ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                                <div class="mb-3 col">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <select name="proveedor" class="form-select" id="proveedor">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                            if (!empty($proveedores)):
                                                foreach ($proveedores as $p):
                                        ?>
                                        <option value="<?= $p->id ?>" <?= isset($req) && $p->id == $req['proveedor_id'] ? 'selected' : ''; ?>><?= $p->nombre ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                                <div class='mb-3 col'>
                                    <label for="fechaSolicitud" class="form-label">Fecha solicitud</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="fechaSolicitud_pop" name="fechaSolicitud" class="form-control datepick" placeholder="Fecha solicitud"
                                            value="<?= isset($req) ? date('d/m/Y', strtotime($req['fecha_solicitud'])) : '' ?>" readOnly>
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='mb-3 col'>
                                    <input type='hidden' name="idUsuario" value="<?= isset($req) ? $req['usuario_id'] : $_SESSION['usuario']->id ?>" />
                                    <label for="usuario" class="form-label">Asignado a:</label>
                                    <input type='text' name="usuario" id="usuario" value="<?= isset($req) ? $req['usuario'] : $_SESSION['usuario']->nombres . ' ' . $_SESSION['usuario']->apellidos ?>"
                                        class="form-control big" disabled readOnly />
                                </div>
                                <div class='mb-3 col'>
                                    <label for="departamento" class="form-label">Departamento:</label>
                                    <input type='text' name="departamento" id="departamento" value="<?= isset($req) ? $req['departamento'] : $user->departamento ?>" class="form-control medium" disabled readOnly />
                                    <button class="btn-ruta" id="descRuta" hidden><i class="pr-1 fas fa-road"></i>Ruta</button>
                                    <?php
                                        if (Utils::permisosCompras()):
                                    ?>
                                    <button class="btn-ruta" id="descProducto" hidden><i class="pr-1 fas fa-flask"></i>Producto</button>
                                    <?php endif; ?>
                                </div>
                                <div class='mb-3 col'>
                                    <label for="fecha_requerida" class="form-label">Fecha requerida:</label>
                                    <div class="input-group mb-3">
                                        <input type='text' id="fechaRequerida_pop" name="fechaRequerida" value="<?= isset($req) ? date('d/m/Y', strtotime($req['fecha_requerida'])) : '' ?>"
                                            class="form-control datepick small" readOnly />
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <!-- <div class="d-flex justify-content-between"> -->
                                <div class="mb-3 col-2">
                                    <label class="form-label" for="urgente" id="urgente">Compra urgente:</label>
                                    <div>
                                        <input class="ml-1" type="radio" id="s" name="urgente" value="S" <?= isset($req) && $req['urgente'] == 'S' ? 'checked' : '' ?> /> <label for="S">Si</label>
                                        <input class="ml-2" type="radio" id="n" name="urgente" value="N" <?= isset($req) && $req['urgente'] == 'N' ? 'checked' : '' ?> /> <label for="N">No</label>
                                    </div>
                                </div>
                                <div class="mb-3 col">
                                    <label class="form-label" id="proyecto" for="proyecto">Proyecto:</label>
                                    <input name="proyecto" id="proyectoEntregar" class="form-control " autocomplete="off" value="<?= isset($req) ? $req['num_proyecto'] : '' ?>" type="text" />
                                </div>
                                <div class="mb-3 col">
                                    <label class="form-label" id="descProyecto" for="descProyecto">Nombre proyecto:</label>
                                    <input name="descProyecto" id="proyectoDomicilio" class="form-control " value="<?= isset($req) ? $req['proyecto'] : '' ?>" type="text" />
                                </div>
                                <div class="mb-3 col-2">
                                    <label class="form-label">Moneda</label>
                                    <select class="form-select s-small" name="moneda">
                                        <option value="">--</option>
                                        <?php
                                            foreach (monedas as $i => $m):
                                        ?>
                                        <option value="<?= $i ?>" <?= isset($req) && $req['moneda'] == $i ? 'selected' : '' ?>><?= $m['clave'] ?></option>
                                        <?php
                                            endforeach;
                                                                                    ?>
                                    </select>
                                </div>
                                <!-- </div> -->
                            </div>

                        </fieldset>

                        <!-- DETALLES -->
                        <fieldset>
                            <legend>Detalles <i class="fa-solid fa-circle-plus agregaPop" data-bs-toggle="modal" data-bs-target="#modal_add"></i></legend>
                            <input type="hidden" id="numDetalles" value="<?php if (isset($req)) { echo count($req['detalle']); } ?>">
                            <div class='row'>
                                <div class='col-9'>
                                    <table id="tabla_detalle" class='table table-striped' style='width:100%'>
                                        <thead>
                                            <th>Descripción del material, equipo o servicio</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Precio unitario</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if (isset($req)) {
                                                    $nD = 1;
                                                    foreach ($req['detalle'] as $d):
                                                        $unidad = '';
                                                        foreach ($unidades as $uni):
                                                            if ($uni->id == $d['unidad_id']) {
                                                                $unidad = $uni->nombre;
                                                                break;
                                                            }
                                                        endforeach;
                                                        echo '  <tr id="detalle_' . $nD . '" data-iddetalle="' . $d['id'] . '">
                                                                <td class="det_descripcion">' . $d['descripcion'] . '</td>
                                                                <td class="det_unidad">' . $unidad . '</td>
                                                                <td class="det_cantidad">' . UtilsHelp::numero2Decimales($d['cantidad'], false) . '</td>
                                                                <td class="det_precio_unitario">' . UtilsHelp::numero2Decimales($d['precio_unitario'], true) . '</td>
                                                                <td>
                                                                    <div>
                                                                        <a id="edit"><span class="material-icons i-edit">edit</span></a>
                                                                        <a id="save" hidden><span class="material-icons i-save">save</span></a>
                                                                        <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        ';

                                                        $nD++;
                                                    endforeach;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class='col-md-3 col-12 d-flex flex-column'>
                                    <div>
                                        <label from="observaciones" class="form-label"><strong>Observaciones/comentarios:</strong></label>
                                        <!-- <textarea name="observaciones" class="form-control flex-grow-1"><?= isset($req) ? $req['observaciones'] : '' ?></textarea> -->
                                        <div name="observaciones" id="observaciones" class="divtext form-control" contentEditable><?= isset($req) ? $req['observaciones'] : '' ?></div>
                                    </div>
                                </div>

                            </div>
                            <br />
                            <div class='row'>
                                <div class='col-12'>
                                    <div class="d-flex justify-content-center">
                                        <div class="w-50 d-flex flex-column"><label>Agregar cotización:</label>
                                            <label for="documento" class="px-2 inputFile"><i class="fas fa-cloud-upload-alt"></i>Agregar cotización</label>
                                            <input id="documento" onchange="cambiarInputFile('documento', 'spanDocumento')" name="documento" value="" type="file" hidden />
                                            <span id="spanDocumento"><?= (isset($req) && $req['cotizacion'] != null) ? $req['cotizacion'] : '' ?></span>
                                        </div>
                                        <div id="deleteCot" class="align-self-end ">
                                            <span id="deleteCotizacion" class="far i-delete material-icons fa-trash-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br />
                        <!-- OCULTOS -->
                        <input type='hidden' name="id" id="id" value="<?= isset($req) ? $req['id'] : '' ?>" />
                        <input type='hidden' name="idRuta" id="idRuta" value="<?= isset($req) ? $req['ruta_id'] : '' ?>" />
                        <input type='hidden' name="idCliente" id="idCliente" value="<?= isset($req) ? $req['cliente_id'] : '' ?>" />
                        <input type='hidden' name="idProducto" id="idProducto" value="<?= isset($req) ? $req['producto_id'] : '' ?>" />
                        <input type='hidden' name="idTransporte" id="idTransporte" value="<?= isset($req) ? $req['transporte_id'] : '' ?>" />
                        <input type='hidden' name="cantidadFlete" id="cantidadFlete" value="<?= isset($req) ? $req['cantidad_flete'] : '' ?>" />
                        <input type='hidden' name="idEstatus" id="idEstatus" value="<?= isset($req) ? $req['estatus_id'] : '' ?>" />
                        <input type='hidden' name="flete" id="flete" value="<?= isset($req) ? $req['flete'] : '' ?>" />
                        <input type='hidden' name="folio" id="folio" value="<?= isset($req) ? $req['folio'] : '' ?>" />
                        <input type='hidden' name="folioOc" id="folioOc" value="<?= isset($req) ? $req['folio_oc'] : '' ?>" />
                        <input type='hidden' name="idAduana" id="idAduana" value="<?= isset($req) ? $req['aduana_id'] : '' ?>" />

                        <!-- BOTON GUARDAR -->
                        <div class="div-btn-gen">
                            <input class="btn btn-primary" id="btnGenerar" type="submit" value="<?= isset($req) ? 'Editar' : 'Generar' ?>" />
                        </div>

                    </form>
                    <br />
                    <br />
                </div>
            </div>

        </div>
    </div>


    <div class="modal" id="modal_add" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar detalle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='row'>
                        <div class='col'>
                            <label for="descripcion" class="form-label">Descripcion:</label>
                            <input class="form-control" type="text" name="descripcion" id="descripcion" />
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <label for="unidad" class="form-label">Unidad:</label>
                            <select class="form-select" name="unidad" id="unidad">
                                <option value="" selected disabled>Selecciona</option>
                                <?php
                                    if (!empty($unidades)):
                                        foreach ($unidades as $uni):
                                            echo '<option value="' . $uni->id . '">' . $uni->nombre . '</option>';
                                        endforeach;
                                    endif;
                                ?>
                            </select>

                        </div>
                        <div class='col'>
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input class="form-control" type="number" step="0.01" name="cantidad" pattern="^\d*(\.\d{0,2})" id="cantidad" />
                        </div>
                        <div class='col'>
                            <label for="pre_unitario" class="form-label">Precio Unitario:</label>
                            <input class="form-control" type="number" step="0.01" name="pre_unitario" pattern="^\d*(\.\d{0,2})?$" id="pre_unitario" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnAgregaDetalle">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_add1" hidden>


        <br />
    </div>
</body>

</html>