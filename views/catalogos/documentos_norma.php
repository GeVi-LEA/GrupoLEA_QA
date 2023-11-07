
<span id="valor" hidden>DocumentoNorma</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Documentos norma</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar Documento</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveDocumentoNorma" method="post" enctype="multipart/form-data" class=" w-100 px-4 formulario" id="formularioDocumentoNorma" >
        <div class="divCancelar">
            <a id="cancel"> <span class= "material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <div class="row d-flex  justify-content-between p-1">
            <input type="text" name="id" class="id" id="id" hidden />
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" class="inputXL" id="nombre" maxlength="300" placeholder="Ej. Formato Orden de compra"/> 
            </div>
            <div>
                <label for="clave">Código:</label>
                <input type="text" name="clave" class="inputSmall text-uppercase" id="clave" maxlength="10" placeholder="código"/> 
            </div>
            <div>
                <label for="revision">Rev:</label>
                <input type="text" name="revision" class="inputXSmall" id="revision" maxlength="2" placeholder="0"/> 
            </div>
            <div>
                <label for="estatus">Estatus:</label>
                <select name="estatus" class="inputSelectMin" id="estatus"> 
                    <option value="" selected disabled>-Selecciona-</option>
                    <?php
                    if (!empty($estatus)):
                        foreach ($estatus as $e):
                            ?>
                            <option value="<?= $e->id ?>"><?= $e->nombre ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showEstatus"><span title="Agregar nuevo estatus" class="material-icons i-add p-1">add</span></a>  
            </div>

        </div>     
        <div class="row d-flex justify-content-between p-1">         
            <div>
                <label for="usuario">Responsable:</label>
                <select name="usuario" class="inputLarge" id="usuario"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($usuarios)):
                        foreach ($usuarios as $u):
                            ?>
                            <option value="<?= $u->id ?>"><?= $u->nombres . " " . $u->apellidos ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showUsuarios"><span title="Agregar nuevo usuario" class="material-icons i-add p-1">add</span></a>  
            </div>
            <div>
                <label for="fechaLiberacion">Fecha Liberación:</label>
                <input type='text' name="fechaLiberacion" id="fechaLiberacion" class="inputSelectMin" readOnly />
            </div>
            <div>
                <label for="fechaAlta">Fecha Alta:</label>
                <input type='text' name="fechaAlta" id="fechaAlta" class="inputSelectMin" readOnly />
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div class=" d-flex">
                <div class="d-flex flex-column">
                    <div><label >Documento:</label>
                        <label for="documento" class="px-2 inputFile"><i class="fas fa-cloud-upload-alt"></i> Subir Documento</label>
                        <input id="documento" onchange="cambiarInputFile('documento', 'spanDocumento')" name="documento" type="file" hidden/>
                    </div>
                    <div>
                        <span id="spanDocumento" class="px-4"></span>
                    </div>
                </div>

            </div>
            <div class="d-block" >
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" class="inputXL" id="descripcion" maxlength="400" placeholder="Escribe una descripción"/>
            </div>
            <div  class="d-block ">
                <span class="material-icons i-apps" id="showDoc">plagiarism</span><span>Ver documento</span>
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Documento ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Documento ya existe</li>                
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
<section id="secDoc" class="sec-doc">
    <div class="btn-slideUp">
        <span class="material-icons i-slideUp" id="i-slideUp">vertical_align_top</span>
    </div>
    <object class="view-doc" id="objDoc" data=""></object>
</section>
<section class="sec-tabla sec-big text-center table-responsive-sm" id="seccionDocumentoNorma">
    <?php if (!empty($documentos)): ?>
        <table class=" table-condensed tabla-big" id="tablaDocumentoNorma">
            <thead class="titulos-datos" id="titulos">
            <th></th>
            <th>Código</th>
            <th>Revisión</th>
            <th>Nombre</th>
            <th>Estatus</th>
            <th>Responsable</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($documentos as $d): ?>             
                    <tr class="tr">
                        <td><span class="material-icons pt-1 i-add" id="show">add_box</span></td>
                        <td class="text-left w-25"><?= $d->codigo;?></td>
                        <td ><?= $d->revision; ?></td>
                        <td ><?= $d->nombre; ?></td>
                        <td title="<?= $d->estatus; ?>"><?= $d->estatusClave; ?></td>
                        <td ><?= $d->usuario; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=catalogo&action=deleteUsuario&id=<?= $d->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-top text-left" id="tbDatos">  
                        <td class="td-datos">
                            <strong>Codigo:</strong></br> <div> <label id="claveTabla"><?= $d->codigo; ?></label></div>
                            <strong>Revisión:</strong></br> <div> <label id="revisionTabla"><?= $d->revision; ?></label></div>
                            <strong>Nombre:</strong></br> <div> <label id="nombreTabla"><?= $d->nombre; ?></label></div>
                            <strong>Estatus:</strong></br>  <div><label id="estatusTabla"><?= $d->estatus; ?></label> </div>
                        </td>
                        <td class="td-datos">
                            <strong>Responsable:</strong></br><div>  <label id="usuarioTabla"><?= $d->usuario; ?></label></div>
                            <strong>Descripción:</strong></br><div>  <label id="descripcionTabla"><?= $d->descripcion; ?></label></div>
                            <strong>Fecha Alta:</strong></br> <div><label id="fechaAltaTabla"><?= $d->fecha_alta == '' ? '' : date('d/m/Y', strtotime($d->fecha_alta)); ?></label></div>
                            <strong>Fecha Liberación:</strong></br><div><label id="fechaLibTabla"><?= $d->fecha_liberacion == '' ? '' : date('d/m/Y', strtotime($d->fecha_liberacion)); ?></label></div>
                        </td>
                        <td class="td-datos w-25">     
                            <strong>Fecha modificación:</strong></br><div>  <label id="fechaModTabla"><?= $d->fecha_modificacion == '' ? '' : date('d/m/Y', strtotime($d->fecha_modificacion)); ?></label></div>
                            <section>
                                <article class="w-50 float-left"><strong>Documento:</strong></br>
                                    <?php if ($d->formato != null): ?>
                                        <object class="documento-obj" id="documentoTabla" data="uploads/documentosNorma/<?= $d->formato ?>" type="application/pdf"></object>
                                    <?php else: ?>
                                        <label>No tiene documento</label>
                                    <?php endif; ?>
                                </article>
                            </section>
                        </td>

                        <td hidden>
                            <span id="idTabla"><?= $d->id; ?></span>
                            <span id="usuarioIdTabla"><?= $d->usuario_id; ?></span>
                            <span id="estatusIdTabla"><?= $d->estatus_id; ?></span>
                            <span id="nombreDocumentoTabla"><?= $d->formato ?></span>               
                        </td>

                        <td> 
                            <div class="py-5 ">
                                <span class="material-icons i-clear" id="clear">clear</span>
                            </div>
                       

                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteDocumentoNorma&id=<?= $d->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    <?php else: ?>
        <span>No hay documentos registrados</span>                   
    <?php endif; ?>
</section>