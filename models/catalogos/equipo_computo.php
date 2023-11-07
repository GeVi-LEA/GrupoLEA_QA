<?php

class EquipoComputo {

    private $id;
    private $folio;
    private $usuarioId;
    private $tipoEquipo;
    private $factura;
    private $marca;
    private $modelo;
    private $numeroSerie;
    private $procesador;
    private $memoriaRam;
    private $discoDuro;
    private $redLan;
    private $redWifi;
    private $aplicaciones;
    private $fechaCompra;
    private $fechaAsignacion;
    private $fechaBaja;
    private $observaciones;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }
     
    function getId() {
        return $this->id;
    }

    function getUsuarioId() {
        return $this->usuarioId;
    }

    function getTipoEquipo() {
        return $this->tipoEquipo;
    }

    function getFactura() {
        return $this->factura;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getNumeroSerie() {
        return $this->numeroSerie;
    }

    function getProcesador() {
        return $this->procesador;
    }

    function getMemoriaRam() {
        return $this->memoriaRam;
    }

    function getDiscoDuro() {
        return $this->discoDuro;
    }

    function getRedLan() {
        return $this->redLan;
    }

    function getRedWifi() {
        return $this->redWifi;
    }

    function getAplicaciones() {
        return $this->aplicaciones;
    }

    function getFechaCompra() {
        return $this->fechaCompra;
    }

    function getFechaAsignacion() {
        return $this->fechaAsignacion;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setUsuarioId($usuarioId): void {
        $this->usuarioId = $usuarioId;
    }

    function setTipoEquipo($tipoEquipo): void {
        $this->tipoEquipo = $tipoEquipo;
    }

    function setFactura($factura): void {
        $this->factura = UtilsHelp::toUpperString($factura);
    }

    function setMarca($marca): void {
        $this->marca = $marca;
    }

    function setModelo($modelo): void {
        $this->modelo = $modelo;
    }

    function setNumeroSerie($numeroSerie): void {
        $this->numeroSerie = UtilsHelp::toUpperString($numeroSerie);
    }

    function setProcesador($procesador): void {
        $this->procesador = $procesador;
    }

    function setMemoriaRam($memoriaRam): void {
        $this->memoriaRam = UtilsHelp::toUpperString($memoriaRam);
    }

    function setDiscoDuro($discoDuro): void {
        $this->discoDuro = UtilsHelp::toUpperString($discoDuro);
    }

    function setRedLan($redLan): void {
        $this->redLan = UtilsHelp::toUpperString($redLan);
    }

    function setRedWifi($redWifi): void {
        $this->redWifi = UtilsHelp::toUpperString($redWifi);
    }

    function setAplicaciones($aplicaciones): void {
        $this->aplicaciones = $aplicaciones;
    }

    function setFechaCompra($fechaCompra): void {
        $this->fechaCompra = $fechaCompra;
    }

    function setFechaAsignacion($fechaAsignacion): void {
        $this->fechaAsignacion = $fechaAsignacion;
    }

    function setFechaBaja($fechaBaja): void {
        $this->fechaBaja = $fechaBaja;
    }

    function setObservaciones($observaciones): void {
        $this->observaciones = UtilsHelp::toUpperString($observaciones);
    }
    
    function getFolio() {
        return $this->folio;
    }

    function setFolio($folio): void {
        $this->folio = $folio;
    }
    
    public function save() {
        $sql = "insert into catalogo_equipos_computo values(null,'{$this->getFolio()}',  {$this->getUsuarioId()}, {$this->getTipoEquipo()}, '{$this->getModelo()}', {$this->getMarca()}, '{$this->getNumeroSerie()}', "
                . "'{$this->getFactura()}', '{$this->getProcesador()}', '{$this->getMemoriaRam()}', '{$this->getDiscoDuro()}', '{$this->getRedLan()}', '{$this->getRedWifi()}','{$this->getAplicaciones()}',";
         
                if($this->getFechaCompra() != null){
                    $sql.= "'{$this->getFechaCompra()}',";
                }else{
                    $sql.="null, ";
                }
                
               if($this->getFechaAsignacion() != null){
                    $sql.= "'{$this->getFechaAsignacion()}',";
                }  else{
                    $sql.="null, ";
                }
                  $sql.="null, curdate(), '{$this->getObservaciones()}');";
     
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql =  "update catalogo_equipos_computo set usuario_id = {$this->getUsuarioId()}, tipo_equipo = {$this->getTipoEquipo()}, modelo = '{$this->getModelo()}', marca = {$this->getMarca()}, "
                . "numero_serie = '{$this->getNumeroSerie()}', factura = '{$this->getFactura()}', procesador = '{$this->getProcesador()}', memoria_ram = '{$this->getMemoriaRam()}', "
                . "disco_duro = '{$this->getDiscoDuro()}', red_lan = '{$this->getRedLan()}', red_wifi = '{$this->getRedWifi()}', aplicaciones = '{$this->getAplicaciones()}', ";
        
                if($this->getFechaCompra() != null){
                    $sql.= "fecha_compra = '{$this->getFechaCompra()}',";
                }else{
                    $sql.="fecha_compra = null, ";
                }
                
               if($this->getFechaAsignacion() != null){
                    $sql.= "fecha_asignacion = '{$this->getFechaAsignacion()}',";
                }  else{
                    $sql.="fecha_asignacion = null, ";
                }
        $sql = $sql . "observaciones ='{$this->getObservaciones()}' where id = {$this->getId()};";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("update catalogo_equipos_computo set fecha_baja = curdate() where id={$this->getId()}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    
        public function mantenimientoEquipo() {
        $delete = $this->db->query("update catalogo_equipos_computo set fecha_mantenimiento = curdate() where id={$this->getId()}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    
        public function getAll($where = null) {
        $result = array();
        $sql = "SELECT e.*, d.nombre as departamento, u.id as usuarioId, concat(u.nombres,' ', u.apellidos) as usuario FROM catalogo_equipos_computo as e "
                . "left join catalogo_usuarios u on u.id = e.usuario_id "
                . "left join catalogo_departamentos d on u.departamento_id = d.id ";
                if($where != null){
              $sql .= $where;
        }
      else{
         $sql .= " order by e.folio asc";
      }      
        $equipos = $this->db->query($sql);
        while ($e = $equipos->fetch_object()) {
            array_push($result, $e);
        }
        return $result;
    }
    
    public function getEquipoByTipoUsuario($equipo, $usuario){
        $where = "where e.tipo_equipo= {$equipo}";
        
        if($usuario != null){
           $where.= " and e.usuario_id = {$usuario}";
        }
        return $this->getAll($where);
    }
  
        public function getEquipoById($equipo){
        $where = "where e.id= {$equipo}";
        return $this->getAll($where);
    }
    
    public function getEquiposMantenimiento(){
        $where = " where e.fecha_mantenimiento <= DATE_ADD(curdate(), INTERVAL -5 month) OR e.fecha_mantenimiento is null order by e.id desc";
             return $this->getAll($where);
    }
    
       public function ultimoEquipoTipoEquipo(){
       $sql = "select e.* from catalogo_equipos_computo e where e.tipo_equipo={$this->getTipoEquipo()} order by e.id desc limit 1";
        $query = $this->db->query($sql);
        return $query->fetch_object();
  }

}
