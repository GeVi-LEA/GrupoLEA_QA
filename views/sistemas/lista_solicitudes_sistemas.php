
<div class="row mt-1 req-estados">
    <div class="col-4 div-estados" id="divEstados">       
        <a class="<?= isset($idEst) ? "" : "estatus-hover"?>" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes"><i title="Ver todas las solitudes de servicio" class="i-list-ol fas fa-list-ol"></i></a>
        <?php if(Utils::isSistemas()):?>
        <a class="estatus-gen <?= $idEst == 1 ? "estatus-hover" : "" ?>" title="Solicitudes de servicio generadas" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes&idEst=1">Generadas</a>
        <a class="estatus-proceso <?= $idEst == 3 ? "estatus-hover" : "" ?>" title="Solicitudes de servicio proceso" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes&idEst=3">En proceso</a>
        <a class="estatus-fin <?= $idEst == 5 ? "estatus-hover" : "" ?>"  title="Solicitudes finalizadas" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes&idEst=5">Finalizadas</a>  
        <a class="estatus-cancel <?= $idEst == 2 ? "estatus-hover" : "" ?>" title="Solicitudes de servicio canceladas" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes&idEst=2">Canceladas</a>
        <?php endif;?>
    </div>
    <div class="col-5"><h5>Solicitudes de servicio</h5></div>
    <div class="col-3 menu-iconos d-flex justify-content-end">
            <?php if( Utils::isAdmin() || Utils::isSistemas()):?>
        <div class="mr-3"><i id="indicadorSolicitudes" title="Indicador de calidad" class="i-excel material-icons fas fa-chart-bar"></i></div>
              <?php endif ;?>
        <div class="mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar folio..."><i id="buscarSolicitud" class="fas fa-search i-search material-icons"></i></div>
        <div class="mr-4"><a href="<?= principalUrl ?>?controller=Sistemas&action=solicitudServicio"><span title="Nueva solicitud de servicio" class="material-icons far fa-file-alt i-new"></span></a>
       </div>
    </div>
</div>

<section class="sec-tabla text-center">
    <?php if (!empty($solicitudes)): ?>
        <table class="table table-condensed tabla-registros" id="tablaRegistros">
            <thead>
            <th>Folio</th>
            <th>Solicitante</th>
            <th>Departamento</th>
            <th>Fecha solicitud</th>
            <th>Prioridad</th>
            <th>Descripción</th>
            <th>Estatus</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($solicitudes as $s): ?>
                    <?php if($s['usuario_id'] == $_SESSION['usuario']->id || Utils::isSistemas()):?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $s['id']; ?></td>
                        <td id="usuarioTabla" hidden><?= $s['usuario']; ?></td>
                        <td hidden></td>
                        <td><strong id="folioTabla"><?= $s['folio']; ?></strong></td>
                        <td id="usuarioTabla"><?= substr($s['usuario'], 0,58); ?></td>
                        <td><?= $s['departamento']; ?></td>
                        <td><?= date('d/m/Y', strtotime($s['fecha_solicitud'])); ?></td>
                        <td><?= prioriodades[$s['prioridad']]; ?></td>
                        <td><?= substr($s['descripcion'], 0,50); ?></td>
                        <td> <div id="tdEstatus" class="<?=Utils::getClaseEstado($s['clave']);?> estatus-tabla" title="<?=$s['descEstatus']?>"><span id="estatus"><?=$s['estatus'];?></span></div></td>
                        <td> 
                            <div class="text-right">
                                 <i id="showSolicitud" class="i-pdf material-icons far fa-file-pdf" title="Ver solicitud"></i>
                                 <?php if((!($s['estatus_id'] == 4 || $s['estatus_id'] == 5)) || Utils::isSistemas()):?>
                                 <a href="<?=principalUrl?>?controller=Sistemas&action=solicitudServicio&id=<?= $s['id']; ?>"><span id="" class="material-icons i-edit" title="Editar">edit</span></a>
                                 <?php endif ;?>
                                 <?php if(!($s['estatus_id'] == 2 || $s['estatus_id'] == 5)):?>
                                 <span id="deleteSolicitud" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                                 <?php endif ;?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay solicitudes de servicio</span>                   
    <?php endif; ?>
</section>

<!-- Modal busqueda solicitudes-->
<div class="modal fade modal-busqueda" id="buscarSolicitudes" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar solicitudes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formBuscarSolicitud" method="POST" action="<?=principalUrl?>?controller=Sistemas&action=buscarSolicitudesServicio">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label for="folioSolicitudBuscar">Folio:</label></div> 
                            <div><input type="text" id="folioSolicitud" name="folio" class="item-small" placeholder="Buscar folio..."></span></div> 
                        </div>
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                             <div class="pr-3"><input type='text' name="fechaInicio"  class="item-small" id="fechaInicio"  readOnly  placeholder="Fecha inicio..."/></div>
                             <div class="pr-2"> <label>Y</label></div>
                             <div><input type='text' name="fechaFin"  class="item-small" id="fechaFin"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"><label>Usuario:</label></div>                                             
                            <div>                            
                                <select name="usuario" class="item-big"" id="usuarioSolicitud"> 
                                    <option value="" selected>--Selecciona--</option>
                                    <?php
                                    $usuarios = Utils::getUsuarios();
                                    if (!empty($usuarios)):
                                        foreach ($usuarios as $u):
                                            ?>
                                            <option value="<?= $u->id ?>"><?= $u->nombreCompleto ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                 </form>
            </div>
                        <div class=" border-modal modal-footer text-center">
                          <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                          <button class="btn enviarBtn" id="btnBuscarSolicitud"><span class="material-icons fas fa-search pr-2"></span>Buscar</button>
                     </div>
           </div>  
             </div>
        </div>

<div class="modal fade modal-busqueda" id="indicadorSolicitudesModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="material-icons fas fa-search pr-2"></span>Buscar solicitudes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="border-modal modal-body">
                <form id="formIndicadorSolicitud" method="POST" action="<?=principalUrl?>?controller=Sistemas&action=indicadoresCalidadSolicitudes">
                    <div class="container">
                        <div class="row d-flex mb-2">
                            <div class="w-25 text-right pr-1"> <label>Fecha entre</label></div>
                             <div class="pr-3"><input type='text' name="fechaInicioExp"  class="item-small" id="fechaInicioExp"  readOnly  placeholder="Fecha inicio..."/></div>
                             <div class="pr-2"> <label>Y</label></div>
                             <div><input type='text' name="fechaFinExp"  class="item-small" id="fechaFinExp"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                    </div>
                    <input type="hidden" id="pdf" name="pdf"/>
                 </form>
            </div>
                     <div class=" border-modal modal-footer text-center">
                          <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                          <button class="btn exportarBtn" id="btnExcelSolicitud"><span class="material-icons fas fa-file-excel pr-2"></span>Excel</button>
                          <button class="btn exportarPdfBtn" id="btnPdfSolicitud"><span class="material-icons far fa-file-pdf pr-2"></span>PDF</button>
                     </div>
           </div>  
             </div>
        </div>
           
 <script src="../sistemas/assets/js/sistemas.js"></script> 