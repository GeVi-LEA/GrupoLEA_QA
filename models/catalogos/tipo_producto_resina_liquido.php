<?php

class TipoProductosResinasLiquidos{

    private $id;
    private $nombre;
    private $descripcion;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(strtoupper(trim($nombre)));
    }

    function getDescripcion() {
    return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : "S/D";
    }

    public function save() {
        $sql = "insert into catalogo_tipos_productos_resinas_liquidos values(null, '{$this->getNombre()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function edit() {
        $sql = "update catalogo_tipos_productos_resinas_liquidos set "
                . "nombre= '{$this->getNombre()}', descripcion = '{$this->getDescripcion()}'"
                . " where id={$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $result = array();
        $tiposEmp = $this->db->query("select te.* from catalogo_tipos_productos_resinas_liquidos te order by te.nombre asc");
        while ($t = $tiposEmp->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_tipos_productos_resinas_liquidos where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

}
