
<span id="valor" hidden>Estado</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
         <div class="col-3 pl-4 text-left"><a href="<?= catalogosUrl ?>?controller=Catalogo&action=showCiudades"><span class="material-icons p-1 i-apps" id="i-apps" title="Ciudades">keyboard_backspace</span></a></div>
         <div class="col-6 text-center"><h1 class="titulo">Estados</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showPaises">Paises</span></a>
<span> <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showCiudades">Ciudades</span></a>
<span id="mostrarForm">Agregar estado</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveEstado" method="post" class="formulario" id="formularioEstado" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="nombre">Nombre:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="nombre" class="inputMedium capitalize" id="nombre" maxlength="30" placeholder="Ej. Nuevo León"/> 
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="clave">Clave:</label>
            </div>
            <div class="col-9">
                <input type="text" name="clave" class="inputSmall text-uppercase" id="clave" maxlength="7" placeholder="Ej. NL"/>
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="pais">País:</label>
            </div>
            <div class="col-9">
                <select name="pais" class="inputMedium" id="pais"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($paises)):
                        foreach ($paises as $p):
                            ?>
                            <option value="<?= $p->id ?>"><?= $p->nombre ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showPaises"><span title="Agregar país" class="material-icons i-add p-1" id="agregarPais">add</span></a>         
            </div>
        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Estado ya existe</li>                   
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionEstado">
<?php if (!empty($estados)): ?>

        <table class="table table-condensed" id="tablaEstado">
            <thead>
            <th>Estado</th>
            <th>Clave</th>
            <th>Pais</th>
            <th></th>
            </thead>
            <tbody>
    <?php foreach ($estados as $est): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?= $est->id; ?></td>
                        <td id="nombreTabla" ><?= $est->nombre; ?></td>
                        <td id="claveTabla"><?= $est->clave; ?></td>  
                        <td id="paisIdTabla" hidden><?= $est->pais_id; ?></td>
                        <td id="nombrePaisTabla"><?= $est->nombre_pais; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteEstado&id=<?= $est->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
        <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay estados registrados</span>                   
<?php endif; ?>

</section>
