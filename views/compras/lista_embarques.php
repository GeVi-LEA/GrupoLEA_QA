
<div class="row mt-1 req-estados">
    <span hidden><?=$carroTanque = Utils::getCarroTanque()->id;?></span>
    <div class="col-5 div-estados" id="divEstados"> 
        <a class="<?= isset($idEst) ? "" : "estatus-hover"?>" href="<?= principalUrl ?>?controller=Compras&action=embarques"><i title="Ver todos los embarques" class="i-list-ol fas fa-list-ol"></i></a>
        <?php if(Utils::permisosCompras()):?>
        <a class="estatus-gen <?= $idEst == 1 ? "estatus-hover" : "" ?>" title="Embarques generados" href="<?= principalUrl ?>?controller=Compras&action=embarques&idEst=1">Generados</a>
        <a class="estatus-transito <?= $idEst == 8 ? "estatus-hover" : "" ?>" title="Embarques en transito" href="<?= principalUrl ?>?controller=Compras&action=embarques&idEst=8">En transito</a>
        <a class="estatus-acept <?= $idEst == 11 ? "estatus-hover" : "" ?>" title="Embarques en terminal" href="<?= principalUrl ?>?controller=Compras&action=embarques&idEst=11">En terminal</a>
        <a class="estatus-fin <?= $idEst == 5 ? "estatus-hover" : "" ?>" title="Embarques finalizados" href="<?= principalUrl ?>?controller=Compras&action=embarques&idEst=5">Finalizados</a>  
        <a class="estatus-cancel <?= $idEst == 2 ? "estatus-hover" : "" ?>" title="Embarques cancelados" href="<?= principalUrl ?>?controller=Compras&action=embarques&idEst=2">Cancelados</a>
        <?php endif;?>
    </div>
    <div class="col-2 text-center"><h5>Embarques</h5></div>
    <div class="col-5 menu-iconos d-flex justify-content-end">
        <div class="mr-3"><i id="exportar" title="Exportar excel" class="i-excel material-icons fas fa-file-excel"></i></div>
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Número factura..."><i id="buscarOrden" class="fas fa-search i-search material-icons"></i></div>
    </div>
</div>
<section class="sec-tabla text-center">
    <?php if (!empty($embarques)): ?>
        <table class="table table-condensed tabla-registros tabla-lista-embarques" id="tablaRegistros">
            <thead >
            <th class="w-td-30 px-0 mx-0"></th>
            <th class="px-0 mx-0">Factura</th>
            <th class="w-td-30 p-0 m-0"><i class="fas fa-paperclip"></i></th>
            <th>OC producto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Transporte</th>
            <th>Proveedor</th>
            <th>Req. flete</th>
            <th>Orden flete</th>
            <th class="px-0 mx-0" >Pedimento</th>
            <th class="p-0 m-0"><i class="fas fa-paperclip"></i></th>
            <th>Fecha factura</th>   
            <th>Estatus</th>       
            </thead>
            <tbody>
                <?php foreach ($embarques as $e): ?>
                    <?php if(Utils::permisosCompras()):?>
                    <tr class="tr">
                      <td id="idOrden" hidden><?= $e['idOrdenProducto'];?></td>
                      <td id="idFlete" hidden><?= $e['id']; ?></td>
                        <td class="w-td-30 p-0 m-0"><span title="Embarque"  id="showFlete" class="material-icons i-recibir"><?= $carroTanque == $e['transporte_id'] ? "directions_subway" : "local_shipping";?></span></td>   
                        <td class="px-0 mx-0"><strong><?= $e['numero_factura']; ?></strong></td>
                        <td class="w-td-30 p-0 m-0"><input id="factura" type="hidden" value="<?= $e['factura']; ?>" /><i id="showFactura" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver factura" <?= $e['factura']== null ? "hidden" :"" ?>></i></td> 
                        <td><span><?= $e['ordenProducto']; ?></span></td>
                        <td><span><?= $e['producto']; ?></span></td>
                        <td><span><?= UtilsHelp::numero2Decimales($e['cantidad_cargada']); ?></span><span class="ml-1">gl.</span></td>
                        <td><span id="unidadTabla"><?= $carroTanque == $e['transporte_id'] ? $e['carroTanque'] : $e['numero_transporte'];?></span></td>
                        <td><span><?= $e['proveedor'] == null ? $carroTanque == $e['transporte_id'] ? Utils::getKansas()->nombre : "" : $e['proveedor']; ?></span></td>
                        <td><span><?= $e['folioFlete']; ?></span></td>
                        <td></span><span><?= $e['orden']  ?></span></td>
                        <td class="px-0 mx-0"><span><?= $e['pedimento']?></span></td>
                        <td class="w-td-30 px-0 mx-0"><input type="hidden" id="pedimento" value="<?=$e['pedimentoDoc']; ?>" /><i id="showPedimento" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver pedimento" <?= $e['pedimentoDoc']== null ? "hidden" :"" ?>></i></td>
                        <td><?=$e['fecha_factura'] == "" ? "" : date('d/m/Y', strtotime($e['fecha_factura'])); ?></td>
                        <td id="fechaTransitoTabla" hidden><?=$e['fecha_transito'] == "" ? "" : date('d/m/Y', strtotime($e['fecha_transito'])); ?></td>
                        <td><div id="tdEstatus" class="<?=Utils::getClaseEstado($e['clave']);?> estatus-tabla estatus-small"><span id="estatus"><?=$e['estatus'];?></span></div></td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay embarques</span>                   
    <?php endif; ?>
</section>
<!-- Modal busqueda orden de compra-->
<div class="modal fade modal-busqueda" id="buscarOrdenCompra" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar embarques</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formBuscar" method="POST" action="<?=principalUrl?>?controller=Compras&action=buscarEmbarques">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                             <div class="pr-3"><input type='text' name="fechaInicio"  class="item-small" id="fechaInicio"  readOnly  placeholder="Fecha inicio..."/></div>
                             <div class="pr-2"> <label>Y</label></div>
                             <div><input type='text' name="fechaFin"  class="item-small" id="fechaFin"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="producto">Producto:</label></div>                                             
                            <div>                            
                                <select name="producto" class="item-medium"" id="producto"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $productos = Utils::getProductos();
                                    if (!empty($productos)):
                                        foreach ($productos as $pro):
                                            ?>
                                                 <option value="<?= $pro->id ?>"><?= $pro->nombre." (".$pro->nombre_refineria.")"?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="aduana">Aduana:</label></div>                                             
                            <div>                            
                                <select name="aduanaExp" class="item-medium"" id="aduana"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $aduanas = Utils::getAduanas();
                                    if (!empty($aduanas)):
                                        foreach ($aduanas as $a):
                                            ?>
                                                 <option value="<?= $a->id ?>"><?= $a->clave?></option>
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
                                <select name="proveedor" class="item-big"" id="proveedorBuscar"> 
                                   <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $proveedores = Utils::getTransportistas();
                                    if (!empty($proveedores)):
                                        foreach ($proveedores as $prov):
                                            ?>
                                                 <option value="<?= $prov->id ?>"><?= $prov->nombre?></option>
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

<!-- Modal exportar orden de compra-->
<div class="modal fade modal-busqueda modal-exportar" id="exportarModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3 modal-title" id="titleModal"><span class="i-excel material-icons fas fa-file-excel pr-3"></span>Generar reporte embarques</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formExportar" method="POST" action="<?=principalUrl?>?controller=Compras&action=exportarComprasEmbarquesExcel">
                    <div class="container">
                    <div class="row d-flex justify-content-center mb-2">
                        <div>
                            <input type="radio" name="tipoReporte"  value="1" checked/><label class="ml-1">Reporte compras</label>
                            <input class="ml-5" type="radio"  name="tipoReporte"  value="2"/> <label >Reporte pedimientos</label>
                        </div>
                    </div>
                            <div class="row d-flex mb-2">

                                  <div class="w-25 text-right pr-1"> <label>Ordenar por:</label></div>
                           <div>                            
                                <select name="ordenar" class="item-medium" id="ordenar"> 
                                    <option value="1" selected>Núm. factura</option>
                                    <option value="2" >Fecha factura</option>
                                    <option value="3" >Fecha pedimento</option>
                                </select> 
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                             <div class="pr-3"><input type='text' name="fechaInicioExp"  class="item-small" id="fechaInicioExp"  readOnly  placeholder="Fecha inicio..."/></div>
                             <div class="pr-2"> <label>Y</label></div>
                             <div><input type='text' name="fechaFinExp"  class="item-small" id="fechaFinExp"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                       <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="productoExp">Producto:</label></div>                                             
                            <div>                            
                                <select name="productoExp" class="item-medium"" id="productoExp"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $productos = Utils::getProductos();
                                    if (!empty($productos)):
                                        foreach ($productos as $pro):
                                            ?>
                                                 <option value="<?= $pro->id ?>"><?= $pro->nombre." (".$pro->nombre_refineria.")"?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="aduanaExp">Aduana:</label></div>                                             
                            <div>                            
                                <select name="aduanaExp" class="item-medium"" id="aduanaExp"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $aduanas = Utils::getAduanas();
                                    if (!empty($aduanas)):
                                        foreach ($aduanas as $a):
                                            ?>
                                                 <option value="<?= $a->id ?>"><?= $a->clave?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="w-25 text-right pr-1"><label for="proveedorExp">Proveedor:</label></div>                                             
                            <div>                            
                                <select name="proveedorExp" class="item-big"" id="proveedorExp"> 
                                   <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $proveedores = Utils::getTransportistas();
                                    if (!empty($proveedores)):
                                        foreach ($proveedores as $prov):
                                            ?>
                                                 <option value="<?= $prov->id ?>"><?= $prov->nombre?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <input type="hidden" id="pdf" name="pdf"/>
                    </div>
                 </form>
            </div>
                     <div class=" border-modal modal-footer text-center">
                          <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                          <button class="btn exportarBtn" id="btnExportar"><span class="material-icons fas fa-file-excel pr-2"></span>Excel</button>
                          <button class="btn exportarPdfBtn" id="btnPdfExportar"><span class="material-icons fa-solid fa-file-pdf pr-2"></span>PDF</button>
                     </div>
           </div>  
             </div>
        </div>

