<style> 
    .contenedor{
        width: 950px;
        height: 1000px;
    } 

</style>

<div style="font-family: Arial; margin: 0;" class="contenedor">
    <table style="width:950px; height:100px; font-family: Arial;">
        <tbody>
            <tr style="height:100px;">
                <td style="width:10%;">
                    <div><img style="height:90px; opacity: .9;" src="<?= root_url ?>/assets/img/default.jpg" /></div>
                </td>
                <td style="width:67%;">
                    <div><strong style="font-size:26px; font-weight:bold; color:#203764;"><?= isset($empresa) ? $empresa['nombre'] : "" ?></strong></div>
                </td>
                <td style="width:13%; text-align:center; padding-top:25px;"  rowspan=2>
                    <div style="text-align:center;"><span style="font-size:24px; text-align:justify; color:#203764;">ORDEN DE COMPRA</span></div>
                </td>
                <td style="width:10%; padding-top:10px; font-size:22px; color:#203764;" rowspan=2> <?= isset($oc) ? $oc->folio : "" ?> </td>
            </tr>
            <tr>
                <td colspan=2>
                    <table style="width:100%; font-size:17px; color:#203764; ">
                        <tr>
                            <td style="padding-bottom:-5px; width:60%;">
                                <div><span>R.F.C.:<?= isset($empresa) ? $empresa['rfc'] : "" ?></span></div>
                                <div><span><?= isset($empresa) ? $empresa['direccion'] : "" ?></span></div>
                                <div><span><?= isset($empresa) ? $empresa['estado'] . ' C.P. ' . $empresa['cp'] : "" ?></span></div>
                            </td>
                            <td style="padding-bottom:-5px; width: 40%; padding-left: 10px;">
                                <div><span>Sitio web: www.leademexico.com</span></div>
                                <div><span>TEL: <?= isset($empresa) ? $empresa['tel'] : "" ?></span></div>
                            </td>
                        </tr> 
                    </table>
                </td>
                <td colspan=2>
                </td>
            </tr>
        </tbody>
    </table>
     <table style="height:110px; font-family: Arial; width:950px; font-size:15px; color:#203764; border-collapse:collapse;">
        <tr>
            <td style="width:410px; border-top: 4px solid #525151;">
                <table style="width:390px;">
                    <tr><td style="width:30%"><span>ORDENADO A:</span></td><td style="width:70%"><strong style="font-size:15px;"><?= isset($r) ? $r['proveedor'] : ""; ?></strong></td></tr>
                     <tr><td style="width:30%"><span>DIRECCION:</span></td><td style="width:70%"><span> <?= isset($r) ? $r['direccion'].", ".$r['ciudad']: ""; ?></td></tr>
                </table>
            </td>
            <td style="width:330px; border-top: 4px solid #525151; ">
                  <table style="border-collapse:collapse; width:300px;">
                    <tr><td style="width:30%"><span >TELEFONO:</span></td><td style="width:70%"><span><?= isset($r) ? $r['tel_provedor'] : ""; ?></span></td></tr>
                    <tr><td style="width:30%"><span>CONTACTO:</span></td><td style="width:70%"><span> <?= isset($r) ? $r['contacto'] : ""; ?></span></td></tr>
                    <tr><td colspan=2><span>CORREO ELECTRONICO: <?= isset($r) ? $r['correo_proveedor'] : ""; ?></span></td></tr>
                </table>
            </td>
            <td style="width:210px; padding-top: 10px; font-size:15px;">
                <table style="border-collapse:collapse; font-size:15px;">
                    <tr><td style="width:70%"><span>FECHA DE LA ORDEN:</span></td><td style="width:30%"><span> <?= isset($oc) ? date('d/m/Y', strtotime($oc->fecha_alta)) : " "; ?></span></td></tr>
                    <tr><td style="width:70%"><span>FECHA DE ENTREGA:</span></td><td style="width:30%"><span> <?= isset($r) && $r['fecha_requerida'] != "" ? date('d/m/Y', strtotime($r['fecha_requerida'])) : ""; ?></span></td></tr>
                    <tr><td style="width:70%"><span>DEPARTAMENTO: </span></td><td style="width:30%"><span> <?= isset($r) ? $r['departamento'] : ""; ?></span></td></tr>
                </table>
            </td>
        </tr>
     </table>
     <table style="width:700px; height:30px; font-family: Arial; color:#203764; border-collapse:collapse;">
         <?php if (isset($cli)): ?>
         <tr style="width:700px; height:15px; font-family: Arial; color:#203764; font-size:11px;">
             <td style="height:15px; width:50%; font-family: Arial; color:#203764;  font-size:11px;"><strong>Entregar a:</strong><span><?= isset($cli) ? $cli->nombre : " "; ?></span></td>
              <td style="height:15px; width:50%; font-family: Arial; color:#203764;  font-size:11px;" colspan=2><strong>Contacto:</strong><span><?= isset($cli) ? $cli->contacto : " "; ?></span></span></td>
         </tr>
         <tr style="width:700px; height:20px; font-family: Arial; color:#203764; border-collapse:collapse;">
              <td style="height:15px; width:50%; font-family: Arial; color:#203764;  font-size:11px;"><strong>Domicilio:</strong><span><?= isset($cli) ? $cli->direccion .", ".$cli->ciudad_completa: " "; ?></span></td>
              <td style="height:15px; width:25%; font-family: Arial; color:#203764;  font-size:11px;"><strong>Correo:</strong><span><?= isset($cli) ? $cli->correo : " "; ?></span></td>
              <td style="height:15px; width:25%; font-family: Arial; color:#203764;  font-size:11px;"><strong>Telefono:</strong><span><?= isset($cli) ? $cli->telefono : " "; ?></span> </td>
         </tr>
         <?php endif; ?>
     </table>
    
    <table style="width:950px; font-family: Arial; color:#203764; border-collapse:collapse;">
        <tr style="height:40px; border:1px solid #2DA2BF;">
            <th style="width:90px; height:30px;border-right:1px solid #2DA2BF;  font-size:12px;">UNIDAD</th>
            <th style="width:440px; border-right:1px solid #2DA2BF;  font-size:12px;">DESCRIPCION</th>
            <th style="width:90px; border-right:1px solid #2DA2BF;  font-size:12px;">CANTIDAD</th>
            <th style="width:110px; border-right:1px solid #2DA2BF;  font-size:12px;">PRECIO UNIDAD</th>
            <th style="width:110px; border-right:1px solid #2DA2BF;  font-size:12px;">DESCUENTO</th>
            <th style="width:110px;  font-size:12px;">PRECIO</th>
        </tr>
        <?php if (isset($r)): ?>
            <?php for ($i = 0; $i < count($r['detalle']); $i++): ?>
                <tr style="background-color: #D2EEF4;  font-size:14px;">
                    <td style="width:90px; height:40px; text-align:center; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= Utils::getNombreUnidad(intval($r['detalle'][$i]['unidad_id'])); ?></td>
                    <td style="width:440px; height:40px; padding-left: 5px; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= $r['detalle'][$i]['descripcion']; ?></td>
                    <td style="width:90px; height:40px; text-align:center; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['cantidad']); ?></td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio_unitario'], true); ?></td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['descuento'], true); ?> </td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-bottom:1px solid #2DA2BF; border-right:1px solid #2DA2BF;  background-color:#79CBDF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio'], true); ?></td>
                <span hidden><?= $i += 1; ?></span>
            </tr>
            <?php if ($i < count($r['detalle'])): ?>
                <tr  style="font-size:14px;">
                    <td style="width:90px; height:40px; text-align:center; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= Utils::getNombreUnidad(intval($r['detalle'][$i]['unidad_id'])); ?></td>
                    <td style="width:440px; height:40px; padding-left: 5px; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= $r['detalle'][$i]['descripcion']; ?></td>
                    <td style="width:90px; height:40px; text-align:center; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['cantidad']); ?></td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio_unitario'], true); ?></td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['descuento'], true); ?> </td>
                    <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-bottom:1px solid #2DA2BF; border-right:1px solid #2DA2BF; background-color:#A6DCEA;"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio'], true); ?></td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
         <?php if (count($r['detalle']) % 2 != 0): ?>
                    <span hidden><?= $i = 0; ?></span>
         <tr  style="font-size:14px;">
            <td style="width:90px; height:40px; text-align:center; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:440px; height:40px; padding-left: 5px; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:90px; height:40px; text-align:center; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-bottom:1px solid #2DA2BF; border-right:1px solid #2DA2BF;  background-color:#A6DCEA;"></td>
        </tr>   
            <span hidden><?= $i += 1; ?></span>
           <?php endif; ?>
         <?php for ($i; $i <= 14 - count($r['detalle']) ; $i++): ?> 
        <tr style="background-color: #D2EEF4; font-size:14px;">
            <td style="width:90px; height:40px; text-align:center; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:440px; height:40px; padding-left:5px; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:90px; height:40px; text-align:center; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-bottom:1px solid #2DA2BF; border-right:1px solid #2DA2BF;  background-color:#79CBDF;"></td>
        <span hidden><?= $i += 1; ?></span>
        </tr>
      
           <?php if ($i <= 14 - count($r['detalle'])): ?>
        <tr>
            <td style="width:90px; height:40px; text-align:center; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:440px; height:40px; padding-left: 5px; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:90px; height:40px; text-align:center; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-bottom:1px solid #2DA2BF; border-right:1px solid #2DA2BF; background-color:#A6DCEA;"></td>
        </tr>
       <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
        <tr>
            <td colspan=4 rowspan=5 style="vertical-align:top; font-size: 16px;"> 
                <table style="font-size: 16px;" >
                    <tr style="width:100%; height: 80px;">
                        <td style="width:100%; height: 80px; vertical-align:top;"><strong>OBSERVACIONES:&nbsp;</strong><span><?= ($r['observaciones'] != "" ? $r['observaciones'] : "Ninguna"); ?> </span></td>
                    </tr>
                   <tr><td style="vertical-align:bottom; width:600px; height: 110px;">
                           <div><span >O.C. EN BASE A COTIZACION ENVIADA POR:&nbsp;</span>&nbsp;<span style="margin-left:10px"><?= (isset($r) ? $r['contacto'] : ""); ?> </span></div>
                               <?php if ($r['solicitud'] == "Transporte"): ?>
                        <div><span class="mr-20">Contacto ventas: &nbsp;<?= usuarios['compras_fletes']['nombre']?></span>&nbsp;</div>
                            <div><span>Teléfono:&nbsp; <?= usuarios['compras_fletes']['telefono']?></span></div>
                        <div><span class="mr-20">Enviar factura a: </span>&nbsp;<span><?= usuarios['compras_fletes']['correo']?></span></div>
                             <?php else: ?>
                        <div><span class="mr-20">Contacto compras: &nbsp;<?= usuarios['compras']['nombre']?></span>&nbsp;</div>
                            <div><span>Teléfono:&nbsp; <?= usuarios['compras']['telefono']?></span></div>
                        <div><span class="mr-20">Enviar factura a: </span>&nbsp;<span><?= usuarios['compras']['correo']?></span></div>
                             <?php endif; ?>

                        </td></tr>
                </table>  

            </td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #D2EEF4;"><strong>IMPORTE:</strong></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><strong>$<?= UtilsHelp::numero2Decimales($oc->importe, true); ?></strong></td>
        </tr>
        <tr>
            <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><span><?= $oc->iva == 0 ? "" : ($oc->otro_iva != null ? $oc->otro_iva : "16")?>% IVA:</span></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#A6DCEA;"><span>$<?= UtilsHelp::numero2Decimales($oc->iva, true); ?></span></td>
        </tr>
        <tr>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #D2EEF4;"><strong>SUB-TOTAL:</strong></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><strong>$<?= UtilsHelp::numero2Decimales($oc->sub_total, true); ?></strong></td>
        </tr>
        <?php if($r['solicitud'] == "Transporte"):?>
        <tr>
            <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><span>RETENCIÓN 4%</span></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#A6DCEA;"><span>$<?= UtilsHelp::numero2Decimales($oc->isr, true); ?></span></td>
        </tr>
        <tr>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #D2EEF4;"><strong></strong></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><strong></strong></td>
            </tr>
        <?php elseif ($r['solicitud'] == "Honorarios"): ?>
            <tr>
                <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><span>RETENCIÓN 10%</span></td>
                <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#A6DCEA;"><span>$<?= UtilsHelp::numero2Decimales($oc->isr, true); ?></span></td>
            </tr>
            <tr>
                <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #D2EEF4;"><span>RET. IVA (10.67%)%</span></td>
                <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><span>$<?= UtilsHelp::numero2Decimales($oc->retencion_iva, true); ?></span></td>
            </tr>
        <?php else: ?>
           <tr>
                <td style="width:110px; height:40px; padding-left:5px; font-size: 12px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;">
                    <span><?=$oc->impuesto != 0 ? "RETENCION ".UtilsHelp::numero2Decimales($oc->impuesto)."%" : "";?></span></td>
                <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#A6DCEA;">
                    <span><?= $oc->isr != 0 ? UtilsHelp::numero2Decimales($oc->isr, true) : "";?></span></td>
            </tr>
            <tr>
                <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #D2EEF4;"><span></span></td>
                <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><span></span></td>
            </tr>
                <?php endif; ?>
        <tr>
            <td colspan=4 style="padding-top:12px;"><strong>IMPORTE CON LETRA:</strong></td>
            <td style="width:110px; height:40px; padding-left:5px; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF;"><span>PAGOS:</span></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#A6DCEA;"><span>$<?= UtilsHelp::numero2Decimales($oc->pagos, true); ?></span></td>
        </tr>
        <tr>
            <td colspan=4 style=" background-color: #D2EEF4;"><span><?= $totalLetra; ?></span></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-left:1px solid #2DA2BF; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color: #A6DCEA;"><strong>TOTAL:</strong></td>
            <td style="width:110px; height:40px; padding-right:5px; text-align:right; border-right:1px solid #2DA2BF; border-bottom:1px solid #2DA2BF; background-color:#79CBDF;"><strong>$<?= UtilsHelp::numero2Decimales($oc->total, true); ?></strong></td>
        </tr>
    </table>           
   <div style="text-align:right; font-size:11px; margin-top:10px;"><strong><span><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></strong></div>
</div>