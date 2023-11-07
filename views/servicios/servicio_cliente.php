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
        <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> 
        <script src="<?= root_url ?>views/servicios/assets/js/servicios.js"></script>
        <title>Servicios clientes</title>
    </head>
    <body>
        <div class="contenedor" id="contenedor">
            <header class='d-flex justify-content-between'>
                <div>
                    <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" />
                </div>
                <div class="text-center mt-4">
                    <h4>Precios servicios - clientes</h4>
                </div>
                <div class="d-flex">
                    <div class="pt-4"><button class="p-0 m-0" id="new" title="Nuevo servicio-cliente"><span class="material-icons i-add btn-icon">add_circle</span></button></div>
                    <div class="pt-4" ><button class="p-0 m-0" id="save" title="Guardar"><span class="material-icons i-save btn-icon">save</span></button></div>
                    <div class="pt-4" ><button class="p-0 m-0" id="cancel" title="Cancelar"><span class="material-icons i-cancel btn-icon">cancel</span></button></div>
                    <div class="pt-4 mr-2"><button class="boton" id="btnSalir" title="Salir"><span class="material-icons i-danger btn-icon" title="Cerrar">disabled_by_default</span></button></div>
                </div>
            </header> 
            <form id="formServicioCliente" enctype="multipart/form-data">
              <input id="id" name="id" type="hidden"/>
            <div class="div-datos p-2" id="divDatos">
             <div class="datos mb-2">
                <div><strong>Cliente:</strong>
                    <select name="cliente" class="item-big" id="cliente">
                        <option value="" selected>--Selecciona--</option>
                        <?php
                        if (!empty($clientes)):
                            foreach ($clientes as $c):
                                ?>
                                <option value="<?= $c->id ?>" ><?= $c->nombre ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select> 
               </div>
          <div class="ml-3"><strong>Servicio:</strong>
                    <select name="servicio" class="item-medium" id="servicio">
                        <option value="" selected>--Selecciona--</option>
                        <?php
                        if (!empty($servicios)):
                            foreach ($servicios as $s):
                                ?>
                                <option value="<?= $s->id ?>" ><?= $s->nombre ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select> 
               </div>
                 <div class="ml-3"><strong>Empaque:</strong>
                  <select name="empaque" class="item-medium" id="empaque">
                          <option value="" selected>--Selecciona--</option>
                    <?php
                    if (!empty($tiposEmpaques)):
                        foreach ($tiposEmpaques as $emp):
                            ?>
                            <option value="<?= $emp->id ?>"> <?= $emp->nombre; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    </select>
               </div>
            </div>
            <div class="datos mb-2">
             <div><strong>Clave:</strong>
                 <input id="clave" class="item-small fixed" type="text" disabled/>
               </div>
                 <div class="ml-3"><strong>Unidad:</strong>
                  <select name="unidad" class="item-small" id="unidad">
                   <option value="" selected>--Selecciona--</option>
                    <?php
                    if (!empty($unidades)):
                        foreach ($unidades as $uni):
                            ?>
                            <option value="<?= $uni->id ?>"> <?= $uni->nombre; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    </select>
               </div>
             <div><strong>Precio:</strong>
              <input id="costo" name="costo" class="item-small" type="text"/>
               </div>
                     <div class="ml-3"><strong>Moneda:</strong>
                    <select name="moneda" class="item-s-small" id="moneda">
                             <option value="">--</option>
                              <?php
                              foreach (monedas as $i => $m):
                                  ?>
                                  <option value="<?= $i ?>" <?= isset($req) && $req['moneda'] == $i ? 'selected' : "" ?>><?= $m['clave'] ?></option>
                                  <?php
                              endforeach;
                              ?>
                          </select>
                      </div>
             <div><strong>Días:</strong>
                  <input id="dias" name="dias" class="item-s-small" type="text"/>
             </div>
            </div>
           <div class="datos-recepcion datos">
                <div><strong>Descripción:</strong>
                     <input id="descripcion" class="item-bigger fixed" type="text" disabled />
               </div>
            </div>
            </div>
         </form>
          <section class="sec-tabla text-center table-responsive-sm mt-3">
<?php if (!empty($serviciosClientes)): ?>
        <table class="tabla-servicios" id="tablaServicioCliente">
            <thead>
    <?php for ($i = 0; $i < count($titulos); $i++): ?>
            <th><?= (strtok($titulos[$i], " ")); ?></th>
       <?php endfor; ?>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($valores); $i++): ?>
                        <tr class="tr">
                            <?php for ($j = 0; $j < count($valores[$i]); $j++): ?>
                                <?php if ($j < 4): ?>
                                    <td><?= $valores[$i][$j]; ?></td>
                                <?php else: ?>
                                    <?php $costos = $valores[$i][$j] != null ? UtilsHelp::stringtoArray($valores[$i][$j], "-") : ""; ?>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                        <div ><span id="idTabla" hidden><?= !empty($costos) ? $costos[0] : "" ?></span>
                                        <span class="pl-1"><?= !empty($costos) ? UtilsHelp::numero2Decimales($costos[1], true, 2) : "" ?></span> 
                                        <span><?= !empty($costos) ? monedas[$costos[2]]['clave'] : "" ?></span>
                                        </div>
                                      <?php if ($costos != null ): ?>    
                                         <div class="d-flex justify-self-end">
                                             <span id="edit" class="material-icons i-edit icon-small" title="Editar">edit</span>                    
                                             <span id="delete" class=" material-icons i-delete icon-small" title="Eliminar">delete_forever</span>
                                         </div>
                                              <?php endif; ?>
                                        </div>
                                    </td>  
                                <?php endif; ?>
                            <?php endfor; ?>             
                        <?php endfor; ?>
                </tbody>
            </table>
        <?php else: ?>
        <span>No hay servicios registrados</span>                   
<?php endif; ?>
</section>        
          </div>
    </body>
</html>