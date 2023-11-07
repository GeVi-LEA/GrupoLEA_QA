
<span id="valor" hidden>CarroTanque</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
         <div class="col-3 pl-4 text-left"><a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoTransporte"><span class="material-icons p-1 i-apps" id="i-apps" title="Transportes">keyboard_backspace</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Carro tanques</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar carro tanque</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveCarroTanque" method="post" class="formulario" id="formularioCarroTanque" >
        <div class="divCancelar">
            <a id="cancel"> <span class="material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>    
        </div>  
        <input type="text" name="id" class="id" id="id" hidden/>
        <div class="row p-1">
            <div class="col-3 text-right">
                <label for="numero">Número:</label>
            </div>
            <div class="col-9 d-flex justify-content-between">
                <input type="text" name="numero" class="inputMedium capitalize" id="numero" maxlength="30" placeholder="Ej. WCHX31153"/>           
            </div>
        </div>
        <div class="row p-1 ">
            <div class="col-3 text-right">
                <label for="estatus">Estatus:</label>
            </div>
            <div class="col-9">
                <select name="estatus" class="inputMedium" id="estatus"> 
                    <option value="" selected disabled>--Selecciona--</option>
                    <?php
                    if (!empty($estatus)):
                        foreach ($estatus as $e):
                            ?>
                            <option value="<?= $e->id ?>"><?= $e->nombre?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showEstados"><span title="Agrgar estado" class="material-icons i-add p-1">add</span></a>
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
<section class="sec-tabla text-center table-responsive-sm" id="seccionCarroTanque">
    <table class="table table-condensed" id="tablaCarroTanque">
        <?php if (!empty($carros)): ?>
            <thead>
            <th>Número</th>
            <th>Estatus</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($carros as $c): ?>
                    <tr class="tr">
                        <td id="idTabla" hidden><?=$c->id; ?></td>
                        <td id="numeroTabla"><?= $c->numero; ?></td>
                        <td ><?= $c->estatus; ?></td>
                        <td id="estatusIdTabla" hidden><?= $c->estatus_id; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteCarroTanque&id=<?= $c->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay carro tanques registrados</span>                   
    <?php endif; ?>
</section>
