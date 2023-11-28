<?php

class TipoTransporte
{
    private $id;
    private $nombre;
    private $clave;
    private $descripcion;
    private $cap_maxima;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getClave()
    {
        return $this->clave;
    }

    function getDescripcion()
    {
        return $this->descripcion;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setNombre($nombre): void
    {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
    }

    function setClave($clave): void
    {
        $this->clave = $this->db->real_escape_string(UtilsHelp::fixString($clave));
    }

    function setDescripcion($descripcion): void
    {
        $desc              = $this->db->real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : 'S/D';
    }

    function getCap_Maxima()
    {
        return preg_replace('~\D~', '', $this->cap_maxima);
    }

    function setCap_Maxima($cap_maxima): void
    {
        $this->cap_maxima = preg_replace('~\D~', '', $cap_maxima);
    }

    public function save()
    {
        $sql    = "insert into catalogo_tipos_transportes values(null, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}', '{$this->getCap_Maxima()}')";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit()
    {
        $sql    = "update catalogo_tipos_transportes set 
                    nombre = '{$this->getNombre()}'
                    , clave= '{$this->getClave()}'
                    ,  descripcion = '{$this->getDescripcion()}'
                    ,  cap_maxima = '{$this->getCap_Maxima()}' 
                    where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll()
    {
        $result          = array();
        $tipoTransportes = $this->db->query('select * from catalogo_tipos_transportes order by nombre asc');
        while ($t = $tipoTransportes->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function getById($id)
    {
        $tipoTransportes = $this->db->query("select * from catalogo_tipos_transportes where id= {$id}");
        return $tipoTransportes->fetch_object();
    }

    public function delete()
    {
        $delete = $this->db->query("delete from catalogo_tipos_transportes where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getByNombre($nombre)
    {
        $tipoTransportes = $this->db->query("select * from catalogo_tipos_transportes where nombre = '{$nombre}'");
        return $tipoTransportes->fetch_object();
    }

    public function isTren()
    {
        $result          = array();
        $tipoTransportes = $this->db->query("select * from catalogo_tipos_transportes where nombre like '%Carro tanque%' or  nombre like '%Ferrotolva%'");
        while ($t = $tipoTransportes->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function isCamion()
    {
        $result          = array();
        $tipoTransportes = $this->db->query("select * from catalogo_tipos_transportes where nombre not like '%Carro tanque%' or  nombre not like '%Ferrotolva%'");
        while ($t = $tipoTransportes->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }
}
