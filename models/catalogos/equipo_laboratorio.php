<?php

class EquipoLaboratorio {

    private $id;
    private $estatusId;
    private $unidadId;
    private $codigo;
    private $nombre;
    private $marca;
    private $modelo;
    private $numeroSerie;
    private $intervaloUso;
    private $intervaloTrabajo;
    private $intervaloPrueba;
    private $puntosCalibrar;
    private $factura;
    private $fechaAlta;
    private $fechaBaja;
    private $fechaCalibracion;
    private $docFactura;
    private $docCalibracion;
    private $observaciones;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getEstatusId() {
        return $this->estatusId;
    }

    public function getUnidadId() {
        return $this->unidadId;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getNumeroSerie() {
        return $this->numeroSerie;
    }

    public function getIntervaloUso() {
        return $this->intervaloUso;
    }

    public function getIntervaloTrabajo() {
        return $this->intervaloTrabajo;
    }

    public function getIntervaloPrueba() {
        return $this->intervaloPrueba;
    }

    public function getPuntosCalibrar() {
        return $this->puntosCalibrar;
    }

    public function getFactura() {
        return $this->factura;
    }

    public function getFechaAlta() {
        return $this->fechaAlta;
    }

    public function getFechaBaja() {
        return $this->fechaBaja;
    }

    public function getFechaCalibracion() {
        return $this->fechaCalibracion;
    }

    public function getDocFactura() {
        return $this->docFactura;
    }

    public function getDocCalibracion() {
        return $this->docCalibracion;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setEstatusId($estatusId): void {
        $this->estatusId = $estatusId;
    }

    public function setUnidadId($unidadId): void {
        $this->unidadId = $unidadId;
    }

    public function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setMarca($marca): void {
        $this->marca = $marca;
    }

    public function setModelo($modelo): void {
        $this->modelo = $modelo;
    }

    public function setNumeroSerie($numeroSerie): void {
        $this->numeroSerie = $numeroSerie;
    }

    public function setIntervaloUso($intervaloUso): void {
        $this->intervaloUso = $intervaloUso;
    }

    public function setIntervaloTrabajo($intervaloTrabajo): void {
        $this->intervaloTrabajo = $intervaloTrabajo;
    }

    public function setIntervaloPrueba($intervaloPrueba): void {
        $this->intervaloPrueba = $intervaloPrueba;
    }

    public function setPuntosCalibrar($puntosCalibrar): void {
        $this->puntosCalibrar = $puntosCalibrar;
    }

    public function setFactura($factura): void {
        $this->factura = $factura;
    }

    public function setFechaAlta($fechaAlta): void {
        $this->fechaAlta = $fechaAlta;
    }

    public function setFechaBaja($fechaBaja): void {
        $this->fechaBaja = $fechaBaja;
    }

    public function setFechaCalibracion($fechaCalibracion): void {
        $this->fechaCalibracion = $fechaCalibracion;
    }

    public function setDocFactura($docFactura): void {
        $this->docFfactura = $docFactura;
    }

    public function setDocCalibracion($docCalibracion): void {
        $this->docCalibracion = $docCalibracion;
    }

    public function setObservaciones($observaciones): void {
        $this->observaciones = $observaciones;
    }

    public function save() {
        $sql = "insert into catalogo_equipos_laboratorio values(null, {$this->getEstatusId()}, {$this->getUnidadId()}, '{$this->getCodigo()}',"
        . "'{$this->getNombre()}', {$this->getMarca()}, '{$this->getModelo()}', '{$this->getNumeroSerie()}', '{$this->getIntervaloUso()}', '{$this->getIntervaloTrabajo()}', "
        . "'{$this->getIntervaloPrueba()}', '{$this->getPuntosCalibrar()}', '{$this->getFactura()}', now(), null,";

                
               if($this->getFechaCalibracion() != null){
                    $sql.= "'{$this->getFechaCalibracion()}',";
                }  else{
                    $sql.="null, ";
                }
                  $sql.="'{$this->getDocFactura()}', '{$this->getDocCalibracion()}','{$this->getObservaciones()}');";
     
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

           public function getAll($where = null) {
        $result = array();
        $sql = "SELECT e.* FROM catalogo_equipos_laboratorio as e ";
                if($where != null){
              $sql .= $where;
        }
      else{
         $sql .= " order by e.codigo asc";
      }      
        $equipos = $this->db->query($sql);
        while ($e = $equipos->fetch_object()) {
            array_push($result, $e);
        }
        return $result;
    }

    public function ultimoEquipoLaboratorio(){
       $sql = "select e.* from catalogo_equipos_laboratorio e order by e.id desc limit 1";
        $query = $this->db->query($sql);
        return $query->fetch_object();
  }

}
