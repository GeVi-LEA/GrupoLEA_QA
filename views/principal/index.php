<?php
define('root', __DIR__);
session_start();
ob_start();
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
require_once './../../config/parameters.php';
require_once './../../config/autoload.php';
require_once './../../config/db.php';
require_once './../../utils/utils.php';

  if (isset($_GET['ajax'])) {
    llamarController();
} else {
    require_once views_root . 'principal/header.php';
    require_once views_root . 'principal/aside.php';
    function show_error() {
        $error = new errorController();
        $error->index();
    }
    llamarController();
    require_once views_root . 'principal/footer.php';
}

function llamarController() {
    if (isset($_GET['controller'])) {

        $nombre_controlador = $_GET['controller'] . 'Controller';
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $nombre_controlador = controller_principal;
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


