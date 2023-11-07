<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/compras/assets/css/recepcion.css" />
        <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
        <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script> 
        <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?= root_url ?>views/compras/assets/js/recepcion.js"></script>
        <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> 
        <title>Embarques</title>
    </head>
    <body>
        <div class="contenedor" id="contenedor">
            <header class='d-flex'>
                <div>
                    <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" />
                </div>
                <div class="text-center w-75 mt-4">
                    <h4>EMBARQUES DE MATERIA PRIMA Y PEDIMENTOS</h4>
                </div>
            </header> 
            <div class="div-datos">
                <span class="titulo-div">Datos orden de compra producto</span>
                <div class="datos-recepcion datos mb-2 mt-1">
                    <div><strong class="mr-1">Proveedor:</strong> <span class="mr-5"><?= isset($r) ? $r['proveedor'] : ""; ?></span></div>   
                    <div><strong class="mr-1">Tipo de compra:</strong><span><?= $r['solicitud'] . ' - ' . $r['compra']; ?></span></div>
                    <div><strong class="mr-1">Fecha solicitada:</strong><span><?= isset($r) && $r['fecha_solicitud'] != "" ? date('d/m/Y', strtotime($r['fecha_solicitud'])) : ""; ?></span></div>
                </div>
                <div class="datos-recepcion datos mb-2">
                    <div><strong class="mr-1">Orden compra:</strong><span id="folioOrdenProducto"><?= isset($oc) ? $oc->folio : "" ?></span></div>
                    <div><strong class="mr-1">Producto:</strong><span><?= isset($prod) ? $prod->nombre : ""; ?></span></div>
                    <div><strong class="mr-1">Refíneria:</strong><span><?= isset($prod) ? $prod->nombre_refineria : ""; ?></span></div>
                    <input type="hidden" id="idDetalle" value="<?= $r['detalle'][0]['id']; ?>"/>
                    <div><strong class="mr-1">Cantidad:</strong><span id="cantidadOrden"><?= UtilsHelp::numero2Decimales($r['detalle'][0]['cantidad']) ?></span><span><?= Utils::getNombreUnidad(intval($r['detalle'][0]['unidad_id'])); ?></span></div>
                    <div><strong class="mr-1">Precio:</strong><span><?= UtilsHelp::numero2Decimales($r['detalle'][0]['precio_unitario']); ?></span></div>     
                </div> 
                <div class="datos-recepcion datos mb-2">
                    <div><strong class="mr-1">Tipo flete:</strong><span><?= $r['flete'] != null ? tipoFlete[intval($r['flete'])] : ""; ?></span></div>
                    <div><strong class="mr-1">Cantidad embarcada:</strong><span id="cantidadEmbarcada"><?= isset($oc) ? UtilsHelp::numero2Decimales($oc->cantidadCargada, true, 0) : "" ?></span><span>gl.</span></div>
                    <div><strong class="mr-1">Cantidad pendiente:</strong><span id="cantidadPendiente"><?= isset($oc) ? UtilsHelp::numero2Decimales(($r['detalle'][0]['cantidad'] - $oc->cantidadCargada), true, 0) : "" ?></span><span>gl.</span></div>
                   <?php if (isset($embarque)): ?>
                    <div><strong class="mr-1">Fecha embarque:</strong><span ><?=isset($embarque) ? date('d/m/Y', strtotime($embarque->fecha_alta)) : "" ?></div> 
                   <?php endif; ?>
                </div> 
            </div>
            <form id="embarqueForm" action="<?= root_url ?>?controller=Compras&action=generarEmbarque" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="hidden" id="idOrdenProducto" name="idOrdenProducto" value="<?= $oc->id; ?>" />
                    <input type="hidden" name="idEmbarque" id="idEmbarque" value="<?= isset($embarque) ? $embarque->id : ""; ?>"/>
                    <input type="hidden" name="idReqProducto" id="idReqProducto" value="<?= $r['id']; ?>"/>
                    <input type="hidden" name="empresa" id="empresa" value="<?= $r['empresa']; ?>"/>
                    <input type="hidden" name="tipoFlete" id="tipoFlete" value="<?= $r['flete']; ?>"/>
                </div>
                <?php if ($r['flete'] == 2): ?>
                    <div class="div-datos mt-3">
                        <span class="titulo-div">Flete</span>
                        <div class="datos mb-2 mt-2">
                            <input type="hidden" name="idReqFlete" id="idReqFlete" value="<?= isset($reqFlete) ? $reqFlete['id'] : ""; ?>"/>
                            <input type="hidden"  name="idDetalleFlete" id="idDetalleFlete" value="<?= isset($reqFlete) ? $reqFlete['detalle'][0]['id'] : ""; ?>"/>
                            <?php if (isset($kansas)): ?>
                                <div><strong class="mr-1">Proveedor:</strong>
                                    <input type="hidden"  name="proveedorFlete" class="item-medium" id="proveedorFlete" value="<?= isset($kansas) ? $kansas->id : ""; ?>"/>
                                    <input type="text"  name="nombreProveedorFlete" class="item-medium fixed" id="nombreProveedorFlete" value="<?= isset($kansas) ? $kansas->nombre : "" ?>" disabled/>
                                </div>                
                                <div><strong class="mr-1">Transporte:</strong>
                                    <input type="hidden" name="transporte" id="transporte" value="<?= $tipoTransporte->id; ?>"/>
                                    <input type="text" name="nombreTransporte" class="item-small fixed" id="nombreTransporte" value="<?= $tipoTransporte->nombre; ?>" disabled/>
                                </div> 
                            <?php else: ?>                           
                                <div>
                                 <?php if (!isset($reqFlete)): ?>
                                    <input type="checkbox" id="agregarFlete"><strong class="mr-3 ml-1">Agregar flete</strong>
                                 <?php endif;?>
                                 <strong class="mr-1">Proveedor:</strong>
                                    <select name="proveedorFlete"  class="item-medium" id="proveedorFlete">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                        if (!empty($proveedores)):
                                            foreach ($proveedores as $p):
                                                ?>
                                                <option value="<?= $p->id ?>" <?= isset($reqFlete) && $p->id == $reqFlete['proveedor_id'] ? 'selected' : ''; ?>><?= $p->nombre ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>                
                                <div><strong class="mr-1">Transporte:</strong>
                                    <select name="transporte" class="item-small" id="transporte" disabled>
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                        if (!empty($transportes)):
                                            foreach ($transportes as $t):
                                                ?>
                                                <option value="<?= $t->id ?>" <?= isset($reqFlete) && $t->id == $reqFlete['transporte_id'] ? 'selected' : ''; ?>><?= $t->nombre ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>   
                                </div> 
                                <div><strong class="mr-1">A-T:</strong>
                                    <input type="text" name="trailer" value="<?= isset($embarque) ? $embarque->numero_transporte : ""; ?>" id="trailer" class="item-small" /> 
                                </div>                      
                            <?php endif; ?>
                        </div>
                        <div class="datos mb-2 mt-2">
                            <div><strong class="mr-1">Aduana:</strong> 
                                <select name="aduana" class="item-small" id="aduana">
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <?php
                                    if (!empty($aduanas)):
                                        foreach ($aduanas as $a):
                                            ?>
                                            <option value="<?= $a->id ?>" <?= $r['aduana_id'] != "" && $a->id == $r['aduana_id'] ? 'selected' : isset($embarque) && $a->id == $embarque->aduana_id ? 'selected' : ''; ?>><?= $a->clave ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select></div>  
                            <div><strong class="mr-1">Ruta:</strong>
                                <select name="ruta" class="item-medium" id="ruta" disabled>
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    if (!empty($rutas)):
                                        foreach ($rutas as $ruta):
                                            ?>
                                            <option value="<?= $ruta->id ?>" <?=$r['ruta_id'] != "" && $ruta->id == $r['ruta_id'] ? "selected" : isset($reqFlete) && $ruta->id == $reqFlete['ruta_id'] ? 'selected' : ''; ?>><?= $ruta->ciudad_or . ' - ' . $ruta->ciudad_des ?> </option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>   
                            </div>
                            <div><strong class="mr-1">Costo flete:</strong><input value="<?= isset($reqFlete) ? UtilsHelp::numero2Decimales($reqFlete['detalle'][0]['precio_unitario']) : ""; ?>" type="text" name="costoFlete" id="costoFlete" class="item-small fixed" readOnly />
                                <strong>$</strong>   
                                <select class="item-ss-small fixed" name="moneda" id="moneda" disabled>
                                    <option value="">--</option>
                                    <?php
                                    foreach (monedas as $i => $m):
                                        ?>
                                        <option value="<?= $i ?>" <?= isset($reqFlete) && $reqFlete['moneda'] == $i ? 'selected' : $m['clave'] == "MX" ? 'selected' : "" ?>><?= $m['clave'] ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>  <span id="editMoneda" class="material-icons i-edit" title="Editar moneda">edit</span>
                            </div>
                        </div>
                        <div class="datos mb-2 mt-2">
                            <div><strong class="mr-1" id="fleteSpan">Req. flete:</strong><input type="text" id="folioReqFlete" name="folioReqFlete" value="<?= isset($reqFlete) ? $reqFlete['folio'] : "" ?>" class="item-small fixed" readOnly />
                                <select id="selectFletes" name="adjuntarReq" class="item-small ml-1" hidden disabled>
                                     <option value="">-Selecciona-</option>
                                </select></div>
                            <div><strong class="mr-1">Orden compra:</strong><input type="text" name="ordenFlete"  id="ordenFlete" value="<?= isset($reqFlete) ? $reqFlete['folio_oc'] : ""; ?>" class="item-small fixed" readOnly /></div>
                            <div><strong class="mr-1">Cliente:</strong>
                                <select name="cliente" class="item-medium" id="cliente" disabled>
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    if (!empty($clientes)):
                                        foreach ($clientes as $cli):
                                            ?>
                                            <option value="<?= $cli->id ?>"  <?= $cli->id == $r['cliente_id'] ? 'selected' : isset($reqFlete) && $cli->id == $reqFlete['cliente_id'] ? 'selected' : ""; ?>><?= $cli->nombre ?> </option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> <span id="editCliente" class="material-icons i-edit" title="Editar cliente">edit</span>   
                            </div>
                        </div>
                        <div class="datos mb-2 mt-2" id="datosCliente" hidden>
                            <div><strong class="mr-1">Dirección de entrega:</strong><input type="text" name="clienteDireccion" value="" id="clienteDireccion" class="item-big fixed" disabled/></div>                            
                        </div>
                    </div>
                <?php else: ?> 
                    <div class="div-datos mt-3">
                        <span class="titulo-div">Flete</span>
                        <div class="datos mb-2 mt-2">
                            <?php if (isset($kansas)): ?>
                                <div><strong class="mr-1">Proveedor:</strong>
                                    <input type="hidden"  name="proveedorFlete" class="item-medium" id="proveedorFlete" value="<?= isset($kansas) ? $kansas->id : ""; ?>"/>
                                    <input type="text"  name="nombreProveedorFlete" class="item-medium fixed" id="nombreProveedorFlete" value="<?= isset($kansas) ? $kansas->nombre : "" ?>" disabled/>
                                </div>                
                                <div><strong class="mr-1">Transporte:</strong>
                                    <input type="hidden" name="transporte" id="transporte" value="<?= $tipoTransporte->id; ?>"/>
                                    <input type="text" name="nombreTransporte" class="item-small fixed" id="nombreTransporte" value="<?= $tipoTransporte->nombre; ?>" disabled/>
                                </div>
                                <div><strong class="mr-1">Aduana:</strong> 
                                    <select name="aduana" class="item-small" id="aduana">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                        if (!empty($aduanas)):
                                            foreach ($aduanas as $a):
                                                ?>
                                                <option value="<?= $a->id ?>" <?= isset($embarque) && $a->id == $embarque->aduana_id ? 'selected' : isset($r) && $a->id == $r['aduana_id'] ? 'selected' : ''; ?>><?= $a->clave ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select></div>,
                            </div>
                            <div class="datos mb-2 mt-2">
                                <div><strong class="mr-1">Ruta:</strong>
                                    <select name="ruta" class="item-medium" id="ruta" disabled>
                                        <option value="" selected>--Selecciona--</option>
                                        <?php
                                        if (!empty($rutas)):
                                            foreach ($rutas as $ruta):
                                                ?>
                                                <option value="<?= $ruta->id ?>" <?= isset($r) && $ruta->id == $r['ruta_id'] ? 'selected' : ""; ?>><?= $ruta->ciudad_or . ' - ' . $ruta->ciudad_des ?> </option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>   
                                </div>            
                    <?php else: ?>
                           <div><strong >Transporte:</strong>
                                    <select name="transporte" class="item-small" id="transporteEmbarque">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                        if (!empty($transportes)):
                                            foreach ($transportes as $t):
                                                ?>
                                                <option value="<?= $t->id ?>" <?= isset($embarque) && $t->id == $embarque->transporte_id ? 'selected' : ''; ?>><?= $t->nombre ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>   
                                </div> 
                                <div><strong>A-T:</strong>
                                    <input type="text" name="trailer" value="<?= isset($embarque) ? $embarque->numero_transporte : ""; ?>" id="trailer" class="item-small" /> 
                                </div>   
                        <div><strong >Aduana:</strong> 
                            <select name="aduana" class="item-small" id="aduana">
                                <option value="" selected disabled>--Selecciona--</option>
                                <?php
                                if (!empty($aduanas)):
                                    foreach ($aduanas as $a):
                                        ?>
                                        <option value="<?= $a->id ?>" <?= isset($embarque) && $a->id == $embarque->aduana_id ? 'selected' : isset($r) && $a->id == $r['aduana_id'] ? 'selected' : ''; ?>><?= $a->clave ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select></div>
                    <?php endif; ?>  
                    <div><strong>Cliente:</strong>
                        <select name="clienteEmbarque" class="item-medium" id="clienteEmbarque" disabled>
                            <option value="" selected>--Selecciona--</option>
                            <?php
                            if (!empty($clientes)):
                                foreach ($clientes as $cli):
                                    ?>
                                    <option value="<?= $cli->id ?>"  <?= $cli->id == $r['cliente_id'] ? 'selected' : isset($embarque) && $cli->id == $embarque->cliente_id ? 'selected' : ''; ?>><?= $cli->nombre ?> </option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select> <span id="editCliente" class="material-icons i-edit" title="Editar cliente">edit</span>   
                    </div> 
            </div>
            <div class="datos mb-2 mt-2" id="datosCliente" hidden>
                <div><strong class="mr-1">Dirección de entrega:</strong><input type="text" name="clienteDireccion" value="" id="clienteDireccion" class="item-big fixed" disabled/></div>                            
            </div>
        </div>
    <?php endif; ?>
    <div class="div-datos mt-3">
        <span class="titulo-div">Factura</span>
        <div class="datos mb-2 mt-2">
            <div><strong class="mr-1"># Factura:</strong><input type="text" name="numeroFactura" value="<?= isset($embarque) ? $embarque->numero_factura : ""; ?>" id="numeroFactura" class="item-small" /></div>
            <div><strong class="mr-1">Galones:</strong> <input type="text" name="cantidadFactura" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->cantidad_cargada) : ""; ?>" id="cantidadFactura" class="item-small"/></div>  
            <div><strong class="mr-1">Litros facturados:</strong><input type="text" name="litrosFactura" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->litros_facturados) : ""; ?>" id="litrosFactura" class="item-small fixed" readOnly /></div>                 
            <div><strong class="mr-1">Fecha:</strong><input type="text" name="fechaFactura" value="<?= isset($embarque) && $embarque->fecha_factura != null ? date('d/m/Y', strtotime($embarque->fecha_factura)) : "" ?>" id="fechaFactura" class="item-small" readOnly /></div>
        </div>
        <div class="datos mb-2 mt-2">
            <div><strong class="mr-1">Precio:</strong><input type="text" name="precioFactura" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->precio_producto) : UtilsHelp::numero2Decimales($r['detalle'][0]['precio_unitario']); ?>" id="precioFactura" class="item-ss-small fixed" readonly/><span>dlls.</span>
                <?php if (Utils::isCompras()): ?> 
                    <span id="editImporte" class="material-icons i-edit" title="Editar precio">edit</span>
                <?php endif; ?></div>
            <?php if (isset($kansas)): ?> 
                <div><strong class="mr-1">Carro tanque:</strong>
                    <input type="hidden" name="carroTanqueId" value="<?= isset($embarque) ? $embarque->carro_tanque_id : "" ; ?>" id="carroTanqueId" />
                    <input name="carroTanque" value="<?= isset($embarque) && $embarque->carro_tanque_id != null ? Utils::getCarroTanqueById($embarque->carro_tanque_id)->numero : "" ; ?>" class="item-small" id="carroTanque" />
                </div>
            <?php endif; ?>
            <div><strong class="mr-1">Oil spill fee recovery:</strong><input type="text" name="oilFee" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->oil_fee) : ""; ?>" id="oilFee" class="item-s-small" /><span>dlls.</span> </div>
            <div><strong class="mr-1">Importe:</strong><input type="text" name="importeFactura" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->importe) : ""; ?>" id="importeFactura" class="item-small fixed important" readOnly/><span>dlls.</span></div>          
        </div>
        <div class="datos mb-2 mt-2">
            <div class="d-flex" id="divDocumentoFactura"><strong class="mr-1">Factura:</strong>
                <div><label for="documento" id="inputFile" class="inputFile"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documento" name="documentoFactura" type="file" hidden />
                    <span id="spanDocumento" class="span-documento"><?= isset($embarque) ? UtilsHelp::recortarString($embarque->factura, "_") : ""; ?></span>
                    <i id="showFactura" class="i-document material-icons fa-solid fa-file-pdf" title="Ver factura" hidden></i>
                    <span id="delete" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="factura" value="<?= isset($embarque) ? $embarque->factura : ""; ?>"/></div>
            </div>
            <div class="d-flex" id="divDocumentoCert"><strong class="mr-1">Certificado:</strong>
                <div><label for="documentoCertificado" id="inputFile" class="inputFile"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documentoCertificado" name="documentoCertificado" type="file" hidden />
                    <span id="spanDocumento" class="span-documento"><?= isset($embarque) ? UtilsHelp::recortarString($embarque->certificado, "_") : ""; ?></span>
                    <i id="showCertificado" class="i-document material-icons fa-solid fa-file-pdf" title="Ver certificado" hidden></i>
                    <span id="deleteCertificado" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="certificado" value="<?= isset($embarque) ? $embarque->certificado : ""; ?>"/></div>
            </div>
            <div><strong class="mr-1">Observaciones:</strong><input type="text" name="observacionesEmbarque" value="<?= isset($embarque) ? $embarque->observaciones : ""; ?>"  id="observacionesEmbarque" class="item-medium" /></div>
        </div>
    </div>
    <div class="div-datos mt-3">
        <span class="titulo-div">Pedimento</span>
        <div class="datos mb-2 mt-2">
            <input type="hidden" name="idPedimento" value="<?= isset($pedimento) ? $pedimento->id : ""; ?>" id="idPedimento"/>
            <div><strong class="mr-1"># Pedimento:</strong><input type="text" name="numeroPedimento" value="<?= isset($pedimento) ? $pedimento->numero : ""; ?>" id="numeroPedimento" class="item-m-medium" /></div>
            <div><strong class="mr-1">Referencia:</strong> <input type="text" name="referenciaPedimento" value="<?= isset($pedimento) ? $pedimento->referencia : ""; ?>"  id="referenciaPedimento" class="item-small"/></div>   
            <div><strong class="mr-1">Fecha pago:</strong><input type="text" name="fechaPedimento" value="<?= isset($pedimento) && $pedimento->fecha_pedimento != "" ? date('d/m/Y', strtotime($pedimento->fecha_pedimento)) : ""; ?>"  id="fechaPedimento" class="item-small" readOnly /></div>
            <div><strong class="mr-1">Tipo cambio:</strong><input type="text" name="tipoCambio" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->tipo_cambio, false, 4) : ""; ?>"  id="tipoCambio" class="item-s-small fixed" /><span>MX.</span></div>
        </div>
        <div class="datos  mb-2 mt-2">
            <div><strong class="mr-1">Incrementables:</strong><input type="text" name="incrementable"  value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->incrementable) : "75"; ?>"  id="incrementable" class="item-ss-small fixed" readOnly /><span>dlls.</span>
                <span id="editIncrementable" class="material-icons i-edit" title="Editar incrementable">edit</span></div>
            <div><strong class="mr-1">Otros cargos:</strong><input type="text" name="otrosCargosPedimento"  value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->otros_cargos) : ""; ?>" id="otrosCargosPed" class="item-s-small" /><span>dlls.</span> </div>
            <div><strong class="mr-1">Total incrementables:</strong><input type="text" name="totalIncrementable"  value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->total_incrementables) : "75"; ?>"  id="totalIncrementable" class="item-s-small fixed" readOnly /><span>dlls.</span></div>
        </div>
        <div class="datos  mb-2 mt-2">
            <div><strong class="mr-1">Incrementables pesos:</strong><input type="text" name="incrementablesPeso"  id="incrementablesPeso"  value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->incrementables_pesos) : ""; ?>"  class="item-small fixed" readOnly /><span>MX.</span></div>
            <div><strong class="mr-1">Valor dolares:</strong><input type="text" name="valorDolares" value="<?= isset($embarque) ? UtilsHelp::numero2Decimales($embarque->valor_dolares) : ""; ?>" id="valorDolares" class="item-small fixed" readOnly/><span>dlls.</span></div> 
            <div><strong class="mr-1">Valor aduana:</strong><input type="text" name="valorAduana" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->valor_aduana) : ""; ?>" id="valorAduana" class="item-small fixed" readOnly/><span>MX.</span></div>
        </div>
        <div class="datos  mb-2 mt-2">
            <div><strong class="mr-1">PRV:</strong><input type="text" name="prvPedimento" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->prv) : "240"; ?>" id="prvPedimento" class="item-ss-small fixed" readOnly/><span>MX.</span>
                <span id="editPrv" class="material-icons i-edit" title="Editar PRV">edit</span></div>     
            <div><strong class="mr-1">IVA PRV:</strong><input type="text" name="ivaPrv" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->iva_prv) : "38"; ?>" id="ivaPrv" class="item-ss-small fixed" readOnly/><span>MX.</span></div>                                    
            <div><strong class="mr-1">DTA:</strong><input type="text" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->dta) : "0"; ?>" name="dtaPedimento" id="dtaPedimento" class="item-s-small fixed" readOnly/><span>MX.</span>
                <span id="editDta" class="material-icons i-edit" title="Editar DTA">edit</span></div>
            <div><strong class="mr-1">IVA:</strong><input type="text" name="ivaPedimento" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->iva) : ""; ?>" id="ivaPedimento" class="item-small fixed" readOnly/><span>MX.</span></div> 
        </div>
        <div class="datos mb-2 mt-2">
            <div><strong class="mr-1">Valor comercial:</strong><input type="text" name="valorComercial" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->valor_comercial) : ""; ?>"id="valorComercial" class="item-small fixed" readOnly/><span>MX.</span></div>
            <div><strong class="mr-1">Total impuestos:</strong><input type="text" name="impuestosPedimento" value="<?= isset($pedimento) ? UtilsHelp::numero2Decimales($pedimento->total_impuestos) : ""; ?>" id="impuestosPedimento" class="item-small fixed important" readOnly/><span>MX.</span></div>
            <div class="d-flex pt-1" id="divDocumentoPedimento"><strong class="mr-1">Pedimento:</strong>
                <div><label for="documentoPedimento" class="inputFile m-0"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documentoPedimento" name="documentoPedimento" value="" type="file" hidden />
                    <span id="spanDocumento" class="span-documento-pedimento"><?= isset($pedimento) ? UtilsHelp::recortarString($pedimento->documento, "_") : ""; ?></span>
                    <i id="showPedimento" class="i-document material-icons fa-solid fa-file-pdf" title="Ver pedimento" hidden></i>
                    <span id="deletePedimento" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="pedimento" value="<?= isset($pedimento) ? $pedimento->documento : ""; ?>"/></div>
            </div>
        </div>
    </div>           
    <div class="datos mt-2">
    <?php if (Utils::permisosCompras()):?>
        <div>
                <div class="mr-2"><button class="btn-token" id= "btnGenerarToken" title="Generar token en BANXICO"><span>Generar token</span></button></div>                 
        </div>
        <div class="d-flex">
            <div class="mr-2"><button class="boton btn-salir" id= "btnEliminar" title="Cancelar embarque"><span class="far i-delete material-icons fa-trash-alt btn-icon"></span></button></div>
            <div class="mr-2"><button class="boton btn-guardar" id= "btnGuardar" title="Guardar"><span class="material-icons btn-icon">save</span></button></div>  
            <div><button class="boton btn-salir" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button></div>
        </div>
      <?php endif; ?>    
    </div>
</form>
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

<!-- Token modal -->
<div class="modal fade modal-token" id="modalToken" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog m-token" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3 modal-title title-token"><span class="material-icons fas fa-key pr-2"></span>Generar token BANXICO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formToken">
                    <div class="container d-flex justify-content-center">
                        <div class="row mb-2">
                            <div class="text-right mr-1"><strong>Token:</strong></div> 
                            <div><input type="text" id="token" class="item-big"><span class="material-icons i-close" id="borrarToken" title="Cerrar" hidden>cancel</span></div>    
                        </div>
                    </div>
                </form>
            </div>
            <div class="border-modal modal-footer d-flex justify-content-between">
                <div>
                    <a href="" id="mostrarToken">Mostrar token actual</a>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn enviarBtn" id="actualizarToken"><span class="material-icons fas fa-key pr-1 vertical-align"></span>Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>   
<!-- Modal enviar aviso cambio de precio correo-->
<div class="modal fade modal-enviar" id="enviarModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3 modal-title" id="titleModal"><span class="pr-2"></span>Cambio de precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formEnviar">
                    <div class="container">
                        <div class="row ml-5">
                            <div class="mr-2 mb-1"><label>Precio nuevo:</label></div>                                                 
                            <div><input type="text" name="precioFacturaNuevo" value="" id="precioFacturaNuevo" class="item-ss-small" /><span>dlls.</span></div>
                        </div>
                        <div class="row ml-5">
                            <div><label>Motivo de cambio de precio:</label></div>                                            
                        </div>
                        <div class="ml-5 row">                                 
                            <div><textarea class="textarea-cambio" id="cuerpoCorreo"></textarea></div> 
                        </div>
                        <div class="row ml-5">
                            <div class="nota-cambio"><strong class="mr-1" mr-1>*</strong><label>Se enviara aviso a gerencia.</label></div>                                            
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="enviarCambioPrecio"><span class="material-icons mr-2">send</span>Enviar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>