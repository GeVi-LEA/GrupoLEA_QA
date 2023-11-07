<span id="valor" hidden>TipoSolicitud</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Servicios/Adquisiciones</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposCompras">Tipos compras</span></a>
<span id="mostrarForm">Agregar Tipo de Solicitud</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveTipoSolicitud" method="post" class="formulario" id="formularioTipoSolicitud" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Tipo:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. Asesoria"/>          
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="tipoCompras">Tipo Compra:</label>
            </div>
            <div class="col-9">
                <select name="tipoCompras" class="inputMedium" id="tipoCompras"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($tiposCompras)):
                        foreach ($tiposCompras as $tc):
                            ?>
                            <option value="<?= $tc->id ?>"><?= $tc->tipo ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposCompras"><span title="Agrgar Tipo compra" class="material-icons i-add p-1">add</span></a>         
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="descripcion">Descripción:</label>
            </div>
            <div class="col-9">
                <input type="text" name="descripcion" class="inputLarge" id="descripcion" maxlength="200" placeholder="Escribe una descripción"/>
            </div>
        </div>

        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Tipo solicitud ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Tipo solicitud ya existe</li>                
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionTipoSolicitud">
    <?php if (!empty($tipoSolicitudes)): ?>

        <table class="table table-condensed" id="tablaTipoSolicitud">
            <thead>
            <th>Tipo Servicio/Adquisición</th>
            <th>Tipo Compra</th>
            <th>Descripción</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($tipoSolicitudes as $ts): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $ts->id; ?></td>
                        <td id="nombreTabla"><?= $ts->tipo; ?></td>
                        <td id="tipoCompraIdTabla" hidden><?= $ts->tipo_compra_id; ?></td>
                        <td id="tipoCompraTabla"><?= $ts->tipoCompra; ?></td>  
                        <td id="descripcionTabla"><?= $ts->descripcion; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteTipoSolicitud&id=<?= $ts->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    <?php else: ?>
        <span>No hay tipos de solucitudes registrados</span>                   
    <?php endif; ?>

</section>
