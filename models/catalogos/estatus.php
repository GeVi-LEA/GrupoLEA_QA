<?php

class Estatus {

    private $id;
    private $nombre;
    private $clave;
    private $descripcion;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getClave() {
        return $this->clave;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
    }

    function setClave($clave): void {
        $cl = trim($clave);
        $this->clave = $this->db->real_escape_string(strlen($cl) > 3 ? ucfirst($cl) : strtoupper($cl));
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : "S/D";
    }

    public function save() {
        $id = (int)$this->getIdUltimoEst() + 1;
        $sql = "insert into catalogo_estatus values({$id}, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_estatus set "
                 . "nombre = '{$this->getNombre()}', clave= '{$this->getClave()}',  descripcion = '{$this->getDescripcion()}'"
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
        $estatus = $this->db->query("select * from catalogo_estatus order by id asc");
        while($e = $estatus->fetch_object()){
            array_push($result, $e);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_estatus where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
        
    public function getIdUltimoEst(){
    $sql = "SELECT MAX(id)as id FROM catalogo_estatus";
    $query = $this->db->query($sql);
    $id = $query->fetch_object()->id;
    return $id;
     }
}
