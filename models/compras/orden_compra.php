<?php

class OrdenCompra
{
    private $id;
    private $requisicionId;
    private $estatusId;
    private $folio;
    private $fechaModificacion;
    private $fechaAta;
    private $importe;
    private $subTotal;
    private $iva;
    private $isr;
    private $impuesto;
    private $retencionIva;
    private $pagos;
    private $total;
    private $notaCredito;
    private $otroIva;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function getRequisicionId()
    {
        return $this->requisicionId;
    }

    function getEstatusId()
    {
        return $this->estatusId;
    }

    function getFolio()
    {
        return $this->folio;
    }

    function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    function getFechaAta()
    {
        return $this->fechaAta;
    }

    function getImporte()
    {
        return $this->importe;
    }

    function getSubTotal()
    {
        return $this->subTotal;
    }

    function getIva()
    {
        return $this->iva;
    }

    function getIsr()
    {
        return $this->isr;
    }

    function getImpuesto()
    {
        return $this->impuesto;
    }

    function getRetencionIva()
    {
        return $this->retencionIva;
    }

    function getPagos()
    {
        return $this->pagos;
    }

    function getTotal()
    {
        return $this->total;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setRequisicionId($requisicionId): void
    {
        $this->requisicionId = $requisicionId;
    }

    function setEstatusId($estatusId): void
    {
        $this->estatusId = $estatusId;
    }

    function setFolio($folio): void
    {
        $this->folio = $folio;
    }

    function setFechaModificacion($fechaModificacion): void
    {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaAta($fechaAta): void
    {
        $this->fechaAta = $fechaAta;
    }

    function setImporte($importe): void
    {
        $this->importe = $importe;
    }

    function setSubTotal($subTotal): void
    {
        $this->subTotal = $subTotal;
    }

    function setIva($iva): void
    {
        $this->iva = $iva;
    }

    function setIsr($isr): void
    {
        $this->isr = $isr;
    }

    function setRetencionIva($retencionIva): void
    {
        $this->retencionIva = $retencionIva;
    }

    function setImpuesto($impuesto): void
    {
        $this->impuesto = $impuesto;
    }

    function setPagos($pagos): void
    {
        $this->pagos = $pagos;
    }

    function setTotal($total): void
    {
        $this->total = $total;
    }

    function getNotaCredito()
    {
        return $this->notaCredito;
    }

    function setNotaCredito($notaCredito): void
    {
        $this->notaCredito = $notaCredito;
    }

    function getOtroIva()
    {
        return $this->otroIva;
    }

    function setOtroIva($otroIva): void
    {
        $this->otroIva = $otroIva;
    }

    public function ultimaOrdenByEmpresa($idEmpresa)
    {
        $sql   = "select o.* from compras_ordenes_compra o inner join compras_requisiciones r on r.id = o.requisicion_id  where r.empresa={$idEmpresa} order by o.id desc limit 1";
        $query = $this->db->query($sql);
        return $query->fetch_object();
    }

    public function save()
    {
        $sql = "insert into compras_ordenes_compra values(null, {$this->getRequisicionId()}, {$this->getEstatusId()}, '{$this->getFolio()}',"
            . "null, curdate(), {$this->getImporte()}, null, {$this->getIva()}, {$this->getSubTotal()}, {$this->getIsr()},"
            . "{$this->getRetencionIva()},0, {$this->getPagos()}, {$this->getTotal()}, 0)";

        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function getAll($where = null)
    {
        $result = array();
        $sql    = 'select r.folio as folioReq, r.transporte_id as transporte, r.usuario_id, r.fecha_requerida, r.producto_id as id_producto, r.cotizacion, r.flete as tipoFlete,
               prod.nombre as producto,p.nombre as proveedor,
               r.cantidad_flete as cantidad_flete, p.correo as correoProv, e.clave as clave, e.nombre as estatus, e.descripcion as descEstatus, 
               (select sum(e.cantidad_cargada) from compras_embarques e where e.requisicion_producto = oc.requisicion_id and e.estatus_id !=2) as cantidadCargada,
               (select ts.tipo from catalogo_tipos_solicitudes ts where ts.id = p.tipo_solicitud_id) as solicitud,
                (select ref.nombre from catalogo_refinerias ref where ref.id = prod.refineria_id) as refineria,
               (select c.tipo from catalogo_tipos_compras c inner join catalogo_tipos_solicitudes ts on c.id = ts.tipo_compra_id where ts.id = p.tipo_solicitud_id) as compra , oc.*  
                from compras_ordenes_compra oc
                inner join compras_requisiciones r on r.id = oc.requisicion_id
                inner join catalogo_proveedores p on p.id = r.proveedor_id
                inner join catalogo_estatus e on e.id = oc.estatus_id
                left join catalogo_productos prod on prod.id = r.producto_id ';
        if ($where != null) {
            $sql .= $where;
        } else {
            $sql .= ' where oc.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by oc.id desc';
        }
        $ordenes = $this->db->query($sql);
        if ($ordenes != null) {
            foreach ($ordenes->fetch_all(MYSQLI_ASSOC) as $oc) {
                $oc['embarque']       = array();
                $oc['recepcionFlete'] = array();
                $detalles             = $this->db->query("select * from compras_detalles_requisiciones where requisicion_id = {$oc['requisicion_id']}");
                $d                    = $detalles->fetch_all(MYSQLI_ASSOC);
                $oc['detalle']        = $d;
                if ($oc['solicitud'] == 'Materia Prima') {
                    $embarques = $this->db->query('select e.*, r.folio as folioFlete, es.clave as clave, es.nombre as estatus,'
                                                      . 'p.numero as pedimento, p.documento as pedimentoDoc, ct.numero as carroTanque, '
                                                      . '(select o.folio from compras_ordenes_compra o where o.requisicion_id = e.requisicion_flete) as orden from compras_embarques e '
                                                      . 'left join compras_requisiciones r on r.id = e.requisicion_flete '
                                                      . 'left join compras_pedimentos p on p.id = e.pedimento_id '
                                                      . 'left join catalogo_carro_tanques ct on ct.id = e.carro_tanque_id '
                                                      . 'inner join catalogo_estatus es on es.id = e.estatus_id '
                                                      . "where e.requisicion_producto = {$oc['requisicion_id']} and e.estatus_id != 2");
                    $e              = $embarques->fetch_all(MYSQLI_ASSOC);
                    $oc['embarque'] = $e;
                }
                if ($oc['solicitud'] == 'Transporte') {
                    $detalles             = $this->db->query("select * from compras_recepciones_fletes where requisicion_id = {$oc['requisicion_id']}");
                    $rt                   = $detalles->fetch_all(MYSQLI_ASSOC);
                    $oc['recepcionFlete'] = $rt;
                }
                array_push($result, $oc);
            }
        }
        return $result;
    }

    public function getUltimasOrdenes()
    {
        $sql = ' where oc.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by oc.id desc limit 6';
        // $sql    = ' order by oc.id desc limit 6';
        $result = $this->getAll($sql);
        return $result;
    }

    public function edit()
    {
        $sql = "update compras_ordenes_compra set fecha_modificacion = curdate(), importe = {$this->getImporte()}, otro_iva = {$this->getOtroIva()}, "
            . " iva = {$this->getIva()}, sub_total = {$this->getSubTotal()}, isr = {$this->getIsr()}, "
            . " retencion_iva = {$this->getRetencionIva()}, impuesto = {$this->getImpuesto()},"
            . " pagos = {$this->getPagos()}, total = {$this->getTotal()}, nota_credito={$this->getNotaCredito()} where id = {$this->getId()};";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getById()
    {
        $sql = 'select oc.*, (select sum(e.cantidad_cargada) from compras_embarques e where e.requisicion_producto = oc.requisicion_id) as cantidadCargada '
            . "from compras_ordenes_compra oc where oc.id = {$this->getId()}";
        $orden = $this->db->query($sql);
        if ($orden->num_rows == 1) {
            return $orden->fetch_object();
        } else {
            return false;
        }
    }

    public function getByRequisicionId()
    {
        $sql   = "select oc.* from compras_ordenes_compra oc where oc.requisicion_id = {$this->getRequisicionId()}";
        $orden = $this->db->query($sql);
        if ($orden->num_rows == 1) {
            return $orden->fetch_object();
        } else {
            return false;
        }
    }

    public function getByEstatusId($idEst)
    {
        if ($idEst != null && $idEst != '') {
            if ($idEst == 3) {
                $sql = ' where (oc.estatus_id = 3 or oc.estatus_id = 7) order by oc.id desc';
            } else {
                $sql = " where oc.estatus_id = {$idEst} order by oc.id desc";
            }
        } else {
            $sql = null;
        }
        $result = $this->getAll($sql);
        return $result;
    }

    public function updateEstatus()
    {
        $sql    = "update compras_ordenes_compra set fecha_modificacion = curdate(), estatus_id = {$this->getEstatusId()} where id = {$this->getId()};";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getOrdenByFolioFechasProv($folio = null, $proveedor = null, $solicitud = null, $fechaIni = null, $fechaFin = null)
    {
        if ($folio != null) {
            $sql = " where oc.folio like '%{$folio}%' order by oc.id desc;";
        } else if ($solicitud != null && $proveedor == null && $fechaIni == null && $fechaFin == null) {
            $sql = " where p.tipo_solicitud_id = '{$solicitud}' order by oc.id desc;";
        } else if ($solicitud != null && $proveedor != null && $fechaIni == null && $fechaFin == null) {
            $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} order by oc.id desc;";
        } else if ($solicitud != null && $proveedor != null && $fechaIni != null && $fechaFin == null) {
            $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and oc.fecha_alta >= '{$fechaIni}' order by oc.id desc;";
        } else if ($solicitud != null && $proveedor != null && $fechaIni != null && $fechaFin != null) {
            $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and oc.fecha_alta between '{$fechaIni}' and '{$fechaFin}' order by oc.id desc;";
        } else if ($solicitud != null && $proveedor != null && $fechaIni == null && $fechaFin != null) {
            $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and oc.fecha_alta <= '{$fechaFin}' order by oc.id desc;";
        } else if ($solicitud == null && $proveedor == null && $fechaIni != null && $fechaFin != null) {
            $sql = " where oc.fecha_alta between '{$fechaIni}' and '{$fechaFin}' order by oc.id desc;";
        } else if ($solicitud == null && $proveedor == null && $fechaIni == null && $fechaFin != null) {
            $sql = " where oc.fecha_alta <= '{$fechaFin}' order by oc.id desc;";
        } else if ($solicitud == null && $proveedor == null && $fechaIni != null && $fechaFin == null) {
            $sql = " where oc.fecha_alta >= '{$fechaIni}' order by oc.id desc;";
        } else {
            $sql = null;
        }
        $result = $this->getAll($sql);
        return $result;
    }

    public function getOC_MES()
    {
        ini_set('memory_limit', '-1');
        $result = array();
        $sql    = '              
                CALL getOC_Mes();
            ';
        $getoc  = $this->db->query($sql);
        if ($getoc != null) {
            foreach ($getoc->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }
}
