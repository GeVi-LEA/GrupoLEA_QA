<?php
class RecepcionFlete {

    private $id;
    private $idUsuario;
    private $idRequisicion;
    private $numeroFactura;
    private $fechaRecepcion;
    private $factura;
    private $docXml;
    private $remision;
    private $evaluacion;
    private $observaciones;
    private $db;
    
    public function __construct() {
      $this->db = Database::connect();
    } 
    
    function getId() {
        return $this->id;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdRequisicion() {
        return $this->idRequisicion;
    }

    function getNumeroFactura() {
        return $this->numeroFactura;
    }

    function getFechaRecepcion() {
        return $this->fechaRecepcion;
    }

    function getFactura() {
        return $this->factura;
    }

    function getDocXml() {
        return $this->docXml;
    }

    function getRemision() {
        return $this->remision;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    function setIdRequisicion($idRequisicion): void {
        $this->idRequisicion = $idRequisicion;
    }

    function setNumeroFactura($numeroFactura): void {
        $this->numeroFactura = $numeroFactura;
    }

    function setFechaRecepcion($fechaRecepcion): void {
        $this->fechaRecepcion = $fechaRecepcion;
    }

    function setFactura($factura): void {
        $this->factura = $factura;
    }

    function setDocXml($docXml): void {
        $this->docXml = $docXml;
    }

    function setRemision($remision): void {
        $this->remision = $remision;
    }

    function setObservaciones($observaciones): void {
        $this->observaciones = $observaciones;
    }
    
    function getEvaluacion() {
        return $this->evaluacion;
    }

    function setEvaluacion($evaluacion): void {
        $this->evaluacion = $evaluacion;
    }

    public function save(){
        $sql = "insert into compras_recepciones_fletes values(null, {$this->getIdUsuario()}, {$this->getIdRequisicion()}, '{$this->getNumeroFactura()}',"
        . "'{$this->getFechaRecepcion()}', '{$this->getFactura()}', '{$this->getDocXml()}', '{$this->getRemision()}', '{$this->getEvaluacion()}', '{$this->getObservaciones()}');";
        $save = $this->db->query($sql);    
        $result = false;
        if ($save) {
          $result = true;
        }
        return $result;
    }
    
    public function edit(){
        $sql = "update compras_recepciones_fletes set numero_factura = '{$this->getNumeroFactura()}', evaluacion = '{$this->getEvaluacion()}', observaciones = '{$this->getObservaciones()}', ";
                if ($this->getFechaRecepcion() == null) {
            $sql .= "fecha_recepcion = null ";
        } else {
            $sql .= "fecha_recepcion = '{$this->getFechaRecepcion()}' ";
        }
        if ($this->getDocXml() != null) {
            $sql .= ", docXml = '{$this->getDocXml()}'";
        }
        if ($this->getFactura() != null) {
            $sql .= ", factura = '{$this->getFactura()}'";
        }      
        if ($this->getRemision() != null) {
            $sql .= ", remision = '{$this->getRemision()}'";
        }
        $sql .= " where id = {$this->getId()}";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        } 
        return $result;
    }
    
     public function getById(){
        $sql = "select * from compras_recepciones_fletes where id = {$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }
    
    public function getByRequisicion(){
        $sql = "select * from compras_recepciones_fletes where requisicion_id = {$this->getIdRequisicion()}";
        $result = $this->db->query($sql);
        if($result->num_rows == 1){
        return $result->fetch_object();
        }
        else{
            return null;
        }
    }
    
    public function deleteDocumentoFactura($id) {
    $sql = "update compras_recepciones_fletes set factura = '' where id = {$id}";
    $query = $this->db->query($sql);
    $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
    public function deleteDocumentoXml($id) {
    $sql = "update compras_recepciones_fletes set docXml = '' where id = {$id}";
    $query = $this->db->query($sql);
    $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
   public function deleteDocumentoRemision($id) {
    $sql = "update compras_recepciones_fletes set remision = '' where id = {$id}";
    $query = $this->db->query($sql);
    $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
}