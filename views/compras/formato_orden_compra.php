<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="../../assets/img/gpl.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/compras/assets/css/formatos.css" />
        <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
        <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script> 
        <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?= root_url ?>views/compras/assets/js/formatos.js"></script>
        <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> 
        <title>Orden de Compra</title>
    </head>
   <body>
    <header class="header-orden">
        <nav class="d-flex"> 
        <input id="estatusId" type="hidden" value="<?=$oc->estatus_id ?>">
            <?php if ($oc->estatus_id != 5 && $oc->estatus_id != 1 && Utils::permisosCompras() && Utils::permisosEditar()): ?>
                <span id="cerrarOrden" title="Finalizar orden de compra" class="material-icons i-finalizar">check_circle_outline</span>
              <?php endif;?>
            <?php if ($r['cotizacion']): ?>
            <span hidden id="archivoCotizacion"><?= $r['cotizacion']; ?></span>
            <span id="showCotizacion" class="i-clip material-icons">attach_file</span>
            <?php endif; ?>
              <?php if ($oc->estatus_id == 1 && Utils::permisosCompras()): ?>
             <span id="edit" title="Editar orden de compra" class="material-icons i-edit transform" title="Editar">edit</span>
             <span id="save" title="Guardar orden de compra" class="material-icons i-save transform hidden">save</span>
             <span id="acept" title="Aceptar orden de compra" class="material-icons transform i-acept">check_box</span>
              <?php elseif ($oc->estatus_id != 1 && Utils::permisosCompras()):  ?>
             <span id="edit" title="Editar orden de compra" class="material-icons i-edit transform" title="Editar">edit</span>
             <span id="save" title="Guardar orden de compra" class="material-icons i-save transform hidden">save</span>
             <span id="imprimirOrden" title="Imprimir orden de compra" class="material-icons i-print transform">print</span>
             <span id="enviarOrden" title="Enviar orden compra" class="material-icons  i-mail transform">mail_outline</span>
              <?php else : ?>
                <span id="imprimirOrden" title="Imprimir orden de compra" class="material-icons i-print transform">print</span>
                <span id="enviarOrden" title="Enviar orden compra" class="material-icons  i-mail transform">mail_outline</span>
              <?php endif;?>
              <?php if ($oc->estatus_id != 2): ?>
                  <span id="delete" title="Eliminar orden de compra" class="material-icons transform i-delete" title="Eliminar">delete_forever</span>
              <?php endif;?>
        </nav>
    </header>
        <div class="contenedor-orden" id="tablaOrden">
            <div class='titulo-orden'>
                <div class="logo">
                    <div>
                        <div>
                            <img class="img" src="<?= root_url ?>assets/img/default.jpg" />
                        </div>
                        <div class="nombre-empresa">
                            <strong><?= isset($empresa) ? $empresa['nombre'] : "" ?></strong>
                        </div>
                    </div>  
                    <div class="datos-empresa">
                        <div>
                            <span>R.F.C.:  <?= isset($empresa) ? $empresa['rfc'] : "" ?></span></br>
                            <span><?= isset($empresa) ? $empresa['direccion'] : "" ?></span></br>
                            <span><?= isset($empresa) ? $empresa['estado'] . ' C.P. ' . $empresa['cp'] : "" ?></span>
                        </div>
                        <div>
                            <span>Sitio web: www.leademexico.com</span></br>
                            <span>TEL: <?= isset($empresa) ? $empresa['tel'] : "" ?></span>
                        </div>
                    </div>
                </div>
                <div class="folio">
                    <div><span>ORDEN DE COMPRA</span></div>
                    <input type="hidden" id="solicitud" value="<?= $r['solicitud']; ?>" />
                    <input type="hidden" id="id" value="<?=$oc->id; ?>" />
                    <div><span id="folio"><?= isset($oc) ? $oc->folio : "" ?></span></div>
                </div>
                <div class="datos-proveedor">
                    <div>
                        <div> <span >ORDENADO A:</span></div>            
                    </div>
                    <div>
                        <div> <strong id="proveedor"><?= isset($r) ? $r['proveedor'] : ""; ?></strong></div>    
                    </div>
                    <div class="pl-15">
                        <span >TELEFONO: <?= isset($r) ? $r['tel_provedor'] : ""; ?></span>
                    </div>
                    <div>
                        <span>DIRECCION:</span>
                    </div>
                    <div>
                        <div> <span > <?= isset($r) ? $r['direccion'].", ".$r['ciudad'] : ""; ?></span></div>   
                    </div>
                    <div class="pl-15">
                        <span>CONTACTO:  <?= isset($r) ? $r['contacto'] : ""; ?></span></br>
                        <span>CORREO:</span><span id="correoProveedor"><?= isset($r) ? $r['correo_proveedor'] : ""; ?></span>  
                    </div>   
                </div>
                <div class="fechas">
                    <span>FECHA DE LA ORDEN: <?= isset($oc) ? date('d/m/Y', strtotime($oc->fecha_alta)) : " "; ?></span></br>
                    <span>FECHA DE ENTREGA: <?= isset($r) && $r['fecha_requerida'] != "" ? date('d/m/Y', strtotime($r['fecha_requerida'])) : ""; ?></span></br>
                    <span>DEPARTAMENTO: <?= isset($r) ? $r['departamento'] : ""; ?></span>
                </div>
            </div>        
            <div>
                <div class="d-flex justify-content-end mt-1">
                     <?php if (isset($cli)): ?>
                     <div class="cliente">            
                         <div>
                             <div><strong>Entregar a:</strong><span><?= isset($cli) ? $cli->nombre : " "; ?></span> </div>
                             <div><strong>Domicilio:</strong><span><?= isset($cli) ? $cli->direccion.", ".$cli->ciudad_completa : " "; ?></span></div>          
                         </div>
                         <div class="pl-15">
                             <div><strong>Contacto:</strong><span><?= isset($cli) ? $cli->contacto : " "; ?></span> </div>
                             <div><strong>Correo:</strong><span><?= isset($cli) ? $cli->correo : " "; ?></span></div>          
                         </div>
                           <div class="pl-15">
                             <div class="pt-15"><strong>Telefono:</strong><span><?= isset($cli) ? $cli->telefono : " "; ?></span> </div>       
                         </div>
                           </div>
                       <?php endif; ?>
                     <div class="refresh"><div id="divIsr" class="hidden pl-4 pt-1">                             
                             <button class="span-add-isr" id="btnIsr">ISR %:</button>
                             <input text="text" class="add-isr" id="addIsr" name="addIsr" value="<?= isset ($oc) && $oc->impuesto > 0 ? UtilsHelp::numero2Decimales($oc->impuesto) : "";?>" />
                         </div>        
                           <?php if ($cuotaExenta): ?>
                             <div id="addCuota" class="hidden"><div class="addCuota"><input id="checkCuota" type="checkbox" id="cuota" class="mr-1"/><label>Cuota exenta</label></div></div>
                        <?php endif; ?>
                         <span id="refresh" class="hidden material-icons i-refresh">refresh</span></div>
                </div>
                <div class="descripcion-orden border-t-b font-bold">
                    <div class="border-r-b d-flex"><span>UNIDAD</span></div>
                    <div class="border-r-b d-flex"><span>DESCRIPCION</span> </div>
                    <div class="border-r-b d-flex"><span>CANTIDAD</span> </div>
                    <div class="border-r-b d-flex"><span>PRECIO POR UNIDAD</span> </div>
                    <div class="border-r-b d-flex"><span>DESCUENTO</span> </div>
                    <div class="d-flex"><span>PRECIO</span> </div>
                </div>
                <?php if (isset($r)): ?>
                    <?php for ($i = 0; $i < count($r['detalle']); $i++): ?>
                        <div class="descripcion-orden back-b">
                            <input type="hidden" id="idDetalle" value="<?=$r['detalle'][$i]['id']; ?>"/>
                            <div class="border-r-b d-flex"><?= Utils::getNombreUnidad(intval($r['detalle'][$i]['unidad_id'])); ?></div>
                            <div class="border-r-b center-v"><?= $r['detalle'][$i]['descripcion']; ?></div>
                            <div class="border-r-b d-flex"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['cantidad']); ?></div>
                            <div class="border-r-b right-v"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio_unitario'], true); ?></div>
                            <div class="border-r-b right-v"><input class="input-edit" id="descuento" type="text" disabled name="descuento[]" value="<?= UtilsHelp::numero2Decimales($r['detalle'][$i]['descuento'], true); ?>" /></div>
                            <div class="right-v back-pre-b"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio'], true); ?> </div>
                            <span hidden><?= $i += 1; ?></span>
                        </div>  
                        <?php if ($i < count($r['detalle'])): ?>
                            <div class="descripcion-orden">
                                <input type="hidden" id="idDetalle" value="<?=$r['detalle'][$i]['id']; ?>"/>
                                <div class="border-r-b d-flex"><?= Utils::getNombreUnidad(intval($r['detalle'][$i]['unidad_id'])); ?></div>
                                <div class="border-r-b center-v"><?= $r['detalle'][$i]['descripcion']; ?></div>
                                <div class="border-r-b d-flex"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['cantidad']); ?></div>
                                <div class="border-r-b right-v"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio_unitario'], true); ?> </div>
                                <div class="border-r-b right-v"><input class="input-edit" id="descuento" type="text" disabled name="descuento[]" value="<?= UtilsHelp::numero2Decimales($r['detalle'][$i]['descuento'], true); ?>" /></div>
                                <div class="right-v back-pre"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio'], true); ?> </div>
                            </div>   
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
                <div class="desc-total-orden">
                    <div class="observaciones-orden pl-3">
                        <div class="pt-10 div-observaciones"><span class="font-bold">OBSERVACIONES:</span><textarea id="observaciones" class="observaciones" disabled><?= (isset($r) ? $r['observaciones'] : ""); ?> </textarea></div> 
                        <div><span >O.C. EN BASE A COTIZACION ENVIADA POR:</span><span><?= (isset($r) ? $r['contacto'] : ""); ?> </span></div> 
                          <?php if ($r['solicitud'] == "Transporte"): ?>
                        <div><span class="mr-20">Contacto ventas: <?= usuarios['compras_fletes']['nombre']?></span></br><span class="mr-20">Teléfono: <?= usuarios['compras_fletes']['telefono']?></span>
                        <span>Enviar factura a: </span><span><?= usuarios['compras_fletes']['correo']?></span></div>
                             <?php else: ?>
                           <div><span class="mr-20">Contacto compras: <?= usuarios['compras']['nombre']?></span></br><span class="mr-20">Teléfono: <?= usuarios['compras']['telefono']?></span>
                             <span>Enviar factura a: </span><span><?= usuarios['compras']['correo']?></span></div>
                             <?php endif; ?>
                        <div class="pt-10"><span class="font-bold">IMPORTE CON LETRA:</span></div> 
                        <div class="back-b center-v"><span><?= $totalLetra; ?></span></div>
                    </div>
                    <div class="totales-orden">
                        <input type="hidden" value="<?=$sumaCantidad?>" id="cantidadTotal">
                        <input type="hidden" value="<?=UtilsHelp::numero2Decimales($r['detalle'][0]['precio_unitario'])?>" id="servicioFletePrecio">
                        <div class="border-b-b border-r-b back-b right-v font-bold"><span>IMPORTE:</span></div>
                        <div class="border-b-b back-pre-b right-v font-bold">$<span id="importe"><?= UtilsHelp::numero2Decimales($oc->importe, true);?></span></div>
                        <div class="border-b-b border-r-b center-v"><input type="checkbox" id="checkIva" class="hidden mr-1"/><input class="input-edit-small" id="otroIva" type="text" disabled name="otroIva" value="<?= $oc->iva == 0 ? "" : ($oc->otro_iva != null ? $oc->otro_iva : "16");?>" /><span>% IVA:</span></div>
                        <div class="border-b-b back-pre right-v">$<span id="iva"><?= UtilsHelp::numero2Decimales($oc->iva, true);?></span></div>  
                        <div class="border-b-b border-r-b back-b right-v font-bold"><span>SUB-TOTAL:</span></div>
                        <div class="border-b-b back-pre-b right-v font-bold">$<span id="subtotal"><?=  UtilsHelp::numero2Decimales($oc->sub_total, true);?></span></div>    
                        
                          <?php if($r['solicitud'] == "Transporte"):?>
                        <div class="border-b-b border-r-b center-v"><input type="checkbox" id="checkIsr" class="hidden mr-1"/><span id="isrText">RETENCIÓN 4%</span></div>
                        <div class="border-b-b back-pre right-v">$<span id="isr"><?=UtilsHelp::numero2Decimales($oc->isr, true);?></span></div>    
                        <div class="border-b-b border-r-b center-v back-b"><span id="retText"></span></div>
                        <div class="border-b-b back-pre-b right-v"><span id="retencion"></span></div>
                        
                         <?php elseif ($r['solicitud'] == "Honorarios"): ?>
                        <div class="border-b-b border-r-b center-v"><input type="checkbox" id="checkIsr" class="hidden mr-1"/><span id="isrText">RETENCIÓN 10%</span></div>
                        <div class="border-b-b back-pre right-v">$<span id="isr"><?=UtilsHelp::numero2Decimales($oc->isr, true);?></span></div>   
                        <div class="border-b-b border-r-b center-v back-b"><span id="retText">RET. IVA (10.6666%)</span></div>
                        <div class="border-b-b back-pre-b right-v">$<span id="retencion"><?=UtilsHelp::numero2Decimales($oc->retencion_iva, true);?></span></div>
                         <?php else:?>
                        <div class="border-b-b border-r-b center-v"><input type="checkbox" id="checkIsr" class="hidden mr-1"/>
                            <span id="isrText">RETENCIÓN  <?=$oc->impuesto != 0 ? UtilsHelp::numero2Decimales($oc->impuesto) : "";?>%</span></div>
                        <div class="border-b-b back-pre right-v"><span id="isr"><?= $oc->isr != 0 ? UtilsHelp::numero2Decimales($oc->isr, true) : "";?></span></div>    
                        <div class="border-b-b border-r-b center-v back-b"><span id="retText"></span></div>
                        <div class="border-b-b back-pre-b right-v"><span id="retencion"></span></div>
                         <?php endif;?>
                        
                        <div class="border-b-b border-r-b center-v"><span>PAGOS</span></div>
                        <div class="border-b-b back-pre right-v"><input class="input-edit" id="pagos" type="text" name="pagos" disabled value="<?= UtilsHelp::numero2Decimales($oc->pagos, true); ?>" /></div> 
                        <div class="border-b-b border-r-b back-pre right-v font-bold"><span>TOTAL:</span></div>  
                        <div class="border-b-b back-pre-b right-v font-bold">$<span id="total"><?=UtilsHelp::numero2Decimales($oc->total, true);?></span></div>  
                    </div>
                </div>
                <div class="version-doc">
                    <?php if($r['solicitud'] == "Materia Prima"):?>
                     <div class="mr-5" ><strong for="notaCredito">Nota de credito</strong><input id="notaCredito" value="<?= $oc->nota_credito != 0 ? UtilsHelp::numero2Decimales($oc->nota_credito, true) : "";?>" type="text" class="ml-1 input-nota" disabled /></div>
                   <?php endif;?>
                   <div ><span><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></span></div>
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
                            <div class="ui-widget"><input type="text" id="correoModal" name="correo[]" class="item-correo correo-user"></span></div> 
                            <span title="Agregar correo" class="material-icons i-add icons p-1" id="agregarCorreo">add</span>      
                        </div>

                           <div class="row mb-2">
                            <div class="div-labl-correo text-right mr-1"><label>Asunto:</label></div> 
                            <div ><input type="text" id="asunto" class="item-correo correo-user" ></span></div> 
                        </div>
                        <div class="row mb-2">
                              <div class="div-labl-correo text-right mr-1"><label>Comentarios:</label></div> 
                              <div><textarea class="textarea-correo" id="cuerpoCorreo"></textarea></div> 
                        </div>
                          <div class="row ml-4 ">
                              <div class="ml-5 d-flex justify-content-between">
                             <input  type="checkbox" name="ajuntarOrden" id="ajuntarOrden" > <label class="ml-2 mt-1 mb-0" for="ajuntarReq"> Adjuntar archivo orden de compra</label><br>
                             <input  type="checkbox" name="adjuntarCot" id="adjuntarCot"> <label class="ml-2 mb-0" for="adjuntarCot"> Adjuntar cotización</label><br>
                             </div>
                        </div>
                       </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="enviarCorreoOrden"><span class="material-icons icons mr-2">send</span>Enviar</button>
            </div>
        </div>
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
    </body>
</html>