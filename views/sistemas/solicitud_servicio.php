
<header class="titulo d-flex justify-content-between align-items-center">
    <div><a href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes"><i class="material-icons i-list ml-3">list</i></a></div>
    <h1>SOLICTUD DE SERVICIO SISTEMAS</h1>
    <?php if(isset($solicitud)):?>
    <span class="mr-5">Folio:  <?=$solicitud['folio']?> </span>
    <?php else: ?>
    <div></div>
    <?php endif; ?> 
</header>
<form id="formSolicitudServicio">
    <section class="sec-datos" id="seccionDatos">
        <fieldset class="field-datos">
            <legend class="legend-datos">Datos de solicitud:</legend>
              <input type='hidden' name="id" id="id" value="<?=isset($solicitud) ? $solicitud['id'] : ''?>"/>
              <div class="div-datos-solicitud datos">
                  <div class="mb-1 d-flex justify-content-between">
                      <div class="d-flex justify-content-between">
                          <div>
                              <label for="empresa">Empresa:</label>
                              <select name="empresa" class="item-small" id="empresa" <?= isset($solicitud)? 'disabled' : ''; ?>>
                                  <option value="">Selecciona</option>
                                  <?php
                                  foreach (empresas as $i => $e):
                                      ?>
                                      <option value="<?= $i ?>" <?= isset($solicitud) && $i == $solicitud['empresa'] ? 'selected' : ''; ?>><?= $e['clave'] ?></option>
                                      <?php
                                  endforeach;
                                  ?>
                              </select>
                          </div>
                      </div>
                      <div>
                          <input type='hidden' name="idUsuario" id="usuarioSolicitudId" value="<?= isset($solicitud) ? $solicitud['usuario_id'] : $_SESSION['usuario']->id ?>"/>
                          <label for="usuario">Solicitante:</label>
                          <input type='text' name="usuario" id="usuario" value="<?= isset($solicitud) ? $solicitud['usuario'] : $_SESSION['usuario']->nombres . " " . $_SESSION['usuario']->apellidos ?>" class="item-big" disabled readOnly />
                      </div>
                      <div>
                          <label for="departamento">Departamento:</label>
                          <input type='text' name="departamento" id="departamento" value="<?= isset($solicitud) ? $solicitud['departamento'] : $user->departamento ?>" class="item-medium" disabled readOnly />
                      </div>
                  </div>      
                  <div class="mb-1 d-flex justify-content-between">
                      <div class="d-flex justify-content-between">
                             <div>
                              <label for="tipoRequerimiento">Tipo de requerimiento:</label>
                              <select name="tipoRequerimiento" class="item-medium" id="tipoRequerimiento">
                                  <option value="">Selecciona</option>
                                  <?php
                                  foreach (requerimientos as $i => $e):
                                      ?>
                                      <option value="<?= $i ?>" <?= isset($solicitud) && $i == $solicitud['tipo_requerimiento'] ? 'selected' : ''; ?>><?= $e ?></option>
                                      <?php
                                  endforeach;
                                  ?>
                              </select>
                          </div>
                      </div>
                       <div class="d-flex justify-content-between">
                             <div>
                              <label for="tipoSolicitud">Tipo de solicitud:</label>
                              <select name="tipoSolicitud" class="item-medium" id="tipoSolicitud">
                                  <option value="">Selecciona</option>
                                  <?php
                                  foreach (tipoSolicitud as $i => $e):
                                      ?>
                                      <option value="<?= $i ?>" <?= isset($solicitud) && $i == $solicitud['tipo_solicitud'] ? 'selected' : ''; ?>><?=$e?></option>
                                      <?php
                                  endforeach;
                                  ?>
                              </select>
                          </div>
                      </div>
                     <div class="d-flex justify-content-between">
                             <div>
                              <label for="prioridad">Prioridad:</label>
                              <select name="prioridad" class="item-medium" id="prioridad">
                                  <option value="">Selecciona</option>
                                  <?php
                                  foreach (prioriodades as $i => $e):
                                      ?>
                                      <option value="<?= $i ?>" <?= isset($solicitud) && $i == $solicitud['prioridad'] ? 'selected' : ''; ?>><?= $e ?></option>
                                      <?php
                                  endforeach;
                                  ?>
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="mb-1" id="divEquipo" hidden>
                      <div class="d-flex justify-content-between">
                          <div>
                              <label for="empresa">Tipo Equipo:</label>
                                <select name="tipoEquipo" class="item-small" id="tipoEquipo" disabled>
                                       <option value="0">Selecciona</option>
                                       <?php
                                       foreach (equipos_sistemas as $i => $e):
                                           ?>
                                           <option value="<?= $i ?>"><?=$e?></option>
                                           <?php
                                       endforeach;
                                       ?>
                                   </select>
                          </div>
                      </div>
                      <div>
                          <input type='hidden' name="idEquipo" value="<?= isset($solicitud) ? $solicitud['equipo_id'] : "" ?>" id="idEquipoSolicitud" value=""/>
                          <label for="marca">Marca:</label>
                           <select name="marca" class="item-small" id="marca" disabled>
                                <option value="0">Selecciona</option>
                                <?php
                                foreach (marcas_sistemas as $i => $e):
                                    ?>
                                    <option value="<?= $i ?>"><?=$e?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                      </div>
                      <div>
                          <label for="folio">Folio:</label>
                          <input type='text' name="folio" id="folio"  class="item-small" disabled />
                      </div>
                      <div>
                          <label for="modelo">Modelo:</label>
                          <input type='text' name="modelo" id="modelo"  class="item-medium" disabled />
                      </div>
                       <div>
                          <label for="serie">Serie:</label>
                          <input type='text' name="serie" id="serie"  class="item-medium" disabled />
                          <span id="deleteEquipo" class="material-icons ml-3 i-delete" title="Eliminar equipo de solicitud">delete_forever</span>
                      </div>
              
                  </div>      
                  <div class="mb-1 d-flex justify-content-between">
                      <div class="d-flex justify-content-between">
                             <div>
                              <label for="usuarioSistemasId">Asginar a:</label>
                              <select name="usuarioSistemasId" class="item-big" id="usuarioSistemasId">
                                  <option value="">Selecciona</option>
                                  <?php
                                  foreach ($usuariosSistemas as $user):
                                      ?>
                                      <option value="<?= $user->id ?>" <?= isset($solicitud) && $user->id == $solicitud['usuario_sistemas_id'] ? 'selected' : ''; ?>><?= $user->nombres. " " . $user->apellidos  ?></option>
                                      <?php
                                  endforeach;
                                  ?>
                              </select>
                          </div>
                      </div>
                       <div class="d-flex justify-content-between">
                     <div>
                       <label >Fecha solicitud:</label>
                       <input type='text' name="fechaSolicitud" value="<?= isset($solicitud) ? UtilsHelp::fechaCompleta($solicitud['fecha_solicitud']) : date('d/m/Y', strtotime(UtilsHelp::today()))?>" class="item-big" disabled readOnly />
                     </div>
                      </div>
                    <div class="d-flex justify-content-between">
                     <div class="d-flex justify-content-between">
                      <?php if(isset($solicitud)):?>
                       <label>Estatus</label>
                       <div id="tdEstatus" class="<?=Utils::getClaseEstado($solicitud['clave']);?> estatus-tabla ml-1" title="<?=$solicitud['descEstatus']?>"><span id="estatus" class="pl-1 pr-1"><?=$solicitud['estatus'];?></span></div>
                        <?php endif;?>
                     </div>
                      </div>
                  </div>
                  <?php if(isset($solicitud) && $solicitud['estatus_id'] != 1):?>
                   <div class="mb-1 d-flex justify-content-between">
                       <div class="d-flex">
                     <div>
                       <label >Fecha atención:</label>
                       <input type='text' name="fechaAtencion" value="<?= isset($solicitud) && $solicitud['fecha_atencion'] != ""? UtilsHelp::fechaCompleta($solicitud['fecha_atencion']) : ""?>" class="item-big" disabled readOnly />
                     </div>
                      </div>
                     <div class="d-flex justify-content-between">
                     <div>
                       <label >Fecha fin:</label>
                       <input type='text' name="fechaFin" value="<?= isset($solicitud) && $solicitud['fecha_solucion'] != "" ? UtilsHelp::fechaCompleta($solicitud['fecha_solucion']) : ""?>" class="item-big" disabled readOnly />
                     </div>
                     </div>
                   <?php endif;?>
                  </div>
        </fieldset>
        <fieldset class="field-datos">
            <legend class="legend-datos">Descripción general del servicio:</legend>
        <div class="row mt-2">
            <div class="col-2 align-self-center"> <label class="ml-4">Descripción de la falla o solicitud:</label></div>
            <div class="col-6"> <textarea name="descripcion" id="descripcion" class="textarea-solicitud"><?=isset($solicitud) ? $solicitud['descripcion'] : ""?></textarea></div>
        </div>
        <?php if(isset($solicitud) && $solicitud['estatus_id'] != 1):?>
        <div class="row mt-2">
            <div class="col-2 align-self-center"> <label class="ml-4">Solución:</label></div>
            <div class="col-6"> <textarea name="solucion" id="solucion" class="textarea-solicitud"><?=isset($solicitud) ? $solicitud['solucion'] : ""?></textarea></div>
        </div>
           <div class="row mt-2">
            <div class="col-2 align-self-center"> <label class="ml-4">Observaciones/comentarios:</label></div>
            <div class="col-6"> <textarea name="observaciones" class="textarea-solicitud"><?=isset($solicitud) ? $solicitud['observaciones'] : ""?></textarea></div>
        </div>
        <?php endif;?>
        </fieldset>
    </section>
        <section class="d-flex m-3 justify-content-center">
        <?php if(!isset($solicitud)):?>
          <div><input class="btn-generar-solicitud btn-azul" id="btnGenerarSolicitud" type="submit" value="Generar solicitud" />        
        </div>
         <?php else: ?>
            <div>
            <?php if(Utils::isSistemas() && $solicitud['usuario_id'] == $_SESSION['usuario']->id):?>
             <button class="btn-generar-solicitud btn-azul mr-2" id="btnGenerarSolicitud"><span class="material-icons mr-2" title="Editar">edit</span><span>Editar</span></button>
           <?php endif;?>
             <?php if(Utils::isSistemas() && $solicitud['estatus_id'] == 1):?>
             <button class="btn-generar-solicitud btn-verde mr-2" id="btnIniciarSolicitud"><i class="fas fa-play mr-2"></i><span>Iniciar</span> </button>   
             <button class="btn-generar-solicitud btn-rojo mr-2" id="btnCancelarSolicitud"><i class="far fa-trash-alt mr-2"></i><span>Cancelar</span> </button> 
              <?php elseif(Utils::isSistemas() && $solicitud['estatus_id'] == 2):?>
             <button class="btn-generar-solicitud btn-verde mr-2" id="btnIniciarSolicitud"><i class="fas fa-play mr-2"></i><span>Iniciar</span> </button>      
              <?php elseif (Utils::isSistemas() && $solicitud['estatus_id'] == 3):?>
              <button class="btn-generar-solicitud btn-rojo mr-2" id="btnCancelarSolicitud"><i class="far fa-trash-alt mr-2"></i><span>Cancelar</span> </button>    
                <button class="btn-generar-solicitud btn-naranja mr-2" id="btnFinalizarSolicitud"><span class="material-icons mr-2">check_circle_outline</span></i><span>Finalizar</span></button>  
              <?php endif;?>
               <button class="btn-generar-solicitud btn-gris mr-2" id="btnImprimirSolicitud"><span class="material-icons mr-2">print</span></i><span>Imprimir</span></button>
        </div>
         <?php endif;?>
    </section>
</form>

<!-- Modal agregar producto-->
<div class="modal fade modal-busqueda" id="equipoModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header title-ruta">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-laptop pr-3"></span>Agregar equipo</h5>
                <button type="button" class="close close-ruta" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formEquipo">
                    <div class="container">
                     <div class="row d-flex mb-2">
                            <div class="text-right pr-1"><label></label>Seleccione el equipo:</div>                                             
                        </div>
                           <div class="row d-flex mb-2">
                            <div class="col-4 text-right pr-1"><label for="equipoSelect">Tipo equipo:</label></div>                                             
                            <div class="col-8 text-left pr-1">                            
                                <select name="tipoSelect" class="item-medium"" id="tipoSelect"> 
                                    <option value="">Selecciona</option>
                                    <?php
                                    foreach (equipos_sistemas as $i => $e):
                                        ?>
                                        <option value="<?= $i ?>"><?=$e?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                   </select> 
                            </div>
                        </div>
                            <div class="row d-flex mb-2">
                            <div class="col-4 text-right pr-1"><label for="equipoSelect">Equipo:</label></div>                                             
                            <div class="col-8 text-left pr-1">                               
                                <select name="equipoSelect" class="item-medium"" id="equipoSelect" disabled> 
                                    <option value="">Selecciona</option>
                                   </select> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer text-center">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn enviarBtn" id="btnEquipo">Aceptar</button>
            </div>
        </div>  
    </div>
</div>
        <script src="../sistemas/assets/js/sistemas.js"></script> 