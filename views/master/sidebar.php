<aside class="sidebar sidebar-default sidebar-base sidebar-boxed navs-pill-all sidebar-transparent">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="<?php echo URL; ?>views/master/?controller=Home&action=home" class="navbar-brand">
            <img src="<?php echo URL; ?>assets/images/logo_lea-sm.png" alt="" height="42">
            <h4 class="logo-title"><?= APP_NAME ?></h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list" id="sidebar">
            <ul class="navbar-nav iq-main-menu" id="sidebar">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Menu</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <ul class="navbar-nav" id="navbar-nav">

                    <!-- start Compras Menu -->
                    <li class="nav-item">
                        <a class="nav-link <?php if (!Utils::permisosCompras()) { echo 'disabled'; } ?>" data-bs-toggle="collapse" href="#sidebarCompras" role="button" aria-expanded="false" aria-controls="sidebarCompras">
                            <i class="fa-solid fa-bag-shopping fa-xl"></i>
                            <span class="item-name">Compras</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebarCompras" data-bs-parent="#sidebar">
                            <li class="nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Compras&action=requisiciones', 'Requisiciones') ?>" href="<?= principalUrl ?>?controller=Compras&action=requisiciones">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> R </i>
                                    <span class="item-name"> Requisiciones </span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Compras&action=ordenesDeCompra', 'Ordenes de Compra') ?>" href="<?= principalUrl ?>?controller=Compras&action=ordenesDeCompra">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> O C </i>
                                    <span class="item-name">Ordenes de Compra</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Compras&action=embarques', 'Embarques') ?>" href="<?= principalUrl ?>?controller=Compras&action=embarques">
                                    <i class="icon svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> E </i>
                                    <span class="item-name">Embarques</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Compras Menu -->

                    <!-- start Laboratorio Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link disabled" href="#sidebarLaboratorio" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLaboratorio">
                            <i class="fa-solid fa-droplet fa-xl"></i>
                            <span class="item-name">Laboratorio</span>
                            <!-- <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i> -->
                        </a>
                        <!-- <ul class="sub-nav collapse" id="sidebarLaboratorio" data-bs-parent="#sidebar">
                                <li class=" nav-item ">
                                    <a class="nav-link <?php activeRoute(principalUrl . '?controller=Compras&action=ordencompra') ?>" href="<?= principalUrl ?>?controller=Compras&action=ordencompra" >
                                        <i class="icon">
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.purchaseorder_short') </i>
                                        <span class="item-name">@lang('translation.purchaseorder')</span>
                                    </a>
                                </li>
                            </ul> -->
                    </li>
                    <!-- end Laboratorio Menu -->

                    <!-- start Produccion Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link disabled" href="#sidebarProduccion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduccion">
                            <i class="fa-solid fa-diagram-project fa-xl"></i>
                            <span class="item-name">Producción</span>
                            <!-- <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i> -->
                        </a>
                        <!-- <div class="collapse menu-dropdown" id="sidebarProduccion">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="layouts-horizontal" target="_blank" class="nav-link">@lang('translation.horizontal')</a>
                                </li>
                                
                            </ul>
                        </div> -->
                    </li>
                    <!-- end Produccion Menu -->

                    <!-- start Almacen Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link <?php if (!Utils::permisosAlmacen()) { echo 'disabled'; } ?>" href=" #sidebarAlmacen" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAlmacen">
                            <i class="fa-solid fa-warehouse fa-xl"></i>
                            <span class="item-name">Almacén</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebarAlmacen" data-bs-parent="#sidebar">
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Almacen&action=almacenBasicos', 'Básicos') ?>" href="<?= principalUrl ?>?controller=Almacen&action=almacenBasicos">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon"> B </i>
                                    <span class="item-name">Básicos</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <!-- end Almacen Menu -->

                    <!-- start Servicios Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link <?php if (!Utils::permisosSupervisor() and !Utils::permisosBascula()) { echo 'disabled'; } ?>" href=" #sidebarServicios" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarServicios">
                            <i class="fa-solid fa-handshake fa-xl"></i>
                            <span class="item-name">Servicios</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebarServicios" data-bs-parent="#sidebar">
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Servicios&action=ensacado', 'Ensacado') ?>" href="<?= principalUrl ?>?controller=Servicios&action=ensacado">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">E</i>
                                    <span class="item-name">Ensacado</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Servicios&action=serviciosNave', 'Nave 4') ?>" href="<?= principalUrl ?>?controller=Servicios&action=serviciosNave">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon"> N4 </i>
                                    <span class="item-name">Nave 4</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Servicios&action=almacenamientoPiso', 'Almacenaje') ?>" href="<?= principalUrl ?>?controller=Servicios&action=almacenamientoPiso">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon">A</i>
                                    <span class="item-name">Almacenaje</span>
                                </a>
                            </li>
                            <!-- start Reportes Menu -->
                            <li class=" nav-item ">
                                <a class="nav-link menu-link <?php activeSubMenu('rep') ?> <?php if (!Utils::permisosSupervisor()) { echo 'disabled'; } ?>" href=" #sidebarServiciosReportes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarServiciosReportes">
                                    <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                                    <span class="item-name">Reportes</span>
                                    <i class="right-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </i>
                                </a>
                                <ul class="sub-nav collapse" id="sidebarServiciosReportes" data-bs-parent="#sidebarServicios">
                                    <li class=" nav-item ">
                                        <a class="nav-link <?php activeRoute(principalUrl . '?controller=Servicios&action=rep_serv_ensacado', 'Reporte Servicios Ensacado') ?>" href="<?= principalUrl ?>?controller=Servicios&action=rep_serv_ensacado">
                                            <i class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                    <g>
                                                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                    </g>
                                                </svg>
                                            </i>

                                            <i class="sidenav-mini-icon">RSE</i>
                                            <span class="item-name">Rep. Serv. Ensacado</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <!-- end Reportes Menu -->

                            <li class=" nav-item " hidden>
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Servicios&action=monitorEntradas', 'Monitor Entradas') ?>" href="<?= principalUrl ?>?controller=Servicios&action=monitorEntradas">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon">M E</i>
                                    <span class="item-name">Monitor Entradas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Servicios Menu -->


                    <!-- start Sistemas Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link <?php if (!Utils::permisosSupervisor()) { echo 'disabled'; } ?>" href=" #sidebarSistemas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSistemas">
                            <i class="fa-solid fa-laptop-code fa-xl"></i>
                            <span class="item-name" data-key="t-landing">Sistemas</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebarSistemas" data-bs-parent="#sidebar">
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Sistemas&action=solicitudes', 'Solicitudes') ?>" href="<?= principalUrl ?>?controller=Sistemas&action=solicitudes">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon">S</i>
                                    <span class="item-name">Solicitudes</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Sistemas&action=mantenimientos', 'Mantenimientos') ?>" href="<?= principalUrl ?>?controller=Sistemas&action=mantenimientos">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon">M</i>
                                    <span class="item-name">Mantenimientos</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- end Sistemas Menu -->

                    <!-- start Catalogos Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link <?php if (!Utils::permisosSupervisor()) { echo 'disabled'; } ?>" href="#sidebarCatalogos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCatalogos">
                            <i class="fa-solid fa-book fa-xl"></i>
                            <span class="item-name" data-key="t-landing" id="abrirCatalogo">Catálogos</span>
                            <!--  <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i> -->
                        </a>
                        <!--    <ul class="sub-nav collapse" id="sidebarCatalogos" data-bs-parent="#sidebar"> 
                           <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showProveedores', 'Cat. Proveedores') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showProveedores">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">P</i>
                                    <span class="item-name">Proveedores</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showTiposSolicitudes', 'Cat. Servicios / Adquisiciones') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showTiposSolicitudes">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">S/A</i>
                                    <span class="item-name">Servicios/Adquisiciones</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showCiudades', 'Cat. Ciudades') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showCiudades">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">C</i>
                                    <span class="item-name">Ciudades</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showTipoTransporte', 'Cat. Transportes') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showTipoTransporte">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">T</i>
                                    <span class="item-name">Transportes</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showRutas', 'Cat. Rutas') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showRutas">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">R</i>
                                    <span class="item-name">Rutas</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showClientes', 'Cat. Clientes') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showClientes">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">C</i>
                                    <span class="item-name">Clientes</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showUnidades') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showUnidades">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">U M</i>
                                    <span class="item-name">Unidades Medida</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showProductos', 'Cat. Productos') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showProductos">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">P</i>
                                    <span class="item-name">Productos</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showProductosResinasLiquidos', 'Cat. Productos resinas/líquidos') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showProductosResinasLiquidos">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">P R</i>
                                    <span class="item-name">Productos resinas/liquidos</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showTiposEmpaques', 'Cat. Tipos de Embarques') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showTiposEmpaques">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">T E</i>
                                    <span class="item-name">Tipos Embarques</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showServicios', 'Cat. Servicios') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showServicios">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">S</i>
                                    <span class="item-name">Servicios</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showDocumentosNorma', 'Cat. Documentos Norma') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showDocumentosNorma">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">D N</i>
                                    <span class="item-name">Documentos Norma</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showDepartamentos', 'Cat. Departamentos') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showDepartamentos">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">D</i>
                                    <span class="item-name">Departamentos</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showUsuarios', 'Cat. Usuarios') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showUsuarios">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">U</i>
                                    <span class="item-name">Usuarios</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showEstatus', 'Cat. Estatus') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showEstatus">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">E</i>
                                    <span class="item-name">Estatus</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showEquipoComputo', 'Cat. Equipo Computo') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showEquipoComputo">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon">E C</i>
                                    <span class="item-name">Equipo Computo</span>
                                </a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link <?php activeRoute(principalUrl . '?controller=Catalogo&action=showAlmacenes', 'Cat. Almacénes') ?>" href="<?= principalUrl ?>?controller=Catalogo&action=showAlmacenes">
                                    <i class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> A </i>
                                    <span class="item-name">Almacénes</span>
                                </a>
                            </li>
                        </ul>-->
                    </li>
                    <!-- end Catalogos Menu -->
                </ul>
            </ul>
        </div>
        <br /><br />
    </div>
    <div class="sidebar-footer"></div>
</aside>


<?php
function activeRoute($url, $titulo = '')
{
    $actual_link         = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $respuesta           = '';
    $accion_url          = '';
    $accion_actual_link  = '';
    $explode_actual_link = explode('&', $actual_link);
    foreach ($explode_actual_link as $value) {
        if (str_contains(strtolower($value), 'action')) {
            $accion_actual_link = explode('=', $value)[1];
        }
    }
    $explode_url = explode('&', $url);
    foreach ($explode_url as $value) {
        if (str_contains(strtolower($value), 'action')) {
            $accion_url = explode('=', $value)[1];
        }
    }

    if ($accion_url == $accion_actual_link) {
        $respuesta         = 'active';
        $_SESSION['title'] = $titulo;
    }

    echo $respuesta;
}

function activeSubMenu($url)
{
    $actual_link         = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $respuesta           = '';
    $accion_url          = '';
    $accion_actual_link  = '';
    $explode_actual_link = explode('&', $actual_link);
    foreach ($explode_actual_link as $value) {
        if (str_contains(strtolower($value), 'action')) {
            $accion_actual_link = explode('=', $value)[1];
        }
    }
    $explode_url = explode('&', $url);
    foreach ($explode_url as $value) {
        if (str_contains(strtolower($value), 'action')) {
            $accion_url = explode('=', $value)[1];
        }
    }

    if (str_contains($accion_actual_link, $url)) {
        $respuesta = 'active';
    }

    echo $respuesta;
}
?>