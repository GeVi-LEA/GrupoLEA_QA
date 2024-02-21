<!DOCTYPE html>
<html lang="es">

<head>
    <title>Grupo LEA de México</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo URL; ?>assets/img/gpl.ico" />
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php echo URL; ?>assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-confirm.css">
    <script src="<?php echo URL; ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/jquery-confirm.js"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-ui/jquery-ui.min.css">
    <script src="<?php echo URL; ?>assets/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/style-app.css">
    <script src="<?php echo URL; ?>assets/js/jquery.js"></script>
    <script src="<?php echo URL; ?>assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/js/sweetalert/themes/bulma/bulma.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/js/sweetalert/sweetalert2.all.min.css"> -->
    <!-- <script src="<?php echo URL; ?>assets/js/sweetalert/sweetalert2.all.min.js"></script> -->
    <!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/js/toaster/toast.min.css"> -->
    <!-- <script src="<?php echo URL; ?>assets/js/toaster/toast.script.js"></script> -->
    <!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/js/toaster/jquery.toast.css"> -->
    <!-- <script src="<?php echo URL; ?>assets/js/toaster/jquery.toast.js"></script> -->
    <!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/libs/datatables/datatables.min.css"> -->
    <!-- <script src="<?php echo URL; ?>assets/libs/datatables/datatables.min.js"></script> -->


    <!-- <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/js/scripts/forms/select2/css/select2.min.css"> -->
    <!-- <script src="<?php echo URL; ?>assets/js/scripts/forms/select2/js/select2.min.js" type="text/javascript"></script> -->
    <script>
    var __url__ = "<?php echo root_url; ?>";
    localStorage.setItem("_URL_", __url__);
    // var elmenu;

    // function selectedMenu(menu) {

    // menu.target.parentElement.className = "selected";
    ////console.log(menu.target.parent());
    // }

    // $(document).ready(function() {
    // if ((localStorage.getItem("elmenu") != null) && (localStorage.getItem("elmenu") != "")) {
    // selectedMenu(localStorage.getItem("elmenu"));
    // }
    // $("#aside a").click(function(e) {
    // elmenu = e;
    // localStorage.setItem("elmenu", elmenu);
    // console.log("el menu: ", localStorage.getItem("elmenu"));
    //// e.preventDefault();
    //// elmenu = e.target.parentElement;
    // selectedMenu(e);

    // });
    // });
    </script>

</head>

<body>
    <div class="contenedor">
        <header class="header">
            <div> <a href="?controller=Principal&action=index"> <img src="<?php echo URL; ?>assets/img/logo_lea_260.png" alt="Logo LEA"></a></div>
            <nav class="menu">
                <ul>
                    <?php if (Utils::permisosCompras()): ?>
                    <li><a href="" id="abrirDirectorio"><i class="fas fa-address-book icon i-catalogo"></i><span>Directorio</span></a></li>
                    <li><a href="" id="abrirCatalogo"><i class="fas fa-book-open icon i-catalogo"></i><span>Catálogos</span></a></li>
                    <?php endif; ?>
                    <li><a href="<?= root_url ?>?controller=Login&action=logOut"><i class="fas fa-sign-out-alt icon i-exit"></i><span class="hidden">Salir</span></a></li>
                </ul>
            </nav>
            <div class="user">
                <div>
                    <?php if (isset($_SESSION['usuario'])): ?>
                    <span><?= strtok($_SESSION['usuario']->nombres, ' ') . ' ' . strtok($_SESSION['usuario']->apellidos, ' ') ?></span>
                    <span><?= $_SESSION['usuario']->puesto ?></span>
                </div>
                <div>
                    <?php if ($_SESSION['usuario']->imagen != null): ?>
                    <img src="<?= root_url ?>views/catalogos/uploads/imgUsuarios/<?= $_SESSION['usuario']->imagen ?>">
                    <?php else: ?>
                    <img src="<?php echo URL; ?>assets/img/user.jpg">
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </header>