<span id="valor" hidden>Unidad</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Unidades de medida</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar unidad</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveUnidades" method="post" class="formulario" id="formularioUnidad" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Unidad:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="15" placeholder="Ej. Metro"/>           
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="clave">Clave:</label>
            </div>
            <div class="col-9">
                <input type="text" name="clave" class="inputSmall" id="clave" maxlength="10" placeholder="Ej. m"/>
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
                <div>
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Unidad ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Unidad ya existe</li>                
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionUnidad">
    <table class="table table-condensed" id="tablaUnidad">
        <?php if (!empty($unidades)): ?>
            <thead>
            <th>Unidad</th>
            <th>Clave</th>
            <th>Descripción</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($unidades as $uni): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $uni->id; ?></td>
                        <td id="nombreTabla"><?= $uni->nombre; ?></td>
                        <td id="claveTabla"><?= $uni->clave; ?></td>
                        <td id="descripcionTabla"><?= $uni->descripcion; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteUnidades&id=<?= $uni->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay unidades registradas</span>                   
    <?php endif; ?>
</section>
