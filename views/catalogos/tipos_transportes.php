<span id="valor" hidden>TipoTransporte</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
<span hidden id="result">true</span>
<?php else: ?>
<span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-1 text-center"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-10 text-center">
            <h1 class="titulo">Tipos de transportes</h1>
        </div>
        <div class="col-1"><a><span class="material-icons p-1 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
    </div>
</header>
<nav class="menu">
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTransportistasClientes">Transportistas</span></a>
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showCarroTanques">Carro tanques</span></a>
    <span id="mostrarForm">Agregar tipo transporte</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveTipoTransporte" method="post" class="formulario" id="formularioTipoTransporte">
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <input type="text" name="id" class="id" id="id" hidden />
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Nombre:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. Pipa" />
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="clave">Clave:</label>
            </div>
            <div class="col-9">
                <input type="text" name="clave" class="inputSmall" id="clave" maxlength="15" placeholder="Ej. Pipa" />
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="descripcion">Descripción:</label>
            </div>
            <div class="col-9">
                <input type="text" name="descripcion" class="inputLarge" id="descripcion" maxlength="200" placeholder="Escribe una descripción" />
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="descripcion">Cap Máxima:</label>
            </div>
            <div class="col-9">
                <input type="number" name="cap_maxima" class="inputLarge" id="cap_maxima" placeholder="Escribe la capacidad máxima" />
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div>
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                        <li>El <b>nombre</b> de transporte ya existe</li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                        <li>La <b>clave</b> de transporte ya existe</li>
                        <?php
endif;
Utils::deleteSession('result');
Utils::deleteSession('errores');
?>
                    </ul>
                </div>
                <input class="btnAgregar" id="btnAgregar" type="submit" value="Agregar" />
                <a id="save"><span class="material-icons i-save" title="Actualizar">save</span></a>
            </div>
        </div>
    </form>
</section>
<section class="sec-tabla text-center table-responsive-sm" id="seccionTipoTransporte">
    <table class="table table-condensed" id="tablaTipoTransporte">
        <?php if (!empty($transportes)): ?>
        <thead>
            <th>Nombre</th>
            <th>Clave</th>
            <th>Descripción</th>
            <th>Cap Máxima</th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($transportes as $t): ?>
            <tr class="tr">
                <td id="idTabla" hidden><?= $t->id; ?></td>
                <td id="nombreTabla"><?= $t->nombre; ?></td>
                <td id="claveTabla"><?= $t->clave; ?></td>
                <td id="descripcionTabla"><?= $t->descripcion; ?></td>
                <td id="cap_maximaTabla"><?= UtilsHelp::numero2Decimales($t->cap_maxima, true, 0); ?> KGs/LTs</td>
                <td>
                    <div>
                        <a><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>
                        <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteTipoTransporte&id=<?= $t->id; ?>"></a><span id="delete" class="material-icons i-delete"
                            title="Eliminar">delete_forever</span>
                    </div>
                </td>
                <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <span>No hay tipos de transportes registrados</span>
    <?php endif; ?>
</section>