<?php

class TipoCompra {

    private $id;
    private $tipo;
    private $descripcion;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setTipo($tipo): void {
        $this->tipo = $this->db->real_escape_string(UtilsHelp::capitalizeString($tipo));
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : "S/D";
    }

    public function save() {
        $sql = "insert into catalogo_tipos_compras values(null, '{$this->getTipo()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_tipos_compras set "
                . "tipo= '{$this->getTipo()}',  descripcion = '{$this->getDescripcion()}'"
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
        $compras = $this->db->query("select * from catalogo_tipos_compras order by tipo asc");
        while ($c = $compras->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_tipos_compras where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

}
