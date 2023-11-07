<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="../../assets/img/gpl.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/compras/assets/css/formatos.css" />
        <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
        <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script> 
        <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?= root_url ?>views/compras/assets/js/formatos.js"></script>
        <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> 
        <title>Formato Evaluación</title>
    </head>
 <body>
    <header class="header-orden">
        <nav class="d-flex"> 
                <span id="imprimirEvaluacion" title="Imprimir evaluación" class="material-icons i-print transform">print</span>
                <span id="enviarEvaluacion" title="Enviar evaluación" class="material-icons  i-mail transform">mail_outline</span>
        </nav>
    </header>
            <div class="contenedor-evaluacion">
                <div class="titulo-evaluacion">
                    <div>
                        <img class="img" src="<?= root_url ?>assets/img/default.jpg" />
                    </div>
                    <div>
                        <h2>Grupo LEA de México S. de R. L. de C. V.</h2>
                        <h4>Evaluación a proveedores de servicio de transporte</h4>
                    </div>        
                </div>
                 <div class="datos-prov-evaluacion">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                        <div class="back-gray border-bold pad-row"><strong>Periodo evaluación: </strong></div>
                        <div class="border-bold-b border-bold-r border-bold-t pad-row"><?=$fechaInicio. " - ". $fechaFinal?></div>
                        <input type="hidden" value="<?=$fechaInicio?>" id="fechaInicio"/>
                        <input type="hidden" value="<?=$fechaFinal?>" id="fechaFin"/>
                        <input type="hidden" value="<?=$id?>" id="idProv"/>
                        </div>
                         <div class="d-flex">
                            <div class="back-gray border-bold pad-row "><strong>Compras en el período: </strong></div>
                            <div class="border-bold-b border-bold-r border-bold-t pad-row"><?=$evaluaciones?></div>
                        </div>
                        <div class="d-flex">
                            <div class="back-gray border-bold pad-row "><strong>Fecha evaluación:</strong></div>
                            <div class="border-bold-b border-bold-r border-bold-t pad-row"><?=date('d/m/Y', strtotime(UtilsHelp::today()))?></div>
                        </div>
                    </div>
                        <div class="d-flex mt-2 back-gray border-bold pad-row"><strong>Datos del proveedor a evaluar</strong></div>
                          <div class="d-flex">   
                              <div class="back-gray border-bold-b border-bold-l border-bold-r pad-row w-20"><strong>Nombre:</strong></div>
                              <div class="border-bold-b border-bold-r w-80 pad-row"><?=$prov->proveedor?></div>
                          </div>
                             <div class="d-flex">   
                              <div class="back-gray border-bold-b border-bold-l border-bold-r pad-row w-20"><strong>Dirección: </strong></div>
                              <div class="border-bold-b border-bold-r w-80 pad-row"><?=$prov->direccion. ", ". $prov->ciudad?></div>
                          </div>      
                        <div class="d-flex">   
                              <div class="back-gray border-bold-b border-bold-l border-bold-r pad-row w-20"><strong>Teléfono: </strong></div>
                              <div class="border-bold-b border-bold-r w-80 pad-row"><?=$prov->telefono?></div>
                          </div>      <div class="d-flex">   
                              <div class="back-gray border-bold-b border-bold-l border-bold-r pad-row w-20"><strong>Contacto: </strong></div>
                              <div class="border-bold-b border-bold-r w-80 pad-row"><?=$prov->contacto?></div>
                          </div>      <div class="d-flex">   
                              <div class="back-gray border-bold-b border-bold-l border-bold-r pad-row w-20"><strong>Correo electrónico: </strong></div>
                              <div class="border-bold-b border-bold-r w-80 pad-row"><?=$prov->correo?></div>
                          </div>
                    </div>
                <div class="instrucciones-evaluacion">
                    <p><b>Instrucciones. </b>El evaluador además de preguntar al proveedor, considerara la información requerida por GLM 
                        y se registrara en la columna de "puntuación", el valor correspondiente a la calificación del proveedor. 
                        Después obtener el promedio de la puntuación y multiplicarlo por 20. Evaluar al proveedor según el criterio establecido</p>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="border-bold-t border-bold-r border-bold-l back-gray titulo-preguntas"><strong>Puntuación</strong></div>
                </div>
                <div class="preguntas-evaluacion border-bold">
                    <div class="border-bold-b border-bold-r">
                    <div class="pregunta-evaluacion"><p><b>1-</b> ¿Las unidades del transportista cumplen con los requisitos y condiciones de limpieza, seguridad y mecánicos solicitados 
                            por GLM, además de las medidas de seguridad del chofer?</p></div>       
                      <div class="d-flex justify-content-around">
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom1 == 5 ? 'X' : ''?></div><div>5 pts.</div></div>
                            <div><span>Siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom1 == 4 ? 'X' : ''?></div><div>4 pts.</div></div>
                            <div><span>Casi siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom1 == 3 ? 'X' : ''?></div><div>3 pts.</div></div>
                            <div><span>La mitad de las veces</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom1 == 2 ? 'X' : ''?></div><div>2 pts.</div></div>
                            <div><span>Pocas veces</span></div>
                        </div>
                            <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom1 == 1 ? 'X' : ''?></div><div>1 pts.</div></div>
                            <div><span>Nunca</span></div>
                        </div>
                    </div>
                    </div>
                    <div class="border-bold-b d-flex"><div class="border-normal casilla text-center"><?=$prom1?></div></div>
                     <div class="border-bold-b border-bold-r">
                    <div class="pregunta-evaluacion"><p><b>2-</b> ¿El transportista reporta la ubicación de sus unidades durante el trayecto a la entrega del cliente?</p></div>       
                      <div class="d-flex justify-content-around">
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom2 == 5 ? 'X' : ''?></div><div>5 pts.</div></div>
                            <div><span>Siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom2 == 4 ? 'X' : ''?></div><div>4 pts.</div></div>
                            <div><span>Casi siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom2 == 3 ? 'X' : ''?></div><div>3 pts.</div></div>
                            <div><span>La mitad de las veces</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom2 == 2 ? 'X' : ''?></div><div>2 pts.</div></div>
                            <div><span>Pocas veces</span></div>
                        </div>
                            <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom2 == 1 ? 'X' : ''?></div><div>1 pts.</div></div>
                            <div><span>Nunca</span></div>
                        </div>
                    </div>
                    </div>
                    <div class="border-bold-b d-flex"><div class="border-normal casilla text-center"><?=$prom2?></div></div>
                     <div class="border-bold-b border-bold-r">
                    <div class="pregunta-evaluacion"><p><b>3-</b> ¿El transportista reporta cuando existen atrasos en la fecha y hora acordada de entrega al cliente?</p></div>       
                      <div class="d-flex justify-content-around">
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom3 == 5 ? 'X' : ''?></div><div>5 pts.</div></div>
                            <div><span>Siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom3 == 4 ? 'X' : ''?></div><div>4 pts.</div></div>
                            <div><span>Casi siempre</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom3 == 3 ? 'X' : ''?></div><div>3 pts.</div></div>
                            <div><span>La mitad de las veces</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom3 == 2 ? 'X' : ''?></div><div>2 pts.</div></div>
                            <div><span>Pocas veces</span></div>
                        </div>
                            <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom3 == 1 ? 'X' : ''?></div><div>1 pts.</div></div>
                            <div><span>Nunca</span></div>
                        </div>
                    </div>
                    </div>
                    <div class="border-bold-b d-flex"><div class="border-normal casilla text-center"><?=$prom3?></div></div>
                    <div class="border-bold-b border-bold-r">
                    <div class="pregunta-evaluacion"><p><b>4-</b> ¿El transportista cumple con la fecha y horario acordado con la entrega al cliente?</p></div>       
                      <div class="d-flex justify-content-around">
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom4 == 5 ? 'X' : ''?></div><div>5 pts.</div></div>
                            <div><span>Cumple</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom4 == 4 ? 'X' : ''?></div><div>4 pts.</div></div>
                            <div><span>Desfase 1 a 2 horas</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom4 == 3 ? 'X' : ''?></div><div>3 pts.</div></div>
                            <div><span>Desfase 2 a 3 horas</span></div>
                        </div>
                        <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom4 == 2 ? 'X' : ''?></div><div>2 pts.</div></div>
                            <div><span>Desfase 3 a 4 horas</span></div>
                        </div>
                            <div class="respuestas-evaluacion">
                            <div><div class="border-normal casilla"><?=$prom4 == 1 ? 'X' : ''?></div><div>1 pts.</div></div>
                            <div><span>Desfase +5 horas. con o sin justificación.</span></div>
                        </div>
                    </div>
                    </div>
                    <div class="border-bold-b d-flex"><div class="border-normal casilla text-center"><?=$prom4?></div></div>
                   <div class="d-flex justify-content-end border-bold-b"><div class="border-bold-l border-bold-r span-suma">Suma</div></div>
                   <div class="d-flex border-bold-b"><div class="border-normal casilla text-center"><?=$suma?></div></div>
               <div class="resultados-evaluacion d-flex justify-content-around back-gray">
                    <div class="w-20 text-center"><strong>Calificación del proveedor</strong></div>
                    <span>=</span>
                    <div class="text-center resultado-evaluacion-div">
                        <div class="resultado-evaluacion border-normal p-1"><strong><?=$promedio?></strong></div><div><span>Promedio de la puntuación</span></div>
                    </div>
                          <span>X</span>
                          <span>20</span>
                          <span>=</span>
                   <div class="text-center resultado-evaluacion-div">
                        <div class="resultado-evaluacion border-normal p-1"><strong><?=$calificacion?></strong></div><div><span>Calificación</span></div>
                    </div>
                </div>
                </div>
                <div class="criterio-firma">
                    <div class="criterio-evaluacion border-bold">
                        <div class="border-bold-b back-gray criterio"><span>Criterio de evaluación</span></div>
                        <div class="border-bold-r border-bold-b back-gray"><span>Calificación</span></div>
                        <div class="back-gray border-bold-r border-bold-b"><span>Estado de evaluación</span></div>
                        <div class="border-bold-b back-gray"><span>Resultado</span></div>
                        <div class="p-3 border-normal-r border-normal-b"><span>De 70 a 100</span></div>
                        <div class="p-3 border-normal-r border-normal-b"><span>Proveedor confiable</span></div>
                        <div class="p-3 border-normal-b"><div class="d-flex"><div class="border-normal casilla"><?=$calificacion >=70 ? "X" : ""?></div></div></div>
                        <div class="p-3 border-normal-r border-normal-b"><span>De 60 a 69</span></div>
                        <div class="p-3 border-normal-r border-normal-b"><span>Proveedor condicionado</span></div>
                        <div class="p-3 border-normal-b"><div class="d-flex"><div class="border-normal casilla"><?=$calificacion >=60 && $calificacion <= 69 ? "X" : ""?></div></div></div>
                        <div class="p-3 border-normal-r"><span>Menos de 60</span></div>
                        <div class="p-3 border-normal-r"><span>Proveedor no confiable</span></div>
                        <div class="p-3"><div class="d-flex"><div class="border-normal casilla"></div><?=$calificacion <=59 ? "X" : ""?></div></div>
                    </div>
                    <div class="d-flex">
                        <div><div><img class="img-firma" src="<?=root_url?>views/catalogos/uploads/imgFirmasUsuarios/<?=Utils::getFirmaUser($_SESSION['usuario']->id)?>" /></div><span class="firma-evaluacion border-normal-t">Firma del evaluador</span></div>
                        <div class="documento-evaluacion"><span><?=$doc != null ? $doc->codigo.' / Ver. '. $doc->revision : "Documento sin registrar"?></span></div>
                    </div>
                </div>
                
                </div>



    </body>
</html>