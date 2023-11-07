<?php

require_once utils_root . 'utilsHelp.php';
require_once models_root . 'catalogos/unidad.php';
require_once models_root . 'catalogos/ciudad.php';
require_once models_root . 'catalogos/estado.php';
require_once models_root . 'catalogos/pais.php';
require_once models_root . 'catalogos/tipo_compra.php';
require_once models_root . 'catalogos/tipo_solicitud.php';
require_once models_root . 'catalogos/unidad.php';
require_once models_root . 'catalogos/departamento.php';
require_once models_root . 'catalogos/tipo_permiso.php';
require_once models_root . 'catalogos/usuario.php';
require_once models_root . 'catalogos/estatus.php';
require_once models_root . 'catalogos/proveedor.php';
require_once models_root . 'catalogos/documento_norma.php';
require_once models_root . 'catalogos/tipo_transporte.php';
require_once models_root . 'catalogos/ruta.php';
require_once models_root . 'catalogos/cliente.php';
require_once models_root . 'catalogos/producto.php';
require_once models_root . 'catalogos/refineria.php';
require_once models_root . 'catalogos/aduana.php';
require_once models_root . 'catalogos/carro_tanque.php';
require_once models_root . 'catalogos/equipo_computo.php';
require_once models_root . 'catalogos/producto_resina_liquido.php';
require_once models_root . 'catalogos/tipo_producto_resina_liquido.php';
require_once models_root . 'catalogos/tipo_empaque.php';
require_once models_root . 'catalogos/servicio.php';
require_once models_root . 'catalogos/almacen.php';

class catalogoController
{
    public function index()
    {
        require_once views_root . 'catalogos/catalogos.php';
    }

    public function showUnidades()
    {
        $unidad   = new Unidad();
        $unidades = $unidad->getAll();

        require views_root . 'catalogos/unidades.php';
    }

    public function saveUnidades()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $unid = new Unidad();
            $unid->setNombre($_POST['nombre']);
            $unid->setClave($_POST['clave']);
            $unid->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);

            $unidades = $unid->getAll();
            if (!empty($unidades)) {
                $errores = array();
                $nombre  = $unid->getNombre();
                $clave   = $unid->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($unidades, $nombre, $clave);
                    if (count($errores) == 0) {
                        $unid->setId($_POST['id']);
                        $save = $unid->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($unidades, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $unid->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $ciudad->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUnidades');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUnidades');
        }
    }

    public function deleteUnidades()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $unidad = new Unidad();
            $unidad->setId($id);
            $unidad->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUnidades');
    }

    public function showCiudades()
    {
        $ciudad   = new Ciudad();
        $ciudades = $ciudad->getAll();

        $estado  = new Estado();
        $estados = $estado->getAll();
        require '../../views/catalogos/ciudades.php';
    }

    public function saveCiudad()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $ciudad = new Ciudad();
            $ciudad->setNombre($_POST['nombre']);
            $ciudad->setClave($_POST['clave']);
            $ciudad->setEstado($_POST['estado']);

            $ciudades = $ciudad->getAll();
            if (!empty($ciudades)) {
                $errores = array();

                $nombre = $ciudad->getNombre();
                $clave  = $ciudad->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($ciudades, $nombre, $clave);
                    if (count($errores) == 0) {
                        $ciudad->setId($_POST['id']);
                        $save = $ciudad->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($ciudades, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $ciudad->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $ciudad->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCiudades');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCiudades');
        }
    }

    public function deleteCiudad()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $ciudad = new Ciudad();
            $ciudad->setId($id);
            $ciudad->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCiudades');
    }

    public function showEstados()
    {
        $estado  = new Estado();
        $estados = $estado->getAll();

        $pais   = new Pais();
        $paises = $pais->getAll();
        require '../../views/catalogos/estados.php';
    }

    public function saveEstado()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $estado = new Estado();
            $estado->setNombre($_POST['nombre']);
            $estado->setClave($_POST['clave']);
            $estado->setPaisId($_POST['pais']);

            $estados = $estado->getAll();
            if (!empty($estados)) {
                $errores = array();
                $nombre  = $estado->getNombre();
                $clave   = $estado->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($estados, $nombre, $clave);
                    if (count($errores) == 0) {
                        $estado->setId($_POST['id']);
                        $save = $estado->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($estados, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $estado->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $estado->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstados');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstados');
        }
    }

    public function deleteEstado()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $estado = new Estado();
            $estado->setId($id);
            $estado->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstados');
    }

    public function showPaises()
    {
        $pais   = new Pais();
        $paises = $pais->getAll();
        require '../../views/catalogos/paises.php';
    }

    public function savePais()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $pais = new Pais();
            $pais->setNombre($_POST['nombre']);
            $pais->setClave($_POST['clave']);

            $paises = $pais->getAll();

            if (!empty($paises)) {
                $errores = array();

                $nombre = $pais->getNombre();
                $clave  = $pais->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($paises, $nombre, $clave);
                    if (count($errores) == 0) {
                        $pais->setId($_POST['id']);
                        $save = $pais->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($paises, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $pais->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $pais->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showPaises');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showPaises');
        }
    }

    public function deletePais()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $pais = new Pais();
            $pais->setId($id);
            $pais->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showPaises');
    }

    public function showTiposSolicitudes()
    {
        $tipoSolicitud   = new TipoSolicitud();
        $tipoSolicitudes = $tipoSolicitud->getAll();

        $tipoCompras  = new TipoCompra();
        $tiposCompras = $tipoCompras->getAll();
        require '../../views/catalogos/tipos_solicitudes.php';
    }

    public function saveTipoSolicitud()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        var_dump($_POST);

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['tipoCompras']) && $_POST['tipoCompras'] != '') {
            $tipoSolicitud = new TipoSolicitud();
            $tipoSolicitud->setTipo($_POST['nombre']);
            $tipoSolicitud->setTipo_compra_id($_POST['tipoCompras']);
            $tipoSolicitud->setDescripcion($_POST['descripcion']);

            $tiposSolicitudes = $tipoSolicitud->getAll();

            if (!empty($tiposSolicitudes)) {
                $errores = array();

                $tipo = $tipoSolicitud->getTipo();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($tiposSolicitudes, $tipo, $clave = null);
                    if (count($errores) == 0) {
                        $tipoSolicitud->setId($_POST['id']);
                        $save = $tipoSolicitud->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($tiposSolicitudes, $tipo, $clave = null);
                    if (count($errores) == 0) {
                        $save                = $tipoSolicitud->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $tipoSolicitud->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposSolicitudes');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposSolicitudes');
        }
    }

    public function deleteTipoSolicitud()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $tipoSolicitud = new TipoSolicitud();
            $tipoSolicitud->setId($id);
            $tipoSolicitud->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposSolicitudes');
    }

    public function showTiposCompras()
    {
        $tipoCompra   = new TipoCompra();
        $tiposCompras = $tipoCompra->getAll();
        require '../../views/catalogos/tipos_compras.php';
    }

    public function saveTipoCompra()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $tipoCompra = new TipoCompra();
            $tipoCompra->setTipo($_POST['nombre']);
            $tipoCompra->setDescripcion($_POST['descripcion']);

            $tiposCompras = $tipoCompra->getAll();

            if (!empty($tiposCompras)) {
                $errores = array();

                $nombre = $tipoCompra->getTipo();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($tiposCompras, $nombre, null);
                    if (count($errores) == 0) {
                        $tipoCompra->setId($_POST['id']);
                        $save = $tipoCompra->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($tiposCompras, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $tipoCompra->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $tipoCompra->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposCompras');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposCompras');
        }
    }

    public function deleteTipoCompra()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $tipoCompra = new TipoCompra();
            $tipoCompra->setId($id);
            $tipoCompra->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposCompras');
    }

    public function showProveedores()
    {
        $tipoSolicitud   = new TipoSolicitud();
        $tipoSolicitudes = $tipoSolicitud->getAll();

        $ciudad   = new Ciudad();
        $ciudades = $ciudad->getAll();

        $proveedor   = new Proveedor();
        $proveedores = $proveedor->getAll();

        require '../../views/catalogos/proveedores.php';
    }

    public function saveProveedor()
    {
        $nombre          = $_POST['nombre'] != '' ? $_POST['nombre'] : false;
        $tipoServicio    = isset($_POST['tipoServicio']) ? $_POST['tipoServicio'] : false;
        $clasificacion   = isset($_POST['clasificacion']) ? $_POST['clasificacion'] : false;
        $contacto        = $_POST['contacto'] != '' ? $_POST['contacto'] : false;
        $correo          = $_POST['correo'] != '' ? $_POST['correo'] : false;
        $correo1         = $_POST['correo1'] != '' ? $_POST['correo1'] : false;
        $correo2         = $_POST['correo2'] != '' ? $_POST['correo2'] : false;
        $correo3         = $_POST['correo3'] != '' ? $_POST['correo3'] : false;
        $telefono        = $_POST['telefono'];
        $celular         = $_POST['celular'] == '' ? 0 : $_POST['telefono'];
        $direccion       = $_POST['direccion'] != '' ? $_POST['direccion'] : false;
        $codPostal       = $_POST['codigoPostal'] == '' ? 0 : $_POST['codigoPostal'];
        $ciudad          = isset($_POST['ciudad']) ? $_POST['ciudad'] : false;
        $rfc             = $_POST['rfc'];
        $certificado     = $_POST['certificado'];
        $fechaAlta       = $_POST['fechaAlta'] == '' ? UtilsHelp::today() : UtilsHelp::covertDatetoDateSql($_POST['fechaAlta']);
        $fechaEvaluacion = $_POST['fechaEvaluacion'] == '' ? UtilsHelp::today() : UtilsHelp::covertDatetoDateSql($_POST['fechaEvaluacion']);
        $calificacion    = $_POST['calificacion'] == '' ? '100' : $_POST['calificacion'];
        $activo          = $_POST['activo'] != '' ? $_POST['activo'] : 'S';
        $cuenta          = $_POST['cuenta'];

        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        $fechaProxEvaluacion = date('Y-m-d', strtotime($fechaEvaluacion . '+ 6 month'));

        if ($nombre && $tipoServicio && $contacto && $clasificacion && $direccion && $ciudad && $correo) {
            $proveedor = new Proveedor();
            $proveedor->setNombre($nombre);
            $proveedor->setTipoSolicitudId($tipoServicio);
            $proveedor->setClasificacion($clasificacion);
            $proveedor->setContacto($contacto);
            $proveedor->setCorreo($correo);
            $proveedor->setCorreo1($correo1);
            $proveedor->setCorreo2($correo2);
            $proveedor->setCorreo3($correo3);
            $proveedor->setTelefono($telefono);
            $proveedor->setCelular($celular);
            $proveedor->setDireccion($direccion);
            $proveedor->setCiudadId($ciudad);
            $proveedor->setCodigoPostal($codPostal);
            $proveedor->setRfc($rfc);
            $proveedor->setCuenta($cuenta);
            $proveedor->setFechaAlta(date('Y-m-d', strtotime($fechaAlta)));
            $proveedor->setFechaEvaluacion(date('Y-m-d', strtotime($fechaEvaluacion)));
            $proveedor->setActivo($activo);
            $proveedor->setCertificacion($certificado);
            $proveedor->setCalificacion($calificacion);
            $proveedor->setFechaProxEvaluacion($fechaProxEvaluacion);
            $proveedores = $proveedor->getAll();

            if (!empty($proveedores)) {
                $errores = array();

                $nombre = $proveedor->getNombre();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($proveedores, $nombre, null);
                    if (count($errores) == 0) {
                        $proveedor->setId($_POST['id']);
                        $save = $proveedor->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($proveedores, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $proveedor->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $proveedor->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProveedores');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProveedores');
        }
    }

    public function deleteProveedor()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $proveedor = new Proveedor();
            $proveedor->setId($id);
            $proveedor->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProveedores');
    }

    public function proveedoresByServicio()
    {
        header('Content-Type: application/json; charset=utf-8');
        $id          = $_POST['idServicio'];
        $proveedor   = new Proveedor();
        $proveedores = $proveedor->proveedoresByServicio($id);
        print_r(json_encode($proveedores));
    }

    public function showDepartamentos()
    {
        $departamento  = new Departamento();
        $departamentos = $departamento->getAll();

        require '../../views/catalogos/departamentos.php';
    }

    public function saveDepartamento()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $dpto = new Departamento();
            $dpto->setNombre($_POST['nombre']);
            $dpto->setClave($_POST['clave']);
            $dpto->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);

            $departamentos = $dpto->getAll();
            if (!empty($departamentos)) {
                $errores = array();
                $nombre  = $dpto->getNombre();
                $clave   = $dpto->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($departamentos, $nombre, $clave);
                    if (count($errores) == 0) {
                        $dpto->setId($_POST['id']);
                        $save = $dpto->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($departamentos, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $dpto->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $dpto->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDepartamentos');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDepartamentos');
        }
    }

    public function deleteDepartamento()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $departamento = new Departamento();
            $departamento->setId($id);
            $departamento->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDepartamentos');
    }

    public function showUsuarios()
    {
        $usuario  = new Usuario();
        $usuarios = $usuario->getAll();

        $permiso  = new TipoPermiso();
        $permisos = $permiso->getAll();

        $dpto          = new Departamento();
        $departamentos = $dpto->getAll();

        require '../../views/catalogos/usuarios.php';
    }

    public function saveUsuario()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['apellido']) && $_POST['apellido'] != '' && isset($_POST['user']) && $_POST['user'] != '') {
            $id           = $_POST['id'] != '' ? $_POST['id'] : null;
            $nombre       = $_POST['nombre'];
            $apellidos    = $_POST['apellido'];
            $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
            $puesto       = $_POST['puesto'] != '' ? $_POST['puesto'] : false;
            $correo       = $_POST['correo'] != '' ? $_POST['correo'] : false;
            $telefono     = $_POST['telefono'] != '' ? $_POST['telefono'] : false;
            $extension    = $_POST['extension'] == '' ? 0 : $_POST['extension'];
            $tipoPermiso  = isset($_POST['permisos']) ? $_POST['permisos'] : '';
            $user         = $_POST['user'] != '' ? $_POST['user'] : false;
            $password     = $_POST['password'] != '' ? $_POST['password'] : false;
            $cambiopass   = $_POST['cambioPass'] != '' ? true : false;
            $fechaAlta    = $_POST['fechaAlta'] == '' ? new DateTime() : str_replace('/', '-', $_POST['fechaAlta']);
            $activo       = $_POST['activo'] == '' ? 'S' : $_POST['activo'];
            Utils::deleteSession('result');
            Utils::deleteSession('errores');
            if ($nombre && $apellidos && $departamento && $puesto && $correo && $user && $password) {
                $usuario = new Usuario();
                $usuario->setNombres($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setDepartamento($departamento);
                $usuario->setPuesto($puesto);
                $usuario->setCorreo($correo);
                $usuario->setTelefono($telefono);
                $usuario->setExtension($extension);
                $usuario->setPermiso(json_encode($tipoPermiso));
                $usuario->setUser($user);
                $usuario->setPassword($password);
                $usuario->setFechaAlta(date('Y-m-d', strtotime($fechaAlta)));
                $usuario->setActivo($activo);

                if ($id != null) {
                    $u = $usuario->getById($id);
                }

                if (isset($_FILES['imagen']) && $_FILES['imagen'] != null) {
                    $file     = $_FILES['imagen'];
                    $filename = $user . $file['name'];
                    $mimetype = $file['type'];

                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {
                        if (!is_dir('uploads/imgUsuarios')) {
                            mkdir('uploads/imgUsuarios', 0777, true);
                        }
                        if ($u->imagen != null && $u->imagen != '') {
                            if (file_exists('uploads/imgUsuarios/' . $u->imagen)) {
                                unlink('uploads/imgUsuarios/' . $u->imagen);
                            }
                        }

                        move_uploaded_file($file['tmp_name'], 'uploads/imgUsuarios/' . $filename);
                        $usuario->setImagen($filename);
                    }
                }

                if (isset($_FILES['firma']) && $_FILES['firma'] != null) {
                    $file     = $_FILES['firma'];
                    $filename = $user . $file['name'];
                    $mimetype = $file['type'];

                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {
                        if (!is_dir('uploads/imgFirmasUsuarios')) {
                            mkdir('uploads/imgFirmasUsuarios', 0777, true);
                        }
                        if ($u->firma != null && $u->firma != '') {
                            if (file_exists('uploads/imgFirmasUsuarios/' . $u->firma)) {
                                unlink('uploads/imgFirmasUsuarios/' . $u->firma);
                            }
                        }
                        move_uploaded_file($file['tmp_name'], 'uploads/imgFirmasUsuarios/' . $filename);
                        $usuario->setFirma($filename);
                    }
                }

                $usuarios = $usuario->getAll();

                if (!empty($usuarios)) {
                    $errores = array();

                    $clave = $usuario->getUser();

                    if ($id != null || $id != '') {
                        $errores = UtilsHelp::validarNombreClaveUnico($usuarios, null, $clave);
                        $id      = $_POST['id'];
                        if (count($errores) == 0) {
                            $usuario->setId($id);
                            $save = $usuario->edit($cambiopass);
                            if ($id == $_SESSION['usuario']->id) {
                                Utils::deleteSession('usuario');
                                $_SESSION['usuario'] = $usuario->getById($id);
                            }
                        } else {
                            $_SESSION['errores'] = $errores;
                        }
                    } else {
                        $errores = UtilsHelp::validarNombreClaveExiste($usuarios, null, $clave);
                        if (count($errores) == 0) {
                            $save                = $usuario->save();
                            $_SESSION['errores'] = $errores;
                        } else {
                            $_SESSION['errores'] = $errores;
                        }
                    }
                } else {
                    $save = $usuario->save();
                }
                if ($save) {
                    $_SESSION['result'] = 'true';
                } else {
                    $_SESSION['result'] = 'false';
                }
                header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUsuarios');
            } else {
                header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUsuarios');
            }
        }
    }

    public function deleteUsuario()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $usuario = new Usuario();
            $usuario->setId($id);
            $usuario->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showUsuarios');
    }

    public function eliminarFirmaUsuario()
    {
        if (isset($_POST['idUser'])) {
            $id      = $_POST['idUser'];
            $usuario = new Usuario();
            $u       = $usuario->getById($id);

            if (file_exists('uploads/imgFirmasUsuarios/' . $u->firma)) {
                unlink('uploads/imgFirmasUsuarios/' . $u->firma);
            }
            $result = $usuario->eliminarFirma($id);
            echo $result;
        } else {
            echo false;
        }
    }

    public function eliminarImagenUsuario()
    {
        if (isset($_POST['idUser'])) {
            $id      = $_POST['idUser'];
            $usuario = new Usuario();
            $u       = $usuario->getById($id);

            if (file_exists('uploads/imgUsuarios/' . $u->imagen)) {
                unlink('uploads/imgUsuarios/' . $u->imagen);
            }
            $result = $usuario->eliminarImagen($id);
            echo $result;
        } else {
            echo false;
        }
    }

    public function getUsuarioById()
    {
        if (isset($_POST['id'])) {
            $id      = $_POST['id'];
            $usuario = new Usuario();
            $u       = $usuario->getById($id);
            print_r(json_encode($u));
        } else {
            echo false;
        }
    }

    public function showTipoPermisos()
    {
        $permiso  = new TipoPermiso();
        $permisos = $permiso->getAll();

        require '../../views/catalogos/tipos_permisos.php';
    }

    public function saveTipoPermiso()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $permiso = new TipoPermiso();
            $permiso->setNombre($_POST['nombre']);
            $permiso->setClave($_POST['clave']);
            $permiso->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);

            $permisos = $permiso->getAll();
            if (!empty($permisos)) {
                $errores = array();
                $nombre  = $permiso->getNombre();
                $clave   = $permiso->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($permisos, $nombre, $clave);
                    if (count($errores) == 0) {
                        $permiso->setId($_POST['id']);
                        $save = $permiso->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($permisos, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $permiso->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $permiso->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoPermisos');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoPermisos');
        }
    }

    public function deleteTipoPermiso()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $permiso = new TipoPermiso();
            $permiso->setId($id);
            $permiso->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoPermisos');
    }

    public function showEstatus()
    {
        $est     = new Estatus();
        $estatus = $est->getAll();

        require '../../views/catalogos/estatus.php';
    }

    public function saveEstatus()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $est = new Estatus();
            $est->setNombre($_POST['nombre']);
            $est->setClave($_POST['clave']);
            $est->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);

            $estatus = $est->getAll();
            if (!empty($estatus)) {
                $errores = array();
                $nombre  = $est->getNombre();
                $clave   = $est->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($estatus, $nombre, $clave);
                    if (count($errores) == 0) {
                        $est->setId($_POST['id']);
                        $save = $est->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($estatus, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $est->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $est->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstatus');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstatus');
        }
    }

    public function deleteEstatus()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $est = new Estatus();
            $est->setId($id);
            $est->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEstatus');
    }

    public function showDocumentosNorma()
    {
        $usuario  = new Usuario();
        $usuarios = $usuario->getAll();

        $est     = new Estatus();
        $estatus = $est->getAll();

        $doc        = new DocumentoNorma();
        $documentos = $doc->getAll();

        require '../../views/catalogos/documentos_norma.php';
    }

    public function saveDocumentoNorma()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave']) {
            $id              = $_POST['id'] != '' ? $_POST['id'] : null;
            $nombre          = $_POST['nombre'];
            $usuario         = isset($_POST['usuario']) ? $_POST['usuario'] : false;
            $estatus         = $_POST['estatus'] != '' ? $_POST['estatus'] : false;
            $codigo          = $_POST['clave'] != '' ? $_POST['clave'] : false;
            $revision        = $_POST['revision'] != '' ? $_POST['revision'] : false;
            $descripcion     = ($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);
            $fechaAlta       = $_POST['fechaAlta'] == '' ? new DateTime() : str_replace('/', '-', $_POST['fechaAlta']);
            $fechaLiberacion = $_POST['fechaLiberacion'] == '' ? new DateTime() : str_replace('/', '-', $_POST['fechaLiberacion']);

            Utils::deleteSession('result');
            Utils::deleteSession('errores');

            if ($nombre && $estatus && $codigo) {
                $doc = new DocumentoNorma();
                $doc->setNombre($nombre);
                $doc->setUsuarioId($usuario);
                $doc->setEstatusId($estatus);
                $doc->setCodigo($codigo);
                $doc->setRevision($revision);
                $doc->setDescripcion($descripcion);
                $doc->setFechaAlta(date('Y-m-d', strtotime($fechaAlta)));
                $doc->setFechaLiberacion(date('Y-m-d', strtotime($fechaLiberacion)));

                if ($id != null) {
                    $d = $doc->getById($id);
                }

                if (isset($_FILES['documento']) && $_FILES['documento'] != null) {
                    $file     = $_FILES['documento'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];

                    if ($mimetype == 'application/pdf') {
                        if (!is_dir('uploads/documentosNorma')) {
                            mkdir('uploads/documentosNorma', 0777, true);
                        }
                        if (file_exists('uploads/documentosNorma/' . $d->formato)) {
                            unlink('uploads/documentosNorma/' . $d->formato);
                        }

                        move_uploaded_file($file['tmp_name'], 'uploads/documentosNorma/' . $filename);
                        $doc->setFormato($filename);
                    }
                }

                $documentos = $doc->getAll();

                if (!empty($documentos)) {
                    $errores = array();

                    $nombre = $doc->getNombre();
                    $clave  = $doc->getCodigo();

                    if ($id != null || $id != '') {
                        $errores = UtilsHelp::validarNombreClaveUnico($documentos, $nombre, $clave);
                        $id      = $_POST['id'];
                        if (count($errores) == 0) {
                            $doc->setId($id);
                            $save = $doc->edit();
                        } else {
                            $_SESSION['errores'] = $errores;
                        }
                    } else {
                        $errores = UtilsHelp::validarNombreClaveExiste($documentos, $nombre, $clave);
                        if (count($errores) == 0) {
                            $save                = $doc->save();
                            $_SESSION['errores'] = $errores;
                        } else {
                            $_SESSION['errores'] = $errores;
                        }
                    }
                } else {
                    $save = $doc->save();
                }
                if ($save) {
                    $_SESSION['result'] = 'true';
                } else {
                    $_SESSION['result'] = 'false';
                }
                header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDocumentosNorma');
            } else {
                header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDocumentosNorma');
            }
        }
    }

    public function deleteDocumentoNorma()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $doc = new DocumentoNorma();
            $doc->setId($id);
            $doc->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showDocumentosNorma');
    }

    public function showTipoTransporte()
    {
        $tipoTrans   = new TipoTransporte();
        $transportes = $tipoTrans->getAll();

        require '../../views/catalogos/tipos_transportes.php';
    }

    public function saveTipoTransporte()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['clave']) && $_POST['clave'] != '') {
            $trans = new TipoTransporte();
            $trans->setNombre($_POST['nombre']);
            $trans->setClave($_POST['clave']);
            $trans->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);

            $transportes = $trans->getAll();
            if (!empty($transportes)) {
                $errores = array();
                $nombre  = $trans->getNombre();
                $clave   = $trans->getClave();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($transportes, $nombre, $clave);
                    if (count($errores) == 0) {
                        $trans->setId($_POST['id']);
                        $save = $trans->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($transportes, $nombre, $clave);
                    if (count($errores) == 0) {
                        $save                = $trans->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $trans->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoTransporte');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoTransporte');
        }
    }

    public function deleteTipoTransporte()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $trans = new TipoTransporte();
            $trans->setId($id);
            $trans->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTipoTransporte');
    }

    public function showRutas()
    {
        $ruta  = new Ruta();
        $rutas = $ruta->getAll();

        $ciudad   = new Ciudad();
        $ciudades = $ciudad->getAll();

        $proveedor      = new Proveedor();
        $transportistas = $proveedor->getTransportistas();

        $tipoTrans   = new TipoTransporte();
        $transportes = $tipoTrans->getAll();

        require '../../views/catalogos/rutas.php';
    }

    public function saveRuta()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['ciudad']) && $_POST['ciudad'] != '' && isset($_POST['proveedor']) && $_POST['proveedor'] != '') {
            $ruta = new Ruta();
            $ruta->setProveedorId($_POST['proveedor']);
            $ruta->setTipoTransporte($_POST['transporte']);
            $ruta->setCiudadOrigen($_POST['ciudad']);
            $ruta->setCiudadDestino($_POST['ciudadDestino']);
            $ruta->setPrecio($_POST['costo'] = !'' ? Utils::quitarComas($_POST['costo']) : '');
            $ruta->setFechaVencimiento(date('Y-m-d', strtotime($_POST['fechaVencimiento'])));
            $ruta->setDescripcion($_POST['descripcion'] == '' ? 'S/D' : $_POST['descripcion']);
            $fecha = $_POST['fechaVencimiento'] == '' ? UtilsHelp::today() : UtilsHelp::covertDatetoDateSql($_POST['fechaVencimiento']);
            $ruta->setFechaVencimiento(date('Y-m-d', strtotime($fecha)));
            $ruta->setMoneda($_POST['moneda']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $ruta->setId($_POST['id']);
                $save = $ruta->edit();
            } else {
                $save = $ruta->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showRutas');
        }
    }

    public function deleteRuta()
    {
        if (isset($_GET['id'])) {
            $id   = $_GET['id'];
            $ruta = new Ruta();
            $ruta->setId($id);
            $ruta->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showRutas');
    }

    public function rutasByProveedorTransporte()
    {
        if (isset($_POST['idProveedor']) && $_POST['idProveedor'] != '' && isset($_POST['idTransporte']) && $_POST['idTransporte'] != '') {
            $id           = $_POST['idProveedor'];
            $idTransporte = $_POST['idTransporte'];
            $ruta         = new Ruta();
            $rutas        = $ruta->rutasByProveedor($id, $idTransporte);
            print_r(json_encode($rutas));
        }
    }

    public function validarFechaVencimientoPrecio()
    {
        if (isset($_POST['idRuta']) && $_POST['idRuta'] != '') {
            $id    = $_POST['idRuta'];
            $ruta  = new Ruta();
            $rutas = $ruta->rutaById($id);
            print_r(json_encode($rutas));
        }
    }

    public function showClientes()
    {
        $ciudad   = new Ciudad();
        $ciudades = $ciudad->getAll();

        $cliente  = new Cliente();
        $clientes = $cliente->getAll();

        require '../../views/catalogos/clientes.php';
    }

    public function saveCliente()
    {
        $nombre    = $_POST['nombre'] != '' ? $_POST['nombre'] : false;
        $contacto  = $_POST['contacto'] != '' ? $_POST['contacto'] : false;
        $correo    = $_POST['correo'] != '' ? $_POST['correo'] : false;
        $telefono  = $_POST['telefono'];
        $direccion = $_POST['direccion'] != '' ? $_POST['direccion'] : false;
        $codPostal = $_POST['codigoPostal'] == '' ? 0 : $_POST['codigoPostal'];
        $ciudad    = isset($_POST['ciudad']) ? $_POST['ciudad'] : false;
        $rfc       = $_POST['rfc'];
        $fechaAlta = $_POST['fechaAlta'] == '' ? UtilsHelp::today() : UtilsHelp::covertDatetoDateSql($_POST['fechaAlta']);

        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if ($nombre && $contacto && $direccion && $ciudad && $correo) {
            $cliente = new Cliente();
            $cliente->setNombre($nombre);
            $cliente->setContacto($contacto);
            $cliente->setCorreo($correo);
            $cliente->setTelefono($telefono);
            $cliente->setDireccion($direccion);
            $cliente->setCiudadId($ciudad);
            $cliente->setCodigoPostal($codPostal);
            $cliente->setRfc($rfc);
            $cliente->setFechaAlta(date('Y-m-d', strtotime($fechaAlta)));
            $clientes = $cliente->getAll();

            if (!empty($clientes)) {
                $errores = array();

                $nombre = $cliente->getNombre();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($clientes, $nombre, null);
                    if (count($errores) == 0) {
                        $cliente->setId($_POST['id']);
                        $save = $cliente->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($clientes, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $cliente->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $cliente->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showClientes');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showClientes');
        }
    }

    public function deleteCliente()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $cliente = new Cliente();
            $cliente->setId($id);
            $cliente->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showClientes');
    }

    public function getClienteById()
    {
        if (isset($_POST['idCliente'])) {
            $id = $_POST['idCliente'];
            if ($id != '' || $id != null) {
                $cliente = new Cliente();
                $cliente->setId($id);
                $cli = $cliente->getClienteById();
                print_r(json_encode($cli));
            }
        }
    }

    public function showProductos()
    {
        $producto  = new Producto();
        $productos = $producto->getAll();

        $refineria  = new Refineria();
        $refinerias = $refineria->getAll();
        require '../../views/catalogos/productos.php';
    }

    public function saveProducto()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['producto']) && $_POST['producto'] != '') {
            $producto = new Producto();
            $producto->setNombre($_POST['producto']);
            $producto->setRefineriaId($_POST['refineria']);
            $productos = $producto->getAll();

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $producto->setId($_POST['id']);
                $save = $producto->edit();
            } else {
                $save = $producto->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductos');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductos');
        }
    }

    public function deleteProducto()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $producto = new Producto();
            $producto->setId($id);
            $producto->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductos');
    }

    public function showRefinerias()
    {
        $refineria  = new Refineria();
        $refinerias = $refineria->getAll();
        require '../../views/catalogos/refinerias.php';
    }

    public function saveRefineria()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $refineria = new Refineria();
            $refineria->setNombre($_POST['nombre']);

            $refinerias = $refineria->getAll();

            if (!empty($refinerias)) {
                $errores = array();

                $nombre = $refineria->getNombre();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($refinerias, $nombre, null);
                    if (count($errores) == 0) {
                        $refineria->setId($_POST['id']);
                        $save = $refineria->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($refinerias, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $refineria->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $refineria->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showRefinerias');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showRefinerias');
        }
    }

    public function deleteRefineria()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $refineria = new Refineria();
            $refineria->setId($id);
            $refineria->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showRefinerias');
    }

    public function showAduanas()
    {
        $aduana  = new Aduana();
        $aduanas = $aduana->getAll();

        $ciudad   = new Ciudad();
        $ciudades = $ciudad->getAll();
        require '../../views/catalogos/aduanas.php';
    }

    public function saveAduana()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $aduana = new Aduana();
            $aduana->setNombre($_POST['nombre']);
            $aduana->setClave($_POST['clave']);
            $aduana->setCiudadId($_POST['ciudad']);
            $aduanas = $aduana->getAll();

            if (!empty($aduanas)) {
                $errores = array();
                $nombre  = $aduana->getNombre();

                if ($_POST['id'] != null || $_POST['id'] != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($aduanas, $nombre, null);
                    if (count($errores) == 0) {
                        $aduana->setId($_POST['id']);
                        $save = $aduana->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($aduanas, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $aduana->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $aduana->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAduanas');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAduanas');
        }
    }

    public function deleteAduana()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $aduana = new Aduana();
            $aduana->setId($id);
            $aduana->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAduanas');
    }

    public function showCarroTanques()
    {
        $carro  = new CarroTanque();
        $carros = $carro->getAll();

        $est     = new Estatus();
        $estatus = $est->getAll();
        require '../../views/catalogos/carro_tanques.php';
    }

    public function saveCarroTanque()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');
        if (isset($_POST['numero']) && $_POST['numero'] != '') {
            $return = isset($_POST['return']) ? true : false;
            $id     = isset($_POST['id']) && $_POST['id'] != '' ? $_POST['id'] : null;
            $carro  = new CarroTanque();
            $carro->setNumero($_POST['numero']);
            $carro->setIdEstatus($_POST['estatus']);
            $carros = $carro->getAll();

            if (!empty($carros)) {
                $errores = array();
                $nombre  = $carro->getNumero();

                if ($id != null || $id != '') {
                    $errores = UtilsHelp::validarNombreClaveUnico($carros, $nombre, null);
                    if (count($errores) == 0) {
                        $carro->setId($id);
                        $save = $carro->edit();
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                } else {
                    $errores = UtilsHelp::validarNombreClaveExiste($carros, $nombre, null);
                    if (count($errores) == 0) {
                        $save                = $carro->save();
                        $_SESSION['errores'] = $errores;
                    } else {
                        $_SESSION['errores'] = $errores;
                    }
                }
            } else {
                $save = $carro->save();
            }

            if ($save) {
                if ($return) {
                    $ultimoId = $carro->getIdUltimoId();
                    return print_r(json_decode($ultimoId));
                }
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }

            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCarroTanques');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCarroTanques');
        }
    }

    public function deleteCarroTanque()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $carro = new CarroTanque();
            $carro->setId($id);
            $carro->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showCarroTanques');
    }

    public function getCarroTanquesDisponibles()
    {
        $carro             = new CarroTanque();
        $carrosDisponibles = $carro->getDisponiblesAndIdCarro();
        print_r(json_encode($carrosDisponibles));
    }

    public function buscarNumeroCarroTanque()
    {
        if (isset($_POST['carroTanque'])) {
            $numero = $_POST['carroTanque'];

            $carro = new CarroTanque();
            $carro->setNumero($numero);
            $c = $carro->getByNumero();

            print_r(json_encode($c));
        }
    }

    public function getDirectorio()
    {
        require_once models_root . 'catalogos/directorio.php';

        $dir        = new Directorio();
        $directorio = $dir->getAll();
        print_r(json_encode($directorio));
    }

    public function evaluarProveedor()
    {
        Utils::noLoggin();
        if (isset($_GET['idProv']) && $_GET['idProv'] != '') {
            $id          = $_GET['idProv'];
            $fechaInicio = isset($_GET['fechaIni']) && $_GET['fechaIni'] != '' ? $_GET['fechaIni'] : null;
            $fechaFinal  = isset($_GET['fechaFin']) && $_GET['fechaFin'] != '' ? $_GET['fechaFin'] : null;

            $fechaIni  = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_GET['fechaIni'])));
            $fechaFin  = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_GET['fechaFin'])));
            $proveedor = new Proveedor();
            $proveedor->setId($id);
            $prov = $proveedor->getById();
            $eval = $proveedor->getEvaluaciones($id, $fechaIni, $fechaFin);
            if ($eval != null && count($eval) > 0) {
                $pregunta1    = 0;
                $pregunta2    = 0;
                $pregunta3    = 0;
                $pregunta4    = 0;
                $evaluaciones = count($eval);
                foreach ($eval as $e) {
                    $arrayEval = json_decode($e->evaluacion);

                    $pregunta1 += ($arrayEval->pregunta1);
                    $pregunta2 += ($arrayEval->pregunta2);
                    $pregunta3 += ($arrayEval->pregunta3);
                    $pregunta4 += ($arrayEval->pregunta4);
                }

                $prom1 = round($pregunta1 / $evaluaciones);
                $prom2 = round($pregunta2 / $evaluaciones);
                $prom3 = round($pregunta3 / $evaluaciones);
                $prom4 = round($pregunta4 / $evaluaciones);

                $suma = $prom1 + $prom2 + $prom3 + $prom4;

                $promedio       = $suma / 4;
                $calificacion   = $promedio * 20;
                $documentoNorma = new DocumentoNorma();
                $doc            = $documentoNorma->getByCodigo('FO-AB-014');

                if (isset($_GET['imprimir'])) {
                    require_once utils_root . 'toPDF/pdf.php';
                    PDF::crearPdfEvaluacionProveedor($prov, $eval, $fechaInicio, $fechaFinal, $doc);
                } else {
                    $fechaProxEvaluacion = date('Y-m-d', strtotime(UtilsHelp::today() . '+ 6 month'));
                    $update              = $proveedor->updateEvaluacion($calificacion, $fechaProxEvaluacion);

                    require '../../views/catalogos/formato_eval_prov_transporte.php';
                }
            } else {
                header('Location:' . root_url . '?controller=Error&action=errorNoEvaluacionesProveedores');
            }
        }
    }

    public function showEquipoComputo()
    {
        $equipo  = new EquipoComputo();
        $equipos = $equipo->getAll();

        $usuario  = new Usuario();
        $usuarios = $usuario->getAll();

        require '../../views/catalogos/equipo_computo.php';
    }

    public function saveEquipoComputo()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['tipoEquipo']) && $_POST['modelo'] != '' && isset($_POST['marca']) && $_POST['serie'] != '') {
            $id              = $_POST['id'] != '' ? $_POST['id'] : null;
            $tipoEquipo      = $_POST['tipoEquipo'];
            $modelo          = $_POST['modelo'];
            $marca           = $_POST['marca'];
            $serie           = $_POST['serie'];
            $factura         = $_POST['factura'];
            $fechaAlta       = $_POST['fechaAlta'] == '' ? null : str_replace('/', '-', $_POST['fechaAlta']);
            $procesador      = $_POST['procesador'];
            $discoDuro       = $_POST['discoDuro'];
            $ram             = $_POST['ram'];
            $usuario         = $_POST['usuarioId'];
            $fechaAsignacion = $_POST['fechaAsignacion'] == '' ? null : str_replace('/', '-', $_POST['fechaAsignacion']);
            $macEthernet     = $_POST['macEthernet'];
            $macWifi         = $_POST['macWifi'];
            $aplicaciones    = isset($_POST['aplicaciones']) ? $_POST['aplicaciones'] : '';
            $observaciones   = $_POST['observaciones'];

            $equipo = new EquipoComputo();
            $equipo->setTipoEquipo($tipoEquipo);
            $equipo->setUsuarioId($usuario != '' ? $usuario : 'null');
            $equipo->setModelo($modelo);
            $equipo->setNumeroSerie($serie);
            $equipo->setMarca($marca);
            $equipo->setFactura($factura);
            $equipo->setProcesador($procesador);
            $equipo->setMemoriaRam($ram);
            $equipo->setdiscoDuro($discoDuro);
            $equipo->setFechaCompra($fechaAlta != null ? date('Y-m-d', strtotime($fechaAlta)) : null);
            $equipo->setFechaAsignacion($fechaAsignacion != null ? date('Y-m-d', strtotime($fechaAsignacion)) : null);
            $equipo->setRedLan($macEthernet);
            $equipo->setRedWifi($macWifi);
            $equipo->setAplicaciones(json_encode($aplicaciones));
            $equipo->setObservaciones($observaciones);

            if ($id != null) {
                $equipo->setId($id);
                $save = $equipo->edit();
            } else {
                $ultimo      = $equipo->ultimoEquipoTipoEquipo();
                $folio       = $ultimo->folio != null ? $ultimo->folio : 'LLM-' . $tipoEquipo . '-0';
                $ultimoFolio = substr($folio, strrpos($folio, '-') + 1);
                $sigFolio    = 'LLM-' . $tipoEquipo . '-' . ($ultimoFolio + 1);
                $equipo->setFolio($sigFolio);
                $save = $equipo->save();
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEquipoComputo');
        }
    }

    public function deleteEquipoComputo()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $equipo = new EquipoComputo();
            $equipo->setId($id);
            $equipo->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showEquipoComputo');
    }

    public function exportarInventarioEquipoComputo()
    {
        Utils::noLoggin();
        if (isset($_POST['formato'])) {
            $e       = new EquipoComputo();
            $equipos = $e->getAll();
            require_once utils_root . 'toExcel/excel.php';
            $documentoNorma = new DocumentoNorma();
            $doc            = $documentoNorma->getByCodigo('FO-SI-004');
            Excel::generarInventarioEquipoComputo($equipos, $doc);
        }
    }

    public function equipoComputoByTipo()
    {
        if (isset($_POST['tipoEquipo'])) {
            $tipoEquipo = $_POST['tipoEquipo'];
            $usuario    = $_POST['idUsuario'] == 0 ? null : $_POST['idUsuario'];

            $equipo = new EquipoComputo();
            $e      = $equipo->getEquipoByTipoUsuario($tipoEquipo, $usuario);

            print_r(json_encode($e));
        }
    }

    public function equipoComputoById()
    {
        if (isset($_POST['idEquipo'])) {
            $idEquipo = $_POST['idEquipo'];

            $equipo = new EquipoComputo();
            $e      = $equipo->getEquipoById($idEquipo);

            print_r(json_encode($e));
        }
    }

    public function showTiposProductosResinasLiquidos()
    {
        $tipoProducto   = new TipoProductosResinasLiquidos();
        $tiposProductos = $tipoProducto->getAll();
        require '../../views/catalogos/tipos_productos_resinas_liquidos.php';
    }

    public function saveTipoProductoResinasLiquidos()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $tipoProducto = new TipoProductosResinasLiquidos();
            $tipoProducto->setNombre($_POST['nombre']);
            $tipoProducto->setDescripcion($_POST['descripcion']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $tipoProducto->setId($_POST['id']);
                $save = $tipoProducto->edit();
            } else {
                $save = $tipoProducto->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposProductosResinasLiquidos');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposProductosResinasLiquidos');
        }
    }

    public function deleteTipoProductoResinasLiquidos()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $producto = new TipoProductosResinasLiquidos();
            $producto->setId($id);
            $producto->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposProductosResinasLiquidos');
    }

    public function showProductosResinasLiquidos()
    {
        $producto  = new ProductoResinaLiquido();
        $productos = $producto->getAll();

        $tipoProducto   = new TipoProductosResinasLiquidos();
        $tiposProductos = $tipoProducto->getAll();

        require '../../views/catalogos/productos_resinas_liquidos.php';
    }

    public function getProductosResinasLiquidos()
    {
        $producto  = new ProductoResinaLiquido();
        $productos = $producto->getAll();

        $tipoProducto   = new TipoProductosResinasLiquidos();
        $tiposProductos = $tipoProducto->getAll();

        print_r(json_encode($productos));
    }

    public function saveProductoResinaLiquido()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['producto']) && $_POST['producto'] != '') {
            $producto = new ProductoResinaLiquido();
            $producto->setNombre($_POST['producto']);
            $producto->setTipoProductoId($_POST['tipoProducto']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $producto->setId($_POST['id']);
                $save = $producto->edit();
            } else {
                $save = $producto->save();
            }
            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductosResinasLiquidos');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductosResinasLiquidos');
        }
    }

    public function deleteProductoResinasLiquidos()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $producto = new ProductoResinaLiquido();
            $producto->setId($id);
            $producto->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showProductosResinasLiquidos');
    }

    public function showTiposEmpaques()
    {
        $tipo          = new TipoEmpaque();
        $tiposEmpaques = $tipo->getAll();
        require '../../views/catalogos/tipos_empaques.php';
    }

    public function saveTipoEmpaque()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $tipo = new TipoEmpaque();
            $tipo->setNombre($_POST['nombre']);
            $tipo->setDescripcion($_POST['descripcion']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $tipo->setId($_POST['id']);
                $save = $tipo->edit();
            } else {
                $save = $tipo->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposEmpaques');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposEmpaques');
        }
    }

    public function deleteTipoEmpaque()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $tipo = new TipoEmpaque();
            $tipo->setId($id);
            $tipo->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showTiposEmpaques');
    }

    public function showServicios()
    {
        $servicio  = new Servicio();
        $servicios = $servicio->getAll();
        require '../../views/catalogos/servicios.php';
    }

    public function saveServicio()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $servicio = new Servicio();
            $servicio->setNombre($_POST['nombre']);
            $servicio->setDescripcion($_POST['descripcion']);
            $servicio->setClave($_POST['clave']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $servicio->setId($_POST['id']);
                $save = $servicio->edit();
            } else {
                $save = $servicio->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showServicios');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showServicios');
        }
    }

    public function deleteServicio()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $servicio = new Servicio();
            $servicio->setId($id);
            $servicio->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showServicios');
    }

    public function getServicioById()
    {
        if (isset($_POST['idServ'])) {
            $idServicio = $_POST['idServ'];

            $servicio = new Servicio();
            $servicio->setId($idServicio);
            $s = $servicio->getServicioById();

            print_r(json_encode($s));
        }
    }

    public function showAlmacenes()
    {
        $a         = new Almacen();
        $almacenes = $a->getAll();
        require '../../views/catalogos/almacenes.php';
    }

    public function saveAlmacen()
    {
        Utils::deleteSession('result');
        Utils::deleteSession('errores');

        if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
            $a = new Almacen();
            $a->setNombre($_POST['nombre']);
            $a->setDescripcion($_POST['descripcion']);

            if ($_POST['id'] != null || $_POST['id'] != '') {
                $a->setId($_POST['id']);
                $save = $a->edit();
            } else {
                $save = $a->save();
            }

            if ($save) {
                $_SESSION['result'] = 'true';
            } else {
                $_SESSION['result'] = 'false';
            }
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAlmacenes');
        } else {
            header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAlmacenes');
        }
    }

    public function deleteAlmacen()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $a = new Almacen();
            $a->setId($id);
            $a->delete();
        }
        header('Location:' . catalogosUrl . '?controller=Catalogo&action=showAlmacenes');
    }

    public function getAlmacenes()
    {
        $a         = new Almacen();
        $almacenes = $a->getAll();
        print_r(json_encode($almacenes));
    }
}