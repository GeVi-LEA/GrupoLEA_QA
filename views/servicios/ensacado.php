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
      <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/servicios/assets/css/servicios.css" />
      <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
      <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
      <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
      <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>
      <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script>
      <title>Ensacado</title>
</head>

<body>
      <div class="contenedor" id="contenedor">
            <header class='d-flex'>
                  <div>
                        <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" />
                  </div>
                  <div class="text-center w-75 mt-3">
                        <h4>SERVICIOS DE ALMACÉN Y ENSACADO</h4>
                  </div>
                  <div class="d-flex pt-3">
                        <?php if ($ensacado['fecha_entrada'] != ''): ?>
                        <div><button class="boton" id="btnSalida" title="Salida de unidad"><span class="fa-solid fa-truck-arrow-right rotarHorizontal material-icons i-danger btn-icon  pr-1"></span></button></div>
                        <?php endif; ?>
                        <?php if ($ensacado['estatus_id'] == '1'): ?>
                        <div><button class="boton" id="btnTransito" title="Poner unidad en transito"><span class="fa-solid fa-arrow-right-arrow-left material-icons i-transit btn-icon pr-1 mr-1"></span></button></div>
                        <?php endif; ?>
                        <?php if ($ensacado['fecha_entrada'] == ''): ?>
                        <div><button class="boton" id="btnIngresar" title="Ingresar unidad"><span class="fa-solid fa-truck-arrow-right material-icons i-iniciar btn-icon pr-1"></span></button></div>
                        <?php endif; ?>
                        <?php if ($ensacado['fecha_entrada'] != '' && $ensacado['estatus_id'] != '5'): ?>
                        <div><button class="boton" id="btnNuevoServicio" title="Agregar nuevo servicio"><span class="material-icons i-add btn-icon">add_circle</span></button></div>
                        <?php endif; ?>
                        <div><button class="boton" id="btnGuardar" title="Guardar"><span class="material-icons btn-icon i-save">save</span></button></div>
                        <div><button class="boton" id="btnEliminar" title="Eliminar"><span class="far i-delete material-icons fa-trash-alt btn-icon-s"></span></button></div>
                        <div><button class="boton" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button></div>
                  </div>
            </header>
            <section id="sectionForm">
                  <form id="ensacadoForm" enctype="multipart/form-data">
                        <div class="div-datos pb-2">
                              <span class="titulo-div">Datos entrada / salida</span>
                              <input type="hidden" id="ferrotolva" value="<?= $isTren ? 'F' : 'C' ?>" />
                              <div class="datos mt-2 mb-1">
                                    <input type="hidden" name="id" value="<?= isset($ensacado) && $ensacado['id'] != '' ? $ensacado['id'] : ''; ?>" id="id" />
                                    <div><strong class="mr-1">Número FT/AT:</strong><input type="text" name="numeroUnidad" value="<?= isset($ensacado) ? $ensacado['numUnidad'] : ''; ?>" id="numeroUnidad"
                                                class="item-small" />
                                          <label id="addDocumento" title="Agregar Bill of lading" for="documentoBill" class="inputFile mb-1"><i class="fas fa-cloud-upload-alt"></i></label>
                                          <input id="documentoBill" name="documentoBill" type="file" hidden /><input type="hidden" id="archivoBill" name="archivoBill"
                                                value="<?= isset($ensacado) && $ensacado['doc_remision'] != '' ? $ensacado['doc_remision'] : ''; ?>">
                                          <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver Bill of lading" hidden></i>
                                          <i id="delete" class="far i-delete material-icons fa-trash-alt" hidden></i>
                                    </div>
                                    <div><strong class="mr-1">Peso cliente:</strong><input type="text" name="pesoCliente" id="pesoCliente"
                                                value="<?= isset($ensacado) && $ensacado['peso_cliente'] != null ? UtilsHelp::numero2Decimales($ensacado['peso_cliente']) : ''; ?>" class="item-small" /><span
                                                class="ml-1">kgs.</span></div>
                                    <div><strong class="mr-1">Cliente:</strong>
                                          <select name="cliente" class="item-big" id="cliente">
                                                <option value="" selected>--Selecciona--</option>
                                                <?php
                                                        if (!empty($clientes)):
                                                                foreach ($clientes as $cli):
                                                ?>
                                                <option value="<?= $cli->id ?>" <?= isset($ensacado) && $cli->id == $ensacado['cliente_id'] ? 'selected' : ''; ?>><?= $cli->nombre ?> </option>
                                                <?php
                                                                endforeach;
                                                        endif;
                                                                                                        ?>
                                          </select>
                                    </div>
                                    <div class="d-flex"><strong class="mr-1">Estatus:</strong>
                                          <div id="tdEstatus" class="<?= Utils::getClaseEstado($ensacado['clave']); ?> estatus text-center"><span id="estatus"><?= $ensacado['estatus']; ?></span></div>
                                    </div>
                              </div>
                              <div class="datos pb-2">
                                    <div><strong class="mr-1">Transportista:</strong><input type="text" name="transportista" value="<?= isset($ensacado['transportista']) ? $ensacado['transportista'] : ''; ?>"
                                                id="transportista" class="item-big" /></div>
                                    <div><strong class="mr-1">Transporte:</strong>
                                          <select name="transporte" class="item-middle" id="transporte">
                                                <option value="" selected>--Selecciona--</option>
                                                <?php
                                                        if (!empty($transportes)):
                                                                foreach ($transportes as $t):
                                                ?>
                                                <option value="<?= $t->id ?>" <?= isset($ensacado) && $t->id == $ensacado['tipo_transporte_id'] ? 'selected' : ''; ?>><?= $t->nombre ?> </option>
                                                <?php
                                                                endforeach;
                                                        endif;
                                                                                                        ?>
                                          </select>
                                    </div>
                                    <div><strong class="mr-1">Tara:</strong><input type="text" name="tara"
                                                value="<?= isset($ensacado) && $ensacado['peso_tara'] != null ? UtilsHelp::numero2Decimales($ensacado['peso_tara']) : ''; ?>" id="tara" class="item-small" /><span
                                                class="ml-1">lbs.</span></div>
                                    <div class="d-flex">
                                          <div><strong class="mr-1">Ticket:</strong><input type="text" name="ticket" value="<?= isset($ensacado) ? $ensacado['ticket'] : ''; ?>" id="ticket" class="item-small" />
                                                <label id="addDocumento" title="Agregar ticket" for="documentoTicket" class="inputFile"><i class="fas fa-cloud-upload-alt"></i></label>
                                                <input id="documentoTicket" name="documentoTicket" type="file" hidden /><input type="hidden" id="archivoTicket" name="archivoTicket"
                                                      value="<?= isset($ensacado) && $ensacado['doc_ticket'] != '' ? $ensacado['doc_ticket'] : ''; ?>">
                                                <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver Bill of lading" hidden></i>
                                                <i id="delete" class=" i-delete material-icons far fa-trash-alt" title="Borrar archivo" hidden></i>
                                          </div>
                                    </div>
                              </div>
                              <div class="datos pb-2" <?= $isTren ? 'hidden' : '' ?>>
                                    <div><strong class="mr-1">Chofer:</strong><input type="text" name="chofer" value="<?= isset($ensacado['chofer']) ? $ensacado['chofer'] : ''; ?>" id="chofer" class="item-big"
                                                <?= $isTren ? 'disabled' : '' ?> /></div>
                                    <div><strong class="mr-1">Placa #1:</strong><input name="placa1" class="item-small" id="placa1" value="<?= isset($ensacado) ? $ensacado['placa1'] : ''; ?>" type="text" /></div>
                                    <div><strong class="mr-1">Placa #2:</strong><input name="placa2" class="item-small" id="placa2" value="<?= isset($ensacado) ? $ensacado['placa2'] : ''; ?>" type="text" /> </div>
                              </div>
                              <div class="datos pb-2">
                                    <div><strong class="mr-1">Fecha llegada:</strong><input type="text" name="fechaLlegada"
                                                value="<?= isset($ensacado) && $ensacado['fecha_entrada'] != '' ? UtilsHelp::fechaHora($ensacado['fecha_entrada']) : ''; ?>" id="fechaLlegada" class="item-medium fixed"
                                                readOnly disabled /></div>
                                    <div><strong class="mr-1">Fecha salida:</strong><input type="text" name="fechaSalida"
                                                value="<?= isset($ensacado) && $ensacado['fecha_salida'] != '' ? UtilsHelp::fechaHora($ensacado['fecha_salida']) : ''; ?>" id="fechaSalida" class="item-medium fixed"
                                                readOnly disabled /></div>
                                    <div><strong class="mr-2">En planta:</strong><span>Días: </span><input class="item-ss-small fixed" id="dias" type="text" value="<?= isset($tiempo) ? $tiempo['dias'] : ''; ?>"
                                                disabled />
                                          <span>Horas: </span><input class="item-ss-small fixed" type="text" value="<?= isset($tiempo) ? $tiempo['horas'] : ''; ?>" disabled />
                                          <span>Minutos: </span><input class="item-ss-small fixed" type="text" value="<?= isset($tiempo) ? $tiempo['minutos'] : ''; ?>" disabled />
                                    </div>
                              </div>

                              <div class="row flex-nowrap pb-3">
                                    <div class=" col-4 pl-5">
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Tara Kilos:</strong></div>
                                                <div class="pr-5"><input type="text" name="taraKilos" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['pesoTaraKg'], true, 0) : ''; ?>" id="taraKilos"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Peso teorico:</strong></div>
                                                <div class="pr-5"><input type="text" name="pesoTeorico" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['peso_teorico'], true, 0) : ''; ?>"
                                                            id="pesoTeorico" class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>

                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>% Tolerable:</strong></div>
                                                <div class="pr-5"><input type="text" name="tolerable" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($ensacado['tolerable'], true, 0) : ''; ?>" id="tolerable"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="d-flex justify-content-between">
                                                <div class="pt-2"><strong title="Diferencia entre peso teorico y peso cliente.">Diferencia teorica:</strong></div>
                                                <div class="pr-5"><input type="text" name="diferenciaTeorica"
                                                            value="<?= isset($ensacado['diferenciaTeorica']) ? UtilsHelp::numero2Decimales($ensacado['diferenciaTeorica'], true, 0) : ''; ?>" id="diferenciaTeorica"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                    </div>
                                    <div class="col-4 pl-5">
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Peso bruto:</strong></div>
                                                <div class="pr-5"><input type="text" name="pesoBruto" value="<?= isset($pesaje) ? UtilsHelp::numero2Decimales($pesaje['EntPesoB'], true, 0) : ''; ?>" id="pesoBruto"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Peso tara:</strong></div>
                                                <div class="pr-5"><input type="text" name="pesoTara" value="<?= isset($pesaje['EntPesoT']) ? UtilsHelp::numero2Decimales($pesaje['EntPesoT'], true, 0) : ''; ?>"
                                                            id="pesoTara" class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Peso neto:</strong></div>
                                                <div class="pr-5"><input type="text" name="pesoNeto" value="<?= isset($pesoNeto) ? UtilsHelp::numero2Decimales($pesoNeto, true, 0) : ''; ?>" id="pesoNeto"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="d-flex justify-content-between">
                                                <div class="pt-2"><strong>Diferencia real:</strong></div>
                                                <div class="pr-5"><input type="text" name="diferenciaReal" value="<?= isset($ensacado) ? UtilsHelp::numero2Decimales($diferenciaReal, true, 0) : ''; ?>" id="diferenciaReal"
                                                            class="item-small fixed" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                    </div>
                                    <div class="col-4 pl-5">
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Fecha peso:</strong></div>
                                                <div class="pr-8"><input type="text" name="fechaPeso" value="<?= isset($pesaje) ? UtilsHelp::formatoFecha($pesaje['EntFechaE']) : ''; ?>" id="fechaPeso"
                                                            class="item-small fixed" disabled /></div>
                                          </div>
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Hora peso:</strong></div>
                                                <div class="pr-8"><input type="text" name="horaPeso" value="<?= isset($pesaje) ? UtilsHelp::formatoHora($pesaje['EntHoraE']) : ''; ?>" id="horaPeso"
                                                            class="item-small fixed" disabled /></div>
                                          </div>
                                          <div class="d-flex justify-content-between mb-1">
                                                <div class="pt-2"><strong>Fecha peso salida:</strong></div>
                                                <div class="pr-8"><input type="text" name="fechaPesoSalida" value="<?= isset($pesaje) ? UtilsHelp::formatoFecha($pesaje['EntFechaS']) : ''; ?>" id="fechaPesoSalida"
                                                            class="item-small fixed" disabled /></div>
                                          </div>
                                          <div class="d-flex justify-content-between">
                                                <div class="pt-2"><strong>Hora peso salida:</strong></div>
                                                <div class="pr-8"><input type="text" name="horaPesoSalida" value="<?= isset($pesaje) ? UtilsHelp::formatoHora($pesaje['EntHoraS']) : ''; ?>" id="horaPesoSalida"
                                                            class="item-small fixed" disabled /></div>
                                          </div>
                                    </div>
                              </div>
                              <?php if (isset($isTren) && !$isTren): ?>
                              <div class="datos pb-2">
                                    <div><strong class="mr-1">Sello #1:</strong><input name="sello1" class="item-middle" id="sello1" type="text" value="<?= isset($ensacado) ? $ensacado['sello1'] : ''; ?>" /></div>
                                    <div><strong class="mr-1">Sello #2:</strong><input name="sello2" class="item-middle" id="sello2" type="text" value="<?= isset($ensacado) ? $ensacado['sello2'] : ''; ?>" /></div>
                                    <div><strong class="mr-1">Sello #3:</strong><input name="sello3" class="item-middle" id="sello3" type="text" value="<?= isset($ensacado) ? $ensacado['sello3'] : ''; ?>" /></div>
                              </div>
                              <?php endif; ?>
                              <div class="datos pb-2">
                                    <div><strong class="mr-1">Observaciones:</strong><input name="observaciones" class="item-bigger" id="observaciones" type="text"
                                                value="<?= isset($ensacado) ? $ensacado['observaciones'] : ''; ?>" /></div>
                              </div>
                        </div>
                  </form>
            </section>
            <section id="seccionServicios">
                  <?php if (isset($ensacado) && count($ensacado['servicio']) > 0): ?>
                  <?php foreach ($ensacado['servicio'] as $serv): ?>
                  <div class="div-datos mt-2">
                        <div class="d-flex justify-content-between mt-1">
                              <input type="hidden" value="<?= $serv['id'] ?>" id="idServicio" />
                              <div class="ml-2"><strong class="mr-1">Folio:</strong><span class="fixed item-medium folio"> <?= $serv['folio'] ?></span></div>
                              <div class="ml-2"><strong class="mr-1">Servicio:</strong><input type="hidden" id="idNombreServicio" value="<?= $serv['servicio_id'] ?> " /> <span id="nombreServicio"
                                          class="fixed item-medium">
                                          <?= $serv['nombreServ'] ?></span></div>
                              <div><strong class="mr-1">Empaque:</strong><span class="fixed item-medium"> <?= $serv['empaque'] ?></span></div>
                              <div><strong class="mr-1">Cantidad:</strong><span class="item-s-small fixed"><?= $serv['cantidad'] != null ? UtilsHelp::numero2Decimales($serv['cantidad']) : ''; ?></span><span
                                          class="ml-1">kgs.</span></div>
                              <div>
                                    <?php if ($serv['fecha_inicio'] == '' && $serv['fecha_programacion'] != ''): ?>
                                    <span id="iniciarServicio" class="material-icons i-iniciar border-btn">play_arrow</span>
                                    <?php endif; ?>
                                    <?php if ($serv['estatus_id'] == 3 || $serv['estatus_id'] == 13): ?>
                                    <span id="detenerServicio" class="fa-regular fa-circle-stop material-icons i-pdf border-btn"></span>
                                    <?php endif; ?>
                                    <span id="editarServicio" class="material-icons i-edit border-btn" title="Editar">edit</span>
                                    <span id="deleteServicio" class="material-icons i-delete border-btn" title="Eliminar">delete_forever</span>
                                    <span id="imprimirServicio" class="i-document material-icons border-btn mr-1">description</span>
                              </div>
                        </div>
                        <div class="datos mt-2">
                              <div><strong class="mr-1">Orden:</strong><span class="item-small fixed mr-2"><?= isset($serv['orden']) ? $serv['orden'] : ''; ?> </span>
                                    <?php if ($serv['doc_orden'] != ''): ?>
                                    <input type="hidden" /><input name="documentoOrden" type="file" hidden /><input type="hidden" name="archivoOrden" value="<?= $serv['doc_orden']; ?>">
                                    <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver Orden"></i>
                                    <?php endif; ?>
                              </div>
                              <div><strong class="mr-1">Lote:</strong><span class="item-small fixed"> <?= isset($serv['lote']) ? $serv['lote'] : ''; ?> </span></div>
                              <div><strong class="mr-1">Producto:</strong><span class="item-small fixed"><?= isset($serv['producto']) ? $serv['producto'] : ''; ?></span></div>
                              <div><strong class="mr-1">Rótulo:</strong><span class="item-small fixed"><?= isset($ensacado['alias']) ? $ensacado['alias'] : ''; ?></span></div>
                              <div class="d-flex"><strong class="mr-1">Estatus:</strong>
                                    <div class="<?= Utils::getClaseEstado($serv['clave']); ?> estatus text-center"><span id="estatus"><?= $serv['estatus']; ?></span></div>
                              </div>
                        </div>
                        <div class="datos mt-2">
                              <?php $transcurrido = UtilsHelp::tiempoTranscurrido(intval($serv['transcurrido'])) ?>
                              <div><strong class="mr-1">Fecha programación:</strong><span
                                          class="item-small fixed"><?= $serv['fecha_programacion'] != null && $serv['fecha_programacion'] != '' ? date('d/m/Y', strtotime($serv['fecha_programacion'])) : ''; ?></span>
                              </div>
                              <div><strong class="mr-1">Inicio:</strong><span
                                          class="item-medium fixed"><?= $serv['fecha_inicio'] != null && $serv['fecha_inicio'] != '' ? UtilsHelp::fechaHora($serv['fecha_inicio']) : ''; ?></span></div>
                              <div><strong class="mr-1">Fin:</strong><span class="item-medium fixed"><?= $serv['fecha_fin'] != null && $serv['fecha_fin'] != '' ? UtilsHelp::fechaHora($serv['fecha_fin']) : ''; ?></span>
                              </div>
                              <div><strong class="mr-1">Duración</strong><span>D: </span><span class="item-ss-small fixed"><?= isset($transcurrido) ? $transcurrido['dias'] : ''; ?></span>
                                    <span>H: </span><span class="item-ss-small fixed"> <?= isset($transcurrido) ? $transcurrido['horas'] : ''; ?> </span>
                                    <span>M: </span><span class="item-ss-small fixed"><?= isset($transcurrido) ? $transcurrido['minutos'] : ''; ?> </span>
                              </div>
                        </div>
                        <div class="datos mt-2" style="visible:<?= str_contains($serv['nombreServ'], 'SALIDA') ? 'none' : 'block'; ?>">
                              <div><strong class="mr-1">Total ensacado:</strong><span
                                          class="item-small fixed"><?= $serv['total_ensacado'] != null ? UtilsHelp::numero2Decimales($serv['total_ensacado']) : ''; ?></span><span class="ml-1">kgs.</span></div>
                              <div><strong class="mr-1">Barredura sucia:</strong><span
                                          class="item-small fixed"><?= $serv['barredura_sucia'] != '' ? UtilsHelp::numero2Decimales($serv['barredura_sucia']) : ''; ?></span><span class="ml-1 mr-3">kgs.</span></div>
                              <div><strong class="mr-1">Barredura limpia:</strong><span
                                          class="item-small fixed"><?= $serv['barredura_limpia'] != '' ? UtilsHelp::numero2Decimales($serv['barredura_limpia']) : ''; ?></span><span class="ml-1 mr-3">kgs.</span></div>
                              <div><strong class="mr-1">Total barredura:</strong><span class="item-small fixed"><?= UtilsHelp::string2Entero($serv['barredura_sucia'] + $serv['barredura_limpia']); ?></span><span
                                          class="ml-1">kgs.</span></div>
                        </div>
                        <div class="datos mt-2">
                              <div><strong class="mr-1">Tarimas:</strong><span class="item-small fixed"><?= $serv['tarimas'] != '' ? UtilsHelp::string2Entero($serv['tarimas']) : ''; ?></span></div>
                              <div><strong class="mr-1">Tipo Tarima:</strong><span class="item-small fixed"><?= $serv['tipo_tarima'] != '' ? tipo_tarimas[$serv['tipo_tarima']] : '' ?></span> </div>
                              <div><strong class="mr-1">Bultos:</strong><span class="item-small fixed"><?= $serv['bultos'] != '' ? UtilsHelp::string2Entero($serv['bultos']) : ''; ?></span></div>
                              <div><strong class="mr-1">Parcial:</strong><span class="item-small fixed"><?= $serv['parcial'] != '' ? UtilsHelp::string2Entero($serv['parcial']) : ''; ?></span></div>
                        </div>
                        <div class="datos mt-2 mb-1">
                              <div><strong class="mr-1">Observaciones:</strong><span class="item-bigger fixed"><?= $serv['observaciones'] != null && $serv['observaciones'] != '' ? $serv['observaciones'] : ''; ?></span>
                              </div>
                        </div>
                  </div>
                  <?php endforeach; ?>
                  <?php endif; ?>

            </section>
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

      <!-- Modal agregar servicio-->
      <div class="modal fade modal-servicio" id="agregarServicioModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog m-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header m-title justify-content-between">
                              <h5 class="modal-title ml-2"><span class="material-icons far fa-file-alt i-new"></span></a><span class="ml-2">Agregar nuevo servicio</span></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="border-modal modal-body">
                              <form id="formAgregarServicio" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="idEntrada" name="idEntrada" />
                                    <div class="container div-form">
                                          <div class="row justify-content-between mb-2">
                                                <div class="d-flex">
                                                      <div class="mr-1"><strong>Servicio:</strong></div>
                                                      <div><select name="idTipoServicio" class="item-big" id="idTipoServicio">
                                                                  <option value="" selected>--Selecciona--</option>
                                                                  <?php
if (!empty($servicios)):
        foreach ($servicios as $s):
                ?>
                                                                  <option value="<?= $s->id ?>"><?= $s->clave . ' - ' . $s->nombre ?> </option>
                                                                  <?php
        endforeach;
endif;
?>
                                                            </select></div>
                                                </div>
                                                <div class="d-flex">
                                                      <div class="mr-1"><strong>Empaque:</strong></div>
                                                      <div><select name="idEmpaque" class="item-medium" id="idEmpaque">
                                                                  <option value="" selected>--Selecciona--</option>
                                                                  <option value="">N/A</option>
                                                                  <?php
if (!empty($tiposEmpaques)):
        foreach ($tiposEmpaques as $tp):
                ?>
                                                                  <option value="<?= $tp->id ?>"><?= $tp->nombre ?> </option>
                                                                  <?php
        endforeach;
endif;
?>
                                                            </select></div>
                                                </div>
                                                <div><strong class="mr-1">Cantidad:</strong><input type="text" name="cantidad" id="cantidad" class="item-small" /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div>
                                                <div class="row justify-content-between mb-2">
                                                      <div><strong class="mr-1">Orden:</strong><input type="text" name="orden" class="item-small" /> </div>
                                                      <div> <strong class="mr-1">Lote:</strong><input type="text" name="lote" id="lote" class="item-small" />
                                                            <select name="lote" id="lote" class="item-small" hidden>
                                                                  <option>--Selecciona--</option>
                                                            </select>
                                                      </div>
                                                      <div><strong class="mr-1">Producto:</strong>
                                                            <select name="producto" class="item-small" id="producto">
                                                                  <option value="" selected>--Selecciona--</option>
                                                                  <?php
if (!empty($productos)):
        foreach ($productos as $p):
                ?>
                                                                  <option value="<?= $p->id ?>"><?= $p->nombre ?> </option>
                                                                  <?php
        endforeach;
endif;
?>
                                                            </select>
                                                      </div>
                                                      <div><strong class="mr-1">Rótulo:</strong><input type="text" name="alias" id="alias" class="item-small" /></div>
                                                </div>
                                                <div class="row d-flex justify-content-between mb-2">
                                                      <div><strong class="mr-1">Observaciones:</strong><input type="text" name="observaciones" class="item-bigger" readOnly /></div>
                                                </div>
                                          </div>
                              </form>
                              <div class=" border-modal modal-footer text-center">
                                    <button type="button" class="btn btn-funcion btn-rojo" data-dismiss="modal"><span class="material-icons pr-2">close</span><span>Cancelar</span></button>
                                    <button class="btn btn-funcion btn-azul" id="btnGenerarServicio"><span class="material-icons pr-2">save</span><span>Guardar</span></button>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      </div>

      <!-- Modal editar servicio-->
      <div class="modal fade modal-servicio" id="editarServicioModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog m-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header m-title justify-content-between">
                              <h5 class="modal-title ml-2"><span class="material-icons far fa-file-alt i-new"></span></a><span class="ml-2">Folio servicio:</span><span class="ml-2" id="folioServicio"></span></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="border-modal modal-body">
                              <form id="formEditarServicio" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id" />
                                    <input type="hidden" id="idEntrada" name="idEntrada" />
                                    <input type="hidden" id="estatus" name="estatus" />
                                    <div class="container div-form">
                                          <div class="row justify-content-between mb-2">
                                                <div class="d-flex">
                                                      <div class="mr-1"><strong>Servicio:</strong></div>
                                                      <div> <select name="idTipoServicio" class="item-medium" id="idTipoServicio" disabled>
                                                                  <option value="">--Selecciona--</option>
                                                                  <?php
if (!empty($servicios)):
        foreach ($servicios as $s):
                ?>
                                                                  <option value="<?= $s->id ?>"><?= $s->nombre ?> </option>
                                                                  <?php
        endforeach;
endif;
?>
                                                            </select></div>
                                                </div>
                                                <div class="d-flex">
                                                      <div class="mr-1"><strong>Empaque:</strong></div>
                                                      <div><select name="idEmpaque" class="item-medium" id="idEmpaque">
                                                                  <option value="" selected>--N/A--</option>
                                                                  <?php
if (!empty($tiposEmpaques)):
        foreach ($tiposEmpaques as $tp):
                ?>
                                                                  <option value="<?= $tp->id ?>"><?= $tp->nombre ?> </option>
                                                                  <?php
        endforeach;
endif;
?>
                                                            </select></div>
                                                </div>
                                                <div><strong class="mr-1">Cantidad:</strong><input type="text" name="cantidad" id="cantidad" class="item-s-small" /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="row d-flex justify-content-between mb-2">
                                                <div><strong class="mr-1">Orden:</strong><input type="text" name="orden" id="orden" class="item-small" />
                                                      <label id="addDocumento" title="Agregar documento orden" for="documentoOrden" class="inputFile mb-1"><i class="fas fa-cloud-upload-alt"></i></label>
                                                      <input id="documentoOrden" name="documentoOrden" type="file" hidden /><input type="hidden" id="archivoOrden" name="archivoOrden">
                                                      <i id="show" class="i-pdf material-icons fa-solid fa-file-pdf" title="Ver documento" hidden></i>
                                                      <i id="delete" class="far i-delete material-icons fa-trash-alt" hidden></i>
                                                </div>

                                                <div>
                                                      <strong class="mr-1">Lote:</strong><input type="text" name="lote" id="lote" class="item-small" />
                                                      <select name="lote" id="lote" class="item-small">
                                                            <option>--Selecciona--</option>
                                                      </select>
                                                </div>
                                                <div><strong class="mr-1">Producto:</strong>
                                                      <select name="producto" class="item-small" id="producto">
                                                            <option value="" selected>--Selecciona--</option>
                                                            <?php
if (!empty($productos)):
        foreach ($productos as $p):
                ?>
                                                            <option value="<?= $p->id ?>"><?= $p->nombre ?> </option>
                                                            <?php
        endforeach;
endif;
?>
                                                      </select>
                                                </div>
                                                <div><strong class="mr-1">Rótulo:</strong><input type="text" name="alias" " id=" alias" class="item-small" /></div>
                                          </div>
                                          <div class="row d-flex justify-content-between mb-2">
                                                <div><strong class="mr-1">Fecha programación:</strong><input type="text" name="fechaPrograma" id="fechaPrograma" class="item-small" readonly=""></div>
                                                <div><strong class="mr-1">Fecha inicio:</strong><input class="item-middle fixed" id="fechaInicio" disabled /></div>
                                                <div><strong class="mr-1">Fecha fin:</strong><input class="item-middle fixed" id="fechaFin" disabled /></div>
                                          </div>
                                          <div class="row d-flex justify-content-between mb-2">
                                                <div><strong class="mr-1">Total ensacado:</strong><input class="item-s-small" id="totalEnsacado" name="totalEnsacado" /><span class="ml-1">kgs.</span></div>
                                                <div><strong class="mr-1">Tarimas:</strong><input class="item-s-small fixed" id="tarimas" name="tarimas" disabled /></span></div>
                                                <div><strong class="mr-1">Tipa Tarima:</strong>
                                                      <select name="tipoTarima" class="item-small" id="tipoTarima">
                                                            <option value="">-Selecciona-</option>
                                                            <?php
foreach (tipo_tarimas as $i => $m):
        ?>
                                                            <option value="<?= $i ?>" <?= $serv['tipo_tarima'] == $i ? 'selected' : '' ?>><?= $m ?></option>
                                                            <?php
endforeach;
?>
                                                      </select>
                                                </div>
                                                <div><strong class="mr-1">Parcial:</strong><input class="item-s-small fixed" id="parcial" name="parcial" disabled /></span></div>
                                          </div>
                                          <div class="row d-flex justify-content-between mb-2">
                                                <div><strong class="mr-1">Bultos:</strong><input class="item-s-small fixed" id="bultos" name="bultos" disabled /></div>
                                                <div><strong class="mr-1">Barredura sucia:</strong><input class="item-s-small" id="barreduraSucia" name="barreduraSucia" /><span class="ml-1">kgs.</span></div>
                                                <div><strong class="mr-1">Barredura limpia:</strong><input class="item-s-small" id="barreduraLimpia" name="barreduraLimpia" /><span class="ml-1">kgs.</span></div>
                                                <div><strong class="mr-1">Total barredura:</strong><input class="item-s-small fixed" id="barredura" name="barredura" disabled /><span class="ml-1">kgs.</span></div>
                                          </div>
                                          <div class="row d-flex justify-content-between mb-2">
                                                <div><strong class="mr-1">Observaciones:</strong><input type="text" name="observaciones" id="observaciones" class="item-bigger" /></div>
                                          </div>
                                    </div>
                              </form>
                              <div class=" border-modal modal-footer text-center">
                                    <button type="button" class="btn btn-funcion btn-rojo" data-dismiss="modal"><span class="material-icons pr-2">close</span><span>Cancelar</span></button>
                                    <button class="btn btn-funcion btn-azul" id="btnEditarServicio"><span class="material-icons pr-2">save</span><span>Guardar</span></button>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Modal enviar a almacen -->
      <div class="modal fade" id="enviarAlmacenModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Enviar a almacen y finalizar servicio:</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                              </button>
                        </div>
                        <div class="modal-body">
                              <form class="pr-2 pl-2" id="formEnviarAlmacen">
                                    <div><input type="hidden" id="idServicioEnviar" name="idServicioEnviar" />
                                          <input type="hidden" id="operacionEnviar" name="operacionEnviar" />
                                    </div>
                                    <div class="d-flex justify-content-between pb-1" id="divAlmacenes">
                                          <div class="d-flex">
                                                <label class="pt-1 pr-1">Almacen:</label> <select class="item-small" name="almacen[]" id="selectAlmacen" required>
                                                      <option value="">-Selecciona</option>
                                                </select>
                                          </div>
                                          <div class="d-flex">
                                                <label class="pt-1 pr-1">Cantidad:</label> <input type="text" name="cantidadAlmacen[]" class="item-small" id="cantidadEnviar" required />
                                                <span class="pt-1 pl-1">Kg.</span>
                                          </div>
                                    </div>
                              </form>
                        </div>
                        <div class="modal-footer justify-content-between">

                              <div><button id="agregarAlmacen" type="button" class="btn-azul folio p-1">Agregar almacén</button></div>
                              <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" id="enviarFinalizarServicio">Finalizar</button>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</body>

</html>