<?php
define('root', __DIR__);
session_start();
ob_start();
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
// ob_clean();
require_once './../../config/parameters.php';
require_once './../../config/autoload.php';
require_once './../../config/db.php';

require_once './../../controllers/NotificacionesController.php';

require_once './../../utils/utils.php';

function getNotificaciones1()
{
    $notificaciones = new Notificaciones();
    return $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
    // return $_SESSION['notificaciones'];
    // echo json_encode(["mensaje" => "OK", "_notificaciones" => $_notificaciones]);
    // require views_root.'erp/notificaciones.php';
}

function llamarController()
{
    if (isset($_GET['controller'])) {
        $nombre_controlador = $_GET['controller'] . 'Controller';
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $nombre_controlador = controller_principal;
    } else {
        show_error();
        exit ();
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

function show_error()
{
    $error = new errorController();
    $error->index();
}

if ($_POST) {
    if (isset($_POST['opc'])) {
        switch ($_POST['opc']) {
            case 'getNotificacionesIndex':
                $notificaciones  = new Notificaciones();
                $notificaciones2 = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
                echo json_encode(['mensaje' => 'OK', 'notificaciones' => $notificaciones2]);
                break;
            case 'seenNotification':
                $notificaciones = new Notificaciones();
                $notificaciones->setId($_POST['id_not']);
                $notificaciones->setAsRead();
                echo json_encode(['mensaje' => 'OK']);
                break;
            case 'deleteNotification':
                $notificaciones = new Notificaciones();
                $notificaciones->setId($_POST['id_not']);
                $notificaciones->delete();
                echo json_encode(['mensaje' => 'OK']);
                break;
            case 'sendMasiveNotification':
                $notificaciones = new Notificaciones();
                $notificaciones->sendNotificacionesByCveNoti($_POST['cve_noti']);
                echo json_encode(['mensaje' => 'OK']);
                break;
        }
    }
} else {
    if (isset($_GET['ajax'])) {
        llamarController();
    } else {
        require_once views_root . 'principal/header.php';
        // require_once views_root . 'principal/_fixed_top.php';
        require_once views_root . 'principal/aside.php';
        require_once views_root . 'erp/notificaciones.php';

        llamarController();
        require_once views_root . 'principal/footer.php';
    }
}
