
<header class="header">
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div> <a href="index.php"> <img src="../../assets/img/logo_lea_260.png" alt="Logo LEA"></a></div>
            <div><h1 class="titulo">Catálogos</h1></div>
            <div><a><span class="material-icons mt-3 i-close" id="i-close" title="Cerrar">cancel</span></a></div>
        </div>
</header>
<div class="row">
    <div class ="col-md-6 col-lg-3 p-1">
        <div class=" item-medium">    
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showProveedores"><i class="material-icons icon">groups</i><span>Proveedores</span></a>
        </div>
    </div>
    <div class ="col-md-6 col-lg-3 p-1">
        <div class="item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposSolicitudes"><i class="material-icons">shopping_cart</i><span>Servicios/Adquisiciones</span></a>
        </div>
    </div>
    <div class ="col-md-6 col-lg-3 p-1">
        <div class="item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showCiudades"> <i class="fas fa-map-marked-alt icon"></i><span>Ciudades</span></a>
        </div>
    </div>
    <div class ="col-md-6 col-lg-3 p-1">
        <div class=" item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTipoTransporte"> <i class="fas fa-truck"></i>  <span>Transportes</span></a>
        </div>
    </div>
</div>
<div class="row">
    <div class ="col-md-6 col-lg-3 p-1">
        <div class=" item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showRutas"><i class="fas fa-road"></i><span>Rutas</span></a>
        </div>
    </div>
    <div class ="col-md-6 col-lg-3 p-1">
        <div class="item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showClientes"><i class="fas fa-people-arrows"></i><span>Clientes</span></a>
        </div>
    </div>
    <div class ="col-md-6 col-lg-3 p-1">
        <div class="item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showUnidades"> <i class="fas fa-ruler icon"></i><span>Unidades medida</span></a>
        </div>
    </div>
        <div class ="col-md-6 col-lg-3 p-1">
        <div class="item-medium">
            <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showProductos"> <i class="fas fa-flask icon"></i><span>Productos</span></a>
        </div>
    </div>    
  </div>
 <div class="row">
        <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showProductosResinasLiquidos">  <i class="fa-solid fa-bottle-water icon"></i><span>Productos resinas/liquidos</span></a>
            </div>
        </div>
        <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showTiposEmpaques">  <i class="fa-solid fa-box-open icon"></i><span>Tipos empaques</span></a>
            </div>
        </div>
        <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showServicios">  <i class="fa-solid fa-pallet icon"></i><span>Servicios</span></a>
            </div>
        </div>
       <?php if (Utils::isAdmin()): ?>
             <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showDocumentosNorma">  <i class="far fa-file-alt icon"></i><span>Documentos norma</span></a>
            </div>
        </div>
     </div>
 <div class="row">
       <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showDepartamentos"><i class="fas fa-industry icon"></i><span>Departamentos</span></a>
            </div>
        </div>
     <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showUsuarios"><i class="fas fa-user-circle icon"></i><span>Usuarios</span></a>
            </div>
        </div>
        <div class ="col-md-6 col-lg-3 p-1">
            <div class=" item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showEstatus"><i class="fas fa-info-circle"></i><span>Estatus</span></a>
            </div>
        </div>
        <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showEquipoComputo">  <i class="fas fa-laptop icon"></i><span>Equipo cómputo</span></a>
            </div>
        </div>
        <?php endif; ?>
     </div>
 <div class="row">
       <div class ="col-md-6 col-lg-3 p-1">
            <div class="item-medium">
                <a href="<?= catalogosUrl ?>?controller=Catalogo&action=showAlmacenes"><i class="fas fa-boxes icon"></i><span>Almacenes</span></a>
            </div>
        </div>

     </div>
