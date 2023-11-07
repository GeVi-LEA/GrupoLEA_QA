<?php

class Ciudad {

    private $id;
    private $estado;
    private $nombre;
    private $clave;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getEstado() {
        return $this->estado;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getClave() {
        return $this->clave;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setEstado($Estado): void {
        $this->estado = $Estado;
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString($nombre));
    }

    function setClave($clave): void {
        $this->clave = $this->db->real_escape_string(strtoupper(trim($clave)));
    }

    public function save() {
        $sql = "insert into catalogo_ciudades values(null, '{$this->getEstado()}', '{$this->getNombre()}', '{$this->getClave()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_ciudades set "
                . "estado_id = {$this->getEstado()}, nombre= '{$this->getNombre()}',  clave = '{$this->getClave()}'"
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
        $ciudades = $this->db->query("select * from view_ciudades");
        while ($c = $ciudades->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_ciudades where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

}
