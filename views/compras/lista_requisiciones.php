
<div class="row mt-1 req-estados">
    <div class="col-5 div-estados" id="divEstados"> 
        <a class="<?= isset($idEst) ? "" : "estatus-hover"?>" href="<?= principalUrl ?>?controller=Compras&action=requisiciones"><i title="Ver todas las requisiciones" class="i-list-ol fas fa-list-ol"></i></a>
        <?php if(Utils::permisosCompras()):?>
        <a class="estatus-gen <?= $idEst == 1 ? "estatus-hover" : "" ?>" title="Requisiciones Generadas" href="<?= principalUrl ?>?controller=Compras&action=requisiciones&idEst=1">Generadas</a>
        <a class="estatus-proceso <?= $idEst == 3 ? "estatus-hover" : "" ?>" title="Requisiciones en proceso" href="<?= principalUrl ?>?controller=Compras&action=requisiciones&idEst=3">En proceso</a>  
        <a class="estatus-acept <?= $idEst == 4 ? "estatus-hover" : "" ?>" title="Requisiciones Aceptadas" href="<?= principalUrl ?>?controller=Compras&action=requisiciones&idEst=4">Aceptadas</a>
        <a class="estatus-fin <?= $idEst == 5 ? "estatus-hover" : "" ?>"  title="Requisiciones Finalizadas" href="<?= principalUrl ?>?controller=Compras&action=requisiciones&idEst=5">Finalizadas</a>  
        <a class="estatus-cancel <?= $idEst == 2 ? "estatus-hover" : "" ?>" title="Requisiciones Canceladas" href="<?= principalUrl ?>?controller=Compras&action=requisiciones&idEst=2">Canceladas</a>
        <?php endif;?>
    </div>
    <div class="col-2"><h5>Requisiciones</h5></div>

    <div class="col-5 menu-iconos d-flex justify-content-end">
             <?php if(Utils::permisosCompras()):?>
        <button class="btn-generar-orden" id="generarOrden" hidden>Generar OC</button>
              <?php endif;?>  
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar folio..."><i id="buscarReq" class="fas fa-search i-search material-icons"></i></div>
        <div class="mr-4"><a href="<?= principalUrl ?>?controller=Compras&action=requisicion"><span title="Nueva requisición" class="material-icons far fa-file-alt i-new"></span></a>
        <span id="imprimirReq" title="Imprimir requisición" class="material-icons i-print">print</span>
        <span id="enviarReq" title="Enviar requisición a proveedor"class="material-icons far fa-envelope"></span></div>
    </div>
</div>

<section class="sec-tabla text-center" id="seccionReq">
    <?php if (!empty($requisiciones)): ?>
        <table class="table table-condensed tabla-registros" id="tablaRegistros">
            <thead>
            <th>Folio</th>
            <th>Proveedor</th>
            <th>Solicitud</th>
            <th>Tipo compra</th>
            <th>Fecha alta</th>
            <th>Fecha requerida</th>
            <th>Estatus</th>
            <?php if($idEst == 5):?>
            <th>Folio OC</th>
             <?php else:?>
            <th>Firmas</th>
             <?php endif;?>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($requisiciones as $r): ?>
                    <?php if($r['usuario_id'] == $_SESSION['usuario']->id || Utils::permisosCompras()):?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $r['id']; ?></td>
                        <td id="usuarioTabla" hidden><?= $r['usuario']; ?></td>
                         <td id="correoTabla" hidden><?= $r['correoUsuario']; ?></td>
                        <td><strong id="folioTabla"><?= $r['folio']; ?></strong></td>
                        <td id="proveedorTabla"><?= substr($r['proveedor'], 0,58); ?></td>
                        <td><?= $r['solicitud']; ?></td>
                        <td id="compra"><?= $r['compra']; ?></td>
                        <td><?= date('d/m/Y', strtotime($r['fecha_alta'])); ?></td>  
                        <td><?= date('d/m/Y', strtotime($r['fecha_requerida']));?></td>
                        <td> <div id="tdEstatus" class="<?=Utils::getClaseEstado($r['clave']);?> estatus-tabla" title="<?=$r['descEstatus']?>"><span id="estatus"><?=$r['estatus'];?></span></div></td>
                         <?php if($r['estatus_id'] == 5):?>
                        <td><strong><?= $r['folio_oc']; ?></strong></td>
                             <?php else:?>
                             <td><div><?= Utils::showFirmas($r['firmas'])?></div></td>
                             <?php endif;?>                       
                        <td> 
                            <div class="text-right">
                                <?php if($r['cotizacion']):?>
                                <span hidden id="archivoCotizacion"><?=$r['cotizacion'];?></span>
                                <span id="showCotizacion" class="i-clip material-icons">attach_file</span>
                                 <?php endif ;?>
                                 <?php if((!($r['estatus_id'] == 4 || $r['estatus_id'] == 5)) || Utils::permisosCompras()):?>
                                <a href="<?=principalUrl?>?controller=Compras&action=requisicion&id=<?= $r['id']; ?>"><span id="" class="material-icons i-edit" title="Editar">edit</span></a> 
                                 <?php endif ;?>
                                <?php if(!($r['estatus_id'] == 2 || $r['estatus_id'] == 5)):?>
                                <span id="deleteReq" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                                <?php endif ;?>
                                <span id="showReq" class="i-document material-icons">description</span></div>
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

          <!-- Modal enviar Requisició correo-->
                    <div class="modal fade modal-enviar" id="enviarReqModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons far fa-envelope pr-2"></span>Enviar correo <strong id="folioReq"></strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="border-modal modal-body">
                                    <form id="formEnviar">
                                        <div class="container">
                                            <div class="row mb-2" id="correo1">
                                                <div class="div-labl-correo text-right mr-1"><label>Para:</label></div> 
                                                <div><input type="text" id="correoModal" name="correo[]" class="item-correo correo-user"></div> 
                                                <span title="Agregar correo" class="material-icons i-add p-1" id="agregarCorreo">add</span>      
                                            </div>
                                            <div class="row mb-2">
                                                  <div class="div-labl-correo text-right mr-1"><label>Comentarios:</label></div> 
                                                  <div><textarea class="textarea-correo" id="cuerpoCorreo"></textarea></div> 
                                            </div>
                                              <div class="row">
                                                  <div class="ml-5 d-flex justify-content-between ">
                                                 <?php if(Utils::permisosCompras()):?>
                                                 <input class="mt-1" type="checkbox" name="rechazarReq" id="rechazarReq"><label class="text-danger ml-1" for="rechazarReq"> Rechazar requisición</label><br>
                                                 <?php endif;?>
                                                 <input class="mt-1" type="checkbox" name="ajuntarReq" id="ajuntarReq" > <label class="ml-1 mb-2 mr-3" for="ajuntarReq"> Adjuntar archivo requisición</label><br>
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
          
               <!-- Modal busqueda requisicion-->
                    <div class="modal fade modal-busqueda" id="buscarRequisicion" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar requisición</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="border-modal modal-body">
                                    <form id="formBuscar" method="POST" action="<?=principalUrl?>?controller=Compras&action=buscarRequisicion">
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
                                                        <option value="" selected disabled>--Selecciona--</option>
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
                                                        <option value="" selected disabled>--Selecciona--</option>
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