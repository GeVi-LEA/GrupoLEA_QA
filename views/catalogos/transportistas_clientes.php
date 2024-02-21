
<span id="valor" hidden>TransportistasClientes</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-1 text-center"><a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoTransporte"><span class="material-icons p-1 i-apps" id="i-apps" title="Productos">keyboard_backspace</span></a></div>
        <div class="col-10 text-center"><h1 class="titulo">Transportistas Clientes</h1></div>
        <div class="col-1"><a><span class="material-icons p-1 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar Transportista</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveTransportistaCliente" method="post" class="formulario" id="formularioTransportistasClientes" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Nombre:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. Herm"/>           
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="clave">Comentarios:</label>
            </div>
            <div class="col-9">
                <input type="text" name="clave" class="inputSmall" id="clave" maxlength="15" placeholder="Ej. Pipa"/>
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de transportista ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de transportista ya existe</li>                
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionTransportistasClientes">
    <table class="table table-condensed" id="tablaTransportistasClientes">
        <?php if (!empty($transportistas)): ?>
            <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Comentarios</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($transportistas as $t): ?>
                    <tr class="tr">
                        <td id="idTabla"><?=$t->id; ?></td>
                        <td id="nombreTabla"><?= $t->nombre; ?></td>
                        <td id="comentariosTabla"><?= $t->comentarios; ?></td>
                        <td>
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteTranspórtistaCliente&id=<?= $t->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay transportistas registradas</span>                   
    <?php endif; ?>
</section>
