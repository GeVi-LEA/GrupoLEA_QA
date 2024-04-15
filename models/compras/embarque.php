<?php

class Embarque
{
    private $id;
    private $idRequisicionProducto;
    private $idRequisicionFlete;
    private $idPedimento;
    private $idAduana;
    private $idCarroTanque;
    private $idCliente;
    private $idEstatus;
    private $idTransporte;
    private $numeroTransporte;
    private $litrosFacturados;
    private $precioProducto;
    private $fechaAlta;
    private $fechaModificacion;
    private $importe;
    private $valorDolares;
    private $oilFee;
    private $numeroFactura;
    private $fechaFactura;
    private $observaciones;
    private $factura;
    private $certificado;
    private $fechaTransito;
    private $fechaLlegada;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function getIdRequisicionProducto()
    {
        return $this->idRequisicionProducto;
    }

    function getIdRequisicionFlete()
    {
        return $this->idRequisicionFlete;
    }

    function getIdPedimento()
    {
        return $this->idPedimento;
    }

    function getIdAduana()
    {
        return $this->idAduana;
    }

    function getIdCarroTanque()
    {
        return $this->idCarroTanque;
    }

    function getIdCliente()
    {
        return $this->idCliente;
    }

    function getIdEstatus()
    {
        return $this->idEstatus;
    }

    function getNumeroTransporte()
    {
        return $this->numeroTransporte;
    }

    function getLitrosFacturados()
    {
        return $this->litrosFacturados;
    }

    function getPrecioProducto()
    {
        return $this->precioProducto;
    }

    function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setIdRequisicionProducto($idRequisicionProducto): void
    {
        $this->idRequisicionProducto = $idRequisicionProducto;
    }

    function setIdRequisicionFlete($idRequisicionFlete): void
    {
        $this->idRequisicionFlete = $idRequisicionFlete;
    }

    function setIdPedimento($idPedimento): void
    {
        $this->idPedimento = $idPedimento;
    }

    function setIdAduana($idAduana): void
    {
        $this->idAduana = $idAduana;
    }

    function setIdCarroTanque($idCarroTanque): void
    {
        $this->idCarroTanque = $idCarroTanque;
    }

    function setIdCliente($idCliente): void
    {
        $this->idCliente = $idCliente;
    }

    function setIdEstatus($idEstatus): void
    {
        $this->idEstatus = $idEstatus;
    }

    function setNumeroTransporte($numeroTransporte): void
    {
        $this->numeroTransporte = strtoupper(trim($numeroTransporte));
    }

    function setLitrosFacturados($litrosFacturados): void
    {
        $this->litrosFacturados = $litrosFacturados;
    }

    function setPrecioProducto($precioProducto): void
    {
        $this->precioProducto = $precioProducto;
    }

    function setFechaAlta($fechaAlta): void
    {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaModificacion($fechaModificacion): void
    {
        $this->fechaModificacion = $fechaModificacion;
    }

    function getCantidadCargada()
    {
        return $this->cantidadCargada;
    }

    function setCantidadCargada($cantidadCargada): void
    {
        $this->cantidadCargada = $cantidadCargada;
    }

    function getObservaciones()
    {
        return $this->observaciones;
    }

    function setObservaciones($observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    function getImporte()
    {
        return $this->importe;
    }

    function getOilFee()
    {
        return $this->oilFee;
    }

    function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    function getFechaFactura()
    {
        return $this->fechaFactura;
    }

    function setImporte($importe): void
    {
        $this->importe = $importe;
    }

    function setOilFee($oilFee): void
    {
        $this->oilFee = $oilFee;
    }

    function setNumeroFactura($numeroFactura): void
    {
        $this->numeroFactura = strtoupper(trim($numeroFactura));
    }

    function setFechaFactura($fechaFactura): void
    {
        $this->fechaFactura = $fechaFactura;
    }

    function getValorDolares()
    {
        return $this->valorDolares;
    }

    function setValorDolares($valorDolares): void
    {
        $this->valorDolares = $valorDolares;
    }

    function getFactura()
    {
        return $this->factura;
    }

    function setFactura($factura): void
    {
        $this->factura = $factura;
    }

    function getCertificado()
    {
        return $this->certificado;
    }

    function setCertificado($certificado): void
    {
        $this->certificado = $certificado;
    }

    function getIdTransporte()
    {
        return $this->idTransporte;
    }

    function setIdTransporte($idTransporte): void
    {
        $this->idTransporte = $idTransporte;
    }

    function getFechaTransito()
    {
        return $this->fechaTransito;
    }

    function setFechaTransito($fechaTransito): void
    {
        $this->fechaTransito = $fechaTransito;
    }

    function getFechaLlegada()
    {
        return $this->fechaLlegada;
    }

    function setFechaLlegada($fechaLlegada): void
    {
        $this->fechaLlegada = $fechaLlegada;
    }

    public function save()
    {
        $sql = "insert into compras_embarques values(null, {$this->getIdRequisicionProducto()}, {$this->getIdRequisicionFlete()}, {$this->getIdPedimento()},"
            . "{$this->getIdAduana()}, {$this->getIdCarroTanque()}, {$this->getIdCliente()}, {$this->getIdEstatus()}, {$this->getIdTransporte()}, '{$this->getNumeroTransporte()}', "
            . "{$this->getCantidadCargada()}, {$this->getLitrosFacturados()}, {$this->getPrecioProducto()}, curdate(), null, '{$this->getNumeroFactura()}',";

        if ($this->getFechaFactura() == null) {
            $sql .= 'null, ';
        } else {
            $sql .= "'{$this->getFechaFactura()}', ";
        }

        $sql .= "{$this->getOilFee()}, {$this->getImporte()}, {$this->getValorDolares()}, '{$this->getObservaciones()}', '{$this->getFactura()}', '{$this->getCertificado()}', null, null)";

        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public function edit()
    {
        $sql = "update compras_embarques set aduana_id = {$this->getIdAduana()}, carro_tanque_id =  {$this->getIdCarroTanque()}, pedimento_id = {$this->getIdPedimento()}, "
            . " cliente_id = {$this->getIdCliente()},  estatus_id = {$this->getIdEstatus()}, transporte_id = {$this->getIdTransporte()},  numero_transporte = '{$this->getNumeroTransporte()}', "
            . "cantidad_cargada = {$this->getCantidadCargada()}, litros_facturados = {$this->getLitrosFacturados()}, requisicion_flete = {$this->getIdRequisicionFlete()}, "
            . "precio_producto = {$this->getPrecioProducto()}, fecha_modificacion = curdate(), observaciones = '{$this->getObservaciones()}',"
            . "numero_factura = '{$this->getNumeroFactura()}', oil_fee = {$this->getOilFee()}, importe = {$this->getImporte()}, valor_dolares = {$this->getValorDolares()}, ";

        if ($this->getFechaFactura() == null) {
            $sql .= 'fecha_factura = null ';
        } else {
            $sql .= "fecha_factura = '{$this->getFechaFactura()}' ";
        }

        if ($this->getFactura() != null) {
            $sql .= ", factura = '{$this->getFactura()}'";
        }
        if ($this->getCertificado() != null) {
            $sql .= ", certificado = '{$this->getCertificado()}'";
        }
        $sql   .= " where id = {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getById()
    {
        $sql    = "select * from compras_embarques where id={$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function getFletesByReqProducto()
    {
        $req = array();
        $sql = 'select COUNT(*) AS num, e.requisicion_flete as idReqFlete, rf.folio as folioReq from compras_embarques e inner join compras_requisiciones r on '
            . 'e.requisicion_producto = r.id inner join compras_requisiciones rf on e.requisicion_flete = rf.id '
            . "where e.requisicion_producto={$this->getIdRequisicionProducto()} GROUP by e.requisicion_flete";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            while ($r = $result->fetch_object()) {
                array_push($req, $r);
            }
        }
        return $req;
    }

    public function getIdUltimoEmbarque()
    {
        $sql   = 'SELECT MAX(id)as id FROM compras_embarques';
        $query = $this->db->query($sql);
        $id    = $query->fetch_object()->id;
        return $id;
    }

    public function getEmbarques()
    {
        $result    = array();
        $embarques = $this->db->query('select * from compras_embarques');
        while ($e = $embarques->fetch_object()) {
            array_push($result, $e);
        }
        return $result;
    }

    public function deleteDocumentoFactura($id)
    {
        $sql    = "update compras_embarques set factura = '' where id = {$id}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function deleteDocumentoCertificado($id)
    {
        $sql    = "update compras_embarques set certificado = '', estatus_id = 1 where id = {$id}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function getAll($where = null)
    {
        $result = array();
        $sql = "select e.*, (DATEDIFF(NOW(), e.fecha_transito)) as dias_transito, (DATEDIFF(NOW(), e.fecha_llegada)) as dias_llegada, r.folio as folioFlete, r.transporte_id as transporte, pr.nombre as proveedor, es.clave as clave, es.nombre as estatus,
            p.numero as pedimento, p.referencia as referencia, p.fecha_pedimento as fechaPedimento, p.tipo_cambio as tipoCambio, p.valor_comercial as valorComercial,
            p.incrementables_pesos as incrementablesPesos, p.total_impuestos as totalImpuestos, p.documento as pedimentoDoc, p.valor_aduana as valorAduana, 
            p.dta as dta, p.iva as ivaImportacion, p.prv as prv, p.iva_prv as ivaPrv, ct.numero as carroTanque, a.nombre as aduana, a.clave as claveAduana, p.otros_cargos as otrosCargos,
            (select o.folio from compras_ordenes_compra o where o.requisicion_id = e.requisicion_flete) as orden,
            (select req.producto_id from compras_requisiciones req where req.id = e.requisicion_producto) as idProducto,
            (select o.id from compras_ordenes_compra o where o.requisicion_id = e.requisicion_producto) as idOrdenProducto,
            (select o.nota_credito from compras_ordenes_compra o where o.requisicion_id = e.requisicion_producto) as notaCredito,
            (select concat(prod.nombre, ' (',ref.nombre,')')from catalogo_productos prod 
             inner join catalogo_refinerias ref on ref.id = prod.refineria_id where prod.id=(select req.producto_id from compras_requisiciones 
             req where req.id=e.requisicion_producto)) as producto,
            (select oc.folio from compras_ordenes_compra oc where oc.requisicion_id = e.requisicion_producto) as ordenProducto from compras_embarques e 
            left join compras_requisiciones r on r.id = e.requisicion_flete 
            left join compras_pedimentos p on p.id = e.pedimento_id 
            left join catalogo_carro_tanques ct on ct.id = e.carro_tanque_id 
            inner join catalogo_estatus es on es.id = e.estatus_id 
            left join catalogo_proveedores pr on pr.id = r.proveedor_id 
            left join catalogo_aduanas a on a.id = e.aduana_id";

        if ($where != null) {
            $sql .= $where;
        } else {
            $sql .= ' where e.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by e.id desc';
        }
        $embarques = $this->db->query($sql);
        if ($embarques != null) {
            foreach ($embarques->fetch_all(MYSQLI_ASSOC) as $e) {
                $moviminentos = $this->db->query('select m.* from almacen_movimientos_embarques m '
                                                     . "where m.embarque_id = {$e['id']} order by m.id desc");
                $m               = $moviminentos->fetch_all(MYSQLI_ASSOC);
                $e['movimiento'] = $m;
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getUltimosEmbarques()
    {
        $sql = ' where e.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by e.id desc limit 6';
        // $sql    = ' order by e.id desc limit 6';
        $result = $this->getAll($sql);
        return $result;
    }

    public function getEmbarqueByFechasProdProv($proveedor = null, $producto = null, $fechaIni = null, $fechaFin = null, $aduana = null, $ordenar = null, $isAlmacen = false, $isFile = false)
    {
        $fecha   = $this->getFechas($fechaIni, $fechaFin);
        $almacen = '';
        if ($isAlmacen) {
            $almacen = ' (e.estatus_id = 5 or e.estatus_id = 8 or e.estatus_id = 11) and ';
        }
        if ($isFile) {
            $almacen .= ' e.estatus_id != 2 and ';
        }
        if ($ordenar == 1) {
            $order = ' e.numero_factura';
        } else if ($ordenar == 2) {
            $order = ' e.fecha_factura';
        } else {
            $order = ' e.id';
        }

        if ($producto != null && $proveedor == null && $aduana == null) {
            $sql = " where e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($producto == null && $proveedor != null && $aduana == null) {
            $sql = ' where' . $almacen . " r.proveedor_id = {$proveedor} order by e.id desc;";
        } else if ($producto != null && $proveedor != null && $aduana == null) {
            $sql = ' where' . $almacen . " e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) and r.proveedor_id = {$proveedor} " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($producto != null && $proveedor != null && $aduana != null) {
            $sql = ' where' . $almacen . " e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) and r.proveedor_id = {$proveedor} and e.aduana_id = {$aduana} " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($producto == null && $proveedor != null && $aduana != null) {
            $sql = ' where' . $almacen . " r.proveedor_id = {$proveedor} and e.aduana_id = {$aduana}  " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($producto == null && $proveedor == null && $aduana != null) {
            $sql = ' where' . $almacen . " e.aduana_id = {$aduana} " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($fechaIni == null && $fechaFin == null) {
            $sql = ' where' . $almacen . " e.aduana_id = {$aduana} " . $fecha . ' order by ' . $order . ' desc;';
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni != null && $fechaFin != null) {
            $sql = ' where' . $almacen . " e.fecha_factura between '{$fechaIni}' and '{$fechaFin}' order by " . $order . ' desc;';
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni == null && $fechaFin != null) {
            $sql = ' where' . $almacen . " e.fecha_factura <= '{$fechaFin}' order by " . $order . ' desc;';
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni != null && $fechaFin == null) {
            $sql = ' where' . $almacen . " e.fecha_factura >= '{$fechaIni}' order by " . $order . ' desc;';
        } else {
            $sql = null;
        }
        $result = $this->getAll($sql);

        return $result;
    }

    private function getFechas($fechaIni, $fechaFin)
    {
        if ($fechaIni != null && $fechaFin != null) {
            return "and e.fecha_factura between '{$fechaIni}' and '{$fechaFin}'";
        } else if ($fechaIni == null && $fechaFin != null) {
            return "and e.fecha_factura <= '{$fechaFin}'";
        } else if ($fechaIni != null && $fechaFin == null) {
            return "and e.fecha_factura >= '{$fechaIni}'";
        } else if ($fechaIni == null && $fechaFin == null) {
            return '';
        }
    }

    public function getEmbarqueByFechasPedimentoProdProv($proveedor = null, $producto = null, $fechaIni = null, $fechaFin = null, $aduana = null, $isFile = false)
    {
        $file = '';
        if ($isFile) {
            $file = ' e.estatus_id != 2 and ';
        }

        $fecha = $this->getFechasPedimento($fechaIni, $fechaFin);
        if ($producto != null && $proveedor == null && $aduana == null) {
            $sql = ' where ' . $file . " e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) " . $fecha . ' order by p.fecha_pedimento asc;';
        } else if ($producto == null && $proveedor != null && $aduana == null) {
            $sql = ' where ' . $file . "  r.proveedor_id = {$proveedor} order by p.fecha_pedimento asc;";
        } else if ($producto != null && $proveedor != null && $aduana == null) {
            $sql = ' where ' . $file . "  e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) and r.proveedor_id = {$proveedor} " . $fecha . ' order by  p.fecha_pedimento asc;';
        } else if ($producto != null && $proveedor != null && $aduana != null) {
            $sql = ' where ' . $file . "  e.requisicion_producto in (select req.id from compras_requisiciones req where req.producto_id = {$producto}) and r.proveedor_id = {$proveedor} and e.aduana_id = {$aduana} " . $fecha . ' order by  p.fecha_pedimento asc;';
        } else if ($producto == null && $proveedor != null && $aduana != null) {
            $sql = ' where ' . $file . "  r.proveedor_id = {$proveedor} and e.aduana_id = {$aduana}  " . $fecha . ' order by p.fecha_pedimento asc;';
        } else if ($producto == null && $proveedor == null && $aduana != null) {
            $sql = ' where ' . $file . "  e.aduana_id = {$aduana} " . $fecha . ' order by  p.fecha_pedimento asc;';
        } else if ($fechaIni == null && $fechaFin == null) {
            $sql = ' where ' . $file . "  e.aduana_id = {$aduana} " . $fecha . ' order by  p.fecha_pedimento asc;';
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni != null && $fechaFin != null) {
            $sql = ' where ' . $file . "   p.fecha_pedimento between '{$fechaIni}' and '{$fechaFin}'  order by  p.fecha_pedimento asc;";
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni == null && $fechaFin != null) {
            $sql = ' where ' . $file . "  p.fecha_pedimento <= '{$fechaFin}' order by  p.fecha_pedimento asc;";
        } else if ($producto == null && $proveedor == null && $aduana == null && $fechaIni != null && $fechaFin == null) {
            $sql = ' where ' . $file . "  p.fecha_pedimento >= '{$fechaIni}' order by  p.fecha_pedimento asc;";
        } else {
            $sql = null;
        }
        error_log($sql,3,logs_root);
        $result = $this->getAll($sql);

        return $result;
    }

    private function getFechasPedimento($fechaIni, $fechaFin)
    {
        if ($fechaIni != null && $fechaFin != null) {
            return "and p.fecha_pedimento between '{$fechaIni}' and '{$fechaFin}'";
        } else if ($fechaIni == null && $fechaFin != null) {
            return "and p.fecha_pedimento <= '{$fechaFin}'";
        } else if ($fechaIni != null && $fechaFin == null) {
            return "and  p.fecha_pedimento >= '{$fechaIni}'";
        } else if ($fechaIni == null && $fechaFin == null) {
            return '';
        }
    }

    public function getByEstatusId($idEst)
    {
        if ($idEst != null && $idEst != '') {
            $sql = " where e.estatus_id = {$idEst} and e.fecha_alta >= DATE_ADD(curdate(), INTERVAL -4 month) order by e.id desc";
        } else {
            $sql = null;
        }
        $result = $this->getAll($sql);
        return $result;
    }

    public function getAlmacen($idEst)
    {
        if ($idEst != null && $idEst != '') {
            $sql = " where e.estatus_id = {$idEst} and e.fecha_alta >= DATE_ADD(curdate(), INTERVAL -4 month) order by e.id desc";
        } else {
            $sql = ' where (e.estatus_id = 5 or e.estatus_id = 11 or e.estatus_id = 8) and e.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by e.id desc';
        }
        $result = $this->getAll($sql);
        return $result;
    }

    public function embarqueEnTransito()
    {
        $sql    = "update compras_embarques set fecha_transito = '{$this->getFechaTransito()}', estatus_id = 8, fecha_llegada = null  where id = {$this->getId()}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function embarqueEnTerminal()
    {
        $sql    = "update compras_embarques set fecha_llegada = '{$this->getFechaLlegada()}', estatus_id = 11 where id = {$this->getId()}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function liberarEmbarque()
    {
        $sql    = "update compras_embarques set fecha_modificacion = '{$this->getFechaModificacion()}', estatus_id = 5 where id = {$this->getId()}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function cancelarEmbarque()
    {
        $sql    = "update compras_embarques set fecha_modificacion = curdate(), estatus_id = 2 where id = {$this->getId()}";
        $query  = $this->db->query($sql);
        $result = false;
        if ($query) {
            $result = true;
        }
        return $result;
    }

    public function getByRequisicionFlete()
    {
        $result    = array();
        $embarques = $this->db->query('select ct.numero as carroTanque, e.* from compras_embarques e left join catalogo_carro_tanques ct '
                                          . "on ct.id = e.carro_tanque_id where requisicion_flete = {$this->getIdRequisicionFlete()} ");
        while ($e = $embarques->fetch_object()) {
            array_push($result, $e);
        }
        return $result;
    }
}