<div class="div-compras">
    <span hidden><?= $carroTanque = Utils::getCarroTanque()->id; ?></span>
    <div class="card">
        <header>
            <div class="titulo-header"> <a href="<?= principalUrl ?>?controller=Compras&action=requisiciones"> <i class="far fa-list-alt"></i>
                    <h4>Requisiciones</h4>
                </a></div>
            <div class="menu-iconos d-flex justify-content-between pt-1">
                <div class="d-flex">
                    <h6 class="ml-3 ">Requisiciones recientes</h6><i class="ml-2  fas fa-angle-down"></i>
                </div>
                <div class="mr-4"><a href="<?= principalUrl ?>?controller=Compras&action=requisicion"><span title="Nueva requisición" class="material-icons far fa-file-alt i-new"></span></a>
                    <span id="imprimirReq" title="Imprimir requisición" class="material-icons i-print">print</span>
                    <span id="enviarReq" title="Enviar requisición a proveedor" class="material-icons far fa-envelope"></span>
                </div>
            </div>
        </header>
        <section class="text-center" id="seccionReq">
            <?php if (!empty($requisiciones)): ?>
            <table class="table table-condensed tabla-compras" id="tablaRegistros">
                <th>Folio</th>
                <th>Proveedor</th>
                <th>Solicitud</th>
                <th></th>
                <th></th>
                <tbody>
                    <?php foreach ($requisiciones as $r): ?>
                    <?php if ($r['usuario_id'] == $_SESSION['usuario']->id || Utils::permisosCompras()): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $r['id']; ?></td>
                        <td id="usuarioTabla" hidden><?= $r['usuario']; ?></td>
                        <td id="correoTabla" hidden><?= $r['correoUsuario']; ?></td>
                        <td><strong id="folioTabla"><?= $r['folio']; ?></strong></td>
                        <td><?= substr($r['proveedor'], 0, 52); ?></td>
                        <td><?= substr($r['solicitud'], 0, 6); ?></td>
                        <td>
                            <div id="tdEstatus" class="<?= Utils::getClaseEstado($r['clave']); ?> estatus-tabla" title="<?= $r['descEstatus'] ?>"><span id="estatus"><?= $r['clave']; ?></span></div>
                        </td>
                        <td class="iconos-tabla">
                            <div class="text-right">
                                <?php if ($r['cotizacion']): ?>
                                <span hidden id="archivoCotizacion"><?= $r['cotizacion']; ?></span>
                                <span id="showCotizacion" class="i-clip material-icons">attach_file</span>
                                <?php endif; ?>
                                <?php if ((!($r['estatus_id'] == 4 || $r['estatus_id'] == 5)) || Utils::permisosCompras()): ?>
                                <a href="<?= principalUrl ?>?controller=Compras&action=requisicion&id=<?= $r['id']; ?>"><span id="" class="material-icons i-edit" title="Editar">edit</span></a>
                                <?php endif; ?>
                                <?php if (!($r['estatus_id'] == 2 || $r['estatus_id'] == 5)): ?>
                                <span id="deleteReq" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                                <?php endif; ?>
                                <span id="showReq" class="i-document material-icons">description
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <span>No hay requisiciones</span>
            <?php endif; ?>
        </section>
    </div>
    <div class="card">
        <header>
            <div class="titulo-header"><a href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra"><i class="fas fa-file-invoice-dollar"></i>
                    <h4>Orden de compra</h4>
                </a></div>
            <div class="menu-iconos d-flex justify-content-between pt-1">
                <div class="d-flex">
                    <h6 class="ml-3 ">Ordenes de compra recientes</h6><i class="ml-2  fas fa-angle-down"></i>
                </div>
                <div class="mr-4">
                </div>
        </header>
        <section class="text-center">
            <?php if (!empty($ordenes)): ?>
            <table class="table table-condensed tabla-compras" id="tablaOrdenCompra">
                <thead>
                    <th>Folio</th>
                    <th>Proveedor</th>
                    <th>Solicitud</th>
                    <th>Req.</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $o): ?>
                    <?php if ($o['usuario_id'] == $_SESSION['usuario']->id || Utils::permisosCompras()): ?>
                    <tr>
                        <td id="usuarioTabla" hidden><?= $o['correoProv']; ?></td>
                        <td id="correoTabla" hidden><?= $o['correoProv']; ?></td>
                        <td id="idTabla" hidden><?= $o['id']; ?></td>
                        <td class="pl-2 text-left"><strong id="folioTabla"><?= $o['folio']; ?></strong></td>
                        <td><?= substr($o['proveedor'], 0, 52); ?></td>
                        <td><?= substr($o['solicitud'], 0, 6); ?></td>
                        <td><?= $o['folioReq']; ?></td>
                        <td>
                            <div id="tdEstatus" class="<?= Utils::getClaseEstado($o['clave']); ?> estatus-tabla" title="<?= $o['descEstatus'] ?>"><span id="estatus"><?= $o['clave']; ?></span></div>
                        </td>
                        <td class="iconos-tabla">
                            <div class="text-right">
                                <?php if ($o['cotizacion']): ?>
                                <span hidden id="archivoCotizacion"><?= $o['cotizacion']; ?></span>
                                <span id="showCotizacion" class="i-clip material-icons">attach_file</span>
                                <?php endif; ?>
                                <?php if ($o['estatus_id'] != 2): ?>
                                <?php endif; ?>
                                <span id="showOrden" class="i-document material-icons">description
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <span>No hay ordenes de compra</span>
            <?php endif; ?>
        </section>
    </div>
    <div class="card">
        <header>
            <div class="titulo-header"><a href="<?= principalUrl ?>?controller=Compras&action=embarques"><i class="fas fa-truck-moving"></i>
                    <h4>Embarques</h4><i class="fas fa-train"></i>
                </a></div>
            <div class="menu-iconos d-flex justify-content-between pt-1">
                <div class="d-flex">
                    <h6 class="ml-3 ">Embarques recientes</h6><i class="ml-2  fas fa-angle-down"></i>
                </div>
                <div class="mr-4">
                </div>
        </header>
        <section class="text-center">
            <?php if (!empty($embarques)): ?>
            <table class="table table-condensed tabla-compras" id="tablaEmbarques">
                <thead>
                    <th class="px-0 mx-0"></th>
                    <th class="px-0 mx-0">Factura</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>AT/CT</th>
                    <th class="px-0 mx-0">Pedimento</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($embarques as $e): ?>
                    <?php if ($o['usuario_id'] == $_SESSION['usuario']->id || Utils::permisosCompras()): ?>
                    <tr>
                        <td id="idFlete" hidden><?= $e['id']; ?></td>
                        <td id="idOrden" hidden><?= $e['idOrdenProducto']; ?></td>
                        <td class="w-td-30 p-0 m-0"><span
                                title="Embarque"><?= $carroTanque != ($e['transporte_id']) ? "<i class='fas fa-truck-moving icon-small' id='showFlete'></i>" : "<i class='fas fa-train icon-small' id='showFlete'></i>" ?></span>
                        </td>
                        <td class="px-0 mx-0"><strong class="mr-1"><?= $e['numero_factura']; ?></strong><input id="factura" type="hidden" value="<?= $e['factura']; ?>" /><i id="showFactura"
                                class="i-pdf material-icons far fa-file-pdf" title="Ver factura" <?= $e['factura'] == null ? 'hidden' : '' ?>></i></td>
                        <td><span><?= UtilsHelp::recortarString($e['producto'], '('); ?></span></td>
                        <td><span><?= UtilsHelp::numero2Decimales($e['cantidad_cargada']); ?></span><span class="ml-1">gl.</span></td>
                        <td><span><?= $carroTanque == ($e['transporte_id']) ? $e['carroTanque'] : $e['numero_transporte']; ?></span></td>
                        <td class="px-0 mx-0"><span class="mr-1"><?= $e['pedimento'] ?></span><input type="hidden" id="pedimento" value="<?= $e['pedimentoDoc']; ?>" /><i id="showPedimento"
                                class="mr-1 i-pdf material-icons far fa-file-pdf" title="Ver pedimento" <?= $e['pedimentoDoc'] == null ? 'hidden' : '' ?>></i></td>
                        <td class="w-td-30"><span>
                                <div id="tdEstatus" class="<?= Utils::getClaseEstado($e['clave']); ?> estatus-tabla "><span id="estatus"><?= $e['clave']; ?></span></div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <span>No hay embarques</span>
            <?php endif; ?>
        </section>
    </div>
    <div class="card">
        <header>
            <div class="titulo-header"><i class="fas fa-truck-loading"></i>
                <h4>Recepción</h4>
            </div>
        </header>
    </div>
</div>

<!-- Cotización modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalCotizacion">
    <div class="modal-dialog m-dialog">
        <div class="modal-content m-content" id="viewCot">
            <div class="modal-header m-header">
                <h5 class="modal-title" id="tituloCotizacion"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDocumento">
    <div class="modal-dialog m-dialog">
        <div class="modal-content m-content" id="viewDoc">
            <div class="modal-header m-header">
                <h5 class="modal-title" id="tituloDocumento"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal enviar Requisició correo-->
<div class="modal fade modal-enviar" id="enviarReqModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons far fa-envelope pr-2"></span>Enviar correo <strong id="folioReq"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formEnviar">
                    <div class="container">
                        <div class="row mb-2" id="correo1">
                            <div class="div-labl-correo text-right mr-1"><label>Para:</label></div>
                            <div class="ui-widget"><input type="text" id="correoModal" name="correo[]" class="item-correo correo-user"></div>
                            <span title="Agregar correo" class="material-icons i-add p-1" id="agregarCorreo">add</span>
                        </div>
                        <div class="row mb-2">
                            <div class="div-labl-correo text-right mr-1"><label>Comentarios:</label></div>
                            <div><textarea class="textarea-correo" id="cuerpoCorreo"></textarea></div>
                        </div>
                        <div class="row">
                            <div class="ml-5 d-flex justify-content-between ">
                                <?php if (Utils::permisosCompras()): ?>
                                <input class="mt-1" type="checkbox" name="rechazarReq" id="rechazarReq"><label class="text-danger ml-1" for="rechazarReq"> Rechazar requisición</label><br>
                                <?php endif; ?>
                                <input class="mt-1" type="checkbox" name="ajuntarReq" id="ajuntarReq"> <label class="ml-1 mb-2 mr-3" for="ajuntarReq"> Adjuntar archivo requisición</label><br>
                                <input class="mt-1" type="checkbox" name="adjuntarCot" id="adjuntarCot"> <label class="ml-1" for="adjuntarCot"> Adjuntar cotización</label><br>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="enviarCorreo"><span class="material-icons mr-2">send</span>Enviar</button>
            </div>
        </div>
    </div>
</div>