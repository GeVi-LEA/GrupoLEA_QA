
<span id="valor" hidden>TipoEmpaque</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-1 text-center"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-10 text-center"><h1 class="titulo">Tipos empaque</h1></div>
        <div class="col-1"><a><span class="material-icons p-1 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar empaque</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveTipoEmpaque" method="post" class="formulario" id="formularioTipoEmpaque" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Tipo empaque:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. GRANEL"/>
                <input type="hidden" name="id" class="inputSmall " id="id"/>
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
                            <li>El <b>nombre</b> de tipo empaque ya existe</li>                   
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionTipoEmpaque">
    <table class="table table-condensed" id="tablaTipoEmpaque">
        <?php if (!empty($tiposEmpaques)): ?>
            <thead>
            <th>Tipo empaque</th>
            <th>Descripción</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($tiposEmpaques as $t): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?=$t->id; ?></td>
                        <td id="nombreTabla"><?= $t->nombre; ?></td>
                        <td id="descripcionTabla"><?= $t->descripcion; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteTipoEmpaque&id=<?= $t->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay tipos de empaque registrados</span>                   
    <?php endif; ?>
</section>
