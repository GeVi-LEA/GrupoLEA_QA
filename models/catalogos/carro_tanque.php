<?php

class CarroTanque {

    private $id;
    private $numero;
    private $idEstatus;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getIdEstatus() {
        return $this->idEstatus;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNumero($numero): void {
        $this->numero = UtilsHelp::toUpperString($numero);
    }

    function setIdEstatus($idEstatus): void {
        $this->idEstatus = $idEstatus;
    }
 
    public function save() {
        $id = intval($this->getIdUltimoId()) + 1;
        $sql = "insert into catalogo_carro_tanques values($id, '{$this->getNumero()}', {$this->getIdEstatus()})";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_carro_tanques set "
                 . "numero = '{$this->getNumero()}', estatus_id = {$this->getIdEstatus()}"
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
        $carros = $this->db->query("select ct.* , e.nombre as estatus from catalogo_carro_tanques ct "
                . "inner join catalogo_estatus e on ct.estatus_id = e.id order by numero asc");
        while($c = $carros->fetch_object()){
            array_push($result, $c);
        }
        return $result;
    }
    
        public function getDisponiblesAndIdCarro($idCarro = "null") {
        $result = array();
        $carros = $this->db->query("select ct.* , e.nombre as estatus from catalogo_carro_tanques ct "
                . "inner join catalogo_estatus e on ct.estatus_id = e.id where ct.estatus_id = 6 or ct.id = {$idCarro} "
                . "order by numero asc");
        while($c = $carros->fetch_object()){
            array_push($result, $c);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_carro_tanques where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
    
    public function getIdUltimoId(){
        $sql = "SELECT MAX(id)as id FROM catalogo_carro_tanques";
        $query = $this->db->query($sql);
        $idReq = $query->fetch_object()->id;
        return $idReq;
   }
   
       public function updateEstatus() {
         $sql = "update catalogo_carro_tanques set estatus_id = {$this->getIdEstatus()} where id={$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    
    public function getByNumero() {
        $result = array();
        $carros = $this->db->query("select ct.* , e.nombre as estatus from catalogo_carro_tanques ct "
                . "inner join catalogo_estatus e on ct.estatus_id = e.id where ct.numero = '{$this->getNumero()}'");
        while($c = $carros->fetch_object()){
            array_push($result, $c);
        }
        return $result;
    }
    
        public function getById() {
        $carros = $this->db->query("select ct.* , e.nombre as estatus from catalogo_carro_tanques ct "
                . "inner join catalogo_estatus e on ct.estatus_id = e.id where ct.id = {$this->getId()}");
        return $carros->fetch_object();
    }

}
