
<span id="valor" hidden>Aduana</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-1 text-center"><a href="<?= catalogosUrl ?>?controller=Catalogo&action=showRutas"><span class="material-icons p-1 i-apps" id="i-apps" title="Productos">keyboard_backspace</span></a></div>
        <div class="col-10 text-center"><h1 class="titulo">Aduanas</h1></div>
        <div class="col-1"><a><span class="material-icons p-1 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar aduana</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveAduana" method="post" class="formulario" id="formularioAduana" >
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
                <label for="clave">Clave:</label>
            </div>
            <div class="col-9">
                <input type="text" name="clave" class="inputSmall" id="clave" maxlength="15" placeholder="Ej. Pipa"/>
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="ciudad">Ciudad:</label>
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
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de aduana ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de aduana ya existe</li>                
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionAduana">
    <table class="table table-condensed" id="tablaAduana">
        <?php if (!empty($aduanas)): ?>
            <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Clave</th>
            <th>Ciudad</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($aduanas as $a): ?>
                    <tr class="tr">
                        <td id="idTabla"><?=$a->id; ?></td>
                        <td id="nombreTabla"><?= $a->nombre; ?></td>
                        <td id="claveTabla"><?= $a->clave; ?></td>
                        <td hidden><span id="ciudadIdTabla"><?= $a->ciudad_id; ?></span> </td>
                        <td id="ciudadTabla"><?= $a->ciudad; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteAduana&id=<?= $a->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay aduanas registradas</span>                   
    <?php endif; ?>
</section>
