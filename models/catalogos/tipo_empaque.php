<?php

class TipoEmpaque
{
    private $id;
    private $nombre;
    private $descripcion;
    private $peso_sugerido;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
    }

    function getDescripcion()
    {
        return $this->descripcion;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setDescripcion($descripcion): void
    {
        $desc              = $this->db->real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : 'S/D';
    }

    public function getPesoSugerido()
    {
        return $this->peso_sugerido;
    }

    public function setPesoSugerido($peso_sugerido): void
    {
        $this->peso_sugerido = $peso_sugerido;
    }

    public function save()
    {
        $sql    = "insert into catalogo_tipos_empaques values(null, '{$this->getNombre()}', '{$this->getDescripcion()}', '{$this->getPesoSugerido()}')";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function edit()
    {
        $sql = 'update catalogo_tipos_empaques set '
            . "nombre= '{$this->getNombre()}', descripcion = '{$this->getDescripcion()}', peso_sugerido = '{$this->getPesoSugerido()}'"
            . " where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll()
    {
        $result   = array();
        $tiposEmp = $this->db->query('select te.* from catalogo_tipos_empaques te order by te.nombre asc');
        while ($t = $tiposEmp->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function delete()
    {
        $delete = $this->db->query("delete from catalogo_tipos_empaques where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
}
