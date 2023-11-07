<?php

class Pais {

    private $id;
    private $nombre;
    private $clave;
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

    function setId($id): void {
        $this->id = $id;
    }
    
    function setNombre($nombre): void {
         $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($nombre)));
    }

    function setClave($clave): void {
        $this->clave = $this->db->real_escape_string(strtoupper(trim($clave)));
    }

 
    public function save() {
        $sql = "insert into catalogo_paises values(null, '{$this->getNombre()}', '{$this->getClave()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_paises set "
                 . "nombre= '{$this->getNombre()}',  clave = '{$this->getClave()} '"
                 . "where id={$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $result = array();
        $paises = $this->db->query("select * from catalogo_paises order by nombre asc");
        while($p = $paises->fetch_object()){
            array_push($result, $p);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_paises where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }

}
