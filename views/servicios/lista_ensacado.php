<?php
include 'assets/js/graficas_entradas_js.php';
?>


<div class='row' style="margin-top:30px;">
    <div class='col-12' id="div-lista">
        <div class="row mt-1 req-estados">
            <div class="col-5 div-estados" id="divEstados">
                <a class="<?= isset($idEst) ? '' : 'estatus-hover' ?>" href="<?= principalUrl ?>?controller=Servicios&action=ensacado"><i title="Ver todas las entradas" class="i-list-ol fas fa-list-ol"></i></a>
                <?php if (Utils::permisosSupervisor()): ?>
                <a class="estatus-filter estatus-gen <?= $idEst == 1 ? 'estatus-hover' : '' ?>" title="Generadas" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=1">Generados</a>
                <a class="estatus-filter estatus-acept <?= $idEst == 11 ? 'estatus-hover' : '' ?>" title="En terminal" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=11">En terminal</a>
                <a class="estatus-filter estatus-proceso <?= $idEst == 3 ? 'estatus-hover' : '' ?>" title="En proceso" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=3">En proceso</a>
                <a class="estatus-filter estatus-fin <?= $idEst == 5 ? 'estatus-hover' : '' ?>" title="Finalizados" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=5">Finalizados</a>
                <a class="estatus-filter estatus-cancel <?= $idEst == 2 ? 'estatus-hover' : '' ?>" title="Cancelados" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=2">Cancelados</a>
                <a class="estatus-filter estatus-liberado <?= $idEst == 15 ? 'estatus-hover' : '' ?>" title="Liberadas" href="<?= principalUrl ?>?controller=Servicios&action=ensacado&idEst=15">Liberados</a>

                <?php endif; ?>
            </div>
            <div class="col-3 text-center">
                <h5>LOGISTICA</h5>
            </div>
            <div class="col-4 menu-iconos d-flex justify-content-end">

                <div class="mr-1"><i id="lista" title="Lista" data-tipo="lista" class="btn-tab material-icons fa-solid fa-list" style="color:orange;"></i></div>
                <div class="mr-1"><i id="grafica" title="Gráfica" data-tipo="grafica" class="btn-tab material-icons fa-solid fa-chart-simple " style="color:blue;"></i></div>

                <div class="mr-1"><i id="preciosServClientes" title="Precios servicios clientes" class="i-edit material-icons fa-solid fa-file-invoice-dollar"></i></div>
                <div class="mr-1"><i id="entradaSalida" title="Entrada / Salida" class="i-clip material-icons fa-solid fa-file-circle-plus"></i></div>
                <div class="mr-3"><i id="exportar" title="Exportar excel" class="i-excel material-icons fas fa-file-excel"></i></div>
                <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Número unidad..."><i id="buscarOrden" class="fas fa-search i-search material-icons"></i></div>
            </div>
        </div>
        <section class="sec-tabla text-center">
            <?php if (!empty($servicios)): ?>
            <table class="table table-condensed tabla-registros" id="tablaRegistros">
                <thead>
                    <th class="w-td-30 px-0 mx-0">FT/AT</th>
                    <th class="w-td-30 px-0 mx-0"></th>
                    <th class="px-0 mx-0">Num. Unidad</th>
                    <th class="w-td-30 p-0 m-0"><i class="fas fa-paperclip"></i></th>
                    <th>Cliente</th>
                    <th>Fecha llegada</th>
                    <th>Fecha Salida</th>
                    <th>Ticket</th>
                    <th class="w-td-30 p-0 m-0"><i class="fas fa-paperclip"></i></th>
                    <th>Estatus</th>
                    <th class="w-td-30 px-0 mx-0"></th>

                </thead>
                <tbody>
                    <?php foreach ($servicios as $s): ?>
                    <?php if (Utils::permisosSupervisor()): ?>
                    <tr class="tr">
                        <td id="" hidden><?= $s['id']; ?></td>
                        <td id="idEnsacado" hidden><?= $s['id']; ?></td>
                        <td class="w-td-30 p-0 m-0"><span id="showEnsacado"
                                class="material-icons i-recibir"><?= $s['tipo_transporte_id'] != null && in_array($s['tipo_transporte_id'], $arrayIdsTr) ? 'directions_subway' : 'local_shipping'; ?></span></td>
                        <td class="w-td-30 px-0 mx-0"><strong><?= Utils::getOperacionServicios($s['servicio']) ?></strong></td>
                        <td class="px-0 mx-0"><strong><?= $s['numUnidad']; ?></strong></td>
                        <td class="w-td-30 p-0 m-0"><i id="show" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver orden" data-unidad="<?= $s['numUnidad']; ?>"
                                data-doc="<?= $s['doc_remision'] != '' ? $s['doc_remision'] : ''; ?>" <?= $s['doc_remision'] == null ? 'hidden' : '' ?>></i>
                        </td>
                        <td><span><?= $s['nombreCliente']; ?></span></td>
                        <td><?= $s['fecha_entrada'] == '' ? '' : date('d/m/Y', strtotime($s['fecha_entrada'])); ?></td>
                        <td><?= $s['fecha_salida'] == '' ? '' : date('d/m/Y', strtotime($s['fecha_salida'])); ?></td>
                        <td><span><?= $s['ticket']; ?></span></td>
                        <td class="w-td-30 p-0 m-0"><i id="showFactura" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver ticket" <?= $s['doc_ticket'] == null ? 'hidden' : '' ?>></i></td>
                        <td class="d-flex justify-content-center">
                            <div id="tdEstatus" class="<?= Utils::getClaseEstado($s['clave']); ?> estatus-tabla estatus-small text-center"><span id="estatus"><?= $s['estatus']; ?></span></div>
                        </td>
                        <td><?php if (count($s['servicio']) > 0): ?>
                            <span id="showServiciosNave" class="material-icons expand">expand_more</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr class="transparent" hidden>
                        <td colspan="15" class="p-0">
                            <table class="table tabla-embarques m-0">
                                <thead>
                                    <th class="w-td-30 px-0 mx-0"></th>
                                    <th>Folio</th>
                                    <th>Lote</th>
                                    <th>Servicio</th>
                                    <th>Fecha progrmación</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th>Empaque</th>
                                    <th>Cantidad</th>
                                    <th>Estatus</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($s['servicio'] as $serv): ?>
                                    <tr class="background-tabla-embarques">
                                        <td id="idServicio" hidden><?= $serv['id']; ?></td>
                                        <td class="w-td-30 p-0 m-0"><i class="fa-regular fa-note-sticky material-icons icon" title="Ver servicio" id="imprimirServicio"></i></td>
                                        <td class="px-0 mx-0"><strong><?= $serv['folio']; ?></strong></td>
                                        <td class="px-0 mx-0"><span><?= $serv['lote']; ?></span></td>
                                        <td class="px-0 mx-0"><span><?= $serv['nombreServ']; ?></span></td>
                                        <td class="px-0 mx-0"><span><?= UtilsHelp::formatoFecha($serv['fecha_programacion']); ?></span></td>
                                        <td class="px-0 mx-0"><span><?= UtilsHelp::fechaHora($serv['fecha_inicio']) ?></span></td>
                                        <td class="px-0 mx-0"><span><?= UtilsHelp::fechaHora($serv['fecha_fin']) ?></span></td>
                                        <td class="px-0 mx-0"><span><?= $serv['empaque'] ?></span></td>
                                        <td class="px-0 mx-0"><span><?= UtilsHelp::numero2Decimales($serv['cantidad'], true, 0); ?></span><span> kg.</span></td>
                                        <td class="d-flex justify-content-center">
                                            <div id="tdEstatus" class="<?= Utils::getClaseEstado($serv['clave']); ?> estatus-tabla estatus-small text-center"><span id="estatus"><?= $serv['estatus']; ?></span></div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr class="emabrque-total">
                                        <td colspan="11">
                                            <div class="d-flex justify-content-around">
                                                <div><strong class="mr-1">Días espuela:</strong><span></span></div>
                                                <div><strong class="mr-1">Peso teorico:</strong><span><?= UtilsHelp::numero2Decimales($s['peso_teorico'], true, 0) ?></span></span><span class="ml-1">kg.</span>
                                                </div>
                                                <div><strong class="mr-1">Peso bruto:</strong><span><?= UtilsHelp::numero2Decimales($s['peso_bruto'], true, 0) ?></span></span><span class="ml-1">kg.</span>
                                                </div>
                                                <div><strong class="mr-1">Peso neto:</strong><span><?= UtilsHelp::numero2Decimales($s['peso_neto'], true, 0) ?></span></span><span class="ml-1">kg.</span></div>
                                                <div><strong
                                                        class="mr-1">Cantidad:</strong><span><?= UtilsHelp::numero2Decimales($cantidad = UtilsHelp::sumarColumnaArray($s['servicio'], 'cantidad'), true, 0) ?></span><span
                                                        class="ml-1">kg.</span></div>
                                            </div>
                                        </td>
                                    </tr>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="border-modal modal-body">
                        <form id="formBuscar" method="POST" action="<?= principalUrl ?>?controller=Compras&action=buscarEmbarques">
                            <div class="container">
                                <div class="row d-flex mb-2">
                                    <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                                    <div class="pr-3"><input type='text' name="fechaInicio" class="item-small" id="fechaInicio" readOnly placeholder="Fecha inicio..." /></div>
                                    <div class="pr-2"> <label>Y</label></div>
                                    <div><input type='text' name="fechaFin" class="item-small" id="fechaFin" placeholder="Fecha fin..." readOnly /></div>
                                </div>
                                <div class="row d-flex mb-2">
                                    <div class="w-25 text-right pr-1"><label for="producto">Producto:</label></div>
                                    <div>
                                        <select name="producto" class="item-medium" id=" producto">
                                            <option value="" selected>--Selecciona--</option>
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
                                    <div class="w-25 text-right pr-1"><label for="aduana">Aduana:</label></div>
                                    <div>
                                        <select name="aduanaExp" class="item-medium" id=" aduana">
                                            <option value="" selected>--Selecciona--</option>
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
                                    <div class="w-25 text-right pr-1"><label for="proveedor">Proveedor:</label></div>
                                    <div>
                                        <select name="proveedor" class="item-big" id=" proveedorBuscar">
                                            <option value="" selected>--Selecciona--</option>
                                            <?php
                                                $proveedores = Utils::getTransportistas();
                                                if (!empty($proveedores)):
                                                    foreach ($proveedores as $prov):
                                            ?>
                                            <option value="<?= $prov->id ?>"><?= $prov->nombre ?></option>
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

        <!-- Documento modal -->
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

        <!-- <div class="modal fade modal-servicio" id="editarServicioModal2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog m-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header m-title justify-content-between">
                        <h5 class="modal-title ml-2"><span class="material-icons far fa-file-alt i-new"></span></a><span class="ml-2">Folio servicio:</span><span class="ml-2" id="folioServicio"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="border-modal modal-body">
                        <iframe id="iframe_servicio" style="width:100%; height:80vh;" src="http://192.168.0.22/GrupoLEA/?controller=Servicios&action=generarEnsacado&id=26" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
    <div class='col-12' id="div-grafica" style="display:none">
        <div class='row'>
            <div class='col-md-5 col-12'>
                <div id='chart_entradas' style='min-height:500px;'></div>
            </div>
            <div class='col-md-7 col-12'>
                <div class='row' style="float: right;">
                    <div class="col-4 menu-iconos d-flex justify-content-end">

                        <div class="mr-1"><i id="lista" title="Lista" data-tipo="lista" class="btn-tab material-icons fa-solid fa-list" style="color:orange;"></i></div>
                        <div class="mr-1"><i id="grafica" title="Gráfica" data-tipo="grafica" class="btn-tab material-icons fa-solid fa-chart-simple " style="color:blue;"></i></div>

                        <div class="mr-1"><i id="preciosServClientes" title="Precios servicios clientes" class="i-edit material-icons fa-solid fa-file-invoice-dollar"></i></div>
                        <div class="mr-1"><i id="entradaSalida" title="Entrada / Salida" class="i-clip material-icons fa-solid fa-file-circle-plus"></i></div>
                    </div>

                    <!-- <div class='col-md-2 col-12'>
                        <div class="mr-1"><i id="lista" title="Lista" data-tipo="lista" class="btn-tab material-icons fa-solid fa-list" style="color:orange;"></i></div>
                    </div>
                    <div class='col-md-2 col-12'>
                        <div class="mr-1"><i id="grafica" title="Gráfica" data-tipo="grafica" class="btn-tab material-icons fa-solid fa-chart-simple " style="color:blue;"></i></div>
                    </div> -->

                    <!-- <div class='col-md-2 col-12'>
                        <div class="mr-1"><i id="preciosServClientes2" title="Precios servicios clientes" class="i-edit material-icons fa-solid fa-file-invoice-dollar"></i></div>
                    </div>
                    <div class='col-md-2 col-12'>
                        <div class="mr-1"><i id="entradaSalida2" title="Entrada / Salida" class="i-clip material-icons fa-solid fa-file-circle-plus"></i></div>
                    </div> -->

                </div>
                <div class='row' style="margin-top: 30px;">


                    <h1 id="tituloestatus" style="border-radius: 10px; text-align: center; padding: 10px;"></h1>
                    <table id="tabla_estatus" class='table stripe' style='width:100%'>
                        <thead>
                            <th hidden>id</th>
                            <th hidden>idensacado</th>
                            <th>FT/AT</th>
                            <th>NUM. UNIDAD</th>
                            <th>CLIENTE</th>
                            <th>FECHA LLEGADA</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>

<script src='<?php echo URL; ?>assets/js/charts/echarts/echarts.js' type='text/javascript'></script>