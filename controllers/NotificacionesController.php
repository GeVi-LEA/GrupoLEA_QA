<?php

require_once models_root . 'erp/notificaciones.php';

class notificacionesController
{
    public function getNotificaciones()
    {
        // $notificaciones             = new Notificaciones();
        // $_SESSION['notificaciones'] = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
        // echo json_encode(["mensaje" => "OK", "_notificaciones" => $_notificaciones]);
        // require views_root.'erp/notificaciones.php';
        if (isset($_POST['opc'])) {
            // print_r('<pre>');
            // print_r($_POST['opc']);
            // print_r('</pre>');

            switch ($_POST['opc']) {
                case 'getNotificacionesIndex':
                    $notificaciones = new Notificaciones();
                    // print_r('<pre>');
                    // print_r($notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id));
                    // print_r('</pre>');
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
        } else {
            // echo  json_encode(['mensaje' => 'OK']));
            echo json_encode([
                                 'mensaje' => 'OKKKK',
                                 //  'clientes'           => $clientes,
                                 //  'transportes'        => $transportes,
                                 //  'cat_transportistas' => $cat_transportistas,
                                 //  'cat_choferes'       => $cat_choferes
                             ]);
            return true;
        }
    }
}

/*
 * if ($_POST) {
 *     if (isset($_POST['opc'])) {
 *         switch ($_POST['opc']) {
 *             case 'getNotificaciones':
 *                 $notificaciones = new Notificaciones();
 *                 $notificaciones = getNotificaciones($_SESSION['usuario']->id);
 *                 echo json_encode(['mensaje' => 'OK', 'notificaciones' => $notificaciones]);
 *                 break;
 *
 *         case 'getNotificacionesIndex':
 *     $notificaciones  = new Notificaciones();
 *     $notificaciones2 = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
 *     echo json_encode(['mensaje' => 'OK', 'notificaciones' => $notificaciones2]);
 *     break;
 * case 'seenNotification':
 *     $notificaciones = new Notificaciones();
 *     $notificaciones->setId($_POST['id_not']);
 *     $notificaciones->setAsRead();
 *     echo json_encode(['mensaje' => 'OK']);
 *     break;
 * case 'deleteNotification':
 *     $notificaciones = new Notificaciones();
 *     $notificaciones->setId($_POST['id_not']);
 *     $notificaciones->delete();
 *     echo json_encode(['mensaje' => 'OK']);
 *     break;
 * case 'sendMasiveNotification':
 *     $notificaciones = new Notificaciones();
 *     $notificaciones->sendNotificacionesByCveNoti($_POST['cve_noti']);
 *     echo json_encode(['mensaje' => 'OK']);
 *     break;
 *     }
 * }
 */
?>