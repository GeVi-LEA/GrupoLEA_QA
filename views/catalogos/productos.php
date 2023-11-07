
<span id="valor" hidden>Producto</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
<span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Productos</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
</div>
</header>
<nav class="menu">
 <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showRefinerias">Refinerias</span></a>
<span id="mostrarForm">Agregar producto</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveProducto" method="post" class="formulario" id="formularioProducto" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Nombre:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="producto" class="inputMedium capitalize" id="producto" maxlength="30" placeholder="Ej. SOKOY 26"/> 
            </div>
        </div>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="refineria">Refíneria:</label>
            </div>
            <div class="col-9">
                <select name="refineria" class="inputMedium" id="refineria"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($refinerias)):
                        foreach ($refinerias as $r):
                            ?>
                            <option value="<?= $r->id ?>"><?= $r->nombre ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showRefinerias"><span title="Agregar refíneria" class="material-icons i-add p-1" id="agregarRefineria">add</span></a>         
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> del producto ya existe</li>                   
                        <?php endif; ?>             
                            <?php
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionProducto">
<?php if (!empty($productos)): ?>

        <table class="table table-condensed" id="tablaProducto">
            <thead>
            <th>Producto</th>
            <th>Refíneria</th>
            <th></th>
            </thead>
            <tbody>
    <?php foreach ($productos as $p): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $p->id; ?></td>
                        <td id="nombreTabla" ><?= $p->nombre; ?></td>
                        <td id="refineriaIdTabla" hidden><?= $p->refineria_id; ?></td>
                        <td id="nombreRefineriaTabla"><?= $p->nombre_refineria; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteProducto&id=<?= $p->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
        <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay productos registrados</span>                   
<?php endif; ?>

</section>
