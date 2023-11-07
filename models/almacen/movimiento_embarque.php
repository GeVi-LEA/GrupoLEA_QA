<?php

class MovimientoEmbarque {

    private $id;
    private $embarqueId;
    private $fecha;
    private $ubicacion;
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getEmbarqueId() {
        return $this->embarqueId;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getUbicacion() {
        return $this->ubicacion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setEmbarqueId($embarqueId): void {
        $this->embarqueId = $embarqueId;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    function setUbicacion($ubicacion): void {
        $this->ubicacion = $ubicacion;
    }

    function save(){
          $sql = "insert into almacen_movimientos_embarques values(null, {$this->getEmbarqueId()}, ";
          
          if($this->getFecha() == null){
              $sql.= " curdate(), ";           
          }else{
              $sql.= " '{$this->getFecha()}',  ";
          }
          $sql.= " {$this->getUbicacion()})";
        $save = $this->db->query($sql);    
        $result = false;
        if ($save) {
                $result = true;
            }
        return $result;
    }
    
        function delete(){
        $sql = "delete from almacen_movimientos_embarques where id = {$this->getId()}";           
        $delete = $this->db->query($sql);    
        $result = false;
        if ($delete) {
                $result = true;
            }
        return $result;
    }
    
      function getById(){
        $sql = "select * from almacen_movimientos_embarques where id = {$this->getId()}";           
        $result = $this->db->query($sql); 
        return $result->fetch_object();
    }
    
      function getMovimientosByEmbarqueId($idEmb){
        $result = array();
        $sql = "select m.* from almacen_movimientos_embarques m where m.embarque_id = {$idEmb} order by m.id desc";           
        $movs = $this->db->query($sql); 
          while ($m = $movs->fetch_object()) {
          array_push($result, $m);
          }
     return $result;
    }
}
    
