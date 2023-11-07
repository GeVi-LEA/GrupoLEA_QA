
<div class="row mt-1 req-estados">
    <span hidden><?=$carroTanque = Utils::getCarroTanque()->id;?></span>
    <div class="col-6 div-estados" id="divEstados"> 
        <a class="<?= isset($idEst) ? "" : "estatus-hover"?>" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra"><i title="Ver todas las ordenes de compra" class="i-list-ol fas fa-list-ol"></i></a>
        <?php if(Utils::permisosCompras()):?>
        <a class="estatus-gen <?= $idEst == 1 ? "estatus-hover" : "" ?>" title="Ordenes de compra Generadas" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&idEst=1">Generadas</a>
        <a class="estatus-proceso <?= $idEst == 3 ? "estatus-hover" : "" ?>" title="Ordenes de compra en proceso" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&idEst=3">En proceso</a>
        <a class="estatus-enviada <?= $idEst == 3 ? "estatus-hover" : "" ?>" title="Ordenes de compra por de embarque" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&embarque">Por embarcar</a>
        <a class="estatus-embarque <?= $idEst == 10 ? "estatus-hover" : "" ?>" title="Ordenes de compra en proceso de embarque" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&idEst=10">Embarque</a>
        <a class="estatus-fin <?= $idEst == 5 ? "estatus-hover" : "" ?>" title="Ordenes de compra Finalizadas" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&idEst=5">Finalizadas</a>  
        <a class="estatus-cancel <?= $idEst == 2 ? "estatus-hover" : "" ?>" title="Ordenes de compra Canceladas" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra&idEst=2">Canceladas</a>
        <?php endif;?>
    </div>
    <div class="col-3"><h5>Ordenes de compra</h5></div>
    <div class="col-3 menu-iconos d-flex justify-content-end">
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="&#xf002; Buscar..."><i id="buscarOrden" class="fas fa-search i-search material-icons"></i></div>
        <div class="mr-4">
        <span id="imprimirOrden" title="Imprimir orden de compra" class="material-icons i-print">print</span>
        <span id="enviarOrden" title="Enviar orden" class="material-icons far fa-envelope"></span></div>
    </div>
</div>
<section class="sec-tabla text-center">
    <?php if (!empty($ordenes)): ?>
        <table class="table tabla-registros" id="tablaRegistros">
            <thead>
            <th>Folio</th>
            <th>Proveedor</th>
            <th>Solicitud</th>
            <th>Tipo compra</th>
            <th>Fecha alta</th>
            <th>Fecha entrega</th>
            <th>Folio req.</th>
            <th>Estatus</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($ordenes as $o): ?>
                    <?php if($o['usuario_id'] == $_SESSION['usuario']->id || Utils::permisosCompras()):?>
                    <tr class="tr">
                        <td id="usuarioTabla" hidden><?= $o['correoProv']; ?></td>
                        <td id="correoTabla" hidden><?= $o['correoProv']; ?></td>
                        <td id="idTabla" hidden><?= $o['id']; ?></td>
                        <td> <strong id="folioTabla"><?= $o['folio']; ?></strong></td>
                        <td id="proveedorTabla"><?= substr($o['proveedor'], 0,58); ?></td>
                        <td><?= $o['solicitud']; ?></td>
                        <td id="compra"><?= $o['compra']; ?></td>
                        <td><?= date('d/m/Y', strtotime($o['fecha_alta'])); ?></td>  
                        <td><?= date('d/m/Y', strtotime($o['fecha_requerida']));?></td>
                        <td><a href="#" id="showReqOrden" title="Ver requisición"><?= $o['folioReq'];?></a></td>
                        <td> <div id="tdEstatus" class="<?=Utils::getClaseEstado($o['clave']);?> estatus-tabla" title="<?=$o['descEstatus']?>"><span id="estatus"><?=$o['estatus'];?></span></div></td>            
                        <td> 
                            <div class="text-right">
                                            <?php if(count($o['embarque']) > 0):?>
                                            <span id="showEmbarque" class="material-icons expand">expand_more</span>
                                            <?php elseif(count($o['recepcionFlete']) > 0):?>
                                            <span id="showRecepcionFlete" class="material-icons expand">expand_more</span>
                                            <?php endif ;?>
                                            <?php if($o['cotizacion']):?>
                                            <span hidden id="archivoCotizacion"><?=$o['cotizacion'];?></span>
                                            <span id="showCotizacion" class="i-clip material-icons">attach_file</span>
                                            <?php endif ;?>
                                                <?php 
                                                 $icono = $carroTanque != $o['transporte'] ? "<i id='showFlete' class='fas fa-truck-moving mr-2 icon-small'></i>" : "<i id='showFlete' class='fas fa-train mr-2 icon-small'></i>";
                                                 $titulo = $carroTanque == $o['transporte'] ? "Carro tanque" : "A-T";
                                                 $pendiente = $o['detalle'][0]['cantidad'] - $o['cantidadCargada'];
                                                    if($o['estatus_id'] == 3 || $o['estatus_id'] == 7 || $o['estatus_id'] == 10):?>
                                                            <?php if($o['id_producto'] == null):?>
                                                          <span id="recibir" title="Recepción" class="material-icons i-recibir">input</span>
                                                             <?php else:?>  
                                                                <?php if($carroTanque == $o['transporte']):?>
                                                                     <?php if($pendiente >= 1000) :?>
                                                                     <span id="recibir" title="Embarque" class="material-icons i-recibir">directions_subway</span>
                                                                     <?php else: ?>
                                                                     <span id="cerrarOrden" title="Cerrar orden de compra" class="material-icons i-finalizar">directions_subway</span>
                                                                     <?php endif ;?>
                                                                <?php else: ?>
                                                                     <?php if($pendiente >= 500) :?>
                                                                    <span id="recibir" title="Embarque" class="material-icons i-recibir">local_shipping</span>
                                                                    <?php else: ?>
                                                                    <span id="cerrarOrden" title="Cerrar orden de compra" class="material-icons i-finalizar">local_shipping</span>
                                                                    <?php endif ;?>
                                                                 <?php endif ;?>
                                                    <?php endif ;?>
                                                <?php endif ;?>
                                                <span id="showOrden" class="i-document material-icons">description</div>
                        </td>
                        <td id="idTablaReq" hidden><?= $o['requisicion_id']; ?></td>
                    </tr>
                <?php if (count($o['embarque']) > 0): ?>
           <tr class="transparent" hidden>
             <td colspan="12" class="p-0"> 
                    <table class="table tabla-embarques">
                        <thead>
                            <th class="text-right">Embarque</th>
                            <th> <?=$titulo?></th>
                         <?php if($o['tipoFlete'] == 2) :?>
                            <th>Req. flete</th>
                            <th>OC. Flete</th>
                          <?php endif ;?>
                            <th class="px-0 mx-0">Factura</th>
                            <th class="w-td-30 px-0 mx-0"><i class="fas fa-paperclip"></i></th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th class="px-0 mx-0">Pedimento</th>
                            <th class="w-td-30 px-0 mx-0"><i class="fas fa-paperclip"></i></th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                        </thead> 
            <tbody>
               <?php $i =1; foreach ($o['embarque']as $embarque): ?>
                 <tr class="background-tabla-embarques">
                    <td id="idFlete" hidden><?=$embarque['id']; ?></td>
                    <td class="text-right"><span class="mr-2"><?=$i;?></span><?=$icono;?></td>
                    <td><span><?= $carroTanque == ($o['transporte']) ? $embarque['carroTanque'] : $embarque['numero_transporte'];?></span></td>
                    <td hidden><span id="idOrden"><?= $o['id']; ?></span></td>
                   <?php if($o['tipoFlete'] == 2) :?>
                    <td><span><?= $embarque['folioFlete']; ?></span></td>
                    <td><span><?= $embarque['orden']?></span></td>
                  <?php endif ;?>
                    <td class="px-0 mx-0"><span><?= $embarque['numero_factura']; ?></span></td>
                    <td class="w-td-30 px-0 mx-0"><input id="factura" type="hidden" value="<?= $embarque['factura']; ?>" /><i id="showFactura" class="i-pdf material-icons far fa-file-pdf" title="Ver factura" <?= $embarque['factura']== null ? "hidden" :"" ?>></i></td>
                    <td><span><?= UtilsHelp::numero2Decimales($embarque['precio_producto']); ?></span></td>
                    <td><span><?= UtilsHelp::numero2Decimales($embarque['cantidad_cargada']); ?></span><span class="ml-1">gl.</span></td>
                    <td><span><?= $embarque['pedimento']?></span></td>
                    <td class="w-td-30 px-0 mx-0"><input type="hidden" id="pedimento" value="<?= $embarque['pedimentoDoc']; ?>" /><i id="showPedimento" class="i-pdf material-icons far fa-file-pdf" title="Ver pedimento" <?= $embarque['pedimentoDoc']== null ? "hidden" :"" ?>></i></td>
                    <td><span><?= date('d/m/Y', strtotime($embarque['fecha_alta'])); ?></span></td>
                    <td><span><div id="tdEstatus" class="<?=Utils::getClaseEstado($embarque['clave']);?> estatus-tabla estatus-small"><span id="estatus"><?=$embarque['estatus'];?></span></div></td>
                  </tr>
                <?php $i++; endforeach; ?>
                                  <tr class="emabrque-total">
                                      <td colspan="15">
                                          <div class="d-flex justify-content-around">
                                              <div><strong class="mr-1">Fletes solicitados:</strong><span><?= $o['cantidad_flete']; ?></span></div>
                                              <div><strong class="mr-1">Producto:</strong><span><?= $o['producto']; ?></span></div>
                                              <div><strong class="mr-1">Refineria:</strong><span><?= $o['refineria']; ?></span></div>
                                              <div><strong class="mr-1">Solicitada:</strong><span><?= UtilsHelp::numero2Decimales($o['detalle'][0]['cantidad']); ?></span><span class="ml-1">gl.</span></div>
                                              <div><strong class="mr-1">Embarcada:</strong> <span><?= UtilsHelp::numero2Decimales($o['cantidadCargada']); ?></span><span class="ml-1">gl.</span></div>
                                              <?php if ($pendiente >= 0) : ?>
                                                  <div class="text-left"><strong>Pendiente:</strong> <span><?= UtilsHelp::numero2Decimales($pendiente, true, 0); ?></span><span class="ml-1">gl.</span></div>
                                              <?php else: ?>
                                                  <div class="text-left"><strong>Excedente:</strong> <span><?= UtilsHelp::numero2Decimales(abs($pendiente), true, 0); ?></span><span class="ml-1">gl.</span></div>
                                              <?php endif; ?>
                                          </div>
                                      </td>
                                  </tr>
                     </tbody>
                    </table>
                        </td>
                    </tr>     
                 <?php else:?>
                        <?php if(count($o['recepcionFlete']) > 0):?>
                           <tr class="tr-emabrques transparent" hidden>
             <td colspan="8" class="p-0"> 
                    <table class="table tabla-embarques">
            <tbody>
               <?php foreach ($o['recepcionFlete'] as $rt): ?>
                 <tr class="background-tabla-embarques">
                    <td hidden><span id="idTabla"><?= $o['id']; ?></span></td>
                    <td class="text-right"><span id="recibir" class="material-icons">sticky_note_2</span></td>
                    <td><i class="mr-1 fas fa-paperclip"></i><strong class="mr-1">Factura:</strong><span class="mr-2"><?= $rt['numero_factura']; ?></span><input id="factura" type="hidden" value="<?= $rt['factura']; ?>" /><i id="showFactura" class="i-pdf material-icons far fa-file-pdf" title="Ver factura" <?= $rt['factura'] == null ? "hidden" : "" ?>></i></td>
                    <td class="px-0 mx-0"><i class="mr-1 fas fa-paperclip"></i><strong class="mr-1">XML:</strong> <input type="hidden" id="xml" value="<?= $rt['docXml']; ?>" /><i id="showXml" class="i-xml material-icons far fa-file-code" title="Ver XML" <?= $rt['docXml']== null ? "hidden" :"" ?>></i></td>
                    <td class="px-0 mx-0"><i class="mr-1 fas fa-paperclip"></i><strong class="mr-1">Remisión:</strong><span class="mr-2"><?= $rt['remision']; ?></span><input type="hidden" id="remision" value="<?= $rt['remision']; ?>" /><i id="showRemision" class="i-pdf material-icons far fa-file-pdf" title="Ver remisión" <?= $rt['remision']== null ? "hidden" :"" ?>></i></td>
                    <td><span><?= date('d/m/Y', strtotime($rt['fecha_recepcion'])); ?></span></td>
                  </tr>
                <?php endforeach; ?>
                     </tbody>
                    </table>
                        </td>
                    </tr>     
                        <?php endif;?>
                 <?php endif;?>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay ordenes de compra</span>                   
    <?php endif; ?>
</section>

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

<!-- Modal enviar Orden correo-->
<div class="modal fade modal-enviar" id="enviarOrdenModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3 modal-title" id="titleModal"><span class="material-icons far fa-envelope pr-2"></span>Enviar correo <strong id="folioOrden"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formEnviar">
                    <div class="container">
                        <div class="row mb-2" id="correo1">
                            <div class="div-labl-correo text-right mr-1"><label>Para:</label></div> 
                            <div><input type="text" id="correoModal" name="correo[]" class="item-correo correo-user"></span></div> 
                            <span title="Agregar correo" class="material-icons i-add p-1" id="agregarCorreo">add</span>      
                        </div>

                           <div class="row mb-2">
                            <div class="div-labl-correo text-right mr-1"><label>Asunto:</label></div> 
                            <div class="ui-widget"><input type="text" id="asunto" class="item-correo correo-user" ></span></div> 
                        </div>
                        <div class="row mb-2">
                              <div class="div-labl-correo text-right mr-1"><label>Comentarios:</label></div> 
                              <div><textarea class="textarea-correo" id="cuerpoCorreo"></textarea></div> 
                        </div>
                          <div class="row">
                              <div class="ml-5 d-flex justify-content-between ">
                             <input class="mt-1" type="checkbox" name="ajuntarOrden" id="ajuntarOrden" > <label class="ml-1 mb-2 mr-3" for="ajuntarReq"> Adjuntar archivo orden de compra</label><br>
                             <input class="mt-1" type="checkbox" name="adjuntarCot" id="adjuntarCot"> <label class="ml-1" for="adjuntarCot"> Adjuntar cotización</label><br>
                             </div>
                        </div>
                       </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="enviarCorreoOrden"><span class="material-icons mr-2">send</span>Enviar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal busqueda orden de compra-->
<div class="modal fade modal-busqueda" id="buscarOrdenCompra" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar Orden compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formBuscar" method="POST" action="<?=principalUrl?>?controller=Compras&action=buscarOrdenCompra">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="folioBuscar">Folio:</label></div> 
                            <div><input type="text" id="folioBuscar" name="folioBuscar" class="item-small" placeholder="Buscar folio..."></span></div> 
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                             <div class="pr-3"><input type='text' name="fechaInicio"  class="item-small" id="fechaInicio"  readOnly  placeholder="Fecha inicio..."/></div>
                             <div class="pr-2"> <label>Y</label></div>
                             <div><input type='text' name="fechaFin"  class="item-small" id="fechaFin"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="proveedorModal">Tipo Solicitud:</label></div>                                             
                            <div>                            
                                <select name="solicitud" class="item-medium"" id="solicitud"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $tipoSolicitudes = Utils::getTipoSolicitudes();
                                    if (!empty($tipoSolicitudes)):
                                        foreach ($tipoSolicitudes as $ts):
                                            ?>
                                            <option value="<?= $ts->id ?>"><?= $ts->tipo ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="w-25 text-right pr-1"><label for="proveedor">Proveedor:</label></div>                                             
                            <div>                            
                                <select name="proveedor" class="item-big"" id="proveedor"> 
                                    <option value="" selected>--Selecciona--</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                 </form>
            </div>
                        <div class=" border-modal modal-footer text-center">
                          <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                          <button class="btn enviarBtn" id="btnBuscar"><span class="material-icons fas fa-search pr-2"></span>Buscar</button>
                     </div>
           </div>  
             </div>
        </div>

<!-- Cotización modal -->
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


