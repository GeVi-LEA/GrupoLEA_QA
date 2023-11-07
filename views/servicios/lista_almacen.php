
<div class="row mt-1 req-estados">
    <div class="col-4 div-estados" id="divEstados">
        <span>Ordenar por: </span>
        <?php if(Utils::permisosCompras()):?>
        <a class="estatus-gen <?= $idEst == null ? "estatus-hover" : "" ?>"  href="<?= principalUrl ?>?controller=Servicios&action=serviciosAlmacen">Lote</a>
        <a class="estatus-gen <?= $idEst == 1 ? "estatus-hover" : "" ?>" href="<?= principalUrl ?>?controller=Servicios&action=serviciosAlmacen&idEst=1">Cliente</a>
       <a class="estatus-gen <?= $idEst == 2 ? "estatus-hover" : "" ?>" href="<?= principalUrl ?>?controller=Servicios&action=serviciosAlmacen&idEst=2">Producto</a>  
       
        <?php endif;?>
    </div>
    <div class="col-4 text-center"><h5>SERVICIO ALMACEN - ENSACADO</h5></div>
    <div class="col-4 menu-iconos d-flex justify-content-end">
        <div class="mr-1"><i id="preciosServClientes" title="Precios servicios clientes" class="i-edit material-icons fa-solid fa-file-invoice-dollar"></i></div>
        <div class="mr-1"><i id="entradaSalida" title="Entrada / Salida" class="i-clip material-icons fa-solid fa-file-circle-plus"></i></div>
        <div class="mr-3"><i id="exportar" title="Exportar excel" class="i-excel material-icons fas fa-file-excel"></i></div>
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Número factura..."><i id="buscarOrden" class="fas fa-search i-search material-icons"></i></div>
    </div>
</div>
<section class="sec-tabla text-center">
    <?php if (!empty($lotesAlmacen)): ?>
        <table class="table table-condensed tabla-registros" id="tablaRegistros">
            <thead>
            <th class="w-td-30 px-0 mx-0"></th>
            <th>Lote</th>
            <th>Producto</th>
            <th>Alias</th>
            <th>Cliente</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Stock</th>
            <th></th>
            </thead>
            <tbody>
               <?php foreach ($lotesAlmacen as $l): ?>
                    <?php if(Utils::permisosCompras()):?>
                    <tr class="tr">
                        <td></td>
                        <td><strong><?=$l['lote'] ?></strong></td>
                        <td><?=$l['producto'] ?></td>
                        <td><?=$l['alias'] ?></td>
                        <td><?=$l['cliente'] ?></td>
                        <td><span class="font-green"><?=UtilsHelp::numero2Decimales($l['descargas'],true,0) ?></span></td>
                        <td><span class="font-red"><?=UtilsHelp::numero2Decimales($l['cargas'],true,0) ?></span></td>
                        <td><span><?=UtilsHelp::numero2Decimales($l['stock'],true,0) ?></span></td>
                        <td> <span id="showServiciosNave" class="material-icons expand">expand_more</span></td>
                    </tr>
           <tr class="transparent" hidden>
             <td colspan="15" class="p-0"> 
                    <table class="table tabla-almacen m-0">
                        <thead>
                            <th class="w-td-30 px-0 mx-0"></th>
                            <th>Folio</th>
                            <th>Servicio</th>
                            <th>Empaque</th>
                            <th>Unidad</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                        </thead> 
            <tbody>
                <?php foreach ($l['servicios'] as $s): ?>
                 <tr class=<?= $s->isDescarga ? "'font-green back-green'" : ""; ?>>
                   <td id="idServicio" hidden><?= $s->id; ?></td>
                   <td class="w-td-30 p-0 m-0"><i class="fa-regular fa-note-sticky material-icons icon" title="Ver servicio" id="imprimirServicio"></i></td>
                   <td class="px-0 mx-0"><strong><?= $s->folio; ?></strong></td>
                   <td class="px-0 mx-0"><span><?= $s->servicio; ?></span></td>
                   <td class="px-0 mx-0"><span><?= $s->empaque; ?></span></td>
                   <td class="px-0 mx-0"><span><?= $s->unidad; ?></span></td>
                   <td class="px-0 mx-0"><span><?= UtilsHelp::fechaHora($s->fecha_fin) ?></span></td>
                   <td class="px-0 mx-0"><span><?= UtilsHelp::numero2Decimales($s->total, true, 0)?></span><span> kg.</span></td>  
                  </tr>
                <?php  endforeach; ?>
                     </tbody>
                    </table>
                        </td>
                    </tr>
                <?php endif; ?>
                   <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay servicios</span>                   
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
                          <button class="btn exportarPdfBtn" id="btnPdfExportar"><span class="material-icons far fa-file-pdf pr-2"></span>PDF</button>
                     </div>
           </div>  
             </div>
        </div>

 <script src="../servicios/assets/js/servicios.js"></script> 