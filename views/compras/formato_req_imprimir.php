<style> 
    @page {
        margin-top: .5cm;
        margin-bottom: .5cm;
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        font-family: Arial;
    }
    .contenedor{
        width: 1200px;
        height: 900px;
    } 
    
    p{
        font-size: 13px;
        padding:0;
        margin:0;
    }
    
    strong{
        font-family: Arial;
        font-size: 12px;
    }
    
    span{
         font-family: Arial; 
    }
</style>

<div style="font-family: Arial; margin: 0" class="contenedor">
    <table style="width:1200px; height:100px;">
        <tbody>
            <tr>
                <td style="width:20%; padding-left:30px;">
                  <div><img style="height:110px; opacity: .8;" src="<?=root_url?>/assets/img/default.jpg" /></div></td>
                   <td style="font-family: Arial; text-align: center;">
                        <strong style="font-size: 18px; font-weight: bold"><?= isset($empresa) ? $empresa['nombre'] : "" ?></strong>
                        <p><?= isset($empresa) ? $empresa['direccion'] : "" ?></p>
                        <p><?= isset($empresa) ? $empresa['estado'] . ' C.P. ' . $empresa['cp'] : "" ?></p>
                        <p>R.F.C.:  <?= isset($empresa) ? $empresa['rfc'] : "" ?></p>
                        <p>TEL/FAX.- <?= isset($empresa) ? $empresa['tel'] : "" ?></p>
                   </td>
                    <td style="width:20%; height:110px;" ></td>
            </tr>
            </table>

         <table style="width:100%; float:right; font-family:Arial; border-collapse:collapse;">
             <tbody>
                 <tr>
                     <td style="width:1030px;"></td>
                     <td style="width:80px; height:25px; border-top:double; border-left:double; border-right: double; text-align: center;"><strong>FOLIO:</strong></td>
                     <td style="width:90px; height:25px; border-top:double; border-right: double; text-align: center;"> <span><?= isset($r) && $r['folio'] != "" ? $r['folio'] : "";?></span></td>
                 </tr>
             </tbody>
         </table>
  
      <table style="width:1200px; height:25px; border:double; margin:0; padding:0;">
            <tr style="width:100%;">
                <td style="text-align: center"><strong style="font-size:14px; font-family: Arial;">REQUISICIÓN DE MATERIALES Y/O SERVICIOS</strong> </td>
            </tr>
      </table>

    <table style="border:double; border-collapse:collapse; font-family:Arial; width:1200px; margin-top:5px;">
        <tbody >
            <tr>
                <td style="width:450px; padding-left:10px; height:20px; border-right:double; border-bottom:double;" colspan="6"><strong>PROVEEDOR SELECCIONADO:</strong></td>
                <td style="width:120px;  padding-left:5px; border-right:1px solid; border-bottom:double;"> <strong>O.C. ASIGNADA:</strong></td>
                <td style="width:180px;  padding-left:5px; border-bottom:double; border-right:double;"> <span><?= isset($r) && $r['folio_oc'] != "" ? $r['folio_oc'] : ""; ?></span></td>
                <td style="width:100px;  padding-left:5px; border-bottom:double; border-right:1px solid;"> <strong>FECHA DE SOLICITUD:</strong></td>
                <td style="width:125px;  padding-left:5px; border-bottom:double; border-right:double;"><span><?= isset($r) && $r['fecha_solicitud'] != "" ? date('d/m/Y', strtotime($r['fecha_solicitud'])) : ""; ?></span></td>
                <td style="width:100px;  padding-left:5px; border-bottom:double; border-right:1px solid;"><strong>FECHA REQUERIDA:</strong></td>   
                <td style="width:125px;  border-bottom:double;"><span><?= isset($r) && $r['fecha_solicitud'] != "" ? date('d/m/Y', strtotime($r['fecha_requerida'])) : ""; ?></span></td>
            </tr>
            <tr>
                <td style="width:450px; padding-left:10px; border-right:double; border-bottom:double;"  colspan="6"><span><?= isset($r) ? $r['proveedor'] : "";?></span></td>
                <td style="width:120px;  padding-left:5px; border-right:1px solid; border-bottom:double;"> <strong>DEPARTAMENTO:</strong></td>
                <td style="width:180px;  padding-left:5px; border-bottom:double; border-right:double;"><span><?=isset($r)? $r['departamento'] : "";?></span></td>
                <td style="width:100px;  padding-left:5px; border-bottom:double; border-right:1px solid;"> <strong>ASIGNADO A(NOMBRE):</strong></td>
                <td style="width:350px;  padding-left:5px; border-bottom:double;" colspan="3"><span><?=isset($r)? $r['usuario'] : "";?></span></td>
            </tr>
            <tr>
                <td style="width:150px; padding-left:10px;  border-bottom:double;"><strong>COMPRA URGENTE:</strong></td>
                <td style="width:50px; padding-left:30px;  border-right:1px solid; border-bottom:double;"><strong>SI</strong></td>
                <td style="width:50px; padding-left:20px;  border-right:1px solid; border-bottom:double;"><span><?=(isset ($r) && $r['urgente']== "S" ? 'X' : "");?></span></td>
                <td style="width:50px; padding-left:30px;  border-right:1px solid; border-bottom:double;"><strong>NO</strong></td>
                <td style="width:50px; padding-left:20px;  border-right:1px solid; border-bottom:double;"><span><?= (isset ($r) && $r['urgente']== "N" ? 'X' : "");?></span></td>
                <td style="width:100px;  border-right:double; border-bottom:double;"></td>
                <td style="width:120px;  padding-left:5px; border-right:1px solid; border-bottom:double;"><strong>N° PROYECTO:</strong></td>
                <td style="width:180px;  padding-left:5px; border-bottom:double; border-right:double;"><span><?= isset ($r) ? $r['num_proyecto'] : "";?></span></td>
                <td style="width:100px;  padding-left:5px; border-bottom:double; border-right:1px solid;"><strong>NOMBRE PROYECTO:</strong></td>
                <td style="width:350px;  padding-left:5px; border-bottom:double;" colspan="3"><span><?= isset ($r)  ? $r['proyecto'] :"";?></span></td>            
            </tr>
        </tbody>
    </table>

    <table style="border:double; border-collapse:collapse; font-family:Arial; width:1200px; margin-top:5px; text-align:center;">
        <tbody>
            <tr>
                <td style="width:780px; border-right:1px solid; "><strong>DESCRIPCION DEL MATERIAL, EQUIPO Y/O SERVICIO:</strong></td>
                <td style="width:120px; border-right:1px solid; "><strong>UNIDAD</strong></td>
                <td style="width:120px; border-right:1px solid; ;"><strong>CANTIDAD SOLICITADA</strong></td>
                <td style="width:240px; "><strong>PRECIO UNITARIO MAS IVA(Cuando sea necesario)</strong></td>
            </tr>
        </tbody>
    </table>
    
        <table style="border-right:double; border-left:double; border-top:double; border-collapse:collapse; font-family:Arial; width:1200px; height:390px; margin-top:5px; text-align:center;">
                <tbody>
   <?php if (isset($r)):?>
            <?php foreach ($r['detalle'] as $d): ?>
                    <tr>
                        <td style="width:780px; border-right:1px solid; border-bottom: 1px solid;"><span><?= $d['descripcion'];?></span></span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid; "><span><?= Utils::getNombreUnidad(intval($d['unidad_id']));?></span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid;"><span><?= UtilsHelp::numero2Decimales($d['cantidad']);?></span></td>
                        <td style="width:240px; border-bottom: 1px solid;"><span><?= UtilsHelp::numero2Decimales($d['precio_unitario'], true);?></span></td>
                    </tr>                
           <?php endforeach ?>   
                <?php for($i=1; $i<= 12 - count($r['detalle']); $i++):?>
                    <tr>
                        <td style="width:780px; border-right:1px solid; border-bottom: 1px solid; "><span style="color:white;">-</span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                        <td style="width:240px; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                    </tr>
                        <?php endfor; ?>
                        <?php else: ?> 
                       <?php for($i=1; $i<= 12; $i++):?>
                       <tr>
                        <td style="width:780px; border-right:1px solid; border-bottom: 1px solid; "><span style="color:white;">-</span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                        <td style="width:120px; border-right:1px solid; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                        <td style="width:240px; border-bottom: 1px solid;"><span style="color:white;">-</span></td>
                       </tr>
                <?php endfor;?>
              <?php endif;?>
               </tbody>
            </table>
                <table style="height:60px;  width:1200px; border-right:double; border-left:double; border-bottom:double; border-collapse:collapse;" >
                    <tbody>
                    <tr>
                    <td style="width:120px; height:70px; border-right:1px solid; float:left; padding-left: 10px; padding-top:7px;"><strong >OBSERVACIONES:</strong></td>
                    <td style="float:left; width:1080px; height:70px; font-size:13px; padding-left: 5px; padding-top:2px;"><span><?= (isset($r) ? $r['observaciones'] : ""); ?></span></td>
                    </tr>
                    </tbody>
                </table>
                <div style="margin-bottom:50px;">
                    <div style="padding-left:15px; height:20px;"><strong>Nota: Solicitud que no se apegue a este formato no se tramitará.</strong></div>
                </div>

    <table style="width:95%; margin:0 auto;">
        <tbody>
            <tr>
                <td style="text-align: center;">
                    <?php if($firmas['firma1'] == 0): ?>
                    <div style="height:220px; margin-top:50px;"><br><br><br><br></div>
                      <?php else: ?>
                      <div><img style="width: 220px; height: 100px;" src="<?=root_url?>views/catalogos/uploads/imgFirmasUsuarios/<?=Utils::getFirmaUser($firmas['firma1'])?>"></div>
                       <?php endif; ?>
                    <strong>_____________________________________</strong><br>
                    <strong>Nombre y firma</strong><br>
                    <strong>Solicitante</strong>
                </td>
                <td style="text-align: center;">
                     <?php if($firmas['firma2'] == 0): ?>
                    <div style="width:220px; margin-top:50px;"><br><br><br><br></div>
                      <?php else: ?>
                      <div><img style="width: 220px; height: 100px;" src="<?=root_url?>views/catalogos/uploads/imgFirmasUsuarios/<?=Utils::getFirmaUser($firmas['firma2'])?>"></div>
                       <?php endif; ?>
                     <strong>_____________________________________</strong><br>
                    <strong>Nombre y firma</strong><br>
                    <strong>Compras</strong>
                </td>
                 <td style="text-align: center;">
                     <?php if($firmas['firma3'] == 0): ?>
                    <div style="width:220px; margin-top:50px;"><br><br><br><br></div>
                      <?php else: ?>
                      <div><img style="width: 220px; height: 100px;" src="<?=root_url?>views/catalogos/uploads/imgFirmasUsuarios/<?=Utils::getFirmaUser($firmas['firma3'])?>"></div>
                       <?php endif; ?>
                    <strong>_____________________________________</strong><br>
                    <strong>Nombre y firma</strong><br>
                    <strong>Gerente general</strong>
                </td>
            </tr>
        </tbody>
    </table>
                <div style="text-align:right; margin-top:10px;"><strong><span><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></strong></div>

</div>