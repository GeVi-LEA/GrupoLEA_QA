<header class="titulo d-flex justify-content-between align-items-center">
    <div><a href="<?= principalUrl ?>?controller=Compras&action=requisiciones"><i class="material-icons i-list ml-3">list</i></a></div>
    <h1>REQUISICIÓN DE MATERIALES Y/O SERVICIOS</h1>
    <?php if (isset($req)): ?>
    <span class="mr-5">Folio:<?= $req['folio'] ?> </span>
    <?php else: ?>
    <div></div>
    <?php endif; ?>
</header>
<form id="formRequisicion" action="<?= root_url ?>?controller=Compras&action=generarRequisicion" method="POST" enctype="multipart/form-data">
    <section class="sec-datos" id="seccionDatos">
        <fieldset class="field-datos">
            <legend class="legend-datos">Datos generales:</legend>
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
            <div class="div-datos datos">
                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="empresa">Empresa:</label>
                            <select name="empresa" class="item-small" id="empresaReq">
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
                        <div>
                            <label for="solicitud">Solicitud:</label>
                            <select name="solicitud" id="solicitud" class="item-medium">
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
                    </div>
                    <div>
                        <label for="proveedor">Proveedor:</label>
                        <select name="proveedor" class="item-big" id="proveedor">
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
                    <div>
                        <label for="fechaSolicitud">Fecha solicitud:</label>
                        <input type='text' name="fechaSolicitud" value="<?= isset($req) ? date('d/m/Y', strtotime($req['fecha_solicitud'])) : '' ?>" id="fechaSolicitud" class="item-small" readOnly />
                    </div>
                </div>
                <div class="mb-1">
                    <div>
                        <input type='hidden' name="idUsuario" value="<?= isset($req) ? $req['usuario_id'] : $_SESSION['usuario']->id ?>" />
                        <label for="usuario">Asignado a:</label>
                        <input type='text' name="usuario" id="usuario" value="<?= isset($req) ? $req['usuario'] : $_SESSION['usuario']->nombres . ' ' . $_SESSION['usuario']->apellidos ?>" class="item-big" disabled
                            readOnly />
                    </div>
                    <div>
                        <label for="departamento">Departamento:</label>
                        <input type='text' name="departamento" id="departamento" value="<?= isset($req) ? $req['departamento'] : $user->departamento ?>" class="item-medium" disabled readOnly />
                        <button class="btn-ruta" id="descRuta" hidden><i class="pr-1 fas fa-road"></i>Ruta</button>
                        <?php
                            if (Utils::permisosCompras()):
                        ?>
                        <button class="btn-ruta" id="descProducto" hidden><i class="pr-1 fas fa-flask"></i>Producto</button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="fecha_requerida">Fecha requerida:</label>
                        <input type='text' name="fechaRequerida" value="<?= isset($req) ? date('d/m/Y', strtotime($req['fecha_requerida'])) : '' ?>" id="fechaRequerida" class="item-small" readOnly />
                    </div>
                </div>
                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex w-30">
                            <label for="urgente" id="urgente">Compra urgente:</label>
                            <div>
                                <input class="ml-1" type="radio" id="s" name="urgente" value="S" <?= isset($req) && $req['urgente'] == 'S' ? 'checked' : '' ?> /> <label for="S">Si</label>
                                <input class="ml-2" type="radio" id="n" name="urgente" value="N" <?= isset($req) && $req['urgente'] == 'N' ? 'checked' : '' ?> /> <label for="N">No</label>
                            </div>
                        </div>
                        <div>
                            <label id="proyecto" for="proyecto">Proyecto:</label>
                            <input name="proyecto" id="proyectoEntregar" class="item-small" value="<?= isset($req) ? $req['num_proyecto'] : '' ?>" type="text" />
                        </div>
                    </div>
                    <div>
                        <label id="descProyecto" for="descProyecto">Nombre proyecto:</label>
                        <input name="descProyecto" id="proyectoDomicilio" class="item-big" value="<?= isset($req) ? $req['proyecto'] : '' ?>" type="text" />
                    </div>
                    <div>
                        <label>Moneda</label>
                        <select class="item-s-small" name="moneda">
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
                </div>
        </fieldset>
        <div class="btn-slideUp">
            <a id="slideUp"><span class="material-icons i-slideUp" id="i-slideUp">vertical_align_top</span></a>
        </div>
        <fieldset class="field-datos" id="divEspecificacion">
            <legend class="legend-datos">Especificaciones:</legend>
            <div class="div-especificaciones datos">
                <div>
                    <label>Descripción:</label>
                    <input class="item-x-big" type="text" name="descEspecif" id="descEspecif" />
                </div>
                <div>
                    <label>Unidad:</label>
                    <select class="item-small" name="unidadEspecif" id="unidadEspecif">
                        <option value="" selected disabled>Selecciona</option>
                        <?php
                            if (!empty($unidades)):
                                foreach ($unidades as $uni):
                        ?>
                        <option value="<?= $uni->id ?>"><?= $uni->nombre; ?></option>
                        <?php
                                endforeach;
                            endif;
                                                    ?>
                    </select>
                </div>
                <div>
                    <label>Cantidad:</label>
                    <input class="item-small" type="text" min="0" name="cantEspecif" id="cantidadEsp" />
                </div>
                <div>
                    <label>Precio unitario:</label>
                    <input class="item-medium" type="text" min="0" name="precioEspecif" id="precioEspecif" />
                </div>
                <div>
                    <button class="btn-add" id="btnAgregar"><span class="material-icons i-add">add_circle</span></button>
                </div>
            </div>
        </fieldset>
    </section>
    <?php if (!isset($req) || count($req['detalle']) == 0): ?>
    <section class="sec-descripcion" id="seccionDescripcion">
        <div class="tabla-descripcion-titulos">
            <div>
                <label>Descripción del material, equipo o servicio</label>
            </div>
            <div>
                <label>Unidad</label>
            </div>
            <div>
                <label>Cantidad</label>
            </div>
            <div>
                <label>Precio unitario</label>
            </div>
        </div>
        <div class="tabla-descripcion" id="tablaDescripcion">
            <div>
                <input class="item-x-big" type="text" name="descripcion[1]" id="descripcion[1]" disabled />
            </div>
            <div>
                <select class="item-small" name="unidad[1]" id="unidad[1]" disabled>
                    <option value="" selected disabled>Selecciona</option>
                    <?php
                    if (!empty($unidades)):
                        foreach ($unidades as $uni):
                    ?>
                    <option value="<?= $uni->id ?>"><?= $uni->nombre; ?></option>
                    <?php
                        endforeach;
                    endif;
                                    ?>
                </select>
                </select>
            </div>
            <div>
                <input class="item-small" type="text" name="cantidad[1]" min="0" id="cantidad[1]" disabled />
            </div>
            <div>
                <input class="item-medium" type="text" name="precioUnitario[1]" min="0" id="precioUnitario[1]" disabled />
            </div>
            <input type="hidden" id="idDetalle[1]" name="idDetalle[1]" value="" />
            <div>
                <a id="edit"><span class="material-icons i-edit">edit</span></a>
                <a id="save" hidden><span class="material-icons i-save">save</span></a>
                <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
            </div>
        </div>
    </section>
    <?php else: ?>
    <input type="hidden" id="numDetalles" value="<?= count($req['detalle']) ?>">
    <section class="sec-descripcion" id="seccionDescripcion">
        <div class="tabla-descripcion-titulos">
            <div>
                <label>Descripción del material, equipo o servicio</label>
            </div>
            <div>
                <label>Unidad</label>
            </div>
            <div>
                <label>Cantidad</label>
            </div>
            <div>
                <label>Precio unitario</label>
            </div>
        </div>

        <?php
        $nD = 1;
        foreach ($req['detalle'] as $d):
        ?>
        <div class="tabla-descripcion" id="tablaDescripcion">
            <div>
                <input class="item-x-big" type="text" value="<?= $d['descripcion'] ?>" name="descripcion[<?= $nD ?>]" id="descripcion[<?= $nD ?>]" disabled />
            </div>
            <div>
                <select class="item-small" name="unidad[<?= $nD ?>]" id="unidad[<?= $nD ?>]" disabled>
                    <option value="" selected disabled>Selecciona</option>
                    <?php
                    if (!empty($unidades)):
                        foreach ($unidades as $uni):
                        ?>
                    <option value="<?= $uni->id ?>" <?= $uni->id == $d['unidad_id'] ? 'selected' : ''; ?>><?= $uni->nombre; ?></option>
                    <?php
                        endforeach;
                    endif;
                                ?>
                </select>
                </select>
            </div>
            <div>
                <input class="item-small" type="text" name="cantidad[<?= $nD ?>]" value="<?= UtilsHelp::numero2Decimales($d['cantidad'], false) ?>" id="cantidad[<?= $nD ?>]" disabled />
            </div>
            <div>
                <input class="item-medium" type="text" name="precioUnitario[<?= $nD ?>]" value="<?= UtilsHelp::numero2Decimales($d['precio_unitario'], true) ?>" min="0" id="precioUnitario[<?= $nD ?>]" disabled />
            </div>
            <input type="hidden" id="idDetalle[<?= $nD ?>]" name="idDetalle[<?= $nD ?>]" value="<?= $d['id'] ?>" />
            <div>
                <a id="edit"><span class="material-icons i-edit">edit</span></a>
                <a id="save" hidden><span class="material-icons i-save">save</span></a>
                <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
            </div>
        </div>
        <?php
            $nD++;
        endforeach;
            ?>
    </section>
    <?php endif ?>
    <section class="sec-comentarios" id="seccionComentarios">
        <div>
            <label>Observaciones/comentarios:</label>
            <textarea name="observaciones" class="textarea-comentarios"><?= isset($req) ? $req['observaciones'] : '' ?></textarea>
        </div>
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
        <div class="div-btn-gen"><input class="btn-generar" id="btnGenerar" type="submit" value="<?= isset($req) ? 'Editar' : 'Generar' ?>" /></div>
    </section>
</form>

<!-- Modal agregar ruta-->
<div class="modal fade modal-busqueda" id="rutaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header title-ruta">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-road pr-3"></span>Agregar ruta</h5>
                <button type="button" class="close close-ruta" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formRuta" method="POST">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="transporteRuta">Transporte:</label></div>
                            <div>
                                <select name="transporteRuta" class="item-big" id="transporteRuta">
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <?php
                                        $transportes = Utils::getTransportes();
                                        if (!empty($transportes)):
                                            foreach ($transportes as $t):
                                    ?>
                                    <option value="<?= $t->id ?>"><?= $t->nombre ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="ruta">Ruta:</label></div>
                            <div>
                                <select name="ruta" class="item-big" id=" ruta" disabled>
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <?php
                                        $rutas = Utils::getRutas();
                                        if (!empty($rutas)):
                                            foreach ($rutas as $r):
                                    ?>
                                    <option value="<?= $r->id ?>"><?= $r->ciudad_or . ' - ' . $r->ciudad_des ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="costo">Costo:</label></div>
                            <div><input type="text" id="costo" name="costo" class="item-medium" placeholder="Costo..." disabled></span></div>
                        </div>
                        <div class="row d-flex">
                            <div class="w-25 text-right pr-1"><label for="cliente">Cliente:</label></div>
                            <div>
                                <select name="cliente" class="item-big" id=" cliente">
                                    <option value="0" selected>--Selecciona--</option>
                                    <?php
                                        $clientes = Utils::getClientes();
                                        if (!empty($clientes)):
                                            foreach ($clientes as $c):
                                    ?>
                                    <option value="<?= $c->id ?>"><?= $c->nombre ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn enviarBtn" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal agregar producto-->
<div class="modal fade modal-busqueda" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header title-ruta">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-flask pr-3"></span>Agregar producto</h5>
                <button type="button" class="close close-ruta" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formProducto">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="producto">Producto:</label></div>
                            <div>
                                <select name="producto" class="item-big" id=" producto">
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <?php
                                        $productos = Utils::getProductos();
                                        if (!empty($productos)):
                                            foreach ($productos as $pro):
                                    ?>
                                    <option value="<?= $pro->id ?>"><?= $pro->nombre . ' (' . $pro->nombre_refineria . ')' ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="transporteProducto">Transporte:</label></div>
                            <div>
                                <?php $carrTanque = Utils::getCarroTanque() ?>
                                <input class="ml-2" type="radio" name="transporteProducto" id="transporteProducto" value="<?= $carrTanque->id ?>"
                                    <?= isset($req) && $req['transporte_id'] == $carrTanque->id ? 'checked' : 'checked' ?> /> <label><?= $carrTanque->nombre ?></label>
                                <input class="ml-2" type="radio" name="transporteProducto" id="transporteProducto" value="1" <?= isset($req) && $req['transporte_id'] != $carrTanque->id ? 'checked' : '' ?> />
                                <label>Pipa</label>
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="cantidadPro">Cantidad:</label></div>
                            <div><input type="text" id="cantidadPro" name="cantidadPro" value="" class="item-medium" placeholder="Ej. 5"></span></div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="tipoFlete">Tipo flete:</label></div>
                            <div>
                                <select name="tipoFlete" class="item-big" id=" tipoFlete">
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <?php
                                        foreach (tipoFlete as $k => $v):
                                    ?>
                                    <option value="<?= $k ?>"><?= $v ?></option>
                                    <?php
                                        endforeach;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex mb-2" id="divRutaProducto">
                            <div class="w-25 text-right pr-1"><label for="rutaProducto">Ruta:</label></div>
                            <div>
                                <select name="rutaProducto" class="item-big" id=" rutaProducto">
                                    <option value="0" selected>--Selecciona--</option>
                                    <?php
                                        $rutas = Utils::getRutasKansas();
                                        if (!empty($rutas)):
                                            foreach ($rutas as $r):
                                    ?>
                                    <option value="<?= $r->id ?>"><?= $r->ciudad_or . ' - ' . $r->ciudad_des ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex mb-2" id="divAduanaProducto">
                            <div class="w-25 text-right pr-1"><label for="aduana">Aduana:</label></div>
                            <div>
                                <select name="aduana" class="item-big" id=" aduana">
                                    <option value="0" selected>--Selecciona--</option>
                                    <?php
                                        $aduanas = Utils::getAduanas();
                                        if (!empty($aduanas)):
                                            foreach ($aduanas as $a):
                                    ?>
                                    <option value="<?= $a->id ?>"><?= $a->clave ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="w-25 text-right pr-1"><label for="cliente">Cliente:</label></div>
                            <div>
                                <select name="clienteProd" class="item-big" id=" clienteProd">
                                    <option value="0" selected>--Selecciona--</option>
                                    <?php
                                        $clientes = Utils::getClientes();
                                        if (!empty($clientes)):
                                            foreach ($clientes as $c):
                                    ?>
                                    <option value="<?= $c->id ?>"><?= $c->nombre ?></option>
                                    <?php
                                            endforeach;
                                        endif;
                                                                            ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn enviarBtn" id="btnProducto">Aceptar</button>
            </div>
        </div>
    </div>
</div>