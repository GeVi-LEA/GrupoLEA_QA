<?php

class Estado {

    private $id;
    private $paisId;
    private $nombre;
    private $clave;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }
    
     function getPaisId(){
        return $this->paisId;
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
    
     function setPaisId($paisId): void {
        $this->paisId = $paisId;
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString($nombre));
    }

    function setClave($clave): void {
        $this->clave = $this->db->real_escape_string(strtoupper(trim($clave)));
    }

 
    public function save() {
        $sql = "insert into catalogo_estados values(null, {$this->getPaisId()}, '{$this->getNombre()}', '{$this->getClave()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_estados set "
                 . "pais_id = {$this->getPaisId()}, nombre= '{$this->getNombre()}',  clave = '{$this->getClave()}'"
                 . " where id={$this->getId()}";
        $save = $this->db->query($sql);
        var_dump($this->db->error);
        $result = false;
        if ($save) {
            $result = true;
        }
        var_dump($this->getNombre());
        return $result;
    }

    public function getAll() {
        $result = array();
        $estados = $this->db->query("select e.*, p.nombre as nombre_pais, p.clave as clave_pais from catalogo_estados e, catalogo_paises p "
                . " where e.pais_id = p.id order by e.nombre asc");
            while($e = $estados->fetch_object()){
            array_push($result, $e);
        }
        return $result;
    }
    
    public function delete(){

       $delete  = $this->db->query("delete from catalogo_estados where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }

}
