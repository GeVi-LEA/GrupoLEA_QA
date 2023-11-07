
<span id="valor" hidden>EquipoComputo</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-4 "><h1 class="titulo">Equipo sistemas</h1></div>
        <div class="col-4 d-flex justify-content-end">
         <?php if(Utils::isAdmin() || Utils::isSistemas()):?>
            <form class="d-flex" id="formExportarInventario" method="POST" action="<?=principalUrl?>?controller=Catalogo&action=exportarInventarioEquipoComputo">
           <input type="hidden" id="formato" name="formato"/>
            <div class="mt-2 mr-3"><i id="exportarInventarioExcel" title="Exportar excel inventario equipo cómputo" class="i-excel material-icons fas fa-file-excel"></i></div>
            </form>
         <?php endif ;?>
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
<span id="mostrarForm">Agregar equipo</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveEquipoComputo" method="post" enctype="multipart/form-data" class=" w-100 px-4 formulario" id="formularioEquipoComputo" >
        <div class="divCancelar">
            <a id="cancel"> <span class= "material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <div class="row d-flex  justify-content-between p-1">
            <input type="hidden" name="id" class="id" id="id"/>
          <div>
                <label for="tipoEquipo">Tipo equipo:</label>
                <select name="tipoEquipo" class="item-small" id="tipoEquipo">
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
            <div>
                <label for="modelo">Modelo:</label>
                <input type="text" name="modelo" class="inputBig capitalize" id="modelo" maxlength="200" placeholder="Modelo"/> 
            </div>
             <div>
                <label for="marca">Marca:</label>
                <select name="marca" class="item-small" id="marca">
                    <option value="">Selecciona</option>
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
                <label for="serie">Número serie:</label>
                <input type="text" name="serie" class="inputBig capitalize" id="serie" maxlength="200" placeholder="S/N"/> 
            </div>
        </div>     
        <div class="row d-flex justify-content-between p-1"> 
         <div>
                <label for="factura">Factura:</label>
                <input type="text" name="factura" class="inputMedium capitalize" id="factura" maxlength="200" placeholder="Factura compra"/> 
            </div>
            <div>
                <label for="fechaAlta">Fecha compra:</label>
                <input type='text' name="fechaAlta" id="fechaAlta" class="inputSelectMin" readOnly />
            </div>
            <div>
                <label for="procesador">Procesador:</label>
                <input type="text" name="procesador" class="inputSmall" id="procesador" maxlength="10" placeholder="i7 8Gen"/> 
            </div>
            <div>
                <label for="discoDuro">Disco duro:</label>
                <input type="text" name="discoDuro" class="inputSmall" id="discoDuro" maxlength="20" placeholder="500 GB"/> 
            </div>
            <div>
                <label for="ram">Ram:</label>
                <input type="text" name="ram" class="inputSmall" id="ram" maxlength="20" placeholder="16 GB"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="usuario">Asignado a:</label>
                <select name="usuarioId" class="inputBig" id="usuarioId"> 
                    <option value="" selected>--Selecciona--</option>
                    <?php
                    if (!empty($usuarios)):
                        foreach ($usuarios as $u):
                            ?>
                            <option value="<?= $u->id ?>"><?= $u->nombres . " " . $u->apellidos; ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showUsuarios"><span title="Agregar usuario" class="material-icons i-add p-1" id="agregarUsuario">add</span></a>         
            </div>
            <div>
                <label for="departamento">Departamento:</label>
                <input type="text" name="departamentoUser" class="inputMedium" id="departamentoUser" disabled /> 
            </div>
            <div>
                <label for="fechaAlta">Fecha asignación:</label>
                <input type='text' name="fechaAsignacion" id="fechaLiberacion" class="inputSelectMin" readOnly />
            </div>
           <div>
                <label for="fechaBaja">Fecha baja:</label>
                <input type="text" name="fechaBaja" class="inputSelectMin" id="fechaBaja" disabled /> 
            </div>
        </div>
         <div class="row d-flex justify-content-between p-1">
           <div>
                <label for="macEthernet">MAC Ethernet:</label>
                <input type='text' name="macEthernet" id="macEthernet" class="inputMedium" />
            </div>
            <div>
            <label for="macWifi">MAC Wifi:</label>
                <input type='text' name="macWifi" id="macWifi" class="inputMedium" />
            </div>
             <div class="d-flex pt-2">
                <div class="mr-2"><label>Aplicaciones:</label></div>
                <div class="d-flex" id="permisos">
                    <?php
                        foreach (aplicaciones_sistemas as $i => $e):
                            ?>
                    <div><input class="mr-1" type="checkbox" name="aplicaciones[]" value="<?= $i?>"><span class="mr-3"><?= $e ?></span></div>
                            <?php
                        endforeach;
                    ?> 
                </div>
            </div>
            </div>
                 <div class="row p-1">
           <div class="d-flex justify-content-start">
                <label class="mt-3 mr-3" for="observaciones">Observaciones:</label>
                <textarea name="observaciones" class="textarea-observaciones" id="observaciones"></textarea>
            </div>
          <div class="d-flex flex-column text-center ml-5">
              <div><label for="fechaMantenimiento">Fecha mantenimiento:</label></div>
                <div><input type="text" name="fechaMantenimiento" class="inputSelectMin" id="fechaMantenimiento" disabled /> </div>
            </div>
            </div> 
        <div class="row p-1">
            <div class="col-12 text-center">               
                <div>
                    <ul class="error text-left" id="error">
                    </ul>
                </div>            
                <input class="btnAgregar" id="btnAgregar" type="submit" value="Agregar"/>
                <a id="save"><span class="material-icons i-save" title="Actualizar">save</span></a>
            </div>
        </div>
    </form>
</section>
<section class="sec-tabla sec-big text-center table-responsive-sm" id="seccionEquipoComputo">
    <?php if (!empty($equipos)): ?>
        <table class=" table-condensed tabla-big" id="tablaEquipoComputo">
            <thead class="titulos-datos" id="titulos">
            <th></th>
            <th>Folio</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>N/S</th>
            <th>Procesador</th>
            <th>Ram</th>
            <th>Disco duro</th>
            <th>Usuario</th>
            <th>Departamento</th>
            <th>Fecha asignación</th>
            <th>Aplicaciones</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($equipos as $e): ?>             
                    <tr class="tr">
                        <td><span class="material-icons pt-1 i-add" id="show">add_box</span></td>
                        <td class="text-left w-30"><?= $e->folio?></td>
                        <td class="ml-3"><?= $e->modelo?></td>
                        <td ><?= marcas_sistemas[$e->marca]; ?></td>
                        <td ><?= $e->numero_serie; ?></td>
                        <td ><?= $e->procesador; ?></td>
                        <td ><?= $e->memoria_ram; ?></td>
                        <td ><?= $e->disco_duro?> </td>
                        <td><?= $e->usuario; ?></td>
                        <td><?= $e->departamento; ?></td>
                        <td><?= $e->fecha_asignacion== '' ? '' : date('d/m/Y', strtotime($e->fecha_asignacion))?></td>
                        <td><?= Utils::getAplicaionesSistemas($e->aplicaciones); ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteEquipoComputo&id=<?= $e->id ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-top text-left" id="tbDatos">  
                        <td class="w-95">
                            <div class="w-100 d-flex justify-content-between div-info">
                             <div><strong class="mr-1">Folio:</strong><label id="folioTabla"><?= $e->folio; ?></label></div>
                             <div><strong class="mr-1">Tipo equipo:</strong><span hidden id="tipoEquipoTabla"><?=$e->tipo_equipo;?></span><label><?= equipos_sistemas[$e->tipo_equipo]; ?></label></div>
                            <div><strong class="mr-1">Modelo:</strong><label id="modeloTabla"><?= $e->modelo; ?></label></div>
                            <div><strong class="mr-1">Marca:</strong><span hidden id="marcaTabla"><?=$e->marca;?></span><label><?= marcas_sistemas[$e->marca]; ?></label> </div>
                            <div><strong class="mr-1">Serie:</strong><label id="serieTabla"><?= $e->numero_serie; ?></label></div>
                            <div><strong class="mr-1">Procesador:</strong> <label id="procesadorTabla"><?= $e->procesador; ?></label></div>
                            <div><strong class="mr-1">Ram:</strong><label id="ramTabla"><?= $e->memoria_ram; ?></label></div>
                            <div><strong class="mr-1">Disco duro:</strong><label id="discoDuroTabla"><?= $e->disco_duro; ?></label></div>
                            </div>
                           <div class="w-100 d-flex justify-content-between div-info">
                            <div><strong class="mr-1">Asignado:</strong><label><?= $e->usuario; ?></label></div>
                            <div><strong class="mr-1">Departamento:</strong><label  id="departamentoUserTabla"><?= $e->departamento;?></label></div>
                            <div><strong class="mr-1">Factura:</strong><label id="facturaTabla"><?= $e->factura;?></label></div>
                            <div><strong class="mr-1">Fecha compra:</strong><label id="fechaAltaTabla"><?= $e->fecha_compra== '' ? '' : date('d/m/Y', strtotime($e->fecha_compra)); ?></label></div>
                            <div><strong class="mr-1">Fecha asignación:</strong><label id="fechaLibTabla"><?= $e->fecha_asignacion  == '' ? '' : date('d/m/Y', strtotime($e->fecha_asignacion));?></label></div>
                            <div><strong class="mr-1">Fecha baja:</strong><label id="fechaBajaTabla"><?= $e->fecha_baja  == '' ? '' : date('d/m/Y', strtotime($e->fecha_baja));?></label></div>
                            </div>
                           <div class="w-100 d-flex justify-content-between div-info mt-1">
                            <div><strong class="mr-1">Fecha mantenimiento:</strong><label id="fechaMantTabla"><?= $e->fecha_mantenimiento  == '' ? '' : date('d/m/Y', strtotime($e->fecha_mantenimiento));?></label></div>
                            <div><strong class="mr-1">MAC Ethernet:</strong><label id="macEthernetTabla"><?= $e->red_lan; ?></label></div>
                            <div><strong class="mr-1">MAC WIFI</strong><label id="macWifiTabla"><?= $e->red_wifi;?></label></div>
                            <div><strong class="mr-1">Aplicaciones:</strong><label><?= Utils::getAplicaionesSistemas($e->aplicaciones);?></label></div>
                           </div>
                             <div class="w-100 d-flex justify-content-between div-info mt-1">
                            <div><strong class="mr-1">Observaciones:</strong><label id="observacionesTabla"><?= $e->observaciones;?></label></div>
                           </div>
                        </td>
                 
                        <td hidden>
                            <span id="idTabla"><?= $e->id; ?></span>
                            <span id="usuarioIdTabla"><?= $e->usuario_id; ?></span>
                            <span id="permisosTabla"><?= $e->aplicaciones; ?></span>
                        </td>
                        <td> 
                            <div class="py-1 ">
                                <span class="material-icons i-clear" id="clear">clear</span>
                            </div>
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl?>?controller=Catalogo&action=deleteUsuario&id=<?= $e->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay equipos registrados</span>                   
    <?php endif; ?>
</section>