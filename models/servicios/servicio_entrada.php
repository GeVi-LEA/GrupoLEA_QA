<?php

class ServicioEntrada
{
    private $id;
    private $clienteId;
    private $estatusId;
    private $entrada_salida;
    private $tipo_producto;
    private $tipoTransporteId;
    private $numUnidad;
    private $fechaEntrada;
    private $fechaLiberacion;
    private $fechaSalida;
    private $transportista;
    private $chofer;
    private $placa1;
    private $placa2;
    private $peso_obligatorio;
    private $ticket;
    private $pesoCliente;
    private $pesoTara;
    private $pesoTeorico;
    private $pesoBruto;
    private $pesoNeto;
    private $docTicket;
    private $docRemision;
    private $sellos;
    private $sello2;
    private $sello3;
    private $cat_puertas;
    private $transp_lea_cliente;
    private $observaciones;
    private $db;

    /* #region CAMPOS */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // region user description
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getNumUnidad()
    {
        return $this->numUnidad;
    }

    public function setNumUnidad($numUnidad): void
    {
        $this->numUnidad = $this->db->real_escape_string(UtilsHelp::toUpperString(UtilsHelp::quitarEspacios($numUnidad)));
    }

    public function getClienteId()
    {
        return $this->clienteId;
    }

    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    public function setFechaEntrada($fechaEntrada): void
    {
        $this->fechaEntrada = $fechaEntrada;
    }

    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    public function setFechaSalida($fechaSalida): void
    {
        $this->fechaSalida = $fechaSalida;
    }

    public function getFechaLiberacion()
    {
        return $this->fechaLiberacion;
    }

    public function setFechaLiberacion($fechaLiberacion): void
    {
        $this->fechaLiberacion = $fechaLiberacion;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function setTicket($ticket): void
    {
        $this->ticket = $ticket;
    }

    public function setClienteId($clienteId): void
    {
        $this->clienteId = $clienteId;
    }

    public function getPesoTara()
    {
        return $this->pesoTara;
    }

    public function setPesoTara($pesoTara): void
    {
        $this->pesoTara = $pesoTara;
    }

    public function getPesoTeorico()
    {
        return $this->pesoTeorico;
    }

    public function setPesoTeorico($pesoTeorico): void
    {
        $this->pesoTeorico = $pesoTeorico;
    }

    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    public function setPesoBruto($pesoBruto): void
    {
        $this->pesoBruto = $pesoBruto;
    }

    public function getPesoNeto()
    {
        return $this->pesoNeto;
    }

    public function setPesoNeto($pesoNeto): void
    {
        $this->pesoNeto = $pesoNeto;
    }

    public function getDocTicket()
    {
        return $this->docTicket;
    }

    public function setDocTicket($docTicket): void
    {
        $this->docTicket = $docTicket;
    }

    public function getTransportista()
    {
        return $this->transportista;
    }

    public function setTransportista($transportista): void
    {
        $this->transportista = $this->db->real_escape_string(UtilsHelp::toUpperString($transportista));
    }

    public function getChofer()
    {
        return $this->chofer;
    }

    public function setChofer($chofer): void
    {
        $this->chofer = $this->db->real_escape_string(UtilsHelp::toUpperString($chofer));
    }

    public function getOrden()
    {
        return $this->orden;
    }

    public function setOrden($orden): void
    {
        $this->orden = $this->db->real_escape_string(UtilsHelp::toUpperString($orden));
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones): void
    {
        $this->observaciones = $this->db->real_escape_string($observaciones);
    }

    public function getPlaca1()
    {
        return $this->placa1;
    }

    public function setPlaca1($placa1): void
    {
        $this->placa1 = $this->db->real_escape_string(UtilsHelp::toUpperString($placa1));
    }

    public function getPlaca2()
    {
        return $this->placa2;
    }

    public function setPlaca2($placa2): void
    {
        $this->placa2 = $this->db->real_escape_string(UtilsHelp::toUpperString($placa2));
    }

    public function getDocRemision()
    {
        return $this->docRemision;
    }

    public function setDocRemision($docRemision): void
    {
        $this->docRemision = $docRemision;
    }

    public function getEstatusId()
    {
        return $this->estatusId;
    }

    public function setEstatusId($estatusId): void
    {
        $this->estatusId = $estatusId;
    }

    public function getTipoTransporteId()
    {
        return $this->tipoTransporteId;
    }

    public function setTipoTransporteId($tipoTransporteId): void
    {
        $this->tipoTransporteId = Utils::getNullString($tipoTransporteId);
    }

    public function getSellos()
    {
        return $this->sellos;
    }

    public function setSellos($sellos): void
    {
        $this->sellos = $sellos;
    }

    public function getSello1()
    {
        return $this->sello1;
    }

    public function setSello1($sello1): void
    {
        $this->sello1 = $this->db->real_escape_string(UtilsHelp::toUpperString($sello1));
    }

    public function getSello2()
    {
        return $this->sello2;
    }

    public function setSello2($sello2): void
    {
        $this->sello2 = $this->db->real_escape_string(UtilsHelp::toUpperString($sello2));
    }

    public function getSello3()
    {
        return $this->sello3;
    }

    public function setSello3($sello3): void
    {
        $this->sello3 = $this->db->real_escape_string(UtilsHelp::toUpperString($sello3));
    }

    public function getPesoCliente()
    {
        return $this->pesoCliente;
    }

    public function setPesoCliente($pesoCliente): void
    {
        $this->pesoCliente = $pesoCliente;
    }

    // ////
    public function getFirma_entrada()
    {
        return $this->firma_entrada;
    }

    public function setFirma_entrada($firma_entrada): void
    {
        $this->firma_entrada = $this->db->real_escape_string($firma_entrada);
    }

    public function getFirma_salida()
    {
        return $this->firma_salida;
    }

    public function setFirma_salida($firma_salida): void
    {
        $this->firma_salida = $this->db->real_escape_string($firma_salida);
    }

    public function getCantPuertas()
    {
        return $this->cant_puertas;
    }

    public function setCantPuertas($cant_puertas): void
    {
        $this->cant_puertas = $cant_puertas;
    }

    public function getTranspLeaCliente()
    {
        return $this->transp_lea_cliente;
    }

    public function setTranspLeaCliente($transp_lea_cliente): void
    {
        $this->transp_lea_cliente = $transp_lea_cliente;
    }

    public function getEntrada_Salida()
    {
        return $this->entrada_salida;
    }

    public function setEntrada_Salida($entrada_salida): void
    {
        $this->entrada_salida = $entrada_salida;
    }

    public function getTipo_Producto()
    {
        return $this->tipo_producto;
    }

    public function setTipo_Producto($tipo_producto): void
    {
        $this->tipo_producto = $tipo_producto;
    }

    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    public function setEmpresaId($empresa_id): void
    {
        $this->empresa_id = $empresa_id;
    }

    public function getPesoObligatorio()
    {
        return $this->peso_obligatorio;
    }

    public function setPesoObligatorio($peso_obligatorio): void
    {
        $this->peso_obligatorio = $peso_obligatorio;
    }

    /* #endregion */

    public function save()
    {
        $sql = "insert into servicios_entradas values(
            null /*id */
        , {$this->getClienteId()}/*, cliente_id */
        , {$this->getEstatusId()}/*, estatus_id */
        , {$this->getTipoTransporteId()}/*, tipo_transporte_id */
        , {$this->getEntrada_Salida()}/*, entrada_salida */
        , {$this->getEmpresaId()}/*, empresa */
        , {$this->getTipo_Producto()}/*, tipo_producto */
        , '{$this->getNumUnidad()}' /*, numUnidad */
        , null  /*, fecha_entrada */
        , null /*, fecha_salida */
        , null /*, fecha_liberacion */
        , '{$this->getTransportista()}' /*, transportista */
        , '{$this->getChofer()}' /*, chofer */
        , '{$this->getPlaca1()}' /*, placa1 */
        , '{$this->getPlaca2()}' /*, placa2 */
        , '{$this->getPesoObligatorio()}' /*, peso_obligatorio */        
        ,  {$this->getTicket()} /*, ticket */
        , null /*, estatus_bascula */
        ,  {$this->getPesoCliente()} /*, peso_cliente */
        ,  {$this->getPesoTara()} /*, peso_tara */
        ,  {$this->getPesoTeorico()} /*, peso_teorico */
        ,  {$this->getPesoBruto()} /*, peso_bruto */
        ,  {$this->getPesoNeto()} /*, peso_neto */
        , '{$this->getDocTicket()}' /*, doc_ticket */
        , '{$this->getDocRemision()}' /*, doc_remision */
        , null /*, sello1 */
        , null /*, sello2 */
        , null /*, sello3 */
        , '{$this->getObservaciones()}' /*, observaciones */
        , '{$_SESSION['usuario']->id}' /*, usuario_creacion */
        , now() /*, fecha_creacion */
        , '' /* firma_entrada */
        , '' /* firma_salida */
        , {$this->getCantPuertas()} /*, cant_puertas */
        , {$this->getTranspLeaCliente()} /*, transp_lea_cliente */
        ,'' /*, sellos */
         )";
        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
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
        $sql    = 'select se.*
                , CEIL(se.peso_tara * 0.453592) as pesoTaraKg
                , c.nombre as nombreCliente
                , es.clave as clave
                , es.nombre as estatus
                , se.peso_cliente as pesoCliente
                , CEIL(se.peso_cliente * .003) as tolerable
                , (se.peso_teorico - se.peso_cliente) as diferenciaTeorica
                , TIMESTAMPDIFF(MINUTE, se.fecha_entrada, if(se.fecha_salida is null, now(), se.fecha_salida)) as tiempoTranscurrido
                , case
                        when tipo_transporte_id = 6 or tipo_transporte_id = 12 then concat(\'<span id="showEnsacado" data-idserv="\',se.id,\'" class="showEnsacado material-icons i-recibir">directions_subway</span>Entrada\')
                        else concat(\'<span id ="showEnsacado"  data-idserv="\',se.id,\'" class = " showEnsacado material-icons i-recibir">local_shipping</span>Salida\')
                    end as iconounidad 
                , c.direccion direccion_cliente
                ,(SELECT sum(ifnull(total_ensacado,cantidad)) FROM servicios_ensacado where entrada_id = se.id and estatus_id <>0 and servicio_id in(1,4,5) ) totalensacado
                ,(SELECT count(*) FROM servicios_ensacado where entrada_id = se.id and estatus_id not in(0, 5)) serv_pendientes
                , case  
                    when (tipo_transporte_id = 6 or tipo_transporte_id = 12) and (SELECT count(*) FROM servicios_ensacado where entrada_id = se.id and estatus_id not in(0, 5)) = 0 and se.estatus_bascula <> \'C\' then concat(\'<div class=\"pendiente\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Pendiente pesar en vacío\">\',numUnidad,\'</div>\')
                    else numUnidad
                    end numeroUnidad
                ,(select COALESCE(SUM(ifnull(total_ensacado,cantidad)), 0) from servicios_ensacado where entrada_id = se.id and estatus_id not in (0)) total_por_ensacar
                ,(select COALESCE(SUM(total_ensacado), 0) from servicios_ensacado where entrada_id = se.id and estatus_id in (5)) total_ensacado
                from servicios_entradas se 
                inner join catalogo_estatus es on es.id = se.estatus_id 
                left join catalogo_clientes c on c.id = se.cliente_id ';
        if ($where != null) {
            $sql .= $where;
        } else {
            $sql .= ' order by se.id desc';
        }

        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                $sql_servicio  = "select se.*
                                , ce.clave as clave
                                , ce.nombre as estatus
                                , serv.nombre as nombreServ
                                , serv.clave as claveServ
                                , te.nombre as empaque
                                , te.id as empaque_id
                                , TIMESTAMPDIFF(MINUTE, se.fecha_inicio, if(se.fecha_fin is null, now(), se.fecha_fin)) as transcurrido
                                , prod.nombre as producto  
                                , concat(usuarios_inicio.nombres,' ',usuarios_inicio.apellidos) usuario_inicio_nombre
                                , concat(usuarios_fin.nombres,' ',usuarios_fin.apellidos) usuario_fin_nombre
                                
                                from servicios_ensacado se 
                                inner join catalogo_estatus ce on ce.id = se.estatus_id 
                                inner join catalogo_servicios serv on serv.id = se.servicio_id 
                                left join catalogo_productos_resinas_liquidos prod on prod.id = se.producto_id
                                left join catalogo_tipos_empaques te on te.id = se.empaque_id 
                                left join catalogo_usuarios usuarios_inicio on usuarios_inicio.id = se.usuario_inicio
                                left join catalogo_usuarios usuarios_fin on usuarios_fin.id = se.usuario_fin
                                where entrada_id = {$e['id']} and estatus_id not in (0) order by id asc
                                ";
                $servicios     = $this->db->query($sql_servicio);
                $s             = $servicios->fetch_all(MYSQLI_ASSOC);
                $e['servicio'] = $s;
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getByEstatusId($idEst)
    {
        if ($idEst != null && $idEst != '') {
            // if ($idEst == 5) {
            //    $sql = " where estatus_id = {$idEst} /*and se.fecha_salida >= DATE_ADD(curdate(), INTERVAL -1 month)*/ order by se.id desc";
            // } else {
            $sql = " where estatus_id = {$idEst} and tipo_producto = 0 order by se.id desc";
            // }
        } else {
            $sql = null;
        }
        $result = $this->getAll($sql);
        return $result;
    }

    public function getById()
    {
        $sql    = " where se.id = {$this->getId()}; ";
        $result = $this->getAll($sql);
        return $result[0];
    }

    public function edit()
    {
        $sql = "update servicios_entradas set 
                numUnidad = '{$this->getNumUnidad()}'
                , cliente_id = {$this->getClienteId()}
                , fecha_entrada = " . (($this->getFechaEntrada() == 'null') ? 'null' : "'" . $this->getFechaEntrada() . "'") . '
                , fecha_liberacion = ' . (($this->getFechaLiberacion() == 'null') ? 'null' : "'" . $this->getFechaLiberacion() . "'") . "
                , transportista = '{$this->getTransportista()}'
                , chofer = '{$this->getChofer()}'
                , tipo_producto = '{$this->getTipo_Producto()}'
                , entrada_salida = '{$this->getEntrada_Salida()}'
                , placa1 = '{$this->getPlaca1()}'
                , placa2 = '{$this->getPlaca2()}'
                , peso_tara = {$this->getPesoTara()}
                , ticket = {$this->getTicket()}
                , peso_teorico = {$this->getPesoTeorico()}
                , peso_bruto = {$this->getPesoBruto()}
                , peso_cliente = {$this->getPesoCliente()}
                , peso_neto = {$this->getPesoNeto()}
                , tipo_transporte_id = {$this->getTipoTransporteId()}
                , doc_ticket = '{$this->getDocTicket()}'
                , doc_remision = '{$this->getDocRemision()}'
                , sellos = '{$this->getSellos()}'
                , sello2 = '{$this->getSello2()}'
                , sello3 = '{$this->getSello3()}'
                , observaciones = '{$this->getObservaciones()}'
                , peso_obligatorio = '{$this->getPesoObligatorio()}'
                , transp_lea_cliente = '{$this->getTranspLeaCliente()}'
                 where id = {$this->getId()}";
        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
        // die();
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function ingresarUnidad()
    {
        $sql = 'update servicios_entradas set '
            . " fecha_entrada = NOW(), estatus_id = 11 where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function transitoUnidad()
    {
        $sql    = "update servicios_entradas set estatus_id = 8 where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function salidaUnidad()
    {
        $sql = 'update servicios_entradas set '
            . " fecha_salida = NOW(), estatus_id = 5 where id={$this->getId()};
            
            ";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function liberarUnidad()
    {
        $sql = 'update servicios_entradas set '
            . " fecha_liberacion = NOW(), estatus_id = 15 where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getClientes()
    {
        $result = array();
        $sql = 'select distinct(se.cliente_id), c.nombre as cliente from servicios_entradas se '
            . 'inner join catalogo_clientes c on c.id = se.cliente_id  '
            . "where se.cliente_id != '' order by se.cliente_id";
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getLotess()
    {
        $result = array();
        $sql = 'select se.id as id, se.lote, c.nombre as cliente, prod.nombre as producto from servicios_entradas se '
            . 'inner join catalogo_clientes c on c.id = se.cliente_id  '
            . 'inner join catalogo_productos_resinas_liquidos prod on prod.id = se.producto_id '
            . "where se.lote != '' order by se.lote";
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                $sql_servicio = 'select se.*, ce.clave as clave, ce.nombre as estatus, serv.nombre as nombreServ, serv.clave as claveServ, te.nombre as empaque '
                    . ' from servicios_ensacado se '
                    . ' inner join catalogo_estatus ce on ce.id = se.estatus_id '
                    . ' inner join catalogo_servicios serv on serv.id = se.servicio_id '
                    . " left join catalogo_tipos_empaques te on te.id = se.empaque_id where entrada_id = {$e['id']} order by id asc";
                $servicios     = $this->db->query($sql_servicio);
                $s             = $servicios->fetch_all(MYSQLI_ASSOC);
                $e['servicio'] = $s;
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function unidadRegistrada()
    {
        if (!$this->getId()) {
            $sql = "select * from servicios_entradas where numUnidad = '{$this->getNumUnidad()}' and estatus_id not in(0, 5, 15) ";
        } else {
            $sql = "select * from servicios_entradas where numUnidad = '{$this->getNumUnidad()}' and estatus_id not in(0, 5, 15)  and id !=  {$this->getId()}";
        }
        return $this->db->query($sql);
    }

    public function eliminarDocumento($tipoDocumento)
    {
        $sql = 'update servicios_entradas set ';
        if ($tipoDocumento == 1) {
            $sql .= " doc_remision = '' where id={$this->getId()}";
        } else {
            $sql .= " doc_ticket = '' where id={$this->getId()}";
        }

        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getCamionesPatio()
    {
        $result   = array();
        $sql      = 'CALL getCamionesPatio();';
        $camiones = $this->db->query($sql);
        if ($camiones != null) {
            foreach ($camiones->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getDataGraficas()
    {
        $result   = array();
        $sql      = 'CALL getDataGraficaEntradas();';
        $camiones = $this->db->query($sql);
        if ($camiones != null) {
            foreach ($camiones->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function updateSellos()
    {
        $sql    = "update servicios_entradas set 
                    sellos = '{$this->getSellos()}'
                    , sello2 = '{$this->getSello2()}'
                    , sello3 = '{$this->getSello3()}'
                    , firma_salida = '{$this->getFirma_salida()}'
                    where id = {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function updateFirmaEntrada()
    {
        $sql    = "update servicios_entradas set 
                firma_entrada = '{$this->getFirma_entrada()}'
                where id = {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = true;
        if ($save) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}