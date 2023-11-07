<div class="row mt-1 req-estados">
    <span hidden><?=$carroTanque = Utils::getCarroTanque()->id;?></span>
    <div class="col-4 div-estados" id="divEstados"> 
        <a class="<?= isset($idEst) ? "" : "estatus-hover"?>" href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos"><i title="Ver todos los embarques" class="i-list-ol fas fa-list-ol"></i></a>
        <?php if(Utils::permisosCompras() || Utils::permisosAlmacen()):?>
        <a class="estatus-transito <?= $idEst == 8 ? "estatus-hover" : "" ?>" title="Almacén en transito" href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos&idEst=8">En transito</a>
        <a class="estatus-pagado <?= $idEst == 11 ? "estatus-hover" : "" ?>" title="Almacén en terminal" href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos&idEst=11">En terminal</a>
        <a class="estatus-fin <?= $idEst == 5 ? "estatus-hover" : "" ?>" title="Almacén en finalizados" href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos&idEst=5">Finalizados</a>
        <?php endif;?>
    </div>
    <div class="col-4 text-center"><h5>Almacén de básicos</h5></div>
    <div class="col-4 menu-iconos d-flex justify-content-end">
        <div class="mr-3"><i id="exportar" title="Exportar excel" class="i-excel material-icons fas fa-file-excel"></i></div>
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Num. unidad..."><i id="buscarOrden" class="fas fa-search i-search material-icons"></i></div>
    </div>
</div>
<section class="sec-tabla text-center">
    <?php if (!empty($embarques)): ?>
        <table class="table table-condensed tabla-registros" id="tablaRegistros">
            <thead>
                <th class="w-td-30 px-0 mx-0"></th>
                <th>Unidad</th>
                <th>Producto</th>
                <th>Litros</th> 
                <th>Galones</th>  
                <th>Precio</th>  
                <th>Costo</th>
                <th class="px-0 mx-0">Factura</th>
                <th class="w-td-30 p-0 m-0"><i class="fas fa-paperclip"></i></th>
                <th>Refineria</th>
                <th class="px-0 mx-0" >Pedimento</th>
                <th class="p-0 m-0"><i class="fas fa-paperclip"></i></th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th class="px-0 mx-0">Días</th>
                <th class="px-0 mx-0"></th>
                <th>Estatus</th> 
            </thead>
            <tbody>
                <?php  $cont=0; foreach ($embarques as $e): 
                    $cont++;
                    $ped = explode(" ", $e['pedimento']);
                    $pedimento = $ped != null ? end($ped) : "";?>
                    <?php if(Utils::permisosCompras() || Utils::permisosAlmacen()):?>
                    <tr class="tr">
                      <td id="idOrden" hidden><?= $e['idOrdenProducto'];?></td>
                      <td id="idFlete" hidden><?= $e['id']; ?></td>
                      <td class="d-flex"><span class="pr-1"><?=$cont?></span><span title="Embarque"  id="showFlete" class="material-icons i-recibir"><?=$carroTanque == ($e['transporte_id']) ? "directions_subway" : "local_shipping";?></span></td>
                        <td><strong><?= $carroTanque == ($e['transporte_id']) ? '<a href="" id="infoCarro">'.$e['carroTanque'].'</a>' : $e['numero_transporte'];?></strong></td>
                        <td id="unidadTabla" hidden><?= $carroTanque == ($e['transporte_id']) ? $e['carroTanque'] : $e['numero_transporte'];?></td>
                        <td><span><?= UtilsHelp::recortarString($e['producto'], '('); ?></span></td>
                        <td><span><?= UtilsHelp::numero2Decimales($e['litros_facturados']); ?></span></td>
                        <td><span><?= UtilsHelp::numero2Decimales($e['cantidad_cargada']); ?></td>
                        <td><span>$ <?= UtilsHelp::numero2Decimales($e['precio_producto'], true, 3); ?></td>
                        <td><span>$ <?= UtilsHelp::numero2Decimales($e['importe'], true, 2); ?></td>
                        <td class="px-0 mx-0"><span><?= $e['numero_factura']; ?></span></td>
                        <td class="w-td-30 p-0 m-0"><input id="factura" type="hidden" value="<?= $e['factura']; ?>" /><i id="showFactura" class="i-pdf material-icons far fa-file-pdf" title="Ver factura" <?= $e['factura']== null ? "hidden" :"" ?>></i></td>
                        <td><span><?= substr(UtilsHelp::recortarString($e['producto'], '(', true),0, -1); ?></span></td>
                        <td class="px-0 mx-0"><span><?= $pedimento?></span></td>
                        <td class="w-td-30 px-0 mx-0"><input type="hidden" id="pedimento" value="<?=$e['pedimentoDoc']; ?>" /><i id="showPedimento" class="i-pdf material-icons far fa-file-pdf" title="Ver pedimento" <?= $e['pedimentoDoc']== null ? "hidden" :"" ?>></i></td>
                        <td><?=$e['fechaPedimento'] == "" ? "" : date('d/m/Y', strtotime($e['fechaPedimento'])); ?></td>
                        <td hidden id="fechaTransitoTabla"><?=$e['fecha_transito'] == "" ? "" : date('d/m/Y', strtotime($e['fecha_transito'])); ?></td>
                        <td> <select class="ubicacion-select" id="ubicacion">
                               <option value="" selected>--Selecciona--</option>
                                    <?php
                                        foreach (ubicaciones_kansas as $i => $ub):
                                            ?>
                                                 <option value="<?= $i?>" <?= count($e['movimiento']) >= 1 ? $e['movimiento'][0]['ubicacion'] == $i ? "selected" : "" : ""?>><?=$ub?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select></td>
                        <td id="diasTransito"><?=$e['dias_llegada'] == "" ? $e['dias_transito'] != "" ? $e['dias_transito'] : "" : $e['dias_llegada']; ?></td>
                        <td><?php if(count($e['movimiento'])> 0):?><span id="showEmbarque" class="material-icons expand">expand_more</span><?php endif ;?></td>
                         <td><span><div id="tdEstatus" class="<?=Utils::getClaseEstado($e['clave']);?> estatus-tabla estatus-small"><span id="estatus"><?=$e['estatus'];?></span></div></td>
                    </tr>
           <?php if (count($e['movimiento']) > 0): ?>
               <tr class="tr-emabrques background-tabla-embarques transparent" hidden>
                   <td colspan="5"><h3 class="d-block"><?= $carroTanque == ($e['transporte_id']) ? $e['carroTanque'] : $e['numero_transporte'];?></h3></td>
                   <td colspan="9"> 
                    <table class="table tabla-embarques" id="tablaMovimientos">
                        <thead>
                            <th>Fecha</th>
                            <th>Ubicación</th>
                            <th></th>
                        </thead> 
                 <tbody>
               <tr class="emabrque-total">
                     <td colspan="3"><strong class="mr-1">Fecha tránsito:</strong><span><?=$e['fecha_transito'] == "" ? "" : date('d/m/Y', strtotime($e['fecha_transito'])); ?></span>
                     <span id="editTransito" class="material-icons i-edit ml-3" title="Editar fecha de tránsito">edit</span></td>
                  </tr>
               <?php foreach ($e['movimiento'] as $m): ?>
                 <tr class="background-tabla-embarques">
                    <td id="idMovimiento" hidden><?=$m['id']; ?></td>
                    <td id="idUbicacion" hidden><?=$m['ubicacion']; ?></td>
                    <td><?=$m['fecha']  == "" ? "" : date('d/m/Y', strtotime($m['fecha'])); ?></td>
                    <td><?=ubicaciones_kansas[$m['ubicacion']]; ?></td>
                    <td><span id="deleteMovimineto" class="material-icons i-delete" title="Eliminar">delete_forever</span></td>
                <?php endforeach; ?>
                     </tbody>
                    </table>
                        </td>
                    </tr>     
                 <?php endif;?>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay almacén</span>      
    <?php endif; ?>
</section>
<!-- Modal busqueda almacen-->
<div class="modal fade modal-busqueda" id="buscarOrdenCompra" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar en almacén</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formBuscar" method="POST" action="<?=principalUrl?>?controller=Almacen&action=buscarAlmacen">
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
                                                 <option value="<?= $a->id ?>"><?= $a->nombre?></option>
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
                <h5 class="ml-3 modal-title" id="titleModal"><span class="i-excel material-icons fas fa-file-excel pr-3"></span>Generar reporte almacén</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formExportar" method="POST" action="<?=principalUrl?>?controller=Almacen&action=exportarAlmacenExcel">
                    <div class="container">
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
                                                 <option value="<?= $a->id ?>"><?= $a->nombre?></option>
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
                          <button class="btn exportarPdfBtn" id="btnPdfExportar"><span class="material-icons far fa-file-pdf pr-2"></span>PDF</button>
                     </div>
           </div>  
             </div>
        </div>

<!-- Modal transtito-->
<div class="modal fade modal-busqueda modal-transito" id="transitoModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="ml-3 modal-title" id="titleModal"><i class="fas fa-route mr-2"></i><span>Tránsito</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formTransito">
                    <div class="container">
                           <div class="row mb-2 ml-4">
                            <div class="col-4 text-right"><label>Unidad:</label></div>                                                 
                            <div class=" col-4 ml-0 pl-0"><input type="text" id="unidad" class="item-medium" disabled/></div>
                        </div>
                        <div class="row ml-4">
                            <div class="col-4 pl-0 text-right"><label>Fecha tránsito:</label></div>                                                 
                            <div class="d-flex col-4 ml-0 pl-0"><input type="text" name="fechaTransito" id="fechaTransito" class="item-small" readOnly /></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="btnTransito"></i>Tránsito</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal finalizar-->
<div class="modal fade modal-busqueda modal-transito" id="finalizarEmbarqueModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="ml-3 modal-title" id="titleModal"><i class="fas fa-route mr-2"></i><span>Finalizar embarque</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formFinalizar">
                    <div class="container">
                           <div class="row mb-2 ml-4">
                            <div class="col-4 text-right"><label>Unidad:</label></div>                                                 
                            <div class=" col-4 ml-0 pl-0"><input type="text" id="unidadFinalizar" class="item-medium" disabled/></div>
                        </div>
                        <div class="row ml-4">
                            <div class="col-4 pl-0 text-right"><label id="fechaLiberacion">Fecha llegada:</label></div>                                                 
                            <div class="d-flex col-4 ml-0 pl-0"><input type="text" name="fechaLlegada" id="fechaLlegada" class="item-small" readOnly /></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="btnFinalizarEmbarque"></i>Finalizar</button>
            </div>
        </div>
    </div>
</div>


