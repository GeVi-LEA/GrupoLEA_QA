<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Grupo LEA de México</title>
            <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css"> 
            <link rel="icon" type="image/png" href="assets/img/gpl.ico"/>
            <link rel="stylesheet" href="assets/fonts/material-icons/css/material-icons.css">
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.min.css">
            <link rel="stylesheet" href="assets/css/jquery-confirm.css">
            <link rel="stylesheet" href="views/login/assets/css/login.css"> 
            <script src="assets/js/jquery-3.5.1.min.js"></script>
            <script src="assets/js/jquery-confirm.js"></script> 
            <link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui.min.css">
            <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.backstretch.min.js"></script>
            <script src="views/login/assets/js/login.js"></script> 
    </head>
            <body>
                <div class="container">
                    <div class="contenedor-form">
                    <?php 
                    if(empty($_GET)):     
                       require_once "formLogin.php" ;
                     else:
                       require_once "formRecupera.php";
                     endif; ?>
                    </div>

                    <footer class="footer justify-self-end">
                        <p>
                            <span>&copy; <?php echo date('Y') ?> Grupo LEA de M&eacute;xico</span> <span> <a href="http://leademexico.com" target="_blank"> leademexico.com</a></span> <span>Todos los derechos reservados.</span>
                        </p>
                    </footer>

                    <!-- Modal -->
                    <div class="modal fade" id="recuperaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titleModal"><span class="fas fa-exclamation-circle i-warning"></span>Recuperar contraseña</h5>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Se enviara un link de recuperación de password al correo <b><?=  isset($_SESSION['usuario']) ? $_SESSION['usuario']->correo : ""; ?></b></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <a href="<?= root_url ?>?controller=Login&action=correoRecupera" class="btn loginBtn">Enviar</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </body>
        <script src="assets/js/bootstrap/bootstrap.min.js"></script> 
        <script src="assets/js/popper.min.js"></script>
        </html>
