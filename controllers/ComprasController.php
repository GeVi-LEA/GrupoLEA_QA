<?php
require_once utils_root . 'utilsHelp.php';
require_once utils_root . 'error_log.php';
require_once models_root . 'catalogos/unidad.php';
require_once models_root . 'catalogos/tipo_solicitud.php';
require_once models_root . 'catalogos/proveedor.php';
require_once models_root . 'catalogos/usuario.php';
require_once models_root . 'catalogos/estatus.php';
require_once models_root . 'catalogos/documento_norma.php';
require_once models_root . 'compras/requisicion.php';
require_once models_root . 'compras/orden_compra.php';
require_once models_root . 'compras/embarque.php';
require_once models_root . 'compras/pedimento.php';
require_once models_root . 'compras/recepcion_flete.php';
require_once models_root . 'catalogos/cliente.php';
require_once models_root . 'catalogos/producto.php';
require_once models_root . 'catalogos/aduana.php';
require_once models_root . 'catalogos/tipo_transporte.php';
require_once models_root . 'catalogos/ruta.php';
require_once models_root . 'catalogos/carro_tanque.php';

class comprasController
{
    public function index()
    {
        Utils::noLoggin();
        $req      = new Requisicion();
        $orden    = new OrdenCompra();
        $embarque = new Embarque();

        $requisiciones = $req->getUltimasRequisiciones();
        $ordenes       = $orden->getUltimasOrdenes();
        $embarques     = $embarque->getUltimosEmbarques();
        require_once views_root . 'compras/compras.php';
    }

    public function requisiciones()
    {
        Utils::noLoggin();
        // $_SESSION['title'] = 'Requisiciones';
        $idEst = null;
        $req   = new Requisicion();
        if (isset($_GET['idEst'])) {
            $idEst = (int) $_GET['idEst'];
        }
        $requisiciones = $req->getByEstatusId($idEst);
        // $requisiciones = $req->getByEstatusCliente($idEst, '');

        $cliente  = new Cliente();
        $clientes = $cliente->getAll();

        // require_once views_root . 'compras/lista_requisiciones.php';
        require_once views_root . 'compras/requisiciones.php';
    }

    public function requisicionesb()
    {
        Utils::noLoggin();
        // $_SESSION['title'] = 'Requisiciones';
        $idEst = null;
        $req   = new Requisicion();
        if (isset($_GET['idEst'])) {
            $idEst = (int) $_GET['idEst'];
        }
        $requisiciones = $req->getByEstatusId($idEst);
        // $requisiciones = $req->getByEstatusCliente($idEst, '');

        $cliente  = new Cliente();
        $clientes = $cliente->getAll();

        require_once views_root . 'compras/lista_requisiciones.php';
        // require_once views_root . 'compras/requisicionesb.php';
    }

    public function buscarRequisicion()
    {
        Utils::noLoggin();
        $req         = new Requisicion();
        $folio       = isset($_POST['folioBuscar']) && $_POST['folioBuscar'] != '' ? $_POST['folioBuscar'] : null;
        $fechaIni    = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] != '' ? $_POST['fechaInicio'] : null;
        $fechaFin    = isset($_POST['fechaFin']) && $_POST['fechaFin'] != '' ? $_POST['fechaFin'] : null;
        $proveedor   = isset($_POST['proveedor']) && $_POST['proveedor'] != '' ? $_POST['proveedor'] : null;
        $solicitud   = isset($_POST['solicitud']) && $_POST['solicitud'] != '' ? $_POST['solicitud'] : null;
        $fechaInicio = null;
        $fechaFinal  = null;
        if ($fechaIni != null) {
            $fechaInicio = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaIni)));
        }

        if ($fechaFin != null) {
            $fechaFinal = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaFin)));
        }
        $idEst = null;

        $requisiciones = $req->getRequisicionByFolioFechasProv($folio, $proveedor, $solicitud, $fechaInicio, $fechaFinal);

        require_once views_root . 'compras/lista_requisiciones.php';
    }

    public function requisicion()
    {
        Utils::noLoggin();
        $usuario = new Usuario();
        if (isset($_SESSION['usuario'])) {
            $user = $usuario->getById($_SESSION['usuario']->id);
        } else {
            header('Location:' . root_url . '?controller=Error&action=noLoggin');
        }

        if (isset($_GET['id'])) {
            $id        = $_GET['id'];
            $requicion = new Requisicion();
            $req       = $requicion->getReqById($id);
        }

        $solicitud   = new TipoSolicitud();
        $solicitudes = $solicitud->getAll();
        $proveedor   = new Proveedor();
        $proveedores = $proveedor->getAll();

        $unidad   = new Unidad();
        $unidades = $unidad->getAll();

        // require_once views_root . 'compras/requisiciones.php';
        require_once views_root . 'compras/requisicion.php';
    }

    public function requisicionpop()
    {
        Utils::noLoggin();
        $usuario = new Usuario();
        if (isset($_SESSION['usuario'])) {
            $user = $usuario->getById($_SESSION['usuario']->id);
        } else {
            header('Location:' . root_url . '?controller=Error&action=noLoggin');
        }
        $req = null;
        if (isset($_GET['id']) && ($_GET['id'] != '0')) {
            $id        = $_GET['id'];
            $requicion = new Requisicion();
            $req       = $requicion->getReqById($id);
        }

        $solicitud   = new TipoSolicitud();
        $solicitudes = $solicitud->getAll();
        $proveedor   = new Proveedor();
        $proveedores = $proveedor->getAll();

        $unidad   = new Unidad();
        $unidades = $unidad->getAll();

        require_once views_root . 'compras/requisicion_pop.php';
    }

    public function generarRequisicion()
    {
        if (isset($_POST['proveedor']) && isset($_POST['idUsuario'])) {
            $id              = isset($_POST['id']) ? $_POST['id'] : null;
            $ruta            = $_POST['idRuta'] != '' ? $_POST['idRuta'] : 'null';
            $aduana          = $_POST['idAduana'] != '' ? $_POST['idAduana'] : 'null';
            $cliente         = $_POST['idCliente'] != '' ? $_POST['idCliente'] : 'null';
            $producto        = $_POST['idProducto'] != '' ? $_POST['idProducto'] : 'null';
            $transporte      = $_POST['idTransporte'] != '' ? $_POST['idTransporte'] : 'null';
            $cantidadFlete   = $_POST['cantidadFlete'] != '' ? $_POST['cantidadFlete'] : 'null';
            $flete           = $_POST['flete'] != '' ? $_POST['flete'] : 'null';
            $empresa         = isset($_POST['empresa']) ? $_POST['empresa'] : null;
            $estatus         = $_POST['idEstatus'];
            $proveedor       = $_POST['proveedor'];
            $fechaSolicitud  = $_POST['fechaSolicitud'] == '' ? new DateTime() : UtilsHelp::covertDatetoDateSql($_POST['fechaSolicitud']);
            $fechaRequerida  = $_POST['fechaRequerida'] == '' ? new DateTime() : UtilsHelp::covertDatetoDateSql($_POST['fechaRequerida']);
            $usuarioId       = $_POST['idUsuario'];
            $urgente         = $_POST['urgente'];
            $proyecto        = isset($_POST['proyecto']) ? $_POST['proyecto'] : '';
            $descProyecto    = isset($_POST['descProyecto']) ? $_POST['descProyecto'] : '';
            $descripciones   = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
            $unidades        = $_POST['unidad'];
            $preciosUnitario = $_POST['precioUnitario'];
            $cantidades      = $_POST['cantidad'];
            $moneda          = $_POST['moneda'];
            $idDetalles      = $_POST['idDetalle'];
            $observaciones   = $_POST['observaciones'] == '' ? null : $_POST['observaciones'];
            $folio           = $_POST['folio'] == '' ? null : $_POST['folio'];
            $requisicion     = new Requisicion();
            $requisicion->setRuta($ruta);
            $requisicion->setAduana($aduana);
            $requisicion->setCliente($cliente);
            $requisicion->setProducto($producto);
            $requisicion->setTransporteId($transporte);
            $requisicion->setCantidadFlete($cantidadFlete);
            $requisicion->setTipoFlete($flete);
            $requisicion->setEmpresa($empresa);
            $requisicion->setProvedorId($proveedor);
            $requisicion->setFechaSolicitud(date('Y-m-d', strtotime($fechaSolicitud)));
            $requisicion->setFechaRequerida(date('Y-m-d', strtotime($fechaRequerida)));
            $requisicion->setUsuarioId($usuarioId);
            $requisicion->setUrgente($urgente);
            $requisicion->setProyecto($descProyecto);
            $requisicion->setNumProyecto($proyecto);
            $requisicion->setObservaciones($observaciones);
            $requisicion->setMoneda($moneda);

            if ($id == null) {
                // estatus 1
                $requisicion->setEstatusId(1);
                $folioUltimaReq = $requisicion->getUltimaReq()->folio;
                $nextFolio      = intval(UtilsHelp::recortarString($folioUltimaReq, '-', true)) + 1;
                $requisicion->setFolio('REQ-' . $nextFolio);
            }
            if (isset($_FILES['documento']) && $_FILES['documento'] != null) {
                $file = $_FILES['documento'];
                // print_r('<pre>');
                // print_r($file);
                // print_r('</pre>');
                if ($folio == null) {
                    $filename = 'Cot-' . $requisicion->getFolio() . '.pdf';
                } else {
                    $filename = 'Cot-' . $folio . '.pdf';
                }
                $mimetype = $file['type'];
                // print_r('<pre>');
                // print_r($mimetype);
                // print_r('</pre>');
                // phpinfo();
                // die ();
                if ($mimetype == 'application/pdf') {
                    if (!is_dir('views/compras/uploads/cotizaciones')) {
                        mkdir('views/compras/uploads/cotizaciones', 0777, true);
                    }
                    if (file_exists('views/compras/uploads/cotizaciones/' . $filename)) {
                        unlink('views/compras/uploads/cotizaciones/' . $filename);
                    }
                    move_uploaded_file($file['tmp_name'], 'views/compras/uploads/cotizaciones/' . $filename);
                    $requisicion->setCotizacion($filename);
                }
            } else {
                $requisicion->setCotizacion(null);
            }
            foreach ($cantidades as $cantidad) {
                $c[] = Utils::quitarComas($cantidad);
            }
            foreach ($descripciones as $descripcion) {
                $d[] = trim($descripcion);
            }
            foreach ($unidades as $unidad) {
                $u[] = $unidad;
            }
            foreach ($idDetalles as $idDetalle) {
                $id_d[] = $idDetalle;
            }
            foreach ($preciosUnitario as $precioUni) {
                $pr_u[] = Utils::quitarComas($precioUni);
            }

            $detalles = array();
            try {
                // code...
                for ($i = 0; $i < count($d); $i++) {
                    $detalles[] = [
                        'idDetalle'      => $id_d[$i],
                        'descripcion'    => ucfirst($d[$i]),
                        'unidad'         => $u[$i],
                        'precioUnitario' => $pr_u[$i],
                        'cantidad'       => $c[$i],
                        'precio'         => $pr_u[$i] * $c[$i],
                    ];
                }
                $requisicion->setDetalles($detalles);
            } catch (\Throwable $th) {
                // throw $th;
            }

            if ($id == null) {
                $saveReq = $requisicion->save();
                header('Location:' . principalUrl . '?controller=Compras&action=index');
            } else {
                $requisicion->setId($id);
                $saveReq = $requisicion->edit();
                // print_r('<pre>');
                // print_r($requisicion);
                // print_r('</pre>');
                // die ();

                if ($saveReq && ($estatus == 5)) {
                    $save = $this->actualizarOrdenCompra($id);
                }
                header('Location:' . principalUrl . '?controller=Compras&action=requisicionpop&id=' . $id);
            }
        }
    }

    public function eliminarCotizacion()
    {
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $id         = $_POST['idReq'];
            $cotizacion = $_POST['cotizacionReq'];
            $req        = new Requisicion();
            $result     = $req->deleteCotizacionReq($id);

            if (file_exists('../../views/compras/uploads/cotizaciones/' . $cotizacion)) {
                unlink('../../views/compras/uploads/cotizaciones/' . $cotizacion);
            }
        }
        echo $result;
    }

    public function deleteRequision()
    {
        $result = false;
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $id     = $_POST['idReq'];
            $req    = new Requisicion();
            $result = $req->deleteRequision($id);
        }
        echo $result;
    }

    public function deleteDetalle()
    {
        $result = false;
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $id     = $_POST['idReq'];
            $req    = new Requisicion();
            $result = $req->deleteDetalle($id);
        }
        echo $result;
    }

    public function showRequisicion()
    {
        if (isset($_GET['idReq']) && $_GET['idReq'] != '') {
            $id  = $_GET['idReq'];
            $req = new Requisicion();
            $r   = $req->getReqById($id);

            $empresa = empresas[intval($r['empresa'])];

            $documentoNorma = new DocumentoNorma();
            $doc            = $documentoNorma->getByCodigo('FO-AB-009');

            if ($r['firmas'] != null) {
                $firmas = array();
                $firmas = json_decode($r['firmas'], TRUE);
            } else {
                $firmas = array(
                    'firma1' => 0,
                    'firma2' => 0,
                    'firma3' => 0
                );
            }
            require_once views_root . 'compras/formato_requisicion.php';
        }
    }

    public function imprimirRequisicion($id = null, $mostrar = true)
    {
        if (isset($_GET['idReq']) && $_GET['idReq'] != '') {
            $id = $_GET['idReq'];
        }
        if ($id != null) {
            require_once utils_root . 'toPDF/pdf.php';
            $req = new Requisicion();
            $r   = $req->getReqById($id);

            $documentoNorma = new DocumentoNorma();
            $doc            = $documentoNorma->getByCodigo('FO-AB-009');

            try {
                // code...
                PDF::crearPdfRequisicion($r, $doc, $mostrar);
            } catch (Exception $th) {
                print_r('<pre>');
                print_r($th);
                print_r('</pre>');
            }
        }
    }

    public function firmarReqisicion()
    {
        Utils::noLoggin();
        if (isset($_POST['idReq'])) {
            $firma   = isset($_POST['firmas']) ? (int) $_POST['firmas'] : 0;
            $firma1  = (int) $_POST['firma1'];
            $firma2  = (int) $_POST['firma2'];
            $firma3  = (int) $_POST['firma3'];
            $usuario = $_SESSION['usuario'];
            $idReq   = intval($_POST['idReq']);

            if ($firma == 0) {
                $firmas = array(
                    'firma1' => $firma1,
                    'firma2' => $firma2,
                    'firma3' => $firma3
                );
            }

            if ($firma == 1) {
                $firmas = array(
                    'firma1' => (int) $usuario->id,
                    'firma2' => $firma2,
                    'firma3' => $firma3
                );
            }
            if ($firma == 2) {
                $firmas = array(
                    'firma1' => $firma1,
                    'firma2' => (int) $usuario->id,
                    'firma3' => $firma3
                );
            }
            if ($firma == 3) {
                $firmas = array(
                    'firma1' => $firma1,
                    'firma2' => $firma2,
                    'firma3' => (int) $usuario->id
                );
            }

            if ($firmas['firma1'] == 0 && $firmas['firma2'] == 0 && $firmas['firma3'] == 0) {
                $est = 1;
            } else if ($firmas['firma1'] != 0 && $firmas['firma2'] != 0 && $firmas['firma3'] != 0) {
                $est = 4;
            } else {
                $est = 3;
            }
            $req = new Requisicion();
            $req->setId($idReq);
            $req->setEstatusId($est);
            $req->setFirmas(json_encode($firmas));
            $r = $req->updateFirmas();
        }
        header('Location:' . root_url . '?controller=Compras&action=showRequisicion&idReq=' . $idReq);
    }

    public function enviarCorreoRequisicion()
    {
        if (isset($_POST['correos']) && isset($_POST['folio']) && isset($_POST['idReq'])) {
            $correos  = json_decode($_POST['correos']);
            $folio    = $_POST['folio'];
            $texto    = $_POST['cuerpo'];
            $rechazar = $_POST['rechazar'];
            $adjReq   = $_POST['adjReq'];
            $adjCot   = $_POST['adjCot'];
            $idReq    = $_POST['idReq'];
            if (UtilsHelp::validarCorreos($correos)) {
                require_once utils_root . 'email/email.php';
                $mail = new Mail();

                $mail->setCorreos($correos);
                $mail->setBody($texto);

                if ($rechazar == 1) {
                    $firmas = array(
                        'firma1' => 0,
                        'firma2' => 0,
                        'firma3' => 0
                    );
                    $est = 1;
                    $req = new Requisicion();
                    $req->setId($idReq);
                    $req->setEstatusId($est);
                    $req->setFirmas(json_encode($firmas));
                    $r = $req->updateFirmas();
                    $mail->setSubject('Se rechazo la requisición ' . $folio);
                } else {
                    $mail->setSubject('Requisición ' . $folio);
                }

                if ($adjReq == 1) {
                    $this->imprimirRequisicion($idReq, false);
                    $mail->setArchivo1($folio);
                    $mail->setRuta1(views_root . 'compras/requisiciones/' . $folio . '.pdf');
                }

                if ($adjCot == 1) {
                    $mail->setArchivo2('Cot-' . $folio);
                    $mail->setRuta2(views_root . 'compras/uploads/cotizaciones/Cot-' . $folio . '.pdf');
                }

                $send = Mail::enviarCorreoReq($mail);

                echo json_encode($send);
            }
        }
    }

    public function generarOrdenCompra()
    {
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $conIva = $_POST['iva'] == 1 ? true : false;
            $id     = $_POST['idReq'];
            $req    = new Requisicion();
            $r      = $req->getReqById($id);

            $empresa = empresas[intval($r['empresa'])];

            $orden       = new OrdenCompra();
            $ultimaOrden = $orden->ultimaOrdenByEmpresa($r['empresa']);
            $folio       = $ultimaOrden->folio != null ? $ultimaOrden->folio : $empresa['folio'] . '-0';

            $ultimoFolio = substr($folio, strpos($folio, '-') + 1);

            $sigFolio = $empresa['folio'] . '-' . ($ultimoFolio + 1);
            $importe  = 0;
            foreach ($r['detalle'] as $d) {
                $importe += floatval($d['precio']);
            }
            $nuevaOrden = new OrdenCompra();
            $nuevaOrden->setRequisicionId($id);
            $nuevaOrden->setEstatusId(1);
            $nuevaOrden->setFolio($sigFolio);
            $nuevaOrden->setImporte($importe);
            $nuevaOrden->setPagos(0);
            if ($conIva) {
                if ($r['solicitud'] == 'Transporte') {
                    $iva       = $importe * impuestos['iva'];
                    $sub_total = $importe + $iva;
                    $isr       = (float) $r['detalle'][0]['precio_unitario'] * impuestos['isr_trans'];
                    $retencion = 0;
                    $total     = $sub_total - $isr;
                } else if ($r['solicitud'] == 'Honorarios') {
                    $iva       = $importe * impuestos['iva'];
                    $sub_total = $importe + $iva;
                    $isr       = $importe * impuestos['isr_hon'];
                    $retencion = $importe * impuestos['ret_iva'];
                    $total     = $sub_total - ($isr + $retencion);
                } else {
                    $iva       = $importe * impuestos['iva'];
                    $sub_total = $importe + $iva;
                    $total     = $sub_total;
                    $isr       = 0;
                    $retencion = 0;
                }
            } else {
                $iva       = 0;
                $sub_total = $importe;
                $total     = $sub_total;
                $isr       = 0;
                $retencion = 0;
            }
            $nuevaOrden->setIva($iva);
            $nuevaOrden->setSubTotal($sub_total);
            $nuevaOrden->setisr($isr);
            $nuevaOrden->setRetencionIva($retencion);
            $nuevaOrden->setTotal($total);
            $save = $nuevaOrden->save();

            if ($save) {
                // Estado 5 finalizada
                $save = $req->updateEstatus(5, $id);
                if ($r['producto_id'] != null && $r['transporte_id'] == 1) {
                    require_once utils_root . 'email/email.php';
                    Mail::solicitarFleteCorreo($sigFolio, $r['detalle'][0]);
                }
            } else {
                $orden_compra = new OrdenCompra();
                $orden_compra->setRequisicionId($id);
                $r = $orden_compra->getByRequisicionId();
                if ($r != null) {
                    $save = $req->updateEstatus(5, $id);
                }
            }
        }
        echo $save;
    }

    public function ordenesDeCompra()
    {
        Utils::noLoggin();
        // $_SESSION['title'] = 'Ordenes de Compra';
        $orden = new OrdenCompra();
        $idEst = null;
        if (isset($_GET['embarque'])) {
            $idEst   = 3;
            $result  = $orden->getByEstatusId($idEst);
            $ordenes = array();
            foreach ($result as $res) {
                if ($res['id_producto'] != null && empty($res['embarque'])) {
                    $ordenes[] = $res;
                }
            }
        } else {
            if (isset($_GET['idEst'])) {
                $idEst = (int) $_GET['idEst'];
            }
            $ordenes = $orden->getByEstatusId($idEst);
        }

        require_once views_root . 'compras/lista_ordenes_compra.php';
    }

    public function showOrdenCompra()
    {
        if (isset($_GET['idOrden']) && $_GET['idOrden'] != '') {
            $id = $_GET['idOrden'];

            $orden = new OrdenCompra();
            $orden->setId($id);
            $oc  = $orden->getById();
            $req = new Requisicion();
            $r   = $req->getReqById($oc->requisicion_id);

            if ($r['cliente_id'] != null) {
                $cliente = new Cliente();
                $cliente->setId($r['cliente_id']);
                $cli = $cliente->getClienteById()[0];
            }

            $cuotaExenta = in_array($r['rfc_provedor'], rfc_cuotaExenta);

            $empresa        = empresas[intval($r['empresa'])];
            $documentoNorma = new DocumentoNorma();
            $doc            = $documentoNorma->getByCodigo('FO-AB-010');

            $moneda = monedas[intval($r['moneda'])];
            require_once utils_root . 'num2String/num2String.php';
            $totalLetra = Num2String::moneyToString(Utils::quitarComas($oc->total), $moneda);

            $sumaCantidad = 0;
            foreach ($r['detalle'] as $d) {
                $sumaCantidad += $d['cantidad'];
            }
            require_once views_root . 'compras/formato_orden_compra.php';
        }
    }

    public function imprimirOrdenCompra($id = null, $mostrar = true)
    {
        if (isset($_GET['idOrden']) && $_GET['idOrden'] != '') {
            $id = $_GET['idOrden'];
        }
        if ($id != null) {
            $orden = new OrdenCompra();
            $orden->setId($id);
            $oc  = $orden->getById();
            $req = new Requisicion();

            $r   = $req->getReqById($oc->requisicion_id);
            $cli = null;
            if ($r['cliente_id'] != null) {
                $cliente = new Cliente();
                $cliente->setId($r['cliente_id']);
                $cli = $cliente->getClienteById()[0];
            }

            $documentoNorma = new DocumentoNorma();
            $doc            = $documentoNorma->getByCodigo('FO-AB-010');
            require_once utils_root . 'toPDF/pdf.php';
            PDF::crearPdfOrdenCompra($r, $oc, $doc, $cli, $mostrar);
        }
    }

    public function actualizarOrdenCompra($idReq)
    {
        if ($idReq != null) {
            $req = new Requisicion();
            $r   = $req->getReqById($idReq);

            $orden = new OrdenCompra();
            $orden->setRequisicionId($idReq);
            $o = $orden->getByRequisicionId();
            $orden->setId($o->id);

            $importe   = 0;
            $totalDesc = 0;
            foreach ($r['detalle'] as $d) {
                $importe   += floatval($d['precio']);
                $totalDesc += floatval($d['descuento']);
            }

            $importeOrden = $importe - $totalDesc;
            $orden->setImporte($importeOrden);
            $totalOrden = 0;

            $iva         = intval($o->iva) == 0 ? false : true;
            $isr         = intval($o->isr) == 0 ? false : true;
            $impuesto    = intval($o->impuesto) == 0 ? false : true;
            $notaCredito = intval($o->nota_credito);

            if ($iva) {
                $cuotaExenta = in_array($r['rfc_provedor'], rfc_cuotaExenta);
                if ($cuotaExenta) {
                    $cantidad = 0;
                    foreach ($r['detalle'] as $d) {
                        $cantidad += floatval($d['cantidad']);
                    }
                    $exenta   = $importeOrden - ($cantidad * 1000 * .374675);
                    $ivaOrden = $exenta * impuestos['iva'];
                } else {
                    if ($o->otro_iva == null) {
                        $porcentaje = impuestos['iva'];
                        $orden->setOtroIva('null');
                    } else {
                        $porcentaje = $o->otro_iva / 100;
                        $orden->setOtroIva($o->otro_iva);
                    }
                    $ivaOrden = $importeOrden * $porcentaje;
                }
                $sub_total = $importeOrden + $ivaOrden;
                $orden->setIva($ivaOrden);
                $orden->setSubTotal($sub_total);
                if ($isr) {
                    if ($impuesto) {
                        $impuestoOrden = $importeOrden * ($impuesto / 100);
                        $totalOrden    = $sub_total - $impuestoOrden;
                        $orden->setImpuesto($impuesto);
                        $orden->setIsr($impuestoOrden);
                        $orden->setRetencionIva(0);
                    } else {
                        $orden->setImpuesto(0);
                        if ($r['solicitud'] == 'Transporte') {
                            $isrOrden   = (float) $r['detalle'][0]['precio_unitario'] * impuestos['isr_trans'];
                            $totalOrden = $sub_total - $isrOrden;
                            $orden->setIsr($isrOrden);
                            $orden->setRetencionIva(0);
                        } else if ($r['solicitud'] == 'Honorarios') {
                            $isrOrden   = $importeOrden * impuestos['isr_hon'];
                            $retencion  = $importeOrden * impuestos['ret_iva'];
                            $totalOrden = $sub_total - ($isrOrden + $retencion);
                            $orden->setIsr($isrOrden);
                            $orden->setRetencionIva($retencion);
                        }
                    }
                } else {
                    $totalOrden = $sub_total;
                    $orden->setisr(0);
                    $orden->setRetencionIva(0);
                    $orden->setImpuesto(0);
                }
            } else {
                $sub_total  = $importeOrden;
                $totalOrden = $sub_total;
                $orden->setOtroIva('null');
                $orden->setIva(0);
                $orden->setSubTotal($sub_total);
                $orden->setIsr(0);
                $orden->setRetencionIva(0);
                $orden->setImpuesto(0);
            }

            $pagos = floatval($o->pagos);
            $orden->setPagos($pagos);
            $orden->setTotal($totalOrden - $pagos);
            $orden->setNotaCredito($notaCredito);
            $saveOrden = $orden->edit();
            if ($saveOrden) {
                echo true;
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    }

    public function editarOrdenCompra()
    {
        if (isset($_POST['id'])) {
            $id            = $_POST['id'];
            $iva           = $_POST['iva'];
            $isr           = $_POST['isr'];
            $cuota         = $_POST['cuota'];
            $nota          = $_POST['notaCredito'];
            $pagos         = $_POST['pagos'];
            $impuesto      = $_POST['addIsr'];
            $desc          = $_POST['descuentos'];
            $otroIva       = $_POST['otroIva'];
            $ids           = $_POST['ids'];
            $observaciones = $_POST['coments'];
            $descuentos    = explode(',', $desc);
            $idsDesc       = explode(',', $ids);

            $orden = new OrdenCompra();
            $orden->setId($id);
            $o = $orden->getById();

            $req     = new Requisicion();
            $r       = $req->getReqById($o->requisicion_id);
            $importe = 0;
            foreach ($r['detalle'] as $d) {
                $importe += floatval($d['precio']);
            }
            $totalDesc = 0;
            for ($i = 0; $i < count($descuentos); $i++) {
                $totalDesc += Utils::stringToFloat($descuentos[$i]);
            }
            $importeOrden = $importe - $totalDesc;
            $orden->setImporte($importeOrden);
            $totalOrden = 0;

            if ($iva == 1) {
                if ($cuota == 1) {
                    $cantidad = 0;
                    foreach ($r['detalle'] as $d) {
                        $cantidad += floatval($d['cantidad']);
                    }
                    $exenta   = $importeOrden - ($cantidad * 1000 * .374675);
                    $ivaOrden = $exenta * impuestos['iva'];
                    $orden->setOtroIva('null');
                } else {
                    if ($otroIva == null) {
                        $porcentaje = impuestos['iva'];
                        $orden->setOtroIva('null');
                    } else {
                        $porcentaje = $otroIva / 100;
                        $orden->setOtroIva($otroIva);
                    }
                    $ivaOrden = $importeOrden * $porcentaje;
                }
                $sub_total = $importeOrden + $ivaOrden;
                $orden->setIva($ivaOrden);
                $orden->setSubTotal($sub_total);
                if ($isr == 1) {
                    if ($impuesto != 0) {
                        $impuestoOrden = $importeOrden * ($impuesto / 100);
                        $totalOrden    = $sub_total - $impuestoOrden;
                        $orden->setImpuesto($impuesto);
                        $orden->setIsr($impuestoOrden);
                        $orden->setRetencionIva(0);
                    } else {
                        $orden->setImpuesto(0);
                        if ($r['solicitud'] == 'Transporte') {
                            $isrOrden   = (float) $r['detalle'][0]['precio_unitario'] * impuestos['isr_trans'];
                            $totalOrden = $sub_total - $isrOrden;
                            $orden->setIsr($isrOrden);
                            $orden->setRetencionIva(0);
                        } else if ($r['solicitud'] == 'Honorarios') {
                            $isrOrden   = $importeOrden * impuestos['isr_hon'];
                            $retencion  = $importeOrden * impuestos['ret_iva'];
                            $totalOrden = $sub_total - ($isrOrden + $retencion);
                            $orden->setIsr($isrOrden);
                            $orden->setRetencionIva($retencion);
                        }
                    }
                } else {
                    $totalOrden = $sub_total;
                    $orden->setisr(0);
                    $orden->setRetencionIva(0);
                    $orden->setImpuesto(0);
                }
            } else {
                $sub_total  = $importeOrden;
                $totalOrden = $sub_total;
                $orden->setOtroIva('null');
                $orden->setIva(0);
                $orden->setSubTotal($sub_total);
                $orden->setIsr(0);
                $orden->setRetencionIva(0);
                $orden->setImpuesto(0);
            }
            $orden->setPagos(Utils::quitarComas(floatval($pagos)));
            $orden->setTotal($totalOrden - Utils::stringToFloat($pagos));

            foreach ($descuentos as $descuento) {
                $det[] = Utils::stringToFloat($descuento == '' ? 0 : $descuento);
            }
            foreach ($idsDesc as $idsDet) {
                $id_d[] = intval($idsDet);
            }

            $detalles = array();
            for ($i = 0; $i < count($det); $i++) {
                $detalles[] = [
                    'idDetalle' => $id_d[$i],
                    'descuento' => $det[$i],
                ];
            }
            $orden->setNotaCredito($nota);
            if ($o->estatus_id = 5) {
                $orden->setEstatusId(3);
                $orden->updateEstatus();
            }
            $saveOrden = $orden->edit();
            $saveObs   = $req->editObservaciones(trim($observaciones), $o->requisicion_id);
            $saveDesc  = $req->editDescuento($detalles);
            if ($saveOrden && $saveDesc && $saveObs) {
                echo true;
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    }

    public function updateEstadoOrdenCompra()
    {
        if (isset($_POST['id'])) {
            $id    = $_POST['id'];
            $idEst = $_POST['estado'];
            $orden = new OrdenCompra();
            $orden->setId($id);
            $orden->setEstatusId($idEst);
            $edit = false;

            if ($idEst != 2) {
                $edit = $orden->updateEstatus();
            } else {
                $oc        = $orden->getById();
                $req       = new Requisicion();
                $editOrden = $orden->updateEstatus();
                $editReq   = $req->deleteRequision($oc->requisicion_id);
                if ($editOrden && $editReq) {
                    $edit = true;
                }
            }
            echo $edit;
        }
    }

    public function enviarCorreoOrdenCompra()
    {
        if (isset($_POST['correos']) && isset($_POST['folio']) && isset($_POST['idOrden'])) {
            Utils::noLoggin();
            $correos  = json_decode($_POST['correos']);
            $folio    = $_POST['folio'];
            $asunto   = $_POST['asunto'];
            $texto    = $_POST['cuerpo'];
            $adjOrden = $_POST['adjOrden'];
            $adjCot   = $_POST['adjCot'];
            $idOrden  = $_POST['idOrden'];
            if (UtilsHelp::validarCorreos($correos)) {
                require_once utils_root . 'email/email.php';
                $mail = new Mail();

                $mail->setCorreos($correos);
                $mail->setBody($texto);
                $mail->setSubject($asunto);

                if ($adjOrden == 1) {
                    $this->imprimirOrdenCompra($idOrden, false);
                    $mail->setArchivo1($folio);
                    $mail->setRuta1(views_root . 'compras/ordenesCompra/' . $folio . '.pdf');
                }

                if ($adjCot == 1) {
                    $mail->setArchivo2('Cot-' . $folio);
                    $mail->setRuta2(views_root . 'compras/uploads/cotizaciones/Cot-' . $folio . '.pdf');
                }

                $send   = Mail::enviarCorreoReq($mail);
                $result = $send;
                if ($send && $adjOrden == 1) {
                    $orden = new OrdenCompra();
                    $orden->setId($idOrden);
                    $oc = $orden->getById();
                    if ($oc->estatus_id == 5) {
                        $result = true;
                    } else {
                        // Estatus 7-> Enviada
                        $orden->setEstatusId(7);
                        $result = $orden->updateEstatus();
                    }
                }
                echo $result;
            } else {
                echo false;
            }
        }
    }

    public function buscarOrdenCompra()
    {
        Utils::noLoggin();
        $oc          = new OrdenCompra();
        $folio       = isset($_POST['folioBuscar']) && $_POST['folioBuscar'] != '' ? $_POST['folioBuscar'] : null;
        $fechaIni    = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] != '' ? $_POST['fechaInicio'] : null;
        $fechaFin    = isset($_POST['fechaFin']) && $_POST['fechaFin'] != '' ? $_POST['fechaFin'] : null;
        $proveedor   = isset($_POST['proveedor']) && $_POST['proveedor'] != '' ? $_POST['proveedor'] : null;
        $solicitud   = isset($_POST['solicitud']) && $_POST['solicitud'] != '' ? $_POST['solicitud'] : null;
        $fechaInicio = null;
        $fechaFinal  = null;
        if ($fechaIni != null) {
            $fechaInicio = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaIni)));
        }

        if ($fechaFin != null) {
            $fechaFinal = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaFin)));
        }
        $idEst = null;

        $ordenes = $oc->getOrdenByFolioFechasProv($folio, $proveedor, $solicitud, $fechaInicio, $fechaFinal);

        require_once views_root . 'compras/lista_ordenes_compra.php';
    }

    public function recepcionCompras()
    {
        Utils::noLoggin();
        if (isset($_GET['idOrden']) && $_GET['idOrden'] != '') {
            $id = $_GET['idOrden'];

            $orden = new OrdenCompra();
            $orden->setId($id);
            $oc  = $orden->getById();
            $req = new Requisicion();
            $r   = $req->getReqById($oc->requisicion_id);

            $empresa      = empresas[intval($r['empresa'])];
            $sumaCantidad = 0;
            foreach ($r['detalle'] as $d) {
                $sumaCantidad += $d['cantidad'];
            }
            $prod   = null;
            $carros = null;

            if ($r['producto_id'] != null) {
                if (isset($_GET['embarque']) && $_GET['embarque'] != '') {
                    $idEmbarque = $_GET['embarque'];
                    $emb        = new Embarque();
                    $emb->setId($idEmbarque);
                    $embarque = $emb->getById();
                    if ($embarque->requisicion_flete != null) {
                        $reqFlete = $req->getReqById($embarque->requisicion_flete);
                    }
                    $idPed = $embarque->pedimento_id;

                    if ($idPed != null) {
                        $ped = new Pedimento();
                        $ped->setId($idPed);
                        $pedimento = $ped->getById();
                    }
                }
                $tipoTransporte = Utils::getTipoTransporte($r['transporte_id']);
                if ($tipoTransporte->nombre == 'Carro tanque') {
                    $kansas = Utils::getKansas();
                }

                $producto = new Producto();
                $prod     = $producto->getById($r['producto_id']);

                $proveedor   = new Proveedor();
                $proveedores = $proveedor->getTransportistas();

                $transporte  = new TipoTransporte();
                $transportes = $transporte->getAll();

                $ruta  = new Ruta();
                $rutas = $ruta->getAll();

                $aduana  = new Aduana();
                $aduanas = $aduana->getAll();

                $cliente  = new Cliente();
                $clientes = $cliente->getAll();

                require_once views_root . 'compras/embarques.php';
            } else {
                require_once views_root . 'compras/recepcion_compras.php';
            }
        }
    }

    public function generarEmbarque()
    {
        if (isset($_POST['idOrdenProducto']) && $_POST['idOrdenProducto'] != '') {
            $idOrdenProducto      = $_POST['idOrdenProducto'];
            $tipoFlete            = isset($_POST['tipoFlete']) ? $_POST['tipoFlete'] : null;
            $idEmbarque           = isset($_POST['idEmbarque']) && $_POST['idEmbarque'] != '' ? $_POST['idEmbarque'] : null;
            $idReqProducto        = isset($_POST['idReqProducto']) ? $_POST['idReqProducto'] : 'null';
            $idPedimento          = isset($_POST['idPedimento']) && $_POST['idPedimento'] != '' ? $_POST['idPedimento'] : null;
            $idReqFlete           = isset($_POST['idReqFlete']) ? $_POST['idReqFlete'] : null;
            $idAduana             = isset($_POST['aduana']) && $_POST['aduana'] != '' ? $_POST['aduana'] : null;
            $idCarroTanque        = isset($_POST['carroTanqueId']) && $_POST['carroTanqueId'] != '' ? $_POST['carroTanqueId'] : 'null';
            $idClienteEmbarque    = isset($_POST['clienteEmbarque']) && $_POST['clienteEmbarque'] ? $_POST['clienteEmbarque'] : 'null';
            $trailer              = isset($_POST['trailer']) ? trim($_POST['trailer']) : '';
            $litrosFacturados     = isset($_POST['litrosFactura']) ? trim($_POST['litrosFactura']) : null;
            $precioFactura        = isset($_POST['precioFactura']) ? $_POST['precioFactura'] : null;
            $cantidadCargada      = isset($_POST['cantidadFactura']) ? trim($_POST['cantidadFactura']) : null;
            $observaciones        = isset($_POST['observacionesEmbarque']) ? trim($_POST['observacionesEmbarque']) : '';
            $numeroFactura        = isset($_POST['numeroFactura']) ? trim($_POST['numeroFactura']) : '';
            $fechaFactura         = $_POST['fechaFactura'] == '' ? null : UtilsHelp::covertDatetoDateSql($_POST['fechaFactura']);
            $oilFee               = isset($_POST['oilFee']) ? trim($_POST['oilFee']) : null;
            $importeFactura       = isset($_POST['importeFactura']) ? $_POST['importeFactura'] : null;
            $valorDolares         = isset($_POST['valorDolares']) ? $_POST['valorDolares'] : null;
            $numeroPedimento      = isset($_POST['numeroPedimento']) ? trim($_POST['numeroPedimento']) : '';
            $referenciaPedimento  = isset($_POST['referenciaPedimento']) ? trim($_POST['referenciaPedimento']) : '';
            $fechaPedimento       = $_POST['fechaPedimento'] == '' ? null : UtilsHelp::covertDatetoDateSql($_POST['fechaPedimento']);
            $tipoCambio           = isset($_POST['tipoCambio']) ? $_POST['tipoCambio'] : 'null';
            $incrementables       = isset($_POST['incrementable']) ? $_POST['incrementable'] : 'null';
            $otrosCargosPedimento = isset($_POST['otrosCargosPedimento']) ? trim($_POST['otrosCargosPedimento']) : 'null';
            $totalIncrementable   = isset($_POST['totalIncrementable']) ? $_POST['totalIncrementable'] : ' null';
            $incrementablesPeso   = isset($_POST['incrementablesPeso']) ? $_POST['incrementablesPeso'] : 'null';
            $valorAduana          = isset($_POST['valorAduana']) ? $_POST['valorAduana'] : 'null';
            $iva                  = isset($_POST['ivaPedimento']) ? $_POST['ivaPedimento'] : 'null';
            $prvPedimento         = isset($_POST['prvPedimento']) ? $_POST['prvPedimento'] : 'null';
            $ivaPrv               = isset($_POST['ivaPrv']) ? $_POST['ivaPrv'] : 'null';
            $dtaPedimento         = isset($_POST['dtaPedimento']) && $_POST['dtaPedimento'] != '' ? $_POST['dtaPedimento'] : 'null';
            $valorComercial       = isset($_POST['valorComercial']) ? $_POST['valorComercial'] : 'null';
            $impuestoPedimento    = isset($_POST['impuestosPedimento']) ? $_POST['impuestosPedimento'] : 'null';
            $IdRuta               = isset($_POST['ruta']) && $_POST['ruta'] != '' ? $_POST['ruta'] : 'null';
            $transporte           = $_POST['transporte'] != '' ? $_POST['transporte'] : 'null';
            $saveReq              = true;
            $savePedimento        = true;
            $estatusEmbarque      = 1;
            if ($tipoFlete == 2) {
                $cliente     = isset($_POST['cliente']) && $_POST['cliente'] != '' ? $_POST['cliente'] : 'null';
                $transporte  = $_POST['transporte'] != '' ? $_POST['transporte'] : 'null';
                $empresa     = $_POST['empresa'];
                $proveedor   = $_POST['proveedorFlete'];
                $moneda      = isset($_POST['moneda']) ? $_POST['moneda'] : 'null';
                $adjuntarReq = isset($_POST['adjuntarReq']) && $_POST['adjuntarReq'] != '' ? false : true;
                $idDetalle   = $_POST['idDetalleFlete'];
                if ($adjuntarReq) {
                    $requisicion = new Requisicion();
                    $requisicion->setRuta($IdRuta);
                    $requisicion->setCliente($cliente);
                    $requisicion->setProducto(null);
                    $requisicion->setAduana($idAduana);
                    $requisicion->setTransporteId($transporte);
                    $requisicion->setEmpresa($empresa);
                    $requisicion->setProvedorId($proveedor);
                    $requisicion->setFechaSolicitud(UtilsHelp::today());
                    $requisicion->setFechaRequerida(UtilsHelp::today());
                    $requisicion->setUrgente('N');
                    $requisicion->setMoneda($moneda);
                    if ($idReqFlete == null) {
                        // estatus 1
                        $requisicion->setEstatusId(1);
                        $folioUltimaReq = $requisicion->getUltimaReq()->folio;
                        $nextFolio      = intval(UtilsHelp::recortarString($folioUltimaReq, '-', true)) + 1;
                        $requisicion->setFolio('REQ-' . $nextFolio);
                    }
                    if ($IdRuta != null) {
                        $ruta = new Ruta();
                        $r    = $ruta->rutaById($IdRuta);

                        $unidad = new Unidad();
                        $uni    = $unidad->getUnidadByNombre('Servicio');

                        $detalles = array();
                        $detalles[] = [
                            'idDetalle'      => $idDetalle,
                            'descripcion'    => 'Flete: ' . $r[0]->transporte . ' - ' . $r[0]->ciudad_or . '-' . $r[0]->ciudad_des,
                            'unidad'         => $uni->id,
                            'precioUnitario' => $r[0]->precio,
                            'cantidad'       => 1,
                            'precio'         => $r[0]->precio,
                        ];
                    }
                    $requisicion->setDetalles($detalles);
                    if ($idReqFlete == null) {
                        $requisicion->setUsuarioId($_SESSION['usuario']->id);
                        $saveReq    = $requisicion->save();
                        $idReqFlete = $requisicion->getIdUltimaReq();
                    } else {
                        $estatus = $requisicion->getEstatusReq($idReqFlete);
                        $requisicion->setId($idReqFlete);
                        $saveReq = $requisicion->edit();
                        if ($saveReq && ($estatus == 5)) {
                            $this->actualizarOrdenCompra($idReqFlete);
                        }
                    }
                }
            } else {
                $idReqFlete = 'null';
            }
            if ($numeroPedimento != null && $referenciaPedimento != null) {
                $pedimento = new Pedimento();
                $pedimento->setNumero($numeroPedimento);
                $pedimento->setReferencia($referenciaPedimento);
                $pedimento->setFecha($fechaPedimento == null ? null : date('Y-m-d', strtotime($fechaPedimento)));
                $pedimento->setTipoCambio(Utils::stringToFloat($tipoCambio));
                $pedimento->setIncrementable(Utils::stringToFloat($incrementables));
                $pedimento->setOtrosCargos(Utils::stringToFloat($otrosCargosPedimento));
                $pedimento->setTotalIncrementables(Utils::stringToFloat($totalIncrementable));
                $pedimento->setIncrementablesPesos(Utils::stringToFloat($incrementablesPeso));
                $pedimento->setValorAduana(Utils::stringToFloat($valorAduana));
                $pedimento->setIva(Utils::stringToFloat($iva));
                $pedimento->setPrv(Utils::stringToFloat($prvPedimento));
                $pedimento->setIvaPrv(Utils::stringToFloat($ivaPrv));
                $pedimento->setDta(Utils::stringToFloat($dtaPedimento));
                $pedimento->setValorComercial(Utils::stringToFloat($valorComercial));
                $pedimento->setTotalImpuestos(Utils::stringToFloat($impuestoPedimento));

                $documento = null;
                if ($idPedimento != null) {
                    $pedimento->setId($idPedimento);
                    $ped       = $pedimento->getById();
                    $documento = $ped->documento;
                }
                $filenamePed = $numeroPedimento . '_' . $referenciaPedimento . '.pdf';
                if (isset($_FILES['documentoPedimento']) && $_FILES['documentoPedimento']['size'] > 0) {
                    $file     = $_FILES['documentoPedimento'];
                    $mimetype = $file['type'];
                    if ($mimetype == 'application/pdf') {
                        if (!is_dir('views/compras/uploads/pedimentos')) {
                            mkdir('views/compras/uploads/pedimentos', 0777, true);
                        }
                        if (file_exists('views/compras/uploads/pedimentos/' . $filenamePed)) {
                            unlink('views/compras/uploads/pedimentos/' . $filenamePed);
                        }
                        if ($documento != null) {
                            if (file_exists('views/compras/uploads/pedimentos/' . $documento)) {
                                unlink('views/compras/uploads/pedimentos/' . $documento);
                            }
                        }
                        move_uploaded_file($file['tmp_name'], 'views/compras/uploads/pedimentos/' . $filenamePed);
                        $pedimento->setDocumentoPedimento($filenamePed);
                        $estatusEmbarque = 8;
                    }
                } else if ($documento != null) {
                    if (file_exists('views/compras/uploads/pedimentos/' . $documento)) {
                        if ($documento != $filenamePed) {
                            rename('views/compras/uploads/pedimentos/' . $documento, 'views/compras/uploads/pedimentos/' . $filenamePed);
                            $pedimento->setDocumentoPedimento($filenamePed);
                        }
                    }
                    $estatusEmbarque = 8;
                } else {
                    $pedimento->setDocumentoPedimento(null);
                }

                if ($pedimento->getId() == null) {
                    $savePedimento = $pedimento->save();
                    if ($savePedimento) {
                        $idPedimento = intval($pedimento->getIdUltimoPedimento());
                    }
                } else {
                    $savePedimento = $pedimento->edit();
                }
            }
            if ($saveReq && $savePedimento) {
                $embarque = new Embarque();
                $embarque->setIdRequisicionProducto($idReqProducto);
                $embarque->setIdRequisicionFlete($idReqFlete);
                $embarque->setIdPedimento($idPedimento == null ? 'null' : $idPedimento);
                $embarque->setIdAduana($idAduana);
                $embarque->setIdCarroTanque($idCarroTanque);
                $embarque->setIdCliente($idClienteEmbarque);
                $embarque->setIdTransporte($transporte);
                $embarque->setNumeroTransporte($trailer);
                $embarque->setCantidadCargada(Utils::stringToFloat($cantidadCargada));
                $embarque->setLitrosFacturados(Utils::stringToFloat($litrosFacturados));
                $embarque->setPrecioProducto(Utils::stringToFloat($precioFactura));
                $embarque->setNumeroFactura($numeroFactura);
                $embarque->setFechaFactura($fechaFactura == null ? null : date('Y-m-d', strtotime($fechaFactura)));
                $embarque->setOilFee(Utils::stringToFloat($oilFee));
                $embarque->setImporte(Utils::stringToFloat($importeFactura));
                $embarque->setValorDolares(Utils::stringToFloat($valorDolares));
                $embarque->setObservaciones($observaciones);
                $factura     = null;
                $certificado = null;
                if ($idEmbarque != null) {
                    $embarque->setId($idEmbarque);
                    $emb         = $embarque->getById();
                    $factura     = $emb->factura;
                    $certificado = $emb->certificado;
                }

                $filenameFac = $numeroFactura . '_' . $idReqProducto . '.pdf';
                if (isset($_FILES['documentoFactura']) && $_FILES['documentoFactura']['size'] > 0) {
                    $file     = $_FILES['documentoFactura'];
                    $mimetype = $file['type'];
                    if ($mimetype == 'application/pdf') {
                        if (!is_dir('views/compras/uploads/facturas')) {
                            mkdir('views/compras/uploads/facturas', 0777, true);
                        }
                        if (file_exists('views/compras/uploads/facturas/' . $filenameFac)) {
                            unlink('views/compras/uploads/facturas/' . $filenameFac);
                        }
                        if ($factura != null) {
                            if (file_exists('views/compras/uploads/facturas/' . $factura)) {
                                unlink('views/compras/uploads/facturas/' . $factura);
                            }
                        }
                        move_uploaded_file($file['tmp_name'], 'views/compras/uploads/facturas/' . $filenameFac);
                        $embarque->setFactura($filenameFac);
                    }
                } else if ($factura != null) {
                    if (file_exists('views/compras/uploads/facturas/' . $factura)) {
                        if ($factura != $filenameFac) {
                            rename('views/compras/uploads/facturas/' . $factura, 'views/compras/uploads/facturas/' . $filenameFac);
                            $embarque->setFactura($filenameFac);
                        }
                    }
                } else {
                    $embarque->setFactura(null);
                }
                $filenameCert = $numeroFactura . '_Cert.pdf';
                if (isset($_FILES['documentoCertificado']) && $_FILES['documentoCertificado']['size'] > 0) {
                    $file     = $_FILES['documentoCertificado'];
                    $mimetype = $file['type'];
                    if ($mimetype == 'application/pdf') {
                        if (!is_dir('views/compras/uploads/certificados')) {
                            mkdir('views/compras/uploads/certificados', 0777, true);
                        }
                        if (file_exists('views/compras/uploads/certificados/' . $filenameCert)) {
                            unlink('views/compras/uploads/certificados/' . $filenameCert);
                        }
                        if ($certificado != null) {
                            if (file_exists('views/compras/uploads/certificados/' . $certificado)) {
                                unlink('views/compras/uploads/certificados/' . $certificado);
                            }
                        }
                        move_uploaded_file($file['tmp_name'], 'views/compras/uploads/certificados/' . $filenameCert);
                        $embarque->setCertificado($filenameCert);
                    }
                } else if ($certificado != null) {
                    if (file_exists('views/compras/uploads/certificados/' . $certificado)) {
                        if ($certificado != $filenameCert) {
                            rename('views/compras/uploads/certificados/' . $certificado, 'views/compras/uploads/certificados/' . $filenameCert);
                            $embarque->setCertificado($filenameCert);
                        }
                    }
                } else {
                    $embarque->setCertificado(null);
                }
                if ($embarque->getId() == null) {
                    $embarque->setIdEstatus($estatusEmbarque);
                    $save = $embarque->save();

                    if ($save) {
                        $idEmbarque = intval($embarque->getIdUltimoEmbarque());
                    } else {
                        $requisicion->elimninarBdRequisicion($idReqFlete);
                    }
                } else {
                    $embarque->setId($idEmbarque);
                    $embarque->setIdEstatus($estatusEmbarque);
                    $save = $embarque->edit();
                    if ($save) {
                        if ($emb->carro_tanque_id != $idCarroTanque) {
                            $carroTanque = new CarroTanque();
                            $carroTanque->setId($emb->carro_tanque_id);
                            $carroTanque->setIdEstatus(6);
                            $carroTanque->updateEstatus();
                        }
                    }
                }
                if ($idCarroTanque != 'null' && $save) {
                    $carroTanque = new CarroTanque();
                    $carroTanque->setId($idCarroTanque);
                    $carroTanque->setIdEstatus(8);
                    $carroTanque->updateEstatus();
                }
                if ($save) {
                    $orden = new OrdenCompra();
                    $orden->setRequisicionId($idReqProducto);
                    $oc = $orden->getByRequisicionId();
                    if ($oc->estatus_id != 5) {
                        $orden->setId($oc->id);
                        $orden->setEstatusId(10);
                        $orden->updateEstatus();
                    }
                }
            }
            header('Location:' . root_url . '?controller=Compras&action=recepcionCompras&idOrden=' . $idOrdenProducto . '&embarque=' . $idEmbarque);
        }
    }

    public function getFletesEmbarque()
    {
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $idReq    = $_POST['idReq'];
            $embarque = new Embarque();
            $embarque->setIdRequisicionProducto($idReq);
            $fletes = $embarque->getFletesByReqProducto();
            echo json_encode($fletes);
        }
    }

    public function eliminarDocumentoPedimento()
    {
        if (isset($_POST['idPed']) && $_POST['idPed'] != '') {
            $id        = intval($_POST['idPed']);
            $documento = $_POST['documento'];
            $ped       = new Pedimento();
            $result    = $ped->deleteDocumentoPedimento($id);

            if (file_exists(views_root . 'compras/uploads/pedimentos/' . $documento)) {
                unlink(views_root . 'compras/uploads/pedimentos/' . $documento);
            }
        }
        echo $result;
    }

    public function eliminarDocumentoFactura()
    {
        if (isset($_POST['idEmbarque']) && $_POST['idEmbarque'] != '') {
            $id        = intval($_POST['idEmbarque']);
            $documento = $_POST['documento'];
            $emb       = new Embarque();
            $result    = $emb->deleteDocumentoFactura($id);

            if (file_exists(views_root . 'compras/uploads/facturas/' . $documento)) {
                unlink(views_root . 'compras/uploads/facturas/' . $documento);
            }
        }
        echo $result;
    }

    public function eliminarDocumentoCertificado()
    {
        if (isset($_POST['idEmbarque']) && $_POST['idEmbarque'] != '') {
            $id        = intval($_POST['idEmbarque']);
            $documento = $_POST['documento'];
            $emb       = new Embarque();
            $result    = $emb->deleteDocumentoCertificado($id);

            if (file_exists(views_root . 'compras/uploads/certificados/' . $documento)) {
                unlink(views_root . 'compras/uploads/certificados/' . $documento);
            }
        }
        echo $result;
    }

    public function embarques()
    {
        Utils::noLoggin();
        $embarque = new Embarque();
        $idEst    = null;
        if (isset($_GET['idEst'])) {
            $idEst = (int) $_GET['idEst'];
        }
        $embarques = $embarque->getByEstatusId($idEst);
        require_once views_root . 'compras/lista_embarques.php';
    }

    public function exportarComprasEmbarquesExcel()
    {
        Utils::noLoggin();
        $pdf         = $_POST['pdf'] == 1 ? true : false;
        $tipoReporte = $_POST['tipoReporte'];
        $aduana      = isset($_POST['aduanaExp']) && $_POST['aduanaExp'] != '' ? $_POST['aduanaExp'] : null;
        $ordenar     = isset($_POST['ordenar']) && $_POST['ordenar'] != '' ? $_POST['ordenar'] : null;
        $fechaInicio = isset($_POST['fechaInicioExp']) && $_POST['fechaInicioExp'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaInicioExp']))) : null;
        $fechaFinal  = isset($_POST['fechaFinExp']) && $_POST['fechaFinExp'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaFinExp']))) : null;
        $proveedor   = isset($_POST['proveedorExp']) && $_POST['proveedorExp'] != '' ? $_POST['proveedorExp'] : null;
        $producto    = isset($_POST['productoExp']) && $_POST['productoExp'] != '' ? $_POST['productoExp'] : null;
        $emb         = new Embarque();
        if ($ordenar != 3) {
            $embarques = $emb->getEmbarqueByFechasProdProv($proveedor, $producto, $fechaInicio, $fechaFinal, $aduana, $ordenar, false, true);
        } else {
            $embarques = $emb->getEmbarqueByFechasPedimentoProdProv($proveedor, $producto, $fechaInicio, $fechaFinal, $aduana, false, true);
        }
        require_once utils_root . 'toExcel/excel.php';
        if ($tipoReporte == 1) {
            Excel::reporteComprasBasicos($embarques, $pdf);
        } elseif ($tipoReporte == 2) {
            Excel::reportePedimentos($embarques, $pdf);
        }
    }

    public function buscarEmbarques()
    {
        Utils::noLoggin();
        $emb         = new Embarque();
        $aduana      = isset($_POST['aduana']) && $_POST['aduana'] != '' ? $_POST['aduana'] : null;
        $fechaInicio = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaInicio']))) : null;
        $fechaFinal  = isset($_POST['fechaFin']) && $_POST['fechaFin'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaFin']))) : null;
        $proveedor   = isset($_POST['proveedor']) && $_POST['proveedor'] != '' ? $_POST['proveedor'] : null;
        $producto    = isset($_POST['producto']) && $_POST['producto'] != '' ? $_POST['producto'] : null;

        $embarques = $emb->getEmbarqueByFechasProdProv($proveedor, $producto, $fechaInicio, $fechaFinal, $aduana);
        $idEst     = null;
        require_once views_root . 'compras/lista_embarques.php';
    }

    public function enviarAvisoCambioPrecio()
    {
        if (isset($_POST['cuerpo']) && isset($_POST['folio'])) {
            $texto       = $_POST['cuerpo'];
            $folio       = $_POST['folio'];
            $precioAnt   = $_POST['precioAnterior'];
            $precioNuevo = $_POST['precioNuevo'];

            $cuerpo = 'Se realizo cambio de precio de <b>' . $precioAnt . '</b> a <b>' . $precioNuevo . '</b> dolares en embarque de la orden <b>' . $folio . '</b>';

            require_once utils_root . 'email/email.php';
            $mail = new Mail();
            $send = Mail::enviarAvisoCambioPrecio($folio, $cuerpo, $texto);

            echo json_encode($send);
        }
    }

    public function finalizarOrdenCompra()
    {
        if (isset($_POST['idOrden'])) {
            $idOrden = $_POST['idOrden'];
            $orden   = new OrdenCompra();
            $orden->setEstatusId(5);  // Estatus 5 finalizada
            $orden->setId($idOrden);
            $result = $orden->updateEstatus();
        }
        echo json_encode($result);
    }

    public function embarqueEnTransito()
    {
        if (isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['fecha']) && $_POST['fecha'] != '') {
            $id            = $_POST['id'];
            $fechaTransito = UtilsHelp::covertDatetoDateSql($_POST['fecha']);
            $embarque      = new Embarque();
            $embarque->setId($id);
            $embarque->setFechaTransito(date('Y-m-d', strtotime($fechaTransito)));
            $result = $embarque->embarqueEnTransito();
            echo $result;
        }
    }

    public function cancelarEmbarque()
    {
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id       = $_POST['id'];
            $embarque = new Embarque();
            $embarque->setId($id);
            $e      = $embarque->getById();
            $delete = $embarque->cancelarEmbarque();
            if ($e->carro_tanque_id != null) {
                $carro = new CarroTanque();
                $carro->setId($e->carro_tanque_id);
                $carro->setIdEstatus(6);  // Disponible
                $carro->updateEstatus();
            }
            if ($delete && $e->requisicion_flete != null) {
                $idReq = $e->requisicion_flete;
                $orden = new OrdenCompra();
                $orden->setRequisicionId($idReq);
                $oc = $orden->getByRequisicionId();
                if ($oc) {
                    $orden->setEstatusId(2);
                    $orden->setId($oc->id);
                    $delete  = $orden->updateEstatus();
                    $req     = new Requisicion();
                    $editReq = $req->deleteRequision($idReq);
                } else {
                    $req     = new Requisicion();
                    $editReq = $req->deleteRequision($idReq);
                }
                if ($delete && $editReq) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    }

    public function recepcionFletes()
    {
        if (isset($_POST['numeroFacturaFlete']) && $_POST['numeroFacturaFlete'] != '' && isset($_POST['fechaFactura']) && $_POST['fechaFactura'] != '') {
            $numeroFactura   = $_POST['numeroFacturaFlete'];
            $fechaRecepcion  = UtilsHelp::covertDatetoDateSql($_POST['fechaFactura']);
            $idReq           = $_POST['idRequisicion'];
            $idRecepcion     = $_POST['id'] != '' ? $_POST['id'] : null;
            $observaciones   = $_POST['observaciones'];
            $descCombustible = isset($_POST['descCombustible']) && $_POST['descCombustible'] != '' ? Utils::stringToFloat($_POST['descCombustible']) : null;
            $idDetalleComb   = isset($_POST['idDetalleComb']) && $_POST['idDetalleComb'] != '' ? $_POST['idDetalleComb'] : null;
            $usuario         = $_SESSION['usuario']->id;
            $pregunta1       = (int) $_POST['pregunta1'];
            $pregunta2       = (int) $_POST['pregunta2'];
            $pregunta3       = (int) $_POST['pregunta3'];
            $pregunta4       = (int) $_POST['pregunta4'];

            if ($descCombustible != null) {
                $unidad = new Unidad();
                $u = $unidad->getUnidadByNombre('Servicio');
                $detalle = array();
                $detalle[] = [
                    'idDetalle'      => $idDetalleComb,
                    'descripcion'    => 'Rediccion de descuento por precio de combustible',
                    'unidad'         => $u->id,
                    'precioUnitario' => $descCombustible,
                    'cantidad'       => 1,
                    'precio'         => $descCombustible,
                ];

                $requi = new Requisicion();
                $requi->setDetalles($detalle);
                $saveDetalle = $requi->saveDetalles($idReq);
                if ($saveDetalle) {
                    $this->actualizarOrdenCompra($idReq);
                } else {
                    echo $saveDetalle;
                    die ();
                }
            }
            $evaluacion = array(
                'pregunta1' => $pregunta1,
                'pregunta2' => $pregunta2,
                'pregunta3' => $pregunta3,
                'pregunta4' => $pregunta4
            );
            $recepcion = new RecepcionFlete();
            $recepcion->setNumeroFactura($numeroFactura);
            $recepcion->setIdUsuario($usuario);
            $recepcion->setIdRequisicion($idReq);
            $recepcion->setFechaRecepcion(date('Y-m-d', strtotime($fechaRecepcion)));
            $recepcion->setEvaluacion(json_encode($evaluacion));
            $recepcion->setObservaciones($observaciones);

            $factura  = null;
            $xml      = null;
            $remision = null;
            if ($idRecepcion != null) {
                $recepcion->setId($idRecepcion);
                $r        = $recepcion->getById();
                $factura  = $r->factura;
                $xml      = $r->docXml;
                $remision = $r->remision;
            }
            $estatus     = null;
            $filenameFac = $numeroFactura . '_' . $idReq . '.pdf';
            if (isset($_FILES['documentoFacturaFlete']) && $_FILES['documentoFacturaFlete']['size'] > 0) {
                $file     = $_FILES['documentoFacturaFlete'];
                $mimetype = $file['type'];
                if ($mimetype == 'application/pdf') {
                    if (!is_dir('views/compras/uploads/facturas')) {
                        mkdir('views/compras/uploads/facturas', 0777, true);
                    }
                    if (file_exists('views/compras/uploads/facturas/' . $filenameFac)) {
                        unlink('views/compras/uploads/facturas/' . $filenameFac);
                    }
                    if ($factura != null) {
                        if (file_exists('views/compras/uploads/facturas/' . $factura)) {
                            unlink('views/compras/uploads/facturas/' . $factura);
                        }
                    }
                    move_uploaded_file($file['tmp_name'], 'views/compras/uploads/facturas/' . $filenameFac);
                    $recepcion->setFactura($filenameFac);
                    $estatus = 5;
                }
            } else if ($factura != null) {
                if (file_exists('views/compras/uploads/facturas/' . $factura)) {
                    if ($factura != $filenameFac) {
                        rename('views/compras/uploads/facturas/' . $factura, 'views/compras/uploads/facturas/' . $filenameFac);
                        $recepcion->setFactura($filenameFac);
                        $estatus = 5;
                    }
                }
            } else {
                $recepcion->setFactura(null);
            }

            $filenameXml = $numeroFactura . '_' . $idReq . '.xml';
            if (isset($_FILES['documentoXml']) && $_FILES['documentoXml']['size'] > 0) {
                $file     = $_FILES['documentoXml'];
                $mimetype = $file['type'];
                if ($mimetype == 'text/xml') {
                    if (!is_dir('views/compras/uploads/xml')) {
                        mkdir('views/compras/uploads/xml', 0777, true);
                    }
                    if (file_exists('views/compras/uploads/xml/' . $filenameXml)) {
                        unlink('views/compras/uploads/xml/' . $filenameXml);
                    }
                    if ($xml != null) {
                        if (file_exists('views/compras/uploads/xml/' . $xml)) {
                            unlink('views/compras/uploads/xml/' . $xml);
                        }
                    }
                    move_uploaded_file($file['tmp_name'], 'views/compras/uploads/xml/' . $filenameXml);
                    $recepcion->setDocXml($filenameXml);
                }
            } else if ($xml != null) {
                if (file_exists('views/compras/uploads/xml/' . $xml)) {
                    if ($xml != $filenameXml) {
                        rename('views/compras/uploads/xml/' . $xml, 'views/compras/uploads/xml/' . $filenameXml);
                        $recepcion->setDocXml($filenameXml);
                    }
                }
            } else {
                $recepcion->setDocXml(null);
            }

            if (isset($_FILES['documentoRemision']) && $_FILES['documentoRemision']['size'] > 0) {
                $file        = $_FILES['documentoRemision'];
                $mimetype    = $file['type'];
                $filenameRem = $file['name'];
                if ($mimetype == 'application/pdf') {
                    if (!is_dir('views/compras/uploads/remisiones')) {
                        mkdir('views/compras/uploads/remisiones', 0777, true);
                    }
                    if (file_exists('views/compras/uploads/remisiones/' . $filenameRem)) {
                        unlink('views/compras/uploads/remisiones/' . $filenameRem);
                    }
                    if ($remision != null) {
                        if (file_exists('views/compras/uploads/remisiones/' . $remision)) {
                            unlink('views/compras/uploads/remisiones/' . $remision);
                        }
                    }
                    move_uploaded_file($file['tmp_name'], 'views/compras/uploads/remisiones/' . $filenameRem);
                    $recepcion->setRemision($filenameRem);
                }
            } else if ($remision != null) {
                if (file_exists('views/compras/uploads/remisiones/' . $remision)) {
                    if ($remision != $filenameRem) {
                        rename('views/compras/uploads/remisiones/' . $remision, 'views/compras/uploads/remisiones/' . $filenameRem);
                        $recepcion->setRemision($filenameRem);
                    }
                }
            } else {
                $recepcion->setRemision(null);
            }
            if ($idRecepcion == null) {
                $save = $recepcion->save();
            } else {
                $save = $recepcion->edit();
            }
            if ($save) {
                if ($estatus != null) {
                    $oc = new OrdenCompra();
                    $oc->setRequisicionId($idReq);
                    $o = $oc->getByRequisicionId();
                    $oc->setEstatusId($estatus);
                    $oc->setId($o->id);
                    $save = $oc->updateEstatus();
                }
            }
            echo $save;
        } else {
            echo false;
        }
    }

    public function eliminarDocumentoFacturaFlete()
    {
        if (isset($_POST['idRecepcion']) && $_POST['idRecepcion'] != '') {
            $id        = intval($_POST['idRecepcion']);
            $documento = $_POST['documento'];
            $rec       = new RecepcionFlete();
            $result    = $rec->deleteDocumentoFactura($id);

            if (file_exists(views_root . 'compras/uploads/facturas/' . $documento)) {
                unlink(views_root . 'compras/uploads/facturas/' . $documento);
            }

            if ($result) {
                $rec->setId($id);
                $r = $rec->getById();

                $idReq = $r->requisicion_id;
                $oc    = new OrdenCompra();
                $oc->setRequisicionId($idReq);
                $o = $oc->getByRequisicionId();
                $oc->setEstatusId(3);
                $oc->setId($o->id);
                $save = $oc->updateEstatus();
            }
        }
        echo $save;
    }

    public function eliminarDocumentoXml()
    {
        if (isset($_POST['idRecepcion']) && $_POST['idRecepcion'] != '') {
            $id        = intval($_POST['idRecepcion']);
            $documento = $_POST['documento'];
            $rec       = new RecepcionFlete();
            $result    = $rec->deleteDocumentoXml($id);

            if (file_exists(views_root . 'compras/uploads/xml/' . $documento)) {
                unlink(views_root . 'compras/uploads/xml/' . $documento);
            }
        }
        echo $result;
    }

    public function eliminarDocumentoRemision()
    {
        if (isset($_POST['idRecepcion']) && $_POST['idRecepcion'] != '') {
            $id        = intval($_POST['idRecepcion']);
            $documento = $_POST['documento'];
            $rec       = new RecepcionFlete();
            $result    = $rec->deleteDocumentoRemision($id);

            if (file_exists(views_root . 'compras/uploads/xml/' . $documento)) {
                unlink(views_root . 'compras/uploads/xml/' . $documento);
            }
        }
        echo $result;
    }

    public function getRequisicionById()
    {
        if (isset($_POST['idReq']) && $_POST['idReq'] != '') {
            $idReq       = $_POST['idReq'];
            $r           = new Requisicion();
            $requisicion = $r->getReqById($idReq);
            echo json_encode($requisicion);
        }
    }

    /* GRAFICAS */
    public function getRequisiciones()
    {
        $req = new Requisicion();
        // if (isset($_POST['idEst'])) {
        //     $idEst = (int) $_POST['idEst'];
        // }

        // $clientes = '';
        // if (isset($_POST['clientes'])) {
        //     $clientes = $_POST['clientes'];
        // }

        $proveedores = '';
        if (isset($_POST['proveedores'])) {
            $proveedores = $_POST['proveedores'];
        }

        $fechaini = '';
        if (isset($_POST['fechaini'])) {
            $fechaini = str_replace('/', '', $_POST['fechaini']);
        }

        $fechafin = '';
        if (isset($_POST['fechafin'])) {
            $fechafin = str_replace('/', '', $_POST['fechafin']);
        }

        // $clientes = $_POST['clientes'];

        $requisiciones = $req->getByEstatusCliente($proveedores, $fechaini, $fechafin);

        echo json_encode(['mensaje' => 'OK', 'requisiciones' => $requisiciones]);
        return true;
    }

    public function editarDetalleReq()
    {
        $requisicion = New Requisicion();
        $requisiciones = $requisicion->updateDetalleReq(
            $_POST['id'],
            $_POST['unidad_id'],
            $_POST['descripcion'],
            $_POST['cantidad'],
            $_POST['precio_unitario']
        );
        echo json_encode(['mensaje' => 'OK', 'requisiciones' => $requisiciones]);
        // return true;
    }
}
