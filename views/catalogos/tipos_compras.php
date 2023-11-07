
<span id="valor" hidden>TiposCompras</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-1 text-center"><a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposSolicitudes"><span class="material-icons p-1 i-apps" id="i-apps" title="Tipos solicitudes">keyboard_backspace</span></a></div>
        <div class="col-10 text-center"><h1 class="titulo">Tipos Compras</h1></div>
        <div class="col-1"><a><span class="material-icons p-1 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar Tipo Compra</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveTipoCompra" method="post" class="formulario" id="formularioTiposCompras" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Tipo compra:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. Producto"/>          
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
                            <li>El <b></b> de tipo sompra ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Estado ya existe</li>                
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionTiposCompras">
    <?php if (!empty($tiposCompras)): ?>

        <table class="table table-condensed" id="tablaTiposCompras">
            <thead>
            <th>Tipo Compra</th>
            <th>Descripción</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($tiposCompras as $com): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $com->id; ?></td>
                        <td id="nombreTabla"><?= $com->tipo; ?></td>
                        <td id="descripcionTabla"><?= $com->descripcion; ?></td>  
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteTipoCompra&id=<?= $com->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay tipos de compras registrados</span>                   
    <?php endif; ?>

</section>
