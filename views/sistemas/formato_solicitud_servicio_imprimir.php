<style> 
        @page {
        margin-top: .5cm;
        margin-bottom: .5cm;
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        font-family: Arial Narrow;
    }
    
    .contenedor{
        width: 950px;
        height: 1000px;
        font-family: Arial Narrow;
        margin: 0;
        padding: 0;
    } 
   tr{
        padding: 0;
        margin:0;
    }
   
</style>

<div style="font-family: Arial Narrow; margin: 0;" class="contenedor">
    <table style="width:950px; height:100px; font-family: Arial;">
        <tbody>
            <tr style="height:60px;">
                <td style="width:10%;">
                    <div><img style="height:90px; opacity: .9;" src="<?= root_url ?>/assets/img/default.jpg" /></div>
                </td>
                <td style="width:90%; text-align: center;">
                    <div><div><strong style="font-size:26px; font-weight:bold; color:#000;"><?= isset($empresa) ? $empresa['nombre'] : "" ?></strong></div> <div><strong style="font-size:22px; font-weight:bold; color:#000;">SOLICITUD DE SERVICIO</strong></div></div>
                </td>
            </tr>
        </tbody>
    </table>
     <div style=" width:100%; font-family: Arial Narrow; margin: 0; padding-left:20px; padding-left:20px; padding-top:10px; padding-bottom:10px; border:1px solid;">
        <table style=" width:100%; height:150px; font-family: Arial Narrow; border-collapse:collapse;  padding: 0; margin:0;" >
            <tr style="height: 33%;">
                <td style=" width: 33%;">
                    <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0;">
                        <tr><td><strong>Solicitante:</strong></td><td style="padding-left: 5px;" ><span><?= isset($s) ? $s['usuario'] : ""; ?></span></td></tr>
                    </table>
                </td>
                 <td style=" width:33%;">
                  <table style="font-size:13px; font-family: Arial Narrow;  padding: 0; margin:0; ">
                    <tr><td ><strong >Departamento:</strong></td><td style="padding-left: 5px;"><span><?= isset($s) ? $s['departamento'] : ""; ?></span></td></tr>
                  </table>
                </td>
                <td  style=" width: 33%";>     
                   <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0;">
                      <tr><td><strong>Folio:</strong></td><td style="padding-left: 5px;" ><span><?= isset($s) ? $s['folio'] : ""; ?></span></td></tr>
                   </table>
                </td>
            </tr>
             <tr style="height: 33%;">
                <td style=" width: 33%;">
                    <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0;">
                        <tr><td><strong>Requerimiento:</strong></td><td style="padding-left: 5px;" ><span><?= isset($s) ? requerimientos[$s['tipo_requerimiento']]  : ""; ?></span></td></tr>
                    </table>
                </td>
                 <td  style=" width:33%;">
                  <table style="font-size:13px; font-family: Arial Narrow;  padding: 0; margin:0; ">
                      <tr><td ><strong >Solicitud:</strong></td><td style="padding-left: 5px;"><span><?= isset($s) ? tipoSolicitud[$s['tipo_solicitud']]  : ""; ?></span></td></tr>
                  </table>
                </td>
                <td  style=" width:33%";>     
                   <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0; ">
                      <tr><td><strong>Prioridad:</strong></td><td style="padding-left: 5px;" ><span><?= isset($s) ? prioriodades[$s['prioridad']] : ""; ?></span></td></tr>
                   </table>
                </td>
            </tr>
              <tr style="height: 33%;">
                <td style=" width: 33%;">
                    <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0;">
                        <tr><td><strong>Fecha solicitud:</strong></td><td style="padding-left: 5px;"><span><?= isset($s)  && $s['fecha_solicitud'] ? UtilsHelp::fechaCompleta($s['fecha_solicitud'])  : ""; ?></span></td></tr>
                    </table>
                </td>
                 <td  style=" width:33%;">
                  <table style="font-size:13px; font-family: Arial Narrow;  padding: 0; margin:0; ">
                      <tr><td ><strong >Fecha atención:</strong></td><td style="padding-left: 5px;"><span><?= isset($s)  && $s['fecha_atencion'] ? UtilsHelp::fechaCompleta($s['fecha_atencion'])  : ""; ?></span></td></tr>
                  </table>
                </td>
                <td  style=" width: 33%";>     
                   <table style="font-size:13px; font-family: Arial Narrow; padding: 0; margin:0; ">
                       <tr><td><strong>Fecha fin:</strong></td><td style="padding-left: 5px;"><span><?= isset($s) && $s['fecha_solucion'] != "" ? UtilsHelp::fechaCompleta($s['fecha_solucion'])  : ""; ?></span></td></tr>
                   </table>
                </td>
            </tr>
        </table>
         <div style="margin-top:15px; margin-left: 20px; margin-right: 20px; width: 80%; height: 130px; text-align: center">
         <table style="width: 100%;  font-family: Arial Narrow;">
             <tr>
                 <td style="border:2px solid; width:100%; text-align: center; background-color: #c7c3bd;"><strong>DESCRIPCIÓN GENERAL DEL SERVICIO</strong></td>
             </tr>
             <tr>
                 <td style="border:2px solid; width:100%; height:100px; padding: 10px; vertical-align: text-top;"><?= isset($s) ? $s['descripcion'] : ""; ?></td>
             </tr>
         </table>
         </div>
      <div style="margin-top:15px; margin-left: 20px; margin-right: 20px; width: 80%; height: 130px; text-align: center">
         <table style="width: 100%;  font-family: Arial Narrow;">
             <tr>
                 <td style="border:2px solid; width:100%; text-align: center; background-color: #c7c3bd;"><strong>SOLUCIÓN</strong></td>
             </tr>
             <tr>
                 <td style="border:2px solid; width:100%; height:100px; padding: 10px; vertical-align: text-top;"><?= isset($s) ? $s['solucion'] : ""; ?></td>
             </tr>
         </table>
         </div>
       <div style="margin-top:15px; margin-left: 20px; margin-right: 20px; width: 80%; height: 130px; text-align: center">
         <table style="width: 100%;  font-family: Arial Narrow;">
             <tr>
                 <td style="border:2px solid; width:100%; text-align: center; background-color: #c7c3bd;"><strong>OBSERVACIONES / COMENTARIOS</strong></td>
             </tr>
             <tr>
                 <td style="border:2px solid; width:100%; height:100px; padding: 10px; vertical-align: text-top;"><?= isset($s) ? $s['observaciones'] : ""; ?></td>
             </tr>
         </table>
         </div>
       <div style="margin-top:10px; margin-left: 20px; margin-right: 20px; width: 100%; height: 30px; text-align: center">
         <table style="width: 100%;  font-family: Arial Narrow;">
             <tr>
                 <td style="width:80%;"><strong>Asignado a:  </strong><span><?= isset($s) ? $s['usuarioSistemas'] : ""; ?></span></td>
                 <td><strong><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></strong></td>
             </tr>
         </table>
         </div>
    </div>
</div8