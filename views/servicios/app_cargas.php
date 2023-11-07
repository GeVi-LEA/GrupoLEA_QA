<?php
require_once views_root . 'servicios/assets/css/app_cargas.css.php';
require_once views_root . 'servicios/assets/js/app_cargas.js.php';

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
                              <div class="d-flex justify-content-between pb-1" id="divAlmacenes">
                                    <div class="d-flex">
                                          <label class="pt-1 pr-1">Almacen:</label>
                                          <select class="item-small" name="almacen[]" id="selectAlmacen" required>
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