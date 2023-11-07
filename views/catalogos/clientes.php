
<span id="valor" hidden>Cliente</span>
<?php if (isset($_SESSION['result']) && $_SESSION['result'] == 'true'): ?>
    <span hidden id="result">true</span>
<?php else : ?>
    <span hidden id="result">false</span>
<?php endif; ?>
<header class="header">
    <div class="row">
        <div class="col-3 pl-4 text-left"><a href="index.php"><span class="material-icons p-1 i-apps" id="i-apps" title="Catalogos">apps</span></a></div>
        <div class="col-6 text-center"><h1 class="titulo">Clientes</h1></div>
        <div class="col-3 d-flex">
            <div class="mt-2 mr-3"><input class="buscador" type="text" id="buscador" placeholder="Buscar..."><i class="fas fa-search i-search"></i></div>
            <a><span class="material-icons ml-3 mt-1 p-1 i-close" id="i-close" title="Cerrar">cancel</span></a>
        </div>
    </div>
</header>
<nav class="menu">
    <span id="mostrarForm">Agregar cliente</span>
</nav>
<section id="secForm">
    <form action="<?= catalogosUrl ?>?controller=Catalogo&action=saveCliente" method="post" class=" w-100 px-4 formulario" id="formularioCliente" >
        <div class="divCancelar">
            <a id="cancel"> <span class= "material-icons i-cancel ml-5" title="Cancelar">disabled_by_default</span></a>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <input type="text" name="id" class="id" id="id" hidden />
            <div>
                <label for="nombre">Cliente:</label>
                <input type="text" name="nombre" class="inputLarge capitalize" id="nombre" maxlength="200" placeholder="Ej. LEA"/> 
            </div>
            <div>
                <label for="contacto">Contacto:</label>
                <input type="text" name="contacto" class="inputLarge capitalize" id="contacto" maxlength="250" placeholder="Ej. Nombre Apellido"/> 
            </div>
            <div>
                <label for="telefono">Tel:</label>
                <input type="text" name="telefono" class="inputSelectMin" id="telefono" maxlength="15" placeholder="Ej.5566778899"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
                <div>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" class="inputLarge " id="direccion" maxlength="250" placeholder="Escribe la dirección del cliente"/> 
            </div>
            <div>
                <label for="ciudad">Ciudad:</label>     
                <select name="ciudad" class="inputBig" id="ciudad"> 
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
              <div>
                <label for="codigoPostal">C.P.</label>
                <input type="text" name="codigoPostal" class="inputSmall" id="codigoPostal" maxlength="5" placeholder="Ej.55665"/> 
            </div>
        </div>
        <div class="row d-flex justify-content-between p-1">
            <div>
                <label for="correo">Correo:</label>
                <input type="text" name="correo" class="inputLarge" id="correo" maxlength="100" placeholder="nombre.apellido@dominio.com"/> 
            </div>
             <div>
                <label for="rfc">RFC:</label>
                <input type="text" name="rfc" class="inputMedium text-uppercase" id="rfc" maxlength="25" placeholder="Ingresa RFC"/> 
            </div>
          
            <div>
                <label for="fechaAlta">Fecha Alta:</label>
                <input type='text' name="fechaAlta" id="fechaAlta" class="inputSelectMin" readOnly />
            </div>

        </div>
        <div class="row p-1">
            <div class="col-12 text-center">
                <div >
                    <ul class="error text-left" id="error">
                        <?php if (isset($_SESSION['errores']['nombre']) && $_SESSION['errores']['nombre'] == 'invalid'): ?>
                            <li>El <b>nombre</b> de Cliente ya existe</li>                   
                        <?php endif; ?>
                        <?php if (isset($_SESSION['errores']['clave']) && $_SESSION['errores']['clave'] == 'invalid'): ?>
                            <li>La <b>clave</b> de Cliente ya existe</li>                
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
<section class="sec-tabla sec-big text-center table-responsive-sm" id="seccionCliente">
    <?php if (!empty($clientes)): ?>
        <table class=" table-condensed tabla-big" id="tablaCliente">
            <thead class="titulos-datos" id="titulos">
            <th></th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th></th>
            </thead>
            <tbody>
                <?php foreach ($clientes as $c): ?>             
                    <tr class="tr">
                        <td><span class="material-icons pt-1 i-add" id="show">add_box</span></td>
                        <td class="text-left w-30"><?= $c->nombre; ?></td>
                        <td ><?= $c->contacto; ?></td>
                        <td ><?= $c->telefono; ?></td>
                        <td ><?= $c->correo; ?></td>
                        <td ><?= $c->direccion; ?></td>
                        <td ><?= $c->ciudad_completa; ?></td>
                        <td> 
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteCliente&id=<?= $c->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-top text-left" id="tbDatos">  
                        <td class="td-datos">
                            <strong>Cliente:</strong></br> <div> <label id="nombreTabla"><?= $c->nombre; ?></label></div>
                            <strong>Contacto:</strong></br> <div> <label id="contactoTabla"><?= $c->contacto; ?></label></div>
                            <strong>Teléfono:</strong></br>  <div><label id="telefonoTabla"><?= $c->telefono; ?></label> </div>
                            <strong>Correo:</strong></br><div>  <label id="correoTabla"><?= $c->correo; ?></label></div>
                            <strong>RFC:</strong></br><div> <label id="rfcTabla"><?= $c->rfc; ?></label></div>
                        </td>
                        <td class="td-datos text-left">
                            <strong>Dirección:</strong></br> <div><label id="direccionTabla"><?= $c->direccion; ?></label></div>
                            <strong>Ciudad:</strong></br> <div> <label id="ciudadTabla"><?= $c->ciudad_completa; ?></label></div>
                            <strong>C.P.</strong></br> <div> <label id="codPostalTabla"><?= $c->codigo_postal == 0 ? "" : $c->codigo_postal; ?></label> </div>
                            <strong>Fecha Alta:</strong></br> <div> <label id="fechaAltaTabla"><?= $c->fecha_alta == '' ? '' : date('d/m/Y', strtotime($c->fecha_alta)); ?></label> </div>
                        </td>
                         
                        <td> 
                            <div class="py-5 ">
                                <span class="material-icons i-clear" id="clear">clear</span>
                            </div>
                            <div>
                                <a ><span id="edit" class="material-icons i-edit" title="Editar">edit</span></a>                    
                                <a id="linkDelete" href="<?= catalogosUrl ?>?controller=Catalogo&action=deleteCliente&id=<?= $c->id; ?>" ></a><span id="delete" class="material-icons i-delete" title="Eliminar">delete_forever</span>
                            </div>
                        </td>
                        <td hidden>
                            <span id="idTabla"><?= $c->id; ?></span>
                            <span id="ciudadIdTabla"><?= $c->ciudad_id; ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay clientes registrados</span>                   
    <?php endif; ?>
</section>