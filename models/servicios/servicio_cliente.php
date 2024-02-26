<?php

class ServicioCliente
{
    private $id;
    private $servicioId;
    private $clienteId;
    private $tipoEmpaqueId;
    private $unidadId;
    private $costo;
    private $moneda;
    private $dias;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getServicioId()
    {
        return $this->servicioId;
    }

    public function getClienteId()
    {
        return $this->clienteId;
    }

    public function getTipoEmpaqueId()
    {
        return $this->tipoEmpaqueId;
    }

    public function getUnidadId()
    {
        return $this->unidadId;
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function getMoneda()
    {
        return $this->moneda;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setServicioId($servicioId): void
    {
        $this->servicioId = $servicioId;
    }

    public function setClienteId($clienteId): void
    {
        $this->clienteId = $clienteId;
    }

    public function setTipoEmpaqueId($tipoEmpaqueId): void
    {
        $this->tipoEmpaqueId = $tipoEmpaqueId;
    }

    public function setUnidadId($unidadId): void
    {
        $this->unidadId = $unidadId;
    }

    public function setCosto($costo): void
    {
        $this->costo = $costo;
    }

    public function setMoneda($moneda): void
    {
        $this->moneda = $moneda;
    }

    public function getDias()
    {
        return $this->dias;
    }

    public function setDias($dias): void
    {
        $this->dias = $dias;
    }

    public function save()
    {
        $sql = "insert into servicios_clientes values(null, {$this->getServicioId()}, {$this->getClienteId()}, {$this->getTipoEmpaqueId()},"
            . " {$this->getUnidadId()}, {$this->getCosto()}, {$this->getMoneda()}, {$this->getDias()})";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getDuplicado()
    {
        $result = false;
        $sql = "select * from servicios_clientes where servicio_id = {$this->getServicioId()} and cliente_id = {$this->getClienteId()}"
            . " and tipo_empaque_id = {$this->getTipoEmpaqueId()} and unidad_id = {$this->getUnidadId()} and moneda = {$this->getMoneda()}";
        $duplicados = $this->db->query($sql);
        if ($duplicados->num_rows > 0) {
            $result = true;
        }
        return $result;
    }

    public function edit()
    {
        $sql = "update servicios_clientes set servicio_id = {$this->getServicioId()}, cliente_id = {$this->getClienteId()}, "
            . " tipo_empaque_id = {$this->getTipoEmpaqueId()}, unidad_id = {$this->getUnidadId()}, costo = {$this->getCosto()}, "
            . " moneda = {$this->getMoneda()}, dias = {$this->getDias()} where id= {$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $sql;
    }

    public function getAll()
    {
        $result    = array();
        $servicios = $this->db->query('select serCli.*, c.nombre as cliNombre, s.nombre as servNombre, s.clave as servClave, emp.nombre as empaque, 
                                        u.nombre as unidad from servicios_clientes serCli
                                        inner join catalogo_servicios s on s.id = serCli.servicio_id
                                        inner join catalogo_clientes c on c.id = serCli.cliente_id
                                        inner join catalogo_unidades u on u.id = serCli.unidad_id
                                        left join catalogo_tipos_empaques emp on emp.id = serCli.tipo_empaque_id
                                        order by serCli.servicio_id, serCli.cliente_id');
        while ($c = $servicios->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function getAllClientes()
    {
        $result = array();
        $sql    = 'select s.* from servicios_clientes s ';
        $serv   = $this->db->query($sql);
        if ($serv->num_rows >= 1) {
            $r = true;
        } else {
            $r = false;
        }
        if ($r) {
            $this->db->query('SET @sql = NULL;');
            $this->db->query(str_replace('\\', '', "SELECT GROUP_CONCAT(DISTINCT CONCAT('MAX(CASE WHEN c.id = ', c.id, ' THEN concat(serCli.id,'\"'-'\"',serCli.costo,'\"'-'\"',serCli.moneda) ELSE NULL END) AS', '\"', c.nombre, '\"'))
                 INTO @sql FROM servicios_clientes as serCli inner join catalogo_clientes c on c.id = serCli.cliente_id;"));
            $this->db->query("SET @sql = CONCAT('select max(s.nombre) as Servicio, s.clave as Clave, emp.nombre as Empaque, max(u.nombre) as Unidad, ', @sql, ' FROM servicios_clientes as serCli inner join catalogo_servicios s on s.id = serCli.servicio_id
                                        inner join catalogo_clientes c on c.id = serCli.cliente_id
                                        inner join catalogo_unidades u on u.id = serCli.unidad_id
                                        left join catalogo_tipos_empaques emp on emp.id = serCli.tipo_empaque_id
                                        GROUP BY serCli.servicio_id, serCli.tipo_empaque_id');");

            $this->db->query('PREPARE stmt FROM @sql;');

            $servicios = $this->db->query('EXECUTE stmt;');
            $this->db->query('DEALLOCATE PREPARE stmt;');
            if ($servicios === false) {
                echo $this->db->error;
            } else {
                while ($c = $servicios->fetch_object()) {
                    array_push($result, $c);
                }
            }
        }
        return $result;
    }

    public function delete()
    {
        $delete = $this->db->query("delete from servicios_clientes where id={$this->getId()}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getById()
    {
        $sql = 'select s.*, ser.clave as clave, ser.descripcion as descripcion from servicios_clientes s '
            . " inner join catalogo_servicios ser on ser.id = s.servicio_id where s.id = {$this->getId()}";
        $serv = $this->db->query($sql);
        if ($serv->num_rows == 1) {
            return $serv->fetch_object();
        } else {
            return false;
        }
    }

    public function getServicioByCliente()
    {
        $result = array();
        $sql = 'select ser.id as id, ser.nombre as nombre, ser.clave as clave from servicios_clientes s '
            . ' inner join catalogo_servicios ser on ser.id = s.servicio_id'
            . ' inner join catalogo_clientes cli on cli.id = s.cliente_id '
            . ' where s.cliente_id = IFNULL(' . (($this->getClienteId() != null) ? $this->getClienteId() : 'null') . ',s.cliente_id) '
            . ' union select servicio.id as id, servicio.nombre as nombre, servicio.clave as clave from '
            . " catalogo_servicios servicio where servicio.clave like '%AJUSTE%'";
        $serv = $this->db->query($sql);
        while ($s = $serv->fetch_object()) {
            array_push($result, $s);
        }
        return $result;
    }
}
