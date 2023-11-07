<?php

class Servicio {

    private $id;
    private $nombre;
    private $clave;
    private $descripcion;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }
    
    public function getNombre() {
        return $this->nombre;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::toUpperString($nombre));
    }

    public function setClave($clave): void {
        $this->clave = $this->db->real_escape_string(UtilsHelp::toUpperString($clave));
    }
    
    function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

        function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : "S/D";
    }

    public function save() {
        $sql = "insert into catalogo_servicios values(null, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_servicios set "
                . "nombre= '{$this->getNombre()}', clave= '{$this->getClave()}',  descripcion = '{$this->getDescripcion()}'"
                . " where id={$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll($where = null) {
        $result = array();
        $sql = "select * from catalogo_servicios s";
          if($where != null){
            $sql.= $where;  
          }
         $sql .= " order by nombre asc";
        $compras = $this->db->query($sql);
        while ($c = $compras->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_servicios where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    
   public function getServicioById() {
        $where = " where s.id={$this->getId()}";
        return $this->getAll($where);
    }
 
    
      public function getServiciosSalidas() {
        $result = array();
        $sql = "select ser.id as id, ser.nombre as nombre, ser.clave as clave from catalogo_servicios ser where ser.clave like '%CARGA%' or ser.clave like '%AJUSTE%'";
        $servicios = $this->db->query($sql);
        while ($s = $servicios->fetch_object()) {
            array_push($result, $s);
        }
        return $result;
    }  
    
  
}
