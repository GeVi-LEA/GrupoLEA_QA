<?php

class Ciudad
{
    private $id;
    private $clave;
    private $nombre;
    private $direccion;
    private $estado;
    private $cp;
    private $rfc;
    private $tel;
    private $folio;
    private $fecha_creacion;
    private $usuario_creacion;
    private $fecha_modificacion;
    private $usuario_modificacion;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function getClave()
    {
        return $this->clave;
    }

    function setClave($clave): void
    {
        $this->clave = $this->db->real_escape_string(strtoupper(trim($clave)));
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function setNombre($nombre): void
    {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString($nombre));
    }

    function getDireccion()
    {
        return $this->direccion;
    }

    function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setEstado($Estado): void
    {
        $this->estado = $Estado;
    }

    function getCP()
    {
        return $this->cp;
    }

    function setCP($cp): void
    {
        $this->cp = $cp;
    }

    function getRFC()
    {
        return $this->rfc;
    }

    function setRFC($rfc): void
    {
        $this->rfc = $rfc;
    }

    function getTel()
    {
        return $this->tel;
    }

    function setTel($tel): void
    {
        $this->tel = $tel;
    }

    function getFolio()
    {
        return $this->folio;
    }

    function setFolio($folio): void
    {
        $this->folio = $folio;
    }

    function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    function setFecha_creacion($fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    function getUsuario_creacion()
    {
        return $this->usuario_creacion;
    }

    function setUsuario_creacion($usuario_creacion): void
    {
        $this->usuario_creacion = $usuario_creacion;
    }

    function getfFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    function setfFecha_modificacion($fecha_modificacion): void
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    function getUsuario_modificacion()
    {
        return $this->usuario_modificacion;
    }

    function setUsuario_modificacion($usuario_modificacion): void
    {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function save()
    {
        $sql    = "INSERT INTO `catalogo_empresas`
                    (`clave`,
                    `nombre`,
                    `direccion`,
                    `estado`,
                    `cp`,
                    `rfc`,
                    `tel`,
                    `folio`,
                    `usuario_creacion`,)
                    VALUES
                    ('{$this->getClave()}}',
                    '{$this->getNombre()}}',
                    '{$this->getDireccion()}}',
                    '{$this->getEstado()}}',
                    '{$this->getCP()}}',
                    '{$this->getRFC()}}',
                    '{$this->getTel()}}',
                    '{$this->getFolio()}}',
                    {$_SESSION['usuario']->id});
                    ";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit()
    {
        $sql = 'update catalogo_empresas set ';
                if($this->getClave() != ""){
                    $sql .=" clave = '{$this->getClave()}',";
                }
                if($this->getNombre()!=""){
                    $sql.=" nombre = '{$this->getNombre()}',";
                }
                if($this->getDireccion()!=""){
                    $sql.=" clave = '{$this->getDireccion()}',";
                }
                if($this->getEstado()!=""){
                    $sql.=" estado = '{$this->getEstado()}',";
                }
                if($this->getCP()!=""){
                    $sql.=" cp = '{$this->getCP()}',";
                }
                if($this->getRFC()!=""){
                    $sql.=" rfc = '{$this->getRFC()}',";
                }
                if($this->getTel()!=""){
                    $sql.=" tel = '{$this->getTel()}',";
                }
                if($this->getFolio()!=""){
                    $sql.=" folio = '{$this->getFolio()}',";
                }
            
                $sql.=" usuario_modificacion = {$_SESSION['usuario']->id}
                , fecha_modificacion = now()  
                where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll($where = null)
    {
        $result   = array();
        $sql ='select * from catalogo_empresas';
        if ($where != null) {
            $sql .= $where;
        } else {
            $sql .= ' order by se.id desc';
        }
        $ciudades = $this->db->query($sql);
        while ($c = $ciudades->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function delete()
    {
        $delete = $this->db->query("delete from catalogo_empresas where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    public function getById()
    {
        $sql    = " where id = {$this->getId()}; ";
        $result = $this->getAll($sql);
        return $result[0];
    }
}