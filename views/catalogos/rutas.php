
<span id="valor" hidden>Ruta</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
    <?php endif; ?>
    <header class="header">
        <div class="row">
            <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
            <div class="col-6 text-center"><h1 class="titulo">Rutas</h1></div>
            <div class="col-3 d-flex">
                <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
                <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
            </div>
        </div>
</header>
<nav class="menu">
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showAduanas">Aduanas</span></a>
    <span id="mostrarForm">Agregar ruta</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveRuta" method="post" class="formulario" id="formularioRuta" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="proveedor">Proveedor:</label>
            </div>
            <div class="col-9">
                <select name="proveedor" class="inputLarge" id="proveedor"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($transportistas)):
                        foreach ($transportistas as $t):
                            ?>
                            <option value="<?= $t->id ?>"><?= $t->nombre ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showProveedores"><span title="Agregar proveedor" class="material-icons i-add p-1">add</span></a>
            </div>
        </div>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="transporte">Tipo transporte:</label>
            </div>
            <div class="col-9">
                <select name="transporte" class="inputBig" id="transporte"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($transportes)):
                        foreach ($transportes as $trans):
                            ?>
                            <option value="<?= $trans->id ?>"><?= $trans->nombre ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoTransporte"><span title="Agregar tipo transporte" class="material-icons i-add p-1">add</span></a>
            </div>
        </div>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="clave">Ciudad origen:</label>
            </div>
            <div class="col-9">
                <select name="ciudad" class="inputLarge" id="ciudad"> 
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
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="ciudadDestino">Ciudad destino:</label>
            </div>
            <div class="col-9">
                <select name="ciudadDestino" class="inputLarge" id="ciudadDestino"> 
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
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="costo">Costo:</label>
            </div>
            <div class="col-9">
                <input type="text" name="costo" class="inputBig" id="costo" maxlength="50" placeholder="Costo flete"/>
                <label class="ml-2">Moneda</label>
                <select class="item-s-small" name="moneda" id="moneda">
                    <option value="">--</option>
                    <?php
                    foreach (monedas as $i => $m):
                        ?>
                        <option value="<?= $i ?>"><?= $m['clave'] ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
          <div class="row p-1 ">
            <div class="col-3 text-right pl-0">
                <label for="fechaVencimiento">Fecha vencimiento:</label>
            </div>
            <div class="col-9">
                 <input type='text' name="fechaVencimiento" value="" id="fechaAlta"  readOnly />
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
                <input class="btnAgregar" id="btnAgregar" type="submit" value="Agregar"/>
                <a id="save"><span class="material-icons i-save" title="Actualizar">save</span></a>
            </div>
        </div>
    </form>
</section>
<section class="sec-tabla sec-big text-center" id="seccionRuta">
    <table class="table tabla-big tabla-ruta" id="tablaRuta">
        <?php if (!empty($rutas)): ?>
            <thead>
            <th>Cuidad origen</th>
            <th>Ciudad destino</th>
            <th>Proveedor</th>
            <th>Transporte</th>
            <th>Costo</th>
            <th>Fecha Venc.</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($rutas as $r): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $r->id; ?></td>
                        <td ><?= $r->ciudad_or; ?></td>
                        <td ><?= $r->ciudad_des; ?></td>
                        <td ><?= $r->proveedor; ?></td>
                        <td ><?= $r->transporte; ?></td>
                        <td><span id="costoTabla"><?= UtilsHelp::numero2Decimales($r->precio, true); ?></span><input type="hidden" value="<?=$r->moneda?>" id="monedaTabla"><span class="pl-1"><?=$r->moneda != 0 ? monedas[$r->moneda]['clave'] : ""?></span></td>
                        <td id="fechaAltaTabla"><?= date('d/m/Y', strtotime($r->fecha_vencimiento)); ?></td>
                        <td hidden>
                            <span id="proveedorIdTabla"><?= $r->proveedor_id; ?></span> 
                            <span id="tipoTransIdTabla"><?= $r->tipo_transporte; ?></span> 
                            <span id="ciudadIdTabla"><?= $r->ciudad_origen; ?></span> 
                            <span id="ciudadDesIdTabla"><?= $r->ciudad_destino; ?></span> 
                            <span id="descripcionTabla"><?= $r->descripcion; ?></span> 
                        </td>
                                <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteRuta&id=<?= $r->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay rutas registradas</span>                   
    <?php endif; ?>
</section>
