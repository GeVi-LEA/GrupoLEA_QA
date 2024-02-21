<div class="position-relative">

    <aside class="sidebar sidebar-default sidebar-base sidebar-boxed navs-pill-all sidebar-transparent">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="<?= URL . 'views/principal/?controller=Compras&action=index' ?>" class="navbar-brand">
                <img src="<?= URL ?>assets/img/logo_lea_260.png" alt="" height="42">
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
                            <a class="nav-link" data-bs-toggle="collapse" href="#sidebarCompras" role="button" aria-expanded="false" aria-controls="sidebarCompras">
                                <!-- <i class="las la-shopping-bag "></i> -->
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
                                    <a class="nav-link active" href="<?= URL . 'views/principal/?controller=Compras&action=requisiciones' ?>">
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
                                    <a class="nav-link {{activeRoute(route('compras.ordencompra'))}}" href="{{route('compras.ordencompra')}}">
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
                                    <a class="nav-link {{activeRoute(route('compras.embarques'))}}" href="{{route('compras.embarques')}}">
                                        <i class="icon svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.shipments_short') </i>
                                        <span class="item-name">@lang('translation.shipments')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Compras Menu -->
                        <!-- start Laboratorio Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLaboratorio" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLaboratorio">
                                <i class="fa-solid fa-droplet fa-xl"></i>
                                <span class="item-name">@lang('translation.laboratory')</span>
                                <!-- <i class="right-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </i> -->
                            </a>
                            <!-- <ul class="sub-nav collapse" id="sidebarLaboratorio" data-bs-parent="#sidebar">
                <li class=" nav-item ">
                    <a class="nav-link {{activeRoute(route('compras.ordencompra'))}}" href="{{route('compras.ordencompra')}}">
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
                            <a class="nav-link menu-link" href="#sidebarProduccion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduccion">
                                <i class="fa-solid fa-diagram-project fa-xl"></i>
                                <span class="item-name">@lang('translation.production')</span>
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
                            <a class="nav-link menu-link" href="#sidebarAlmacen" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAlmacen">
                                <i class="fa-solid fa-warehouse fa-xl"></i>
                                <span class="item-name">@lang('translation.warehouse')</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebarAlmacen" data-bs-parent="#sidebar">
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('almacen.basicos'))}}" href="{{route('almacen.basicos')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.basic_short') </i>
                                        <span class="item-name">@lang('translation.basic')</span>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <!-- end Almacen Menu -->

                        <!-- start Servicios Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarServicios" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarServicios">
                                <i class="fa-solid fa-handshake fa-xl"></i>
                                <span class="item-name">@lang('translation.Services')</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebarServicios" data-bs-parent="#sidebar">
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('servicios.logistica'))}}" href="{{route('servicios.logistica')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.logistic_short') </i>
                                        <span class="item-name">@lang('translation.logistic')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('servicios.nave4'))}}" href="{{route('servicios.nave4')}}">
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
                                    <a class="nav-link {{activeRoute(route('servicios.almacenpiso'))}}" href="{{route('servicios.almacenpiso')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.storage_short') </i>
                                        <span class="item-name">@lang('translation.storage')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('servicios.monentradas'))}}" href="{{route('servicios.monentradas')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.entrymonitor_short') </i>
                                        <span class="item-name">@lang('translation.entrymonitor')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Servicios Menu -->

                        <!-- start Sistemas Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarSistemas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSistemas">
                                <i class="fa-solid fa-laptop-code fa-xl"></i>
                                <span class="item-name" data-key="t-landing">@lang('translation.systems') </span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebarSistemas" data-bs-parent="#sidebar">
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('sistemas.solicitudes'))}}" href="{{route('sistemas.solicitudes')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.request_short') </i>
                                        <span class="item-name">@lang('translation.request')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('sistemas.mantenimiento'))}}" href="{{route('sistemas.mantenimiento')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>

                                        <i class="sidenav-mini-icon"> @lang('translation.maintenance_short') </i>
                                        <span class="item-name">@lang('translation.maintenance')</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!-- end Sistemas Menu -->

                        <!-- start Catalogos Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCatalogos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCatalogos">
                                <i class="fa-solid fa-book fa-xl"></i>
                                <span class="item-name" data-key="t-landing">@lang('translation.catalogs') </span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebarCatalogos" data-bs-parent="#sidebar">
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.proveedores'))}}" href="{{route('catalogos.proveedores')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.proveedores_short') </i>
                                        <span class="item-name">@lang('translation.proveedores')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.servadq'))}}" href="{{route('catalogos.servadq')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.servadq_short') </i>
                                        <span class="item-name">@lang('translation.servadq')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.ciudades'))}}" href="{{route('catalogos.ciudades')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.ciudades_short') </i>
                                        <span class="item-name">@lang('translation.ciudades')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.transportes'))}}" href="{{route('catalogos.transportes')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.transportes_short') </i>
                                        <span class="item-name">@lang('translation.transportes')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.rutas'))}}" href="{{route('catalogos.rutas')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.rutas_short') </i>
                                        <span class="item-name">@lang('translation.rutas')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.clientes'))}}" href="{{route('catalogos.clientes')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.clientes_short') </i>
                                        <span class="item-name">@lang('translation.clientes')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.unidadesmedida'))}}" href="{{route('catalogos.unidadesmedida')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.unidadesmedida_short') </i>
                                        <span class="item-name">@lang('translation.unidadesmedida')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.productos'))}}" href="{{route('catalogos.productos')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.productos_short') </i>
                                        <span class="item-name">@lang('translation.productos')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.productosresina'))}}" href="{{route('catalogos.productosresina')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.productosresinas_short') </i>
                                        <span class="item-name">@lang('translation.productosresinas')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.tiposembarque'))}}" href="{{route('catalogos.tiposembarque')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.tipoembarques_short') </i>
                                        <span class="item-name">@lang('translation.tipoembarques')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.servicios'))}}" href="{{route('catalogos.servicios')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.Services_short') </i>
                                        <span class="item-name">@lang('translation.Services')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.documentosnorma'))}}" href="{{route('catalogos.documentosnorma')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.documentosnorma_short') </i>
                                        <span class="item-name">@lang('translation.documentosnorma')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.departamentos'))}}" href="{{route('catalogos.departamentos')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.departamentos_short') </i>
                                        <span class="item-name">@lang('translation.departamentos')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.usuarios'))}}" href="{{route('catalogos.usuarios')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.usuarios_short') </i>
                                        <span class="item-name">@lang('translation.usuarios')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.estatus'))}}" href="{{route('catalogos.estatus')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.estatus_short') </i>
                                        <span class="item-name">@lang('translation.estatus')</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.equipocomputo'))}}" href="{{route('catalogos.equipocomputo')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> E C </i>
                                        <span class="item-name"> Equipo Computo</span>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a class="nav-link {{activeRoute(route('catalogos.almacenes'))}}" href="{{route('catalogos.almacenes')}}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> @lang('translation.almacenes_short') </i>
                                        <span class="item-name">@lang('translation.almacenes')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end Catalogos Menu -->
                    </ul>
                </ul>
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>

</div>
<main class="main-content">

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <br />
        <br />