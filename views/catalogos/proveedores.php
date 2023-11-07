
<span id="valor" hidden>Proveedor</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Proveedores</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar proveedor</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveProveedor" method="post" class=" w-100 px-4 formulario" id="formularioProveedor" >
        <div class="divCancelar">
            <a id="cancel"> <span class= "material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <input type="text" name="id" class="id" id="id" hidden />
            <div>
                <label for="nombre">Proveedor:</label>
                <input type="text" name="nombre" class="inputLarge capitalize" id="nombre" maxlength="200" placeholder="Ej. LEA"/> 
            </div>
            <div>
                <label for="tipoServicio">Tipo:</label>
                <select name="tipoServicio" class="inputMedium" id="tipoServicio"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($tipoSolicitudes)):
                        foreach ($tipoSolicitudes as $ts):
                            ?>
                            <option value="<?= $ts->id ?>"><?= $ts->tipo ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposSolicitudes"><span title="Agregar nuevo tipo servicio" class="material-icons i-add p-1">add</span></a>         
            </div>
            <div>
                <label for="clasificacion">Clasificación:</label>
                <select name="clasificacion" class="inputSelectMin" id="clasificacion"> 
                    <option value="" selected disabled>Selecciona</option>
                    <option value="Directo">Directo</option>
                    <option value="Indirecto">Indirecto</option>
                </select>
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="contacto">Contacto:</label>
                <input type="text" name="contacto" class="inputLarge capitalize" id="contacto" maxlength="250" placeholder="Ej. Nombre Apellido"/> 
            </div>
            <div>
                <label for="telefono">Tel:</label>
                <input type="text" name="telefono" class="inputSelectMin" id="telefono" maxlength="15" placeholder="Ej.5566778899"/> 
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="text" name="correo" class="inputLarge" id="correo" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
        </div>
         <div class="row d-flex justify-content-between p-1">
            <div>
                <i class="far fa-envelope"></i>
                <input type="text" name="correo1" class="inputMail" id="correo1" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
            <div>
               <i class="far fa-envelope"></i>
                <input type="text" name="correo2" class="inputMail" id="correo2" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
            <div>
          <i class="far fa-envelope"></i>
                <input type="text" name="correo3" class="inputMail" id="correo3" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="celular">Cel:</label>
                <input type="text" name="celular" class="inputSelectMin" id="celular" maxlength="15" placeholder="Ej.5566778899"/> 
            </div>
            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" class="inputLarge " id="direccion" maxlength="250" placeholder="Escribe la dirección del proveedor"/> 
            </div>
            <div>
                <label for="ciudad">Ciudad:</label>     
                <select name="ciudad" class="inputBig" id="ciudad"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($ciudades)):
                        foreach ($ciudades as $c):
                            ?>
                            <option value="<?= $c->id ?>"><?= $c->ciudad_completa ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showCiudades"><span title="Agregar ciudad" class="material-icons i-add p-1">add</span></a>
            </div>
            <div>
                <label for="codigoPostal">C.P.</label>
                <input type="text" name="codigoPostal" class="inputSmall" id="codigoPostal" maxlength="5" placeholder="Ej.55665"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="rfc">RFC:</label>
                <input type="text" name="rfc" class="inputMedium text-uppercase" id="rfc" maxlength="25" placeholder="Ingresa RFC"/> 
            </div>
            <div>
                <label for="certificado">Certificado:</label>
                <select name="certificado" class="inputSmall" id="certificado"> 
                    <option value="" selected disabled>-</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
            </div>
            <div>
                <label for="fechaAlta">Fecha alta:</label>
                <input type='text' name="fechaAlta" id="fechaAlta" class="inputSelectMin" readOnly />
            </div>

            <div>
                <label for="fechaEvaluacion">Fecha evaluación:</label>
                <input type='text' name="fechaEvaluacion" id="fechaEvaluacion" class="inputSelectMin" readOnly />
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="cuenta">Cuenta:</label>
                <input type="text" name="cuenta" class="inputMedium" id="cuenta" maxlength="20" placeholder="Cuenta interna"/> 
            </div>
            <div>
                <label for="calificacion">Calificación:</label>
                <input type="text" name="calificacion" class="inputSmall" id="calificacion" maxlength="3" placeholder="100"/> 
            </div>
            <div>
                <label for="activo">Activo:</label>
                <select name="activo" class="inputSmall" id="activo"> 
                    <option value="" selected disabled>-</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
                        <div>
                <label for="fechaProximaEvaluacion">Fecha proxima evaluación:</label>
                <input type='text' id="fechaProximaEvaluacion" class="inputSelectMin" disabled readOnly />
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Proveedor ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Proveedor ya existe</li>                
                            <?php
                        endif;
                        Utils::deleteSession('result');
                        Utils::deleteSession('errores');
                        ?>
                    </ul>
                </div>
                <input class="btnAgregar" id="btnAgregar" type="submit" value="Agregar"/>
                <a id="save"><span class="material-icons i-save" title="Actualizar">save</span></a>
            </div>
        </div>
    </form>
</section>
<section class="sec-tabla sec-big text-center table-responsive-sm" id="seccionProveedor">
    <?php if (!empty($proveedores)): ?>
        <table class=" table-condensed tabla-big" id="tablaProveedor">
            <thead class="titulos-datos" id="titulos">
            <th></th>
            <th>Proveedor</th>
            <th>Tipo Servicio</th>
            <th>Contacto</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $pro): ?>             
                    <tr class="tr">
                        <td><span class="material-icons pt-1 i-add" id="show">add_box</span></td>
                        <td class="text-left w-30"><?= $pro->nombre; ?></td>
                        <td ><?= $pro->tipo_servicio; ?></td>
                        <td ><?= $pro->contacto; ?></td>
                        <td ><?= $pro->correo; ?></td>
                        <td ><?= $pro->telefono; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteProveedor&id=<?= $pro->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                                <a><span id="evaluarProveedor" class="material-icons i-list" title="Evaluar proveedor"><i class="fas fa-tasks"></i></span></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-top text-left" id="tbDatos">  
                        <td class="td-datos  w-25">
                            <strong>Proveedor:</strong></br> <div> <label id="nombreTabla"><?= $pro->nombre; ?></label></div>
                            <strong>Tipo Servicio:</strong></br> <div> <label id="tipoServicioTabla"><?= $pro->tipo_servicio; ?></label></div>
                            <strong>Contacto:</strong></br>  <div><label id="contactoTabla"><?= $pro->contacto; ?></label> </div>
                            <strong>Correo:</strong></br><div>  <label id="correoTabla"><?= $pro->correo; ?></label></div>
                            <strong>Teléfono:</strong></br>  <div> <label id="telefonoTabla"><?= $pro->telefono; ?></label></div>
                            <strong>Celular:</strong></br> <div><label id="celularTabla"><?= $pro->celular == 0 ? "" : $pro->celular; ?></label></div>
                        </td>
                        <td class="td-datos text-left w-25">
                            <strong>Dirección:</strong></br> <div><label id="direccionTabla"><?= $pro->direccion; ?></label></div>
                            <strong>Ciudad:</strong></br> <div> <label id="ciudadTabla"><?= $pro->ciudad_completa; ?></label></div>
                            <strong>C.P.</strong></br> <div> <label id="codPostalTabla"><?= $pro->codigo_postal == 0 ? "" : $pro->codigo_postal; ?></label> </div>
                            <strong>RFC:</strong></br><div> <label id="rfcTabla"><?= $pro->rfc; ?></label></div>
                            <strong>Cuenta:</strong></br><div>  <label id="cuentaTabla"><?= $pro->cuenta; ?></label></div>
                            <strong>Clasificación:</strong></br> <div> <label id="clasificacionTabla"><?=$pro->clasificacion; ?></label></div>
                        </td>
                        <td class="td-datos text-left">
                            <strong>Correo 1:</strong></br><div>  <label id="correo1Tabla"><?= $pro->correo1; ?></label></div>
                            <strong>Correo 2:</strong></br><div>  <label id="correo2Tabla"><?= $pro->correo2; ?></label></div>
                            <strong>Correo 3:</strong></br><div>  <label id="correo3Tabla"><?= $pro->correo3; ?></label></div>
                            <strong>Calificación:</strong></br><div> <label id="calificacionTabla"><?= $pro->calificacion == 0 ? "" : $pro->calificacion ; ?></label></div>
                            <strong>Certificación:</strong></br> <div> <label id="certificacionTabla"><?= $pro->certificacion; ?></label></div>  
                        </td>
                        <td class="td-datos text-left">
                            <strong>Fecha Alta:</strong></br> <div> <label id="fechaAltaTabla"><?= $pro->fecha_alta == '' ? '' : date('d/m/Y', strtotime($pro->fecha_alta)); ?></label> </div>
                            <strong>Fecha Evaluación:</strong></br> <div><label id="fechaEvaluacionTabla"><?= $pro->fecha_evaluacion == '' ? '' : date('d/m/Y', strtotime($pro->fecha_evaluacion)); ?></label></div>
                            <strong>Fecha modificación:</strong></br><div> <label id="fechaModTabla"><?= $pro->fecha_modificacion == '' ? '' : date('d/m/Y', strtotime($pro->fecha_modificacion)); ?></label></div>
                            <strong>Fecha Prox. Evaluación:</strong></br><div><label id="fechaProxEvaTabla"><?= $pro->fecha_proxima_evaluacion == '' ? '' : date('d/m/Y', strtotime($pro->fecha_proxima_evaluacion)); ?></label></div>                          
                            <strong>Activo:</strong></br> <div><label id="activoTabla"><?= $pro->activo; ?></label></div>
                            <strong>Fecha Baja:</strong></br><div><label><?= $pro->fecha_baja == '' ? "" : date('d/m/Y', strtotime($pro->fecha_baja)); ?></label></div>  
                        </td>
                        <td> 
                            <div class="py-5 ">
                                <span class="material-icons i-clear" id="clear">clear</span>
                            </div>
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteProveedor&id=<?= $pro->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                        <td hidden>
                            <span id="idTabla"><?= $pro->id; ?></span>
                            <span id="tipoServicioIdTabla"><?= $pro->tipo_solicitud_id; ?></span>
                            <span id="ciudadIdTabla"><?= $pro->ciudad_id; ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay proveedores registrados</span>                   
    <?php endif; ?>
</section>
    
<!-- Modal busqueda orden de compra-->
<div class="modal fade modal-busqueda" id="evaluarProveedorModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog m-dialog" role="document">
        <div class="modal-content m-content">
            <div class="modal-header m-header">
                <h5 class="ml-3  modal-title" id="titleModal"><span class="fas fa-tasks pr-2"></span>Evaluar proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="container">
                <form id="evaluarProveedorForm">
                    <div class="modal-body">                    
                        <div class="row d-flex mb-2">
                            <input type="hidden" name="idProveedorModal" id="idProveedorModal">
                            <div class="text-right pr-1"><label for="proveedorModal">Proveedor:</label></div> 
                            <div><input type="text" id="proveedorModal" class="inputLarge" readonly disabled/></span></div> 
                        </div>
                        <div class="row d-flex">
                            <div class="text-right pr-4"> <label>Periodo: </label></div>
                            <div class="pr-2"><input type='text' name="fechaInicioEvaluacion"  class="inputSmall" id="fechaInicioEvaluacion"  readOnly  placeholder="Fecha inicio..."/></div>
                            <div class="pr-2"> <label>Y</label></div>
                            <div><input type='text' name="fechaFinEvaluacion"  class="inputSmall" id="fechaFinEvaluacion"  placeholder="Fecha fin..." readOnly /></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" border-modal modal-footer m-footer text-center">
                <button type="button" class="btn btn-secondary" id="cancelarEnviar" data-dismiss="modal">Cancelar</button>
                <button class="btn enviarBtn" id="btnEvaluarProveedor"><span class="material-icons pr-2">done_outline</span><span>Evaluar</span></button>
            </div>
        </div>
    </div>
</div>