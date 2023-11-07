<?php

class Almacen {

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
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
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
        $sql = "insert into catalogo_almacenes values(null, '{$this->getNombre()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_almacenes set "
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
        $a = $this->db->query("select a.* from catalogo_almacenes a order by a.nombre asc");
        while ($t = $a->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_almacenes where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

}
