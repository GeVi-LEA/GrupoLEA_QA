<?php
require_once views_root . 'servicios/assets/css/app_ensacado.css.php';
require_once views_root . 'servicios/assets/js/app_ensacado.js.php';

?>
<link rel="stylesheet" href="../../assets/libs/datatables/datatables.min.css">
<script src="../../assets/libs/datatables/datatables.min.js"></script>
<!-- <script src="assets/js/servicios.js"></script> -->
<div class='contenido'>


      <div class='row'>
            <div class='col-12'>
                  <a href='<?= principalUrl ?>?controller=Home&action=index'><button type='button' class='btn btn-info btnRegresar'>Regresar</button></a>
            </div>
      </div>
      <div class='row'>
            <div class='row'>
                  <div class='col-12'>
                        <div class='row  panelunidades'>

                        </div>
                  </div>
            </div>
      </div>
</div>

<!-- Modal enviar a almacen -->
<div class="modal fade" id="enviarAlmacenModal1" tabindex="-1" aria-hidden="true">
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
                              <div class=" " id="divAlmacenes">
                                    <div class='row'>
                                          <div class='col-md-6 col-12'>
                                                <label for="selectAlmacen" class="pt-1 pr-1"><strong>Almacen:</strong></label>
                                                <select class="item-medium form-control mt-4" name="almacen[]" id="selectAlmacen" required>
                                                      <option value="">-Selecciona</option>
                                                </select>
                                          </div>
                                          <div class='col-md-6 col-12'>
                                                <label for="cantidadTotal" class="pt-1 pr-1"><strong>Cantidad Cliente:</strong></label>
                                                <div class="input-group mt-4">
                                                      <input type="text" name="cantidadTotal[]" class="item-small form-control numhtml" id="cantidadCliente" readonly required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Kg.</div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class='row'>
                                          <div class='col-md-4 col-12'>
                                                <label for="cantidadEnviar" class="pt-1 pr-1"><strong>Cantidad Total:</strong></label>
                                                <div class="input-group mt-4">
                                                      <input type="text" name="cantidadAlmacen[]" class="item-small form-control numhtml" id="cantidadEnviar" readonly required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Kg.</div>
                                                      </div>

                                                </div>
                                          </div>
                                          <div class='col-md-4 col-12'>
                                                <label for="cantidadTarimas" class="pt-1 pr-1"><strong>Cantidad</strong></label>
                                                <div class="input-group mt-4">
                                                      <input type="text" name="cantidadTarimas[]" class="item-small form-control numhtml" id="cantidadTarimas" required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Tarimas</div>
                                                      </div>

                                                </div>
                                          </div>
                                          <div class='col-md-4 col-12'>
                                                <label for="cantidadSacos" class="pt-1 pr-1"><strong>ensacado:</strong></label>
                                                <div class="input-group mt-4">
                                                      <input type="text" name="cantidadSacos[]" class="item-small form-control numhtml" id="cantidadSacos" required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Sacos</div>
                                                      </div>

                                                </div>
                                          </div>
                                    </div>
                                    <div class='row'>
                                          <div class='col-md-6 col-12'>
                                                <label for="BarreduraSucia" class="pt-1 pr-1"><strong>Barredura sucia:</strong></label>
                                                <div class="input-group">
                                                      <input type="text" name="BarreduraSucia[]" class="item-small form-control numhtml" id="BarreduraSucia" required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Kg.</div>
                                                      </div>

                                                </div>
                                          </div>
                                          <div class='col-md-6 col-12'>
                                                <label for="BarreduraLimpia" class="pt-1 pr-1"><strong>Barredura limpia:</strong></label>
                                                <div class="input-group">
                                                      <input type="text" name="BarreduraLimpia[]" class="item-small form-control numhtml" id="BarreduraLimpia" required />
                                                      <div class="input-group-prepend">
                                                            <div class="input-group-text">Kg.</div>
                                                      </div>

                                                </div>
                                          </div>
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