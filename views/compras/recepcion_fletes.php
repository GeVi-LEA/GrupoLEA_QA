            <div class="mt-2 d-flex">
                <div class="w-90">
                <table class="tabla-recepcion">
                  <?php if (isset($r)): ?>
                    <thead>
                   <tr>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                       </tr>     
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($r['detalle']); $i++): ?>
                                <tr>
                            <input type="hidden" id="idDetalle" value="<?= $r['detalle'][$i]['id']; ?>"/>
                            <td><?= Utils::getNombreUnidad(intval($r['detalle'][$i]['unidad_id'])); ?></td>
                            <td><?= $r['detalle'][$i]['descripcion']; ?></td>
                            <td><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['cantidad']); ?></td>
                            <td><span class="mr-1"><?= UtilsHelp::numero2Decimales($r['detalle'][$i]['precio']); ?></span><span><?= monedas[$r['moneda']]['clave'] ?></span></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
             <?php endif; ?>
                </table>
                </div>
                <?php if ($carroTanque != $r['transporte_id']): ?>
                    <div class="pr-1 text-center mb-1"><strong class="d-block">A-T</strong>
                        <?php foreach ($embs as $e): ?>
                            <span class="fixed important pl-2 pr-2"><?= $e->numero_transporte ?></span>
                        <?php endforeach; ?> 
                    </div>
                <?php else: ?>
                    <div class="pr-1 text-center mb-1"><strong class="d-block">Carro Tanque</strong>
                        <?php foreach ($embs as $e): ?>
                            <span class="fixed important pl-2 pr-2"><?= $e->carroTanque ?></span>
                        <?php endforeach; ?> 
                    </div>
                <?php endif; ?>   
            </div>
            </div>
<form id="recepcionFleteForm">
 <div class="div-datos mt-2">
                <span class="titulo-div">Datos recepción</span>
                 <input type="hidden" name="id" id="id" value="<?= isset($rt) ? $rt->id : "";?>" />
                 <input type="hidden" name="idRequisicion" id="idRequisicion" value="<?=$r['id']; ?>" />
             <div class="datos mb-2 mt-2">
               <div><strong class="mr-1"># Factura:</strong><input type="text" name="numeroFacturaFlete" value="<?= isset($rt) ? $rt->numero_factura : ""; ?>" id="numeroFacturaFlete" class="item-small" /></div>
               <div class="d-flex" id="divDocumentoFacturaFlete"><strong class="mr-1 mt-1">Factura:</strong>
                <div><label for="documentoFacturaFlete" class="inputFile m-0"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documentoFacturaFlete" name="documentoFacturaFlete" value="" type="file" hidden />
                    <span id="spanDocumento" class="span-documento-factura"><?= isset($rt) ? UtilsHelp::recortarString($rt->factura, "_") : ""; ?></span>
                    <i id="showFacturaFlete" class="i-document material-icons far fa-file-pdf" title="Ver factura" hidden></i>
                    <span id="deleteFacturaFlete" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="facturaFlete" value="<?= isset($rt) ? $rt->factura : ""; ?>"/></div>
               </div>
              <div class="d-flex" id="divDocumentoXml"><strong class="mr-1 mt-1">XML:</strong>
                <div><label for="documentoXml" class="inputFile m-0"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documentoXml" name="documentoXml" value="" type="file" hidden />
                    <span id="spanDocumento" class="span-documento-factura"><?= isset($rt) ? UtilsHelp::recortarString($rt->docXml, "_") : ""; ?></span>
                    <i id="showXml" class="material-icons far fa-file-code" title="Ver XML" hidden></i>
                    <span id="deleteXml" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="xml" value="<?= isset($rt) ? $rt->docXml : ""; ?>"/></div>
               </div>
                <?php if($carroTanque != $r['transporte_id']):?>
               <div class="d-flex" id="divDocumentoRemision"><strong class="mr-1 mt-1">Remisión:</strong>
                <div><label for="documentoRemision" class="inputFile m-0"><i class="fas fa-cloud-upload-alt"></i>Agregar</label>
                    <input id="documentoRemision" name="documentoRemision" value="" type="file" hidden />
                    <span id="spanDocumento" class="span-documento-factura"><?= isset($rt) ? $rt->remision : ""; ?></span>
                    <i id="showRemision" class="i-document material-icons far fa-file-pdf" title="Ver pedimento" hidden></i>
                    <span id="deleteRemision" class="far i-delete material-icons fa-trash-alt" hidden></span>
                    <input type="hidden" id="remision" value="<?= isset($rt) && $rt->remision !=  '' ? $rt->remision : ""; ?>"/></div>
               </div>
                <?php else: ?>
                 <div><strong class="mr-1">Fecha recepción:</strong><input type="text" name="fechaFactura" value="<?= isset($rt) && $rt->fecha_recepcion != "" ? date('d/m/Y', strtotime($rt->fecha_recepcion)) : ""; ?>" id="fechaFactura" class="item-small" readOnly /></div>
                 <?php endif ?>
                     </div>
                 <div class="datos mb-2 mt-2 text-center">
                      <?php if($carroTanque != $r['transporte_id']):?>
                   <div><strong class="mr-1">Fecha recepción:</strong><input type="text" name="fechaFactura" value="<?= isset($rt) && $rt->fecha_recepcion != "" ? date('d/m/Y', strtotime($rt->fecha_recepcion)) : ""; ?>" id="fechaFactura" class="item-small" readOnly /></div>
                   <div><strong class="mr-1">Observaciones</strong><input type="text" name="observaciones" value="<?= isset($rt) && $rt->observaciones != "" ? $rt->observaciones : ""; ?>" class="item-big"/></div>
                   <?php else: ?>
                   <div><strong class="mr-1">Reducción descuento combustible:</strong><input type="hidden" id="idDetalleComb" name="idDetalleComb" value="<?= isset($r)  && count($r['detalle']) == 2 ? $r['detalle'][1]['id'] : ""; ?>"/><input type="text" id="descCombustible" name="descCombustible" value="<?= isset($r) && count($r['detalle']) == 2 ? UtilsHelp::numero2Decimales($r['detalle'][1]['precio']) : ""; ?>" class="item-s-small"/></div>
                   <div><strong class="mr-1">Observaciones:</strong><input type="text" name="observaciones" value="<?= isset($rt) && $rt->observaciones != "" ? $rt->observaciones : ""; ?>" class="item-big"/></div>
                   <?php endif ?>
                </div>
               </div>
              <div class="div-datos mt-2" id="evaluacionProveedor">
                <span class="titulo-div">Evaluación servicio de transporte</span>
                 <div class="datos mt-2">
                   <div><strong class="font-18 mr-1 ml-1" id="preg1">1- ¿Las unidades del transportista cumplen con los requisitos y condiciones de limpieza, seguridad y mecánicos solicitados por GLM, además de las medidas de seguridad del chofer?</strong></div>
                </div>
                  <div class="checkbox">
                      <div><input type="radio" name="pregunta1" value="5" <?=$evaluacion['pregunta1'] == 5 ? 'checked' : ""?>/><span>Siempre</span></div>
                      <div><input type="radio" name="pregunta1" value="4" <?=$evaluacion['pregunta1'] == 4 ? 'checked' : ""?>/><span>Casi siempre</span></div>
                      <div><input type="radio" name="pregunta1" value="3" <?=$evaluacion['pregunta1'] == 3 ? 'checked' : ""?>/><span>La mitad de las veces</span></div>
                      <div><input type="radio" name="pregunta1" value="2" <?=$evaluacion['pregunta1'] == 2 ? 'checked' : ""?>/><span>Pocas veces</span></div>
                      <div><input type="radio" name="pregunta1" value="1" <?=$evaluacion['pregunta1'] == 1 ? 'checked' : ""?>/><span>Nunca</span></div>
                </div>
                <div class="background-gray">
               <div class="datos mt-3">
                   <div><strong class="mr-1 ml-1 font-18 background-gray" id="preg2">2- ¿El transportista reporta la ubicación de sus unidades durante el trayecto a la entrega del cliente?</strong></div>
                </div>
                  <div class="checkbox">
                      <div><input type="radio" name="pregunta2" value="5" <?=$evaluacion['pregunta2'] == 5 ? 'checked' : ""?>/><span>Siempre</span></div>
                      <div><input type="radio" name="pregunta2" value="4" <?=$evaluacion['pregunta2'] == 4 ? 'checked' : ""?>/><span>Casi siempre</span></div>
                      <div><input type="radio" name="pregunta2" value="3" <?=$evaluacion['pregunta2'] == 3 ? 'checked' : ""?>/><span>La mitad de las veces</span></div>
                      <div><input type="radio" name="pregunta2" value="2" <?=$evaluacion['pregunta2'] == 2 ? 'checked' : ""?>/><span>Pocas veces</span></div>
                      <div><input type="radio" name="pregunta2" value="1" <?=$evaluacion['pregunta2'] == 1 ? 'checked' : ""?>/><span>Nunca</span></div>
                </div>
                </div>
                <div class="datos mt-3">
                   <div><strong class="mr-1 ml-1 font-18" id="preg3">3- ¿El transportista reporta cuando existen atrasos en la fecha y hora acordada de entrega al cliente?</strong></div>
                </div>
                  <div class="checkbox mb-1">
                      <div><input type="radio" name="pregunta3" value="5" <?=$evaluacion['pregunta3'] == 5 ? 'checked' : ""?>/><span>Siempre</span></div>
                      <div><input type="radio" name="pregunta3" value="4" <?=$evaluacion['pregunta3'] == 4 ? 'checked' : ""?>/><span>Casi siempre</span></div>
                      <div><input type="radio" name="pregunta3" value="3" <?=$evaluacion['pregunta3'] == 3 ? 'checked' : ""?>/><span>La mitad de las veces</span></div>
                      <div><input type="radio" name="pregunta3" value="2" <?=$evaluacion['pregunta3'] == 2 ? 'checked' : ""?>/><span>Pocas veces</span></div>
                      <div><input type="radio" name="pregunta3" value="1" <?=$evaluacion['pregunta3'] == 1 ? 'checked' : ""?>/><span>Nunca</span></div>
                </div>
                      <div class="background-gray">
                <div class="datos mt-3">
                   <div><strong class="mr-1 ml-1 font-18" id="preg4">4- ¿El transportista cumple con la fecha y horario acordado con la entrega al cliente?</strong></div>
                </div>
                  <div class="checkbox">
                      <div><input type="radio" name="pregunta4" value="5" <?=$evaluacion['pregunta4'] == 5 ? 'checked' : ""?>/><span>Cumple</span></div>
                      <div><input type="radio" name="pregunta4" value="4" <?=$evaluacion['pregunta4'] == 4 ? 'checked' : ""?>/><span>Desfase 1 a 2 horas</span></div>
                      <div><input type="radio" name="pregunta4" value="3" <?=$evaluacion['pregunta4'] == 3 ? 'checked' : ""?>/><span>Desfase 2 a 3 horas</span></div>
                      <div><input type="radio" name="pregunta4" value="2" <?=$evaluacion['pregunta4'] == 2 ? 'checked' : ""?>/><span>Desfase 3 a 4 horas</span></div>
                      <div><input type="radio" name="pregunta4" value="1" <?=$evaluacion['pregunta4'] == 1 ? 'checked' : ""?>/><span>Desfase +5 horas. con o sin justificación.</span></div>
                </div>
                      </div>
              <div class="datos mt-3">
                  <div class="calificacion">
                      <div><strong class="mr-2">Promedio de la puntuación: </strong><input type="text" class="item-ss-small fixed" id="promedio" value="" readOnly disabled></div>
                      <div><strong class="mr-2"> Calificación del proveedor:</strong><input type="text" class="item-ss-small fixed" id="calificacion" value="" readOnly disabled></div>
                  </div>
                </div>
               </div>
          </form>
               <div class="datos mt-2">
                <?php if (Utils::permisosCompras()):?>
                    <div>
                                 
                    </div>
                    <div class="d-flex">
                        <div class="mr-2"><button class="boton btn-salir" id= "btnElminarRecepcionFlete" title="Cancelar embarque"><span class="far i-delete material-icons fa-trash-alt btn-icon"></span></button></div>
                        <div class="mr-2"><button class="boton btn-guardar" id= "btnGurdarRecepcionFlete" title="Guardar"><span class="material-icons btn-icon">save</span></button></div>  
                        <div><button class="boton btn-salir" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button></div>
                    </div>
                  <?php endif; ?>    
                </div>