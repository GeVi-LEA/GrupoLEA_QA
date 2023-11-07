<?php

class Producto {

    private $id;
    private $refineriaId;
    private $nombre;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }
    
    function getRefineriaId() {
        return $this->refineriaId;
    }

    function setRefineriaId($refineriaId): void {
        $this->refineriaId = $refineriaId;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function setId($id): void {
        $this->id = $id;
    }
    
    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(strtoupper(trim($nombre)));
    }
 
    public function save() {
        $sql = "insert into catalogo_productos values(null, {$this->getRefineriaId()}, '{$this->getNombre()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;

    }

    public function edit() {
         $sql = "update catalogo_productos set "
                 . "refineria_id = {$this->getRefineriaId()}, nombre= '{$this->getNombre()}'"
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
        $productos = $this->db->query("select p.*, r.nombre as nombre_refineria from catalogo_productos p, catalogo_refinerias r "
                . " where p.refineria_id = r.id order by p.nombre asc");
            while($p = $productos->fetch_object()){
            array_push($result, $p);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_productos where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
    
          public function getById($id) {
        $result = $this->db->query("select p.*, r.nombre as nombre_refineria from catalogo_productos p "
                . " inner join catalogo_refinerias r on r.id = p.refineria_id where p.id={$id}");
        return $result->fetch_object();
    }

}
