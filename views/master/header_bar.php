<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar navs-sticky">
    <div class="container-fluid navbar-inner">
        <a href="<?= URL ?>views/master/?controller=Compras&action=index" class="navbar-brand">
            <img src="<?= URL ?>assets/images/logo_lea-sm.png" alt="" height="22">
            <h4 class="logo-title"><?= APP_NAME ?></h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" height="20px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>
        <div class='d-flex'>
            <div class="ms-1 header-item d-none d-sm-flex titulo">
                <span id="master_title" style="font-size: 1.5rem;/*margin-left: 450%;*/"><?= (isset($_SESSION['title'])) ? $_SESSION['title'] : '' ?></span>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1 mt-2"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto  navbar-list mb-2 mb-lg-0">
                <li class="nav-item me-3">
                </li>
                <li>
                    <div class="light-ico">
                        <div class="nav-link" data-setting="color-mode" data-name="color" data-value="light" style="color: white;">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="dark-ico">
                        <div class="nav-link" data-setting="color-mode" data-name="color" data-value="dark">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M9,2C7.95,2 6.95,2.16 6,2.46C10.06,3.73 13,7.5 13,12C13,16.5 10.06,20.27 6,21.54C6.95,21.84 7.95,22 9,22A10,10 0 0,0 19,12A10,10 0 0,0 9,2Z"></path>
                            </svg>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown noti-icon">
                    <a href="#" class="nav-link" id="notification-drop" data-bs-toggle="dropdown">
                        <svg width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.7695 11.6453C19.039 10.7923 18.7071 10.0531 18.7071 8.79716V8.37013C18.7071 6.73354 18.3304 5.67907 17.5115 4.62459C16.2493 2.98699 14.1244 2 12.0442 2H11.9558C9.91935 2 7.86106 2.94167 6.577 4.5128C5.71333 5.58842 5.29293 6.68822 5.29293 8.37013V8.79716C5.29293 10.0531 4.98284 10.7923 4.23049 11.6453C3.67691 12.2738 3.5 13.0815 3.5 13.9557C3.5 14.8309 3.78723 15.6598 4.36367 16.3336C5.11602 17.1413 6.17846 17.6569 7.26375 17.7466C8.83505 17.9258 10.4063 17.9933 12.0005 17.9933C13.5937 17.9933 15.165 17.8805 16.7372 17.7466C17.8215 17.6569 18.884 17.1413 19.6363 16.3336C20.2118 15.6598 20.5 14.8309 20.5 13.9557C20.5 13.0815 20.3231 12.2738 19.7695 11.6453Z"
                                fill="currentColor"></path>
                            <path opacity="0.4"
                                d="M14.0088 19.2283C13.5088 19.1215 10.4627 19.1215 9.96275 19.2283C9.53539 19.327 9.07324 19.5566 9.07324 20.0602C9.09809 20.5406 9.37935 20.9646 9.76895 21.2335L9.76795 21.2345C10.2718 21.6273 10.8632 21.877 11.4824 21.9667C11.8123 22.012 12.1482 22.01 12.4901 21.9667C13.1083 21.877 13.6997 21.6273 14.2036 21.2345L14.2026 21.2335C14.5922 20.9646 14.8734 20.5406 14.8983 20.0602C14.8983 19.5566 14.4361 19.327 14.0088 19.2283Z"
                                fill="currentColor"></path>
                        </svg>

                        <span class="noti-dot bg-danger rounded-pill"></span>
                    </a>
                    <div class="sub-drop dropdown-menu dropdown-menu-end p-0" aria-labelledby="notification-drop">
                        <div>
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-15"> Notificaciones </h5>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons todoleido" data-toggle="tooltip" data-placement="top" title="Marcar todo como leído">visibility_off</i>
                                        <i class="material-icons tododelete" data-toggle="tooltip" data-placement="top" title="Borrar todo">delete</i>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="" class="contenedor-noti">
                                <div class='notificaciones-lista'>

                                </div>
                            </div>
                        </div>
                    </div>


                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if ($_SESSION['usuario']->imagen != null): ?>
                        <img src="<?= root_url ?>views/catalogos/uploads/imgUsuarios/<?= $_SESSION['usuario']->imagen ?>" style="max-height: 40px;">
                        <?php else: ?>
                        <img src="../../assets/img/user.jpg" style="max-height: 40px;">
                        <?php endif; ?>
                        <div class="caption ms-3 d-none d-md-block ">
                            <h6 class="mb-0 caption-title"><?= strtok($_SESSION['usuario']->nombres, ' ') . ' ' . strtok($_SESSION['usuario']->apellidos, ' ') ?></h6>
                            <p class="mb-0 caption-sub-title text-capitalize"><?= $_SESSION['usuario']->puesto ?></p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= principalUrl ?>?controller=Login&action=perfil">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= root_url ?>?controller=Login&action=logOut">Salir</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>