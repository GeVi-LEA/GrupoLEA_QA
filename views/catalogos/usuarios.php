
<span id="valor" hidden>Usuario</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Usuarios</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoPermisos">Tipo permisos</span></a>
<span id="mostrarForm">Agregar usuario</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveUsuario" method="post" enctype="multipart/form-data" class=" w-100 px-4 formulario" id="formularioUsuario" >
        <div class="divCancelar">
            <a id="cancel"> <span class= "material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <div class="row d-flex  justify-content-between p-1">
            <input type="hidden" name="id" class="id" id="id"/>
            <div>
                <label for="nombre">Nombres:</label>
                <input type="text" name="nombre" class="inputBig capitalize" id="nombre" maxlength="200" placeholder="Nombres"/> 
            </div>
            <div>
                <label for="apellido">Apellidos:</label>
                <input type="text" name="apellido" class="inputBig capitalize" id="apellido" maxlength="200" placeholder="Apellidos"/> 
            </div>
            <div>
                <label for="departamento">Departamento:</label>
                <select name="departamento" class="inputMedium" id="departamento"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($departamentos)):
                        foreach ($departamentos as $d):
                            ?>
                            <option value="<?= $d->id ?>"><?= $d->nombre ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showDepartamentos"><span title="Agregar nuevo departamento" class="material-icons i-add p-1">add</span></a>  
            </div>
        </div>     
        <div class="row d-flex justify-content-between p-1">         
            <div>
                <label for="puesto">Puesto:</label>
                <input type="text" name="puesto" class="inputBig capitalize" id="puesto" maxlength="200" placeholder="Puesto"/> 
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="text" name="correo" class="inputLarge" id="correo" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
            <div>
                <label for="telefono">Tel:</label>
                <input type="text" name="telefono" class="inputSelectMin" id="telefono" maxlength="15" placeholder="Ej.5566778899"/> 
            </div>
            <div>
                <label for="extension">Ext:</label>
                <input type="text" name="extension" class="inputSmall" id="extension" maxlength="4" placeholder="Ej.5566"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="user">Usuario:</label>
                <input type="text" name="user" class="inputSelectMin" id="user" maxlength="10" placeholder="Usuario"/> 
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" class="inputSelectMin" id="password" maxlength="10" placeholder="*******"/> 
                <input type="text" name="cambioPass" class="inputSelectMin" id="cambioPass" hidden/> 
            </div>
            <div>
                <label for="fechaAlta">Fecha Alta:</label>
                <input type='text' name="fechaAlta" id="fechaAlta" class="inputSelectMin" readOnly />
            </div>
             <div class="d-block">
                <label for="activo">Activo:</label>
                <select name="activo" class="inputSmall" id="activo"> 
                    <option value="" selected disabled>-</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
        </div>
        <div class="row div-img-permisos p-1">
            <div class="d-flex flex-row">
                <div class="d-block py-2">
                    <label>Foto:</label>
                    <label id="subirImagen" for="imagen" class="px-2 inputFile"><i class="fas fa-cloud-upload-alt"></i> Subir imagen</label>
                    <input id="imagen" onchange="cambiarInputFile('imagen', 'spanImg')" name="imagen" type="file" hidden/></br>
                    <span  id="spanImg" class="px-2"></span></div>
                <div><img class="img-thumb ml-2" id="imgThumb" src="../../assets/img/user.jpg"></div>
                <div><span id="deleteImagen" class="material-icons i-clear" title="Eliminar imagen" hidden>clear</span></div>
            </div>
            <div class="d-flex flex-row">
                <div class="d-block py-2">
                    <label>Firma:</label>
                    <label id="subirFirma" for="firma" class="px-2 inputFile"><i class="fas fa-cloud-upload-alt"></i> Subir imagen</label>
                    <input id="firma" onchange="cambiarInputFile('firma', 'spanImgFirma')" name="firma" type="file" hidden/></br>
                    <span  id="spanImgFirma" class="px-2"></span></div>
                <div><img class="img-thumb ml-2" id="imgFirmaThumb" src="" hidden></div>
                <div><span id="deleteFirma" class="material-icons i-clear" title="Eliminar firma" hidden>clear</span></div>
            </div>
            <div>
                <div><label>Permisos:</label></div>
                <div class="d-flex flex-row flex-wrap" id="permisos">
                    <?php
                    if (!empty($permisos)):
                        foreach ($permisos as $p):
                            ?>
                    <div><input class="mr-1" type="checkbox" name="permisos[]" value="<?= $p->id?>"><span class="mr-3"><?= $p->nombre ?></span></div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoPermisos"><span title="Agregar nuevo permiso" class="material-icons i-add p-1">add</span></a> 
                </div>
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Usuario ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Usuario ya existe</li>                
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
<section class="sec-tabla sec-big text-center table-responsive-sm" id="seccionUsuario">
    <?php if (!empty($usuarios)): ?>
        <table class=" table-condensed tabla-big" id="tablaUsuario">
            <thead class="titulos-datos" id="titulos">
            <th></th>
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Puesto</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Extensión</th>
            <th>Permisos</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usr): ?>             
                    <tr class="tr">
                        <td><span class="material-icons pt-1 i-add" id="show">add_box</span></td>
                        <td class="text-left w-30"><?= $usr->nombres . " " . $usr->apellidos; ?></td>
                        <td ><?= $usr->departamento; ?></td>
                        <td ><?= $usr->puesto; ?></td>
                        <td ><?= $usr->correo; ?></td>
                        <td ><?= $usr->telefono; ?></td>
                        <td ><?= $usr->extension == 0 ? "" : $usr->extension; ?> </td>
                        <td><?= Utils::getClaverPermisosUser($usr->permisos); ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteUsuario&id=<?= $usr->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-top text-left" id="tbDatos">  
                        <td class="td-datos  w-25">
                            <strong>Nombre:</strong></br> <div> <label id="nombreTabla"><?= $usr->nombres; ?></label><label id="apellidoTabla"><?= $usr->apellidos; ?></label></div>
                            <strong>Departamento:</strong></br> <div> <label id=departamentoTabla"><?= $usr->departamento; ?></label></div>
                            <strong>Puesto:</strong></br>  <div><label id="puestoTabla"><?= $usr->puesto; ?></label> </div>
                            <strong>Permisos:</strong></br><div>  <label id="permisoTabla"><?= Utils::getClaverPermisosUser($usr->permisos); ?></label></div>
                        </td>
                        <td class="td-datos  w-25">
                            <strong>Correo:</strong></br><div>  <label id="correoTabla"><?= $usr->correo; ?></label></div>
                            <strong>Teléfono:</strong></br>  <div> <label id="telefonoTabla"><?= $usr->telefono; ?></label></div>
                            <strong>Extensión:</strong></br> <div><label id="extensionTabla"><?= $usr->extension == 0 ? "" : $usr->extension; ?></label></div>
                            <strong>Usuario:</strong></br>  <div> <label id="userTabla"><?= $usr->user; ?></label></div>
                        </td>
                        <td class="td-datos">
                            <strong>Fecha Alta:</strong></br> <div><label id="fechaAltaTabla"><?= $usr->fecha_alta == '' ? '' : date('d/m/Y', strtotime($usr->fecha_alta)); ?></label></div>
                            <strong>Fecha modificación:</strong></br><div>  <label id="fechaModTabla"><?= $usr->fecha_modificacion  == '' ? '' : date('d/m/Y', strtotime($usr->fecha_modificacion));?></label></div>
                            <strong>Activo:</strong></br><div>  <label id="activoTabla"><?= $usr->activo; ?></label></div>
                            <strong>Fecha Baja:</strong></br><div><label><?= $usr->fecha_baja == '' ? '' : date('d/m/Y', strtotime($usr->fecha_baja));?></label></div>
                        </td>
                        <td class="td-datos w-25">              
                            <section>
                                <article class="w-50 float-left imagen"><strong>Foto:</strong></br>
                                    <?php if ($usr->imagen != null): ?>
                                        <img class="img-user" id="imagenTabla" src="uploads/imgUsuarios/<?= $usr->imagen ?>">
                                    <?php else: ?>
                                        <img class="img-user" id="imagenTablaDef" src="../../assets/img/user.jpg">
                                    <?php endif; ?>
                                </article>
                                <article class="w-50 float-left imagen"><strong>Firma:</strong></br>
                                    <?php if ($usr->firma != null): ?>
                                        <img id="imgFirmaTabla" class="img-user"  src="uploads/imgFirmasUsuarios/<?= $usr->firma ?>">
                                    <?php else: ?>
                                        <label id="imgFirmaTablaDef">Sin firma registrada</label>
                                    <?php endif; ?>
                                </article>
                            </section>
                        </td>

                        <td hidden>
                            <span id="idTabla"><?= $usr->id; ?></span>
                            <span id="departamentoIdTabla"><?= $usr->departamento_id; ?></span>
                            <span id="permisosTabla"><?=$usr->permisos; ?></span>
                            <span id="passwordTabla"><?= $usr->password; ?></span>
                        </td>
                        <td> 
                            <div class="py-5 ">
                                <span class="material-icons i-clear" id="clear">clear</span>
                            </div>
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl?>?controller=Catalogo&action=deleteUsuario&id=<?= $usr->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay usuarios registrados</span>                   
    <?php endif; ?>
</section>