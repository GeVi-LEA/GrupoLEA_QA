<?php

class TipoSolicitud {

    private $id;
    private $tipo_compra_id;
    private $tipo;
    private $descripcion;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getTipo_compra_id() {
        return $this->tipo_compra_id;
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

    function setTipo_compra_id($tipo_compra_id): void {
        $this->tipo_compra_id = $tipo_compra_id;
    }

    public function save() {
        $sql = "insert into catalogo_tipos_solicitudes values(null, {$this->getTipo_compra_id()}, '{$this->getTipo()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_tipos_solicitudes set "
                . "tipo_compra_id= {$this->getTipo_compra_id()},  tipo = '{$this->getTipo()}', descripcion = '{$this->getDescripcion()}'"
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
        $tiposSolicitudes = $this->db->query("select ts.*, tc.tipo as tipoCompra from catalogo_tipos_solicitudes ts, catalogo_tipos_compras tc "
                . " where ts.tipo_compra_id = tc.id  order by ts.tipo asc");
        while ($t = $tiposSolicitudes->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_tipos_solicitudes where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

}
