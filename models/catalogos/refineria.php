<?php

class Refineria {

    private $id;
    private $nombre;
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

    function setId($id): void {
        $this->id = $id;
    }
    
    function setNombre($nombre): void {
         $this->nombre = $this->db->real_escape_string(strtoupper(trim($nombre)));
    }
 
    public function save() {
        $sql = "insert into catalogo_refinerias values(null, '{$this->getNombre()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_refinerias set "
                 . "nombre= '{$this->getNombre()}' where id={$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $result = array();
        $refinerias = $this->db->query("select * from catalogo_refinerias order by nombre asc");
        while($r = $refinerias->fetch_object()){
            array_push($result, $r);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_refinerias where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }

}
