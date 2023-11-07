<?php

class Unidad {

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
        $this->clave = $this->db->real_escape_string(strlen($cl) > 3 ? ucfirst($cl) : strtolower($cl));
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc;
    }

    public function save() {
        $sql = "insert into catalogo_unidades values(null, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_unidades set "
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
        $unidades = $this->db->query("select * from catalogo_unidades order by nombre asc");
        while($u = $unidades->fetch_object()){
            array_push($result, $u);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_unidades where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
    
    public function getUnidadById($id) { 
        $result = $this->db->query("select * from catalogo_unidades where id={$id}");   
        return $result->fetch_object();
    }
    
    public function getUnidadByNombre($nombre) { 
       $result = $this->db->query("select * from catalogo_unidades where nombre='{$nombre}'");   
       return $result->fetch_object();
    }

}
