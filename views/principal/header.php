<!DOCTYPE html>
<html lang="es">

<head>
      <title>Grupo LEA de México</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/png" href="../../assets/img/gpl.ico" />
      <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css">
      <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap-extended.min.css">
      <link rel="stylesheet" href="../../assets/fonts/material-icons/css/material-icons.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link rel="stylesheet" href="../../assets/fonts/fontawesome/css/all.min.css">
      <link rel="stylesheet" href="../../assets/fonts/materialdesign/materialdesign.icons.css">
      <link rel="stylesheet" href="../../assets/css/jquery-confirm.css">
      <script src="../../assets/js/jquery-3.5.1.min.js"></script>
      <script src="../../assets/js/jquery-confirm.js"></script>
      <link rel="stylesheet" href="../../assets/css/jquery-ui/jquery-ui.min.css">
      <script src="../../assets/js/jquery-ui.min.js"></script>
      <link rel="stylesheet" href="../../assets/css/style.css">
      <script src="../../assets/js/jquery.js"></script>
      <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
      <link rel="stylesheet" href="../../assets/js/sweetalert/themes/bulma/bulma.css">
      <!-- <link rel="stylesheet" href="../../assets/js/sweetalert/sweetalert2.all.min.css"> -->
      <script src="../../assets/js/sweetalert/sweetalert2.all.min.js"></script>

      <link rel="stylesheet" href="../../assets/js/toaster/toast.min.css">
      <script src="../../assets/js/toaster/toast.min.js"></script>

      <link rel="stylesheet" href="../../assets/libs/animation/animate.css">
      <script src="../../assets/libs/animation/jquery.appear.js"></script>

      <script type='text/javascript' src='../servicios/assets/js/servicios.js'></script>

      <script>
      let __url__ = "<?php echo root_url; ?>";
      localStorage.setItem("_URL_", __url__);

      function erpalert(
            tipo = "",
            title = "Hecho!",
            texto = "",
            subtitle = "",
            time = "3500",
            show = "slideDown",
            hide = "slideUp"
      ) {
            if (tipo == "") {
                  tipo = "success";
            }

            $.toast({

                  title: title,

                  subtitle: subtitle,

                  content: texto,

                  type: tipo,

                  delay: time,

                  dismissible: true,


            });
      }
      </script>
</head>

<body>
      <div class="contenedor">
            <header class="header">
                  <div class='row' style="width:90vw;">
                        <div class='col-7'>
                              <div> <a href="?controller=Principal&action=index"> <img src="../../assets/img/logo_lea_260.png" alt="Logo LEA"></a></div>
                        </div>
                        <div class='col-2 '>
                              <div class='row'>
                                    <div class='col-4 abrirDirectorio'>
                                          <?php if (Utils::permisosCompras()): ?>
                                          <li><a href="" id="abrirDirectorio"><i class="fas fa-address-book icon i-catalogo"></i><span>Directorio</span></a></li>
                                    </div>
                                    <div class='col-4 abrirCatalogo'>
                                          <li><a href="" id="abrirCatalogo"><i class="fas fa-book-open icon i-catalogo"></i><span>Catálogos</span></a></li>
                                          <?php endif; ?>
                                    </div>
                                    <div class='col-4'>
                                          <li><a href="<?= root_url ?>?controller=Login&action=logOut"><i class="fas fa-sign-out-alt icon i-exit"></i><span class="hidden">Salir</span></a></li>
                                    </div>
                              </div>
                        </div>
                        <div class='col-3'>
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
                                          <img src="../../assets/img/user.jpg">
                                          <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                              </div>
                        </div>
                  </div>

            </header>