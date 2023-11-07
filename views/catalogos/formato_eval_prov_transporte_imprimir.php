<style> 
    
    @page {
        margin-top: 20px;
        margin-left:40px;
        margin-right:40px;
        margin-bottom:20px;
        }
    .contenedor{
        width: 950px;
        height: 1000px;
    } 
</style>

<div style="font-family: Arial;" class="contenedor">
    <table style="width:950px; height:100px; font-family: Arial;">
        <tbody>
            <tr style="height:100px;">
                <td style="width:10%;">
                    <div><img style="height:90px; opacity: .9;" src="<?= root_url ?>/assets/img/default.jpg" /></div>
                </td>
                <td style="width:67%; text-align:center;">
                    <div style="height:90px; margin-bottom: 10px;"><strong style="font-weight:bold; font-size:28px;">Grupo LEA de México S. de R. L. de C. V.</strong></div>
                    <div><strong style="font-size:20px;">Evaluación a proveedores de servicio de transporte</strong></div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width:950px; height:25px; font-family: Arial; font-size:14px; border-collapse:collapse; margin-top:5px">
        <tbody>
            <tr style="height:20px; ">
                <td style="width:15%; height:20px; border:3px solid; font-weight:bold; text-align:center; font-size:14px; background-color:#c8cccc">Período evaluación:</td>
                <td style="width:20%; height:20px; border-top:3px solid; border-bottom:3px solid; border-right:3px solid; font-size:14px; text-align:center;"><?=$fechaInicio. " - ". $fechaFinal?></td>
                <td style="width:3%"></td>
                <td style="width:19%; font-size:14px; margin-left:30px; height:20px; border:3px solid; text-align:center; background-color:#c8cccc; font-weight:bold;">Compras en el período:</td>
                <td style="width:7%; font-size:14px; height:20px; border-top:3px solid; border-bottom:3px solid; border-right:3px solid; text-align:center;"><?=$evaluaciones?></td>
                <td style="width:3%"></td>
                <td style="width:15%; font-size:14px; margin-left:30px; height:20px; border:3px solid; text-align:center; background-color:#c8cccc; font-weight:bold;">Fecha evaluación:</td>
                <td style="width:18%; font-size:14px; height:20px; border-top:3px solid; border-bottom:3px solid; border-right:3px solid; text-align:center;"><?=date('d/m/Y', strtotime(UtilsHelp::today()))?></td>
            </tr>
        </tbody>
    </table>
    <table style="width:950px; height:150px; font-family: Arial; border-collapse:collapse; margin-top:5px">
        <tr style="height:20px; ">
            <td colspan="2" style="width:100%; font-size:14px; border:3px solid; font-weight:bold; text-align:center; background-color:#c8cccc;">Datos del proveedor a evaluar</td> 
        </tr>
        <tr style="height:20px; ">
            <td style="width:20%; font-size:14px; border:3px solid; font-weight:bold; padding-left:5px; background-color:#c8cccc;">Nombre:</td>
            <td style="width:80%; border-top:3px solid; border-bottom:3px solid;  padding-left:5px; border-right:3px solid; font-size:14px;"><?=$prov->proveedor?></td>
        </tr>
        <tr style="height:20px; ">
            <td style="width:20%; font-size:14px; border:3px solid; font-weight:bold;  padding-left:5px; background-color:#c8cccc;">Dirección:</td>
            <td style="width:80%; border-top:3px solid; border-bottom:3px solid;  padding-left:5px; border-right:3px solid; font-size:14px;"><?=$prov->direccion. ", ". $prov->ciudad?></td>
        </tr>
         <tr style="height:20px; ">
            <td style="width:20%; font-size:14px; border:3px solid; font-weight:bold;  padding-left:5px; background-color:#c8cccc;">Teléfono:</td>
            <td style="width:80%; border-top:3px solid; border-bottom:3px solid;  padding-left:5px; border-right:3px solid; font-size:14px;"><?=$prov->telefono?></td>
        </tr>
                <tr style="height:20px; ">
            <td style="width:20%; font-size:14px; border:3px solid; font-weight:bold;  padding-left:5px; background-color:#c8cccc;">Contacto:</td>
            <td style="width:80%; border-top:3px solid; border-bottom:3px solid;  padding-left:5px; border-right:3px solid; font-size:14px;"><?=$prov->contacto?></td>
        </tr>
         <tr style="height:20px; ">
            <td style="width:20%; font-size:14px; border:3px solid; font-weight:bold;  padding-left:5px; background-color:#c8cccc;">Correo electrónico:</td>
            <td style="width:80%; border-top:3px solid; border-bottom:3px solid;  padding-left:5px; border-right:3px solid; font-size:14px;"><?=$prov->correo?></td>
        </tr>
         <tr style="height:30px; ">
             <td colspan="2" style="padding:4px; font-size:14px; font-family:Arial;"><p><b>Instrucciones. </b>El evaluador además de preguntar al proveedor, considerara la información requerida por GLM y 
                     se registrara en la columna de "puntuación", el valor correspondiente a la calificación del proveedor. 
                     Después obtener el promedio de la puntuación y multiplicarlo por 20. Evaluar al proveedor según el criterio establecido</p>
             </td>
        </tr>
    </table>
    <table style="height:20px; font-family:Arial; width:950px; font-size:14px; border-collapse:collapse;">
        <tr style="height:20px;">
            <td style="width:90%;"></td>
            <td style="width:10%; border-top:3px solid; border-right:3px solid; border-left:3px solid; text-align: center; background-color:#c8cccc;">Puntuación</td>
        </tr>
     </table> 
        <table style="height:240px; width:950px; font-family:Arial; font-size:14px; border-collapse: collapse;">
        <tr style="height:60px;">
            <td style="width:90%; border:3px solid;">
                <table style="width:100%;">
                    <tr>
                        <td><p><b>1-</b> ¿Las unidades del transportista cumplen con los requisitos y condiciones de limpieza, seguridad y mecánicos solicitados por GLM, 
                                además de las medidas de seguridad del chofer?</p></td>
                    </tr>
                    <tr>
                        <td>
                            <table style:"font-family:Arial; font-size:14px;">
                                <tr> <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom1 == 5 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Siempre</td>
                                            </tr>
                                            <tr>
                                                <td>5&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; font-size:18px; width:25px; height:28px;"><?=$prom1 == 4 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Casi siempre</td>
                                            </tr>
                                            <tr>
                                                <td>4&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:200px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom1 == 3 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;"><p>La mitad de las veces</p></td>
                                            </tr>
                                            <tr>
                                                <td>3&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom1 == 2 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Pocas veces</td>
                                            </tr>
                                            <tr>
                                                <td>2&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:100px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom1 == 1 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Nunca</td>
                                            </tr>
                                            <tr>
                                                <td>1&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:10%; border-bottom: 3px solid; border-top:3px solid; border-right: 3px solid;">
                <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$prom1?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table> 
            </td>
        </tr>
         <tr style="height:60px;">
            <td style="width:90%;  border-bottom:3px solid; border-left: 3px solid; border-right: 3px solid;">
                <table style="width:100%;">
                    <tr>
                        <td><p><b>2-</b> ¿El transportista reporta la ubicación de sus unidades durante el trayecto a la entrega del cliente?</p></td>
                    </tr>
                    <tr>
                        <td>
                            <table style:"font-family:Arial; font-size:14px; ">
                                <tr> <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom2 == 5 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Siempre</td>
                                            </tr>
                                            <tr>
                                                <td>5&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; font-size:18px; width:25px; height:28px;"><?=$prom2 == 4 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Casi siempre</td>
                                            </tr>
                                            <tr>
                                                <td>4&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:200px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom2 == 3 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;"><p>La mitad de las veces</p></td>
                                            </tr>
                                            <tr>
                                                <td>3&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom2 == 2 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Pocas veces</td>
                                            </tr>
                                            <tr>
                                                <td>2&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:100px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom2 == 1 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Nunca</td>
                                            </tr>
                                            <tr>
                                                <td>1&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:10%; border-bottom: 3px solid; border-top:3px solid; border-right: 3px solid;">
                <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$prom2?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table> 
            </td>
        </tr>
         <tr style="height:60px;">
            <td style="width:90%; border-bottom:3px solid; border-left: 3px solid; border-right: 3px solid;">
                <table style="width:100%;">
                    <tr>
                        <td><p><b>3-</b> ¿El transportista reporta cuando existen atrasos en la fecha y hora acordada de entrega al cliente?</p></td>
                    </tr>
                    <tr>
                        <td>
                            <table style:"font-family:Arial; font-size:14px; ">
                                <tr> <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom3 == 5 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Siempre</td>
                                            </tr>
                                            <tr>
                                                <td>5&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; font-size:18px; width:25px; height:28px;"><?=$prom3 == 4 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Casi siempre</td>
                                            </tr>
                                            <tr>
                                                <td>4&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:200px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom3 == 3 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;"><p>La mitad de las veces</p></td>
                                            </tr>
                                            <tr>
                                                <td>3&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom3 == 2 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Pocas veces</td>
                                            </tr>
                                            <tr>
                                                <td>2&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:100px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom3 == 1 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Nunca</td>
                                            </tr>
                                            <tr>
                                                <td>1&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:10%; border-bottom: 3px solid; border-top:3px solid; border-right: 3px solid;">
                <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$prom3?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table> 
            </td>
        </tr>
         <tr style="height:60px;">
            <td style="width:90%;  border-bottom:3px solid; border-left: 3px solid; border-right: 3px solid;">
                <table style="width:100%;">
                    <tr>
                        <td><p><b>4-</b>  ¿El transportista cumple con la fecha y horario acordado con la entrega al cliente?</p></td>
                    </tr>
                    <tr>
                        <td>
                            <table style:"font-family:Arial; font-size:14px; ">
                                <tr> <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom4 == 5 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Cumple</td>
                                            </tr>
                                            <tr>
                                                <td>5&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; font-size:18px; width:25px; height:28px;"><?=$prom4 == 4 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Desfase 1 a 2 horas</td>
                                            </tr>
                                            <tr>
                                                <td>4&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:200px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom4 == 3 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;"><p>Desfase 2 a 3 horas</p></td>
                                            </tr>
                                            <tr>
                                                <td>3&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:150px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom4 == 2 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Desfase 3 a 4 horas</td>
                                            </tr>
                                            <tr>
                                                <td>2&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>                         
                                    <td style="width:100px; text-align:center;">
                                        <table style="font-family: Arial; font-size: 12px;">
                                            <tr>
                                                <td style="border:1px solid; width:25px; font-size:18px; height:28px;"><?=$prom4 == 1 ? 'X' : ''?></td>
                                                <td style="height:28px; width:125px; padding-left:5px; text-align:left;">Desfase +5 horas. con o sin justificación</td>
                                            </tr>
                                            <tr>
                                                <td>1&nbsp;pts.</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:10%; border-bottom: 3px solid; border-right: 3px solid;">
                <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$prom4?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table> 
            </td>
        </tr>
        </table>
         <table style="height: 30px; border-collapse: collapse; font-family:Arial; font-size:14px;">
             <tr>
            <td style="width:85%; height: 30px; border-bottom:3px solid; border-left:3px solid; border-right:3px solid;"></td>
            <td style="width:5%; border-bottom: 3px solid; text-align: center">Suma</td>
            <td style="width:10%; height: 30px; border-bottom: 3px solid;  border-left:3px solid; border-right: 3px solid;">
                <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr style="height:30px;">
                        <td style="width:33%; height:30px;"></td><td style="border:1px solid; width:30px; height:20px; font-size:18px; text-align:center;"><?=$suma?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
              </table>
           </td>
        </tr>
    </table>
    <table style="height: 60px; border-collapse: collapse; font-family:Arial; font-size: 14px; background-color:#c8cccc;">
        <tr>
            <td style="width:15%; height: 60px; border-bottom:3px solid; border-left: 3px solid; text-align: right;"><strong>Calificación del proveedor</strong></td>
            <td style="width:5%; border-bottom: 3px solid;  text-align: center;">=</td>
            <td style="width:20%; height: 30px; border-bottom: 3px solid;">
                <table style="height:100%; width:100%;">
                    <tr style="height:15%; width:100%;"><td></td></tr>
                    <tr style="height:50%; width:100%;"><td style="border:1px solid; background-color:#ffffff; text-align:center;"><strong><?=$promedio?></strong></td></tr>
                    <tr style="height:20%; width:100%;"><td style="font-size:10px; text-align:center;">Promedio de la puntuación</td></tr>
                    <tr style="height:15%; width:100%;"><td></td></tr>
                </table>
            </td>
            <td style="width:20%; height: 30px; border-bottom: 3px solid; text-align:center;">X</td>
            <td style="width:10%; height: 30px; border-bottom: 3px solid; text-align:center; ">20</td>
            <td style="width:10%; height: 30px; border-bottom: 3px solid; text-align:center;">=</td>
            <td style="width:20%; height: 30px; border-bottom: 3px solid; border-right: 3px solid; ">
               <table style="height:100%; width:100%;">
                    <tr style="height:15%; width:100%;"><td></td></tr>
                    <tr style="height:50%; width:100%; text-align:center;"><td style="border:1px solid; background-color:#ffffff; text-align:center;"><strong><?=$calificacion?></strong></td></tr>
                    <tr style="height:20%; width:100%;"><td style="font-size:10px; text-align:center;">Calificación</td></tr>
                    <tr style="height:15%; width:100%;"><td></td></tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="height:450px; font-family: Arial; font-size: 14px; border-collapse: collapse; margin-top:15px;">
        <tr>
            <td  style="width:50%;">
                <table  style="border-collapse: collapse;">>
                    <tr style="background-color:#c8cccc; height:20px;">
                        <td colspan="3" style="width:100%; height:20px; text-align:center; border:3px solid;">
                            Criterio de evaluación
                        </td>
                    </tr>
                    <tr style="height:20px;">
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 3px solid; border-left: 3px solid;">Calificación</td>
                        <td style="width:50%; height:20px; text-align:center; border-bottom: 3px solid; border-left: 3px solid; border-right: 3px solid;">Estado de evaluación</td>
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 3px solid; border-right: 3px solid;">Calificación</td>  
                    </tr>
                    <tr style="height:20px;">
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 1px solid; border-left: 3px solid;">De 70 a 100</td>
                        <td style="width:50%; height:20px; text-align:center; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Proveedor confiable</td>
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 1px solid; border-right: 3px solid;">  <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$calificacion >=70 ? "X" : ""?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table></td>  
                    </tr>
                      <tr style="height:20px;">
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 1px solid; border-left: 3px solid;">De 60 a 69</td>
                        <td style="width:50%; height:20px; text-align:center; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Proveedor condicionado</td>
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 1px solid; border-right: 3px solid;">  <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$calificacion >=60 && $calificacion <= 69 ? "X" : ""?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table></td>  
                    </tr>
                    <tr style="height:20px;">
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 3px solid; border-left: 3px solid;">Menos de 60</td>
                        <td style="width:50%; height:20px; text-align:center; border-bottom: 3px solid; border-left: 1px solid; border-right: 1px solid;">Proveedor no confiable</td>
                        <td style="width:25%; height:20px; text-align:center; border-bottom: 3px solid; border-right: 3px solid;">  <table>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width:33%"></td><td style="border:1px solid; width:30px; height:30px; font-size:18px; text-align:center;"><?=$calificacion <=59 ? "X" : ""?></td><td style="width:33%"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </table></td>  
                    </tr>
                </table>
            </td>
            <td  style=" width:50%;">
                <table style="width:300px; margin-left:30px;">
                    <tr style="height:45%">
                        <td style="width: 85%; text-align:center;"> <div><img style="width: 220px; height: 100px;" src="<?=root_url?>views/catalogos/uploads/imgFirmasUsuarios/<?=Utils::getFirmaUser($_SESSION['usuario']->id)?>"></div><td>
                        <td style="width: 15%;"><td>   
                    </tr>
                       <tr style="height:45%">
                        <td style="width: 85%; border-top:1px solid; text-align:center;">Firma del evaluador</td>
                        <td style="width: 15%;"><td>   
                    </tr>
                    <tr style="height:10%">
                        <td style="width: 85%; font-size: 10px; text-align:right; padding-top:20px;"><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></td>
                        <td style="width: 15%;"><td>   
                    </tr>
                </table>
            </td>           
        </tr>
    </table>
</div>