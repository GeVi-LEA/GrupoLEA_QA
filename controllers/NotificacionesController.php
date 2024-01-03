<?php

require_once models_root . 'erp/notificaciones.php';

class notificacionesController
{
    public function getNotificaciones()
    {
        $notificaciones             = new Notificaciones();
        $_SESSION['notificaciones'] = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
        // echo json_encode(["mensaje" => "OK", "_notificaciones" => $_notificaciones]);
        // require views_root.'erp/notificaciones.php';
    }
}

if ($_POST) {
    if (isset($_POST['opc'])) {
        switch ($_POST['opc']) {
            case 'getNotificaciones':
                $notificaciones = new Notificaciones();
                $notificaciones = getNotificaciones($_SESSION['usuario']->id);
                echo json_encode(['mensaje' => 'OK', 'notificaciones' => $notificaciones]);
                break;
        }
    }
}

?>