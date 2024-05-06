<?php

class ServicioEnsacado
{
    private $id;
    private $entradaId;
    private $servicioId;
    private $productoId;
    private $empaqueId;
    private $estatusId;
    private $folio;
    private $lote;
    private $alias;
    private $cantidad;
    private $fechaProgramacion;
    private $fechaInicio;
    private $fechaFin;
    private $barreduraSucia;
    private $barreduraLimpia;
    private $totalEnsacado;
    private $bultos;
    private $tarimas;
    private $tipoTarima;
    private $sacoxtarima;
    private $peso_empaque;
    private $parcial;
    private $orden;
    private $docOrden;
    private $observaciones;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEntradaId()
    {
        return $this->entradaId;
    }

    public function getServicioId()
    {
        return $this->servicioId;
    }

    public function getProductoId()
    {
        return $this->productoId;
    }

    public function getEmpaqueId()
    {
        return $this->empaqueId;
    }

    public function getEstatusId()
    {
        return $this->estatusId;
    }

    public function getFolio()
    {
        return $this->folio;
    }

    public function getBarreduraSucia()
    {
        return $this->barreduraSucia;
    }

    public function getBarreduraLimpia()
    {
        return $this->barreduraLimpia;
    }

    public function setBarreduraSucia($barreduraSucia): void
    {
        $this->barreduraSucia = Utils::getNullString($barreduraSucia);
    }

    public function setBarreduraLimpia($barreduraLimpia): void
    {
        $this->barreduraLimpia = Utils::getNullString($barreduraLimpia);
    }

    public function getLote()
    {
        return $this->lote;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getFechaProgramacion()
    {
        return $this->fechaProgramacion;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function getTotalEnsacado()
    {
        return $this->totalEnsacado;
    }

    public function getBultos()
    {
        return $this->bultos;
    }

    public function getTarimas()
    {
        return $this->tarimas;
    }

    public function getParcial()
    {
        return $this->parcial;
    }

    public function getOrden()
    {
        return $this->orden;
    }

    public function getDocOrden()
    {
        return $this->docOrden;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setEntradaId($entradaId): void
    {
        $this->entradaId = $entradaId;
    }

    public function setServicioId($servicioId): void
    {
        $this->servicioId = $servicioId;
    }

    public function setProductoId($productoId): void
    {
        $this->productoId = Utils::getNullString($productoId);
    }

    public function setEmpaqueId($empaqueId): void
    {
        $this->empaqueId = Utils::getNullString($empaqueId);
    }

    public function setEstatusId($estatusId): void
    {
        $this->estatusId = $estatusId;
    }

    public function setFolio($folio): void
    {
        $this->folio = $this->db->real_escape_string(UtilsHelp::toUpperString($folio));
    }

    public function setLote($lote): void
    {
        $this->lote = $this->db->real_escape_string(UtilsHelp::toUpperString($lote));
    }

    public function setAlias($alias): void
    {
        $this->alias = $this->db->real_escape_string(UtilsHelp::toUpperString($alias));
    }

    public function setCantidad($cantidad): void
    {
        $this->cantidad = Utils::getNullString($cantidad);
    }

    public function setFechaProgramacion($fechaProgramacion): void
    {
        $this->fechaProgramacion = $fechaProgramacion;
    }

    public function setFechaInicio($fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin): void
    {
        $this->fechaFin = $fechaFin;
    }

    public function setTotalEnsacado($totalEnsacado): void
    {
        $this->totalEnsacado = Utils::getNullString($totalEnsacado);
    }

    public function setBultos($bultos): void
    {
        $this->bultos = Utils::getNullString($bultos);
    }

    public function setTarimas($tarimas): void
    {
        $this->tarimas = Utils::getNullString($tarimas);
    }

    public function setParcial($parcial): void
    {
        $this->parcial = Utils::getNullString($parcial);
    }

    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }

    public function setDocOrden($docOrden): void
    {
        $this->docOrden = $docOrden;
    }

    public function setObservaciones($observaciones): void
    {
        $this->observaciones = $this->db->real_escape_string($observaciones);
    }

    public function getTipoTarima()
    {
        return $this->tipoTarima;
    }

    public function setTipoTarima($tipoTarima): void
    {
        $this->tipoTarima = $tipoTarima;
    }

    public function getAlmacenId()
    {
        return $this->almacen_id;
    }

    public function setAlmacenId($almacen_id): void
    {
        $this->almacen_id = $almacen_id;
    }

    public function getInsumoPor()
    {
        return $this->insumo_por;
    }

    public function setInsumoPor($insumo_por): void
    {
        $this->insumo_por = $insumo_por;
    }

    public function getSacoXTarima()
    {
        return $this->sacoxtarima;
    }

    public function setSacoXTarima($sacoxtarima): void
    {
        $this->sacoxtarima = $sacoxtarima;
    }

    public function getTarimaPor()
    {
        return $this->tarima_por;
    }

    public function setTarimaPor($tarima_por): void
    {
        $this->tarima_por = $tarima_por;
    }

    public function getPesoEmpaque()
    {
        return $this->peso_empaque;
    }

    public function setPesoEmpaque($peso_empaque): void
    {
        $this->peso_empaque = $peso_empaque;
    }

    public function save()
    {
        $sql = "insert into servicios_ensacado values(
                        null
                        , {$this->getEntradaId()}
                        , {$this->getServicioId()}
                        , {$this->getProductoId()}
                        , {$this->getAlmacenId()}
                        , {$this->getEmpaqueId()}
                        , {$this->getInsumoPor()}
                        , " . (($this->getServicioId() == '5') ? '13' : (($this->getFechaProgramacion() != 'null') ? '13' : $this->getEstatusId())) . "
                        , '{$this->getFolio()}'
                        , '{$this->getLote()}'
                        , '{$this->getAlias()}'
                        , {$this->getCantidad()}
                        , " . (($this->getServicioId() == '5') ? 'now()' : (($this->getFechaProgramacion() != 'null') ? "'" . $this->getFechaProgramacion() . "'" : 'null')) . "
                        , null
                        , null
                        , null
                        , null
                        , null
                        , null
                        , null
                        , {$this->getBultos()}
                        , {$this->getTarimas()}
                        , " . (($this->getTipoTarima() == '') ? '1' : $this->getTipoTarima()) . "
                        , {$this->getSacoXTarima()}
                        , {$this->getPesoEmpaque()}
                        , {$this->getTarimaPor()}
                        , {$this->getParcial()}
                        , '{$this->getOrden()}'
                        , '{$this->getDocOrden()}'
                        , '{$this->getObservaciones()}'
                        , '{$_SESSION['usuario']->id}'
                        , NOW()
                  )";
        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $sql;
    }

    public function getUltimoServicio()
    {
        $sql      = 'SELECT * FROM servicios_ensacado ORDER BY id DESC LIMIT 1';
        $query    = $this->db->query($sql);
        $servicio = $query->fetch_object();
        return $servicio;
    }

    public function getById()
    {
        $sql    = " where s.id = {$this->getId()} ";
        $result = $this->getAll($sql);
        return $result[0];
    }

    public function getAll($where = null)
    {
        $result = array();
        $sql    = 'select s.*
        , ce.clave as clave
        , ce.nombre as estatus
        , serv.nombre as servicio
        , serEnt.numUnidad as unidad
        , serEnt.fecha_entrada as fechaEntrada
        , serEnt.fecha_salida as fechaSalida
        #, TIMESTAMPDIFF(DAY, serEnt.fecha_entrada, serEnt.fecha_salida) as transcurridos
        , TIMESTAMPDIFF(MINUTE, s.fecha_inicio, s.fecha_fin) as transcurridos
        , (select cli.nombre from catalogo_clientes cli where cli.id =  serEnt.cliente_id) as cliente
        , serEnt.cliente_id 
        , prod.nombre nombre_producto 
        , s.sacoxtarima 
        , s.peso_empaque 
        from servicios_ensacado s
        left join catalogo_productos_resinas_liquidos prod on prod.id = s.producto_id
        inner join servicios_entradas serEnt on serEnt.id = s.entrada_id 
        inner join catalogo_estatus ce on ce.id = s.estatus_id 
        inner join catalogo_servicios serv on serv.id = s.servicio_id 
        left join catalogo_tipos_empaques te on te.id = s.empaque_id ';

        if ($where != null) {
            $sql .= $where;
        }
        $sql      .= ' order by s.id asc';
        $servicios = $this->db->query($sql);
        while ($c = $servicios->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function edit()
    {
        $sql = "update servicios_ensacado set 
          producto_id = {$this->getProductoId()}
        , empaque_id = {$this->getEmpaqueId()}
        , insumo_por = {$this->getInsumoPor()}
        , orden = '{$this->getOrden()}'
        , estatus_id = {$this->getEstatusId()}
        , lote = '{$this->getLote()}'
        , alias = '{$this->getAlias()}'
        , cantidad = {$this->getCantidad()}
        , total_ensacado = {$this->getTotalEnsacado()}
        , barredura_sucia = {$this->getBarreduraSucia()}
        , barredura_limpia = {$this->getBarreduraLimpia()}
        , bultos = {$this->getBultos()}, ";

        if ($this->getFechaProgramacion() == null or $this->getFechaProgramacion() == 'null') {
            $sql .= ' fecha_programacion = null, ';
        } else {
            $sql .= " fecha_programacion  = '{$this->getFechaProgramacion()}', ";
        }
        $sql   .= "  
        tarimas = {$this->getTarimas()}
        , parcial = {$this->getParcial()}
        , tipo_tarima = {$this->getTipoTarima()}
        , sacoxtarima = {$this->getSacoXTarima()}
        , tarima_por = {$this->getTarimaPor()}
        , doc_orden = '{$this->getDocOrden()}'
        , observaciones = '{$this->getObservaciones()}' 
        where id = {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function delete()
    {
        $sql    = "update servicios_ensacado set estatus_id = 0 where id = {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function inicarServicio()
    {
        $sql  = "update servicios_ensacado set 
        fecha_inicio = NOW()
        , estatus_id = 3
        , usuario_inicio = {$_SESSION['usuario']->id} 
        where id = {$this->getId()}; 
        ";
        $save = $this->db->query($sql);

        $sql  = "update servicios_entradas
        set estatus_id = 3
        where id = (select entrada_id from servicios_ensacado where id = {$this->getId()}) ;
        ";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function finalizarServicio()
    {
        $sql  = "
            update servicios_ensacado 
            set fecha_fin = NOW()
            , estatus_id = 5 
            , usuario_fin = {$_SESSION['usuario']->id} 
            where id = {$this->getId()}
            ";
        $save = $this->db->query($sql);

        $sql    = "
            update servicios_entradas
            set estatus_id = 3
            where id = (select entrada_id from servicios_ensacado where id = {$this->getId()})
            ;
        ";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function actualizaBarredura()
    {
        $sql    = "update servicios_ensacado 
                set barredura_limpia = '{$this->getBarreduraLimpia()}'
                ,barredura_sucia = '{$this->getBarreduraSucia()}'
                ,total_ensacado = '{$this->getTotalEnsacado()}' 
                ,tarimas = '" . (($this->getTarimas() == 'null') ? '0' : $this->getTarimas()) . "' 
                ,bultos = '" . (($this->getBultos() == 'null') ? '0' : $this->getBultos()) . "' 
                ,parcial = '" . (($this->getParcial() == 'null') ? '0' : $this->getParcial()) . "' 
                where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function eliminarDocumento()
    {
        $sql    = "update servicios_ensacado set doc_orden= ' ' where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getLotesCliente($clienteId)
    {
        $result    = array();
        $sql       = 'CALL getLotesCliente(' . $clienteId . ');';
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getInfoLote($lote)
    {
        $result    = array();
        $sql       = "
                              select 
                                se.lote
                                , max(se.producto_id)producto_id
                                , max(cat_prod.nombre) producto
                                , max(se.alias) alias 
                                , ifnull(get_disponibleByLote(max(se.lote), max(ent.cliente_id)),0) disponible
                                , get_almacenIdByLote(max(se.lote)) almacenId
                              from servicios_ensacado se 
                              inner join catalogo_productos_resinas_liquidos cat_prod on cat_prod.id = se.producto_id
                              inner join servicios_entradas ent on ent.id = se.entrada_id

                              where se.lote like '%{$lote}%' group by se.lote";
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getByLote()
    {
        $result    = array();
        $sql       = "select serEnt.producto_id as producto, serEnt.lote as lote, serEnt.alias as alias,  
                 (select sum(servEns.total_ensacado) from servicios_ensacado servEnt
                 left join servicios_ensacado servEns on servEns.entrada_id = servEnt.id 
                 inner join catalogo_servicios serv on servEns.servicio_id = serv.id where servEnt.lote like '%$lote%' and serv.clave not like '%CARGA%' and serv.clave not like '%AJUSTE%' and servEns.estatus_id = 5) as descargas,
                 where SerEnt.lote like '%$lote%'  group by serEnt.lote;";
        $servicios = $this->db->query($sql);
        while ($c = $servicios->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function getCargasPendientes($id)
    {
        $result    = array();
        $sql       = 'CALL getCargasPendientes(' . $id . ')';
        $servicios = $this->db->query($sql);
        while ($c = $servicios->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function getServicios($fecha_ini, $fecha_fin, $clientes, $tiposervicios = '1')
    {
        ini_set('memory_limit', '-1');
        $result = array();
        $sql    = "      
                select                
                ens.folio
                ,serv.id id_tipo_serv
                ,serv.nombre tipo_serv
                ,ent.numUnidad
                ,cli.nombre as nom_cliente
                ,cli.id id_cliente
                ,ens.lote
                ,prod.nombre as nom_prod
                ,ens.alias
                ,FORMAT(ens.cantidad,2) cantidad
                ,ens.fecha_inicio
                ,concat(usu_ini.nombres, ' ', usu_ini.apellidos) usu_ini
                ,ens.fecha_fin
                ,concat(usu_fin.nombres, ' ', usu_fin.apellidos) usu_fin
                ,get_DiffDates(ens.fecha_inicio, ens.fecha_fin) tiempo_invertido
                ,ens.tarimas
                ,ens.parcial
                ,ens.sacoxtarima
                ,ens.peso_empaque
                ,FORMAT(ens.barredura_sucia,2) barredura_sucia
                ,FORMAT(ens.barredura_limpia,2) barredura_limpia
                
                from servicios_ensacado ens
                inner join servicios_entradas ent on ent.id = ens.entrada_id /*and ent.entrada_salida = 0*/
                inner join catalogo_clientes cli on cli.id = ent.cliente_id
                inner join catalogo_productos_resinas_liquidos prod on prod.id = ens.producto_id
                inner join catalogo_usuarios usu_ini on usu_ini.id = ens.usuario_inicio
                inner join catalogo_usuarios usu_fin on usu_fin.id = ens.usuario_fin
                inner join catalogo_servicios serv on serv.id = ens.servicio_id
                where 
                ens.servicio_id in(" . $tiposervicios . ")
                and ens.fecha_fin >= '" . $fecha_ini . " 00:00:00'
                and ens.fecha_fin <= '" . $fecha_fin . " 23:00:00'
                ";
        if ($clientes != '') {
            $sql .= ' and ent.cliente_id in (' . $clientes . ') ';
        }
        // else {
        $sql .= 'order by cli.nombre, serv.nombre, ens.fecha_fin desc ';
        // }

        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
        // die();
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getServiciosGrafica($fecha_ini, $fecha_fin, $clientes, $tiposervicios = '1')
    {
        ini_set('memory_limit', '-1');
        $result = array();
        $sql    = '      
            select                
            max(cli.id) as id_cliente
            ,cli.nombre as nom_cliente
            ,count(*) cantidad
            ,max(cli.colorweb) colorweb
            from servicios_ensacado ens
            inner join servicios_entradas ent on ent.id = ens.entrada_id /*and ent.entrada_salida = 0*/
            inner join catalogo_clientes cli on cli.id = ent.cliente_id
            where 
            ens.servicio_id in(' . $tiposervicios . ")
            and ens.fecha_fin >= '" . $fecha_ini . " 00:00:00'
            and ens.fecha_fin <= '" . $fecha_fin . " 23:00:00'
            ";
        if ($clientes != '') {
            $sql .= ' and ent.cliente_id in (' . $clientes . ') 
            group by cli.nombre 
            order by count(*) desc';
        } else {
            $sql .= 'group by cli.nombre 
            order by count(*) desc, cli.nombre ';
        }
        // print_r('<pre>');
        // print_r($sql);
        // print_r('</pre>');
        // die();
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }
}
