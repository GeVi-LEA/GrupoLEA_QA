<?php

class Aduana {

    private $id;
    private $ciudadId;
    private $nombre;
    private $clave;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getCiudadId() {
        return $this->ciudadId;
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

    function setCiudadId($ciudadId): void {
        $this->ciudadId = $ciudadId;
    }

    function setNombre($nombre): void {
        $this->nombre =  $this->db->real_escape_string(ucfirst(trim($nombre)));;
    }

    function setClave($clave): void {
        $this->clave = trim($clave);
    }

     
    public function save() {
        $id = intval($this->getUltimoId()) + 1;
        $sql = "insert into catalogo_aduanas values($id, {$this->getCiudadId()}, '{$this->getNombre()}', '{$this->getClave()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_aduanas set "
                 . "ciudad_id = {$this->getCiudadId()}, nombre= '{$this->getNombre()}', clave= '{$this->getClave()}'"
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
        $productos = $this->db->query("select a.*, c.ciudad_completa as ciudad from catalogo_aduanas a, view_ciudades c "
                . " where a.ciudad_id = c.id order by a.nombre asc");
            while($p = $productos->fetch_object()){
            array_push($result, $p);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_aduanas where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
    
          public function getById($id) {
        $result = $this->db->query("select a.*, c.ciudad_completa as ciudad from catalogo_aduanas a, view_ciudades c "
                . " where a.ciudad_id = c.id and a.id={$id}");
        return $result->fetch_object();
    }

    
    public function getUltimoId(){
     $sql = "SELECT MAX(id)as id FROM catalogo_aduanas";
     $query = $this->db->query($sql);
     $idReq = $query->fetch_object()->id;
     if($idReq != null){
        return $idReq;
     }else{
        return 0;
    }
    }

}
