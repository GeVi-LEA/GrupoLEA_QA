  <?php
define('root', __DIR__);

session_start();
require_once './../../config/parameters.php';
require_once './../../config/autoload.php';
require_once './../../config/db.php';
require_once './../../utils/utils.php';

if (isset($_GET['ajax'])) {
    llamarController();
} else {
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogos LEA</title>
        <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css"> 
        <link rel="stylesheet" href="../../assets/fonts/material-icons/css/material-icons.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
        <link rel="stylesheet" href="../../assets/fonts/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="../../assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="assets/css/catalogos.css"> 
        <script src="../../assets/js/jquery-3.5.1.min.js"></script>
        <script src="../../assets/js/jquery-confirm.js"></script> 
        <link rel="stylesheet" href="../../assets/css/jquery-ui/jquery-ui.min.css">
        <script src="../../assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/funcionesCatalogo.js"></script> 
    
    </head>
    <body>
        <div class="container" id="container">
            <?php
            llamarController();
            ?>
        </div>
    </body>
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script> 
    <script src="../../assets/js/popper.min.js"></script>
    <script src="assets/js/funcionesJSCatalogo.js"></script> 
</html>
      <?php
}
      function llamarController(){
            if (isset($_GET['controller'])) {

                $nombre_controlador = $_GET['controller'] . 'Controller';
            } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
                $nombre_controlador = controller_default_catalogos;
            } else {
                show_error();
                exit();
            }

            if (class_exists($nombre_controlador)) {
                $controlador = new $nombre_controlador();
                if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                    $action = $_GET['action'];
                    $controlador->$action();
                } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
                    $default = action_default;
                    $controlador->$default();
                } else {
                    show_error();
                }
            } else {
                show_error();
            }
      }
      
         function show_error() {
                $error = new errorController();
                $error->index();
            }
            ?>