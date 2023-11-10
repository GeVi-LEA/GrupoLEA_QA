<aside class="aside" id="aside">
    <ul>
        <li title="Compras">
            <a href="<?= principalUrl ?>?controller=Compras&action=index"><i class="material-icons">local_mall</i><span class="hidden">Compras</span></a><i id="dropMenu"
                class="material-icons expand-menu rotar90">expand_more</i>
        </li>
        <ul class="menu-drop transparent hidden" id="subMenu">
            <li>
                <a href="<?= principalUrl ?>?controller=Compras&action=requisiciones"><i class="fas fa-circle i-list-circle"></i>Requisiciones</a>
            </li>
            <li>
                <a href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra"><i class="fas fa-circle i-list-circle"></i>Orden compra</a>
            </li>
            <li>
                <a href="<?= principalUrl ?>?controller=Compras&action=embarques"><i class="fas fa-circle i-list-circle"></i>Embarques</a>
            </li>
        </ul>
        <li>
            <i class="material-icons">science</i><span class="hidden">Laboratorio</span>
        </li>
        <li>
            <i class="material-icons">engineering</i><span class="hidden">Producción</span>
        </li>
        <li>
            <div>
                <span class="material-icons pr-1">home_work</span><span class="hidden">Almacén</span>
                <i id="dropMenu" class="material-icons expand-menu rotar90">expand_more</i>
            </div>
        </li>
        <ul class="menu-drop transparent hidden" id="subMenu">
            <li title="Almacén básicos">
                <a href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos">
                    <i class="fas fa-circle i-list-circle"></i>Básicos</a>
            </li>
        </ul>
        <li title="Servicios">
            <a href="<?= principalUrl ?>?controller=Servicios&action=index"><i class="fa-solid fa-handshake-simple pr-1"></i><span class="hidden">Servicios</span></a>
            <i id="dropMenu" class="material-icons expand-menu rotar90">expand_more</i>
        </li>
        <ul class="menu-drop transparent hidden" id="subMenu">
            <li>
                <a href="<?= principalUrl ?>?controller=Servicios&action=ensacado"><i class="fas fa-circle i-list-circle"></i>Logistica</a>
            </li>
            <li>
                <a href="<?= principalUrl ?>?controller=Servicios&action=serviciosNave"><i class="fas fa-circle i-list-circle"></i>Nave 4</a>
            </li>
            <!-- <li><a href="<?= principalUrl ?>?controller=Servicios&action=serviciosAlmacen"><i class="fas fa-circle i-list-circle"></i>Almacenaje</a></li> -->
            <li>
                <a href="<?= principalUrl ?>?controller=Servicios&action=almacenamientoPiso"><i class="fas fa-circle i-list-circle"></i>Almacenaje</a>
            </li>
            <!-- <li><a href="<?= principalUrl ?>?controller=Servicios&action=almacenamientoPiso"><i class="fas fa-circle i-list-circle"></i>Alm. Piso</a></li> -->
            <li>
                <a href="<?= principalUrl ?>?controller=Servicios&action=monitorEntradas"><i class="fas fa-circle i-list-circle"></i>Mon. Entradas</a>
            </li>
        </ul>
        <li>
            <div>
                <i class="fas fa-laptop pr-1"></i>
                <span class="hidden">Sistemas</span>
                <i id="dropMenu" class="material-icons expand-menu rotar90">expand_more</i>
            </div>
        </li>
        <ul class="menu-drop transparent hidden" id="subMenu">
            <li title="Solicitudes de servicio sistemas">
                <a href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes""><i class=" fas fa-circle i-list-circle"></i>Solicitudes</a>
            </li>
            <?php if (Utils::isAdmin() || Utils::isSistemas()): ?>
            <li title="Mantenimientos de equipos">
                <a href="<?= principalUrl ?>?controller=Sistemas&action=mantenimientos""><i class=" fas fa-circle i-list-circle"></i>Mantenimiento</a>
            </li>
            <?php endif; ?>
        </ul>
    </ul>
</aside>
<div class="principal">