<?php

class Utils
{
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    public static function noLoggin()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == null) {
            header('Location:' . root_url . '?controller=Error&action=noLoggin');
            die();
        } else {
            return true;
        }
    }

    public static function permisosCompras()
    {
        if (self::isAdmin() || self::isCompras()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosEditar()
    {
        if (self::isAdmin() || self::isEditar()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosAlmacen()
    {
        if (self::isAdmin() || self::isAlmacen()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosGerente()
    {
        if (self::isAdmin() || self::isGerente()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosSupervisor()
    {
        if (self::isAdmin() || self::isSupervisor()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosCatalogos()
    {
        if (self::isAdmin() || self::isCatalogos()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosBascula()
    {
        if (self::isAdmin() || self::isBascula()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosVigilancia()
    {
        if (self::isAdmin() || self::isVigilancia()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosEnsacado()
    {
        if (self::isAdmin() || self::isEnsacado()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosLogistica()
    {
        if (self::isAdmin() || self::isLogistica()) {
            return true;
        } else {
            return false;
        }
    }

    public static function permisosSistemas()
    {
        if (self::isAdmin() || self::isSistemas()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getPermisosUser()
    {
        if (isset($_SESSION['usuario'])) {
            $permisos = json_decode($_SESSION['usuario']->permisos);
            return $permisos;
        } else {
            self::noLoggin();
        }
    }

    public static function isAdmin()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('1', $permisos);
        } else {
            return false;
        }
    }

    public static function isCompras()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('3', $permisos);
        } else {
            return false;
        }
    }

    public static function isSupervisor()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('12', $permisos);
        } else {
            return false;
        }
    }

    public static function isCatalogos()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('13', $permisos);
        } else {
            return false;
        }
    }

    public static function isBascula()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('11', $permisos);
        } else {
            return false;
        }
    }

    public static function isSistemas()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('7', $permisos);
        } else {
            return false;
        }
    }

    public static function isEditar()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('2', $permisos);
        } else {
            return false;
        }
    }

    public static function isAlmacen()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('6', $permisos);
        } else {
            return false;
        }
    }

    public static function isLogistica()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('8', $permisos);
        } else {
            return false;
        }
    }

    public static function isEnsacado()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('9', $permisos);
        } else {
            return false;
        }
    }

    public static function isVigilancia()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('10', $permisos);
        } else {
            return false;
        }
    }

    public static function isGerente()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('5', $permisos);
        } else {
            return false;
        }
    }

    public static function isFirmas()
    {
        $permisos = self::getPermisosUser();
        if (!empty($permisos)) {
            return in_array('4', $permisos);
        } else {
            return false;
        }
    }

    public static function getNombreUnidad($id)
    {
        require_once models_root . 'catalogos/unidad.php';
        $unidad = new Unidad();
        return $unidad->getUnidadById($id)->nombre;
    }

    public static function getTipoSolicitudes()
    {
        require_once models_root . 'catalogos/tipo_solicitud.php';
        $tipoSolicitud = new TipoSolicitud();
        return $tipoSolicitud->getAll();
    }

    public static function getRutas()
    {
        require_once models_root . 'catalogos/ruta.php';
        $ruta = new Ruta();
        return $ruta->getAll();
    }

    public static function getRutasKansas()
    {
        require_once models_root . 'catalogos/ruta.php';
        $id   = self::getCarroTanque()->id;
        $ruta = new Ruta();
        return $ruta->getRutasCarroTanques($id);
    }

    public static function getClientes()
    {
        require_once models_root . 'catalogos/cliente.php';
        $cliente = new Cliente();
        return $cliente->getAll();
    }

    public static function getProductos()
    {
        require_once models_root . 'catalogos/producto.php';
        $producto = new Producto();
        return $producto->getAll();
    }

    public static function getAduanas()
    {
        require_once models_root . 'catalogos/aduana.php';
        $aduana = new Aduana();
        return $aduana->getAll();
    }

    public static function getTransportes()
    {
        require_once models_root . 'catalogos/tipo_transporte.php';
        $transporte = new TipoTransporte();
        return $transporte->getAll();
    }

    public static function getKansas()
    {
        require_once models_root . 'catalogos/proveedor.php';
        $proveedor = new Proveedor();
        return $proveedor->getByNmobre('Kansas city');
    }

    public static function getTransportistas()
    {
        require_once models_root . 'catalogos/proveedor.php';
        $proveedor = new Proveedor();
        return $proveedor->getTransportistas();
    }

    public static function getTipoTransporte($id)
    {
        require_once models_root . 'catalogos/tipo_transporte.php';
        $transporte = new TipoTransporte();
        return $transporte->getById($id);
    }

    public static function getCarroTanque()
    {
        require_once models_root . 'catalogos/tipo_transporte.php';
        $transporte = new TipoTransporte();
        return $transporte->getByNombre('Carro tanque');
    }

    public static function isTren()
    {
        require_once models_root . 'catalogos/tipo_transporte.php';
        $transporte = new TipoTransporte();
        return $transporte->isTren();
    }

    public static function getCarroTanqueById($id)
    {
        require_once models_root . 'catalogos/carro_tanque.php';
        $carro = new CarroTanque();
        $carro->setId($id);
        return $carro->getById();
    }

    public static function getDirectorio()
    {
        require_once models_root . 'catalogos/directorio.php';
        $dir = new Directorio();
        return $dir->getAll();
    }

    public static function getUsuarios()
    {
        require_once models_root . 'catalogos/usuario.php';
        $u = new Usuario();
        return $u->getAll();
    }

    public static function getUsuarioNombre($id)
    {
        require_once models_root . 'catalogos/usuario.php';
        $u = new Usuario();
        return $u->getById($id);
    }

    public static function getRecepcionesFletes($id)
    {
        require_once models_root . 'compras/recepcion_flete.php';
        $recepcion = new RecepcionFlete();
        $recepcion->setId($id);
        $result = $recepcion->getByRequisicion();
        return $result;
    }

    public static function showFirmas($firmas)
    {
        $firmasArray = json_decode($firmas, TRUE);
        $str         = '';
        if (is_array($firmasArray)) {
            foreach ($firmasArray as $f) {
                if ($f != 0) {
                    $str .= '<i class="text-success fas fa-check pl-1"></i>';
                } else {
                    $str .= '<i class="text-danger fas fa-times pl-1"></i>';
                }
            }
        }
        return $str;
    }

    public static function getClaseEstado($clave)
    {
        switch ($clave) {
            case 'G':
                return 'estatus-gen';
                break;
            case 'C':
                return 'estatus-cancel';
                break;
            case 'A':
                return 'estatus-acept';
                break;
            case 'P':
                return 'estatus-proceso';
                break;
            case 'FIN':
                return 'estatus-fin';
                break;
            case 'E':
                return 'estatus-enviada';
                break;
            case 'TRS':
                return 'estatus-transito';
                break;
            case 'PAG':
                return 'estatus-pagado';
                break;
            case 'EMB':
                return 'estatus-embarque';
                break;
            case 'TERM':
                return 'estatus-pagado';
                break;
            case 'PSD':
                return 'estatus-pesado';
                break;
            case 'PROG':
                return 'estatus-programa';
                break;
            case 'SALIDA':
                return 'estatus-salida';
                break;
            case 'LIB':
                return 'estatus-liberado';
            case 'DEL':
                return 'estatus-eliminado';
                break;
        }
    }

    public static function quitarComas($string)
    {
        $str = preg_replace('/[,]/', '', $string);
        return $str;
    }

    public static function stringToFloat($string)
    {
        $str = preg_replace('/[,]/', '', trim($string));
        return floatval($str);
    }

    public static function getFirmaUser($id)
    {
        require_once models_root . 'catalogos/usuario.php';
        $user = new Usuario();
        $u    = $user->getById($id);
        if ($u != null) {
            return $u->firma;
        } else {
            return null;
        }
    }

    public static function getClaverPermisosUser($ids)
    {
        require_once models_root . 'catalogos/tipo_permiso.php';
        if (is_numeric($ids)) {
            return $ids;
        }
        $array   = json_decode($ids);
        $permiso = new TipoPermiso();
        $claves  = '';
        if (!empty($array)) {
            foreach ($array as $id) {
                $p       = $permiso->getById($id);
                $claves .= $p->clave . ', ';
            }
        }
        return substr($claves, 0, -2);
    }

    public static function getNullString($num)
    {
        return $num == null ? 'null' : $num;
    }

    public static function getNullText($str)
    {
        return $str == null ? null : "'" . $str . "'";
    }

    public static function getAplicaionesSistemas($ids)
    {
        if (is_numeric($ids)) {
            return $ids;
        }
        $array  = json_decode($ids);
        $claves = '';
        if (!empty($array)) {
            foreach ($array as $id) {
                $claves .= aplicaciones_sistemas[$id] . ', ';
            }
        }
        return substr($claves, 0, -2);
    }

    public static function getServiciosEnsacados($lote)
    {
        require_once models_root . 'servicios/servicio_ensacado.php';
        $l = new ServicioEnsacado();
        return $l->getAlmacenLotes($lote);
    }

    public static function getOperacionServicios($servicios)
    {
        $operacion = "<i class='fa-solid fa-arrow-right i-green'  title='Descarga'></i>";
        if (!empty($servicios)) {
            foreach ($servicios as $s) {
                if ($s['claveServ'] == 'CARGA') {
                    $operacion = "<i class='fa-solid fa-arrow-left i-red'  title='Carga'></i>";
                }
            }
        } else {
            $operacion = "<i class='fa-solid fa-minus i-clip'></i>";
        }
        return $operacion;
    }

    public static function getChofer($id)
    {
        require_once models_root . 'catalogos/chofer_transportista.php';
        $chofer = new ChoferTransportista();
        if ($id == '') {
            // $data = ['nombre' => ''];
            // return json_encode($data);
            // OTROS //
            $id   = '61';
            $data = ['nombre' => ''];
        } else {
            $data = $chofer->getById($id);
        }

        // print_r('<pre>');
        // print_r($data);
        // print_r('</pre>');
        return json_encode($data);
    }

    public static function getTransportistaCliente($id)
    {
        require_once models_root . 'catalogos/transportista_cliente.php';
        $chofer = new TransportistaCliente();
        if ($id == '') {
            $data = ['nombre' => ''];
            return json_encode($data);
        } else {
            return $chofer->getById($id);
        }
    }
}
