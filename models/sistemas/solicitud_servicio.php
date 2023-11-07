<?php
class SolicitudServicio {

    private $id;
    private $estatusId;
    private $usuarioId;
    private $equipoId;
    private $usuarioSistemasId;
    private $folio;
    private $empresa;
    private $tipoRequerimiento;
    private $tipoSolicitud;
    private $fechaSolicitud;
    private $fechaAtencion;
    private $fechaSolucion;
    private $prioridad;
    private $descripcion;
    private $observaciones;
    private $solucion;
    private $db;


    public function __construct() {
        $this->db = Database::connect();
    }
    function getEquipoId() {
        return $this->equipoId;
    }

    function setEquipoId($equipoId): void {
        $this->equipoId = $equipoId;
    }

    function getId() {
    return $this->id;
    }

    function getEstatusId() {
        return $this->estatusId;
    }

    function getUsuarioId() {
        return $this->usuarioId;
    }

    function getUsuarioSistemasId() {
        return $this->usuarioSistemasId;
    }

    function getFolio() {
        return $this->folio;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getTipoRequerimiento() {
        return $this->tipoRequerimiento;
    }

    function getTipoSolicitud() {
        return $this->tipoSolicitud;
    }

    function getFechaSolicitud() {
        return $this->fechaSolicitud;
    }

    function getFechaAtencion() {
        return $this->fechaAtencion;
    }

    function getFechaSolucion() {
        return $this->fechaSolucion;
    }

    function getPrioridad() {
        return $this->prioridad;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getSolucion() {
        return $this->solucion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setEstatusId($estatusId): void {
        $this->estatusId = $estatusId;
    }

    function setUsuarioId($usuarioId): void {
        $this->usuarioId = $usuarioId;
    }

    function setUsuarioSistemasId($usuarioSistemasId): void {
        $this->usuarioSistemasId = $usuarioSistemasId;
    }

    function setFolio($folio): void {
        $this->folio = $folio;
    }

    function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }

    function setTipoRequerimiento($tipoRequerimiento): void {
        $this->tipoRequerimiento = $tipoRequerimiento;
    }

    function setTipoSolicitud($tipoSolicitud): void {
        $this->tipoSolicitud = $tipoSolicitud;
    }

    function setFechaSolicitud($fechaSolicitud): void {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    function setFechaAtencion($fechaAtencion): void {
        $this->fechaAtencion = $fechaAtencion;
    }

    function setFechaSolucion($fechaSolucion): void {
        $this->fechaSolucion = $fechaSolucion;
    }

    function setPrioridad($prioridad): void {
        $this->prioridad = $prioridad;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = UtilsHelp::toUpperString($descripcion);
    }

    function setObservaciones($observaciones): void {
        $this->observaciones = UtilsHelp::toUpperString($observaciones);
    }

    function setSolucion($solucion): void {
        $this->solucion = UtilsHelp::toUpperString($solucion);
    }

      public function save(){
        $sql = "insert into sistemas_solicitudes_servicio values(null, {$this->getEstatusId()}, {$this->getUsuarioId()}, {$this->getUsuarioSistemasId()}, {$this->getEquipoId()}, "
        . "'{$this->getFolio()}', {$this->getEmpresa()}, {$this->getTipoRequerimiento()}, {$this->getTipoSolicitud()}, NOW(), null,"
        . "null, {$this->getPrioridad()}, '{$this->getDescripcion()}', '{$this->getObservaciones()}', '{$this->getSolucion()}')";
        
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
      }
    
     public function ultimaSolicitudByEmpresa($idEmpresa){
      $sql = "select s.* from sistemas_solicitudes_servicio s where s.empresa={$idEmpresa} order by s.id desc limit 1";
        $query = $this->db->query($sql);    
        return $query->fetch_object();
  }
    
    public function edit(){
      $sql = "update sistemas_solicitudes_servicio set usuario_sistemas_id = {$this->getUsuarioSistemasId()}, equipo_id= {$this->getEquipoId()}, "
      . " tipo_requerimiento = {$this->getTipoRequerimiento()}, tipo_solicitud = {$this->getTipoSolicitud()}, prioridad = {$this->getPrioridad()},  observaciones = '{$this->getObservaciones()}',"
      . " descripcion = '{$this->getDescripcion()}', solucion = '{$this->getSolucion()}'";

      $sql.=(" where id = {$this->getId()};");
      $save = $this->db->query($sql);
      $result = false;
      if ($save) {
          $result = true;
      }
      return $result;
  }
   
    public function getSolicitudes($where=null) {
      $result = array();
      $sql = "select s.*,  concat(u.nombres,' ', u.apellidos) as usuario, (select d.nombre from catalogo_departamentos d where d.id = u.departamento_id) as departamento,
              e.clave as clave, e.nombre as estatus, e.descripcion as descEstatus,  concat(us.nombres,' ', us.apellidos) as usuarioSistemas,
              (SELECT TIMESTAMPDIFF(MINUTE, s.fecha_solicitud, s.fecha_atencion)) as tiempo_atencion,
              (SELECT TIMESTAMPDIFF(DAY, s.fecha_solicitud, s.fecha_solucion)) as tiempo_solucion from sistemas_solicitudes_servicio s
              inner join catalogo_usuarios u on u.id = s.usuario_id
              inner join catalogo_usuarios us on us.id = s.usuario_sistemas_id
              inner join catalogo_estatus e on e.id = s.estatus_id";
        if($where != null){
              $sql .= $where;
        }
      else{
         $sql .= " where s.fecha_solicitud >= DATE_ADD(curdate(), INTERVAL -1 month) order by s.id desc";
      }      
       $solicitudes = $this->db->query($sql);   
       if ($solicitudes != null) {
          foreach ($solicitudes->fetch_all(MYSQLI_ASSOC) as $solicitud) {
              array_push($result, $solicitud);
          }
      }    
      return $result;
  }
  
    public function iniciarSolicitud(){
      $sql = "update sistemas_solicitudes_servicio set estatus_id={$this->getEstatusId()}, fecha_atencion = NOW() where id = {$this->getId()}";
      $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
      public function finalizarSolicitud(){
      $sql = "update sistemas_solicitudes_servicio set estatus_id={$this->getEstatusId()}, solucion='{$this->getSolucion()}', fecha_solucion = NOW() where id = {$this->getId()}";
      $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }

    public function getByEstatusId($idEst){
        if($idEst != null && $idEst != ''){ 
          $sql = " where s.estatus_id = {$idEst} and s.fecha_solicitud >= DATE_ADD(curdate(), INTERVAL -1 month) order by s.id desc";
        }else{
            $sql = null;
        }
          $result = $this->getSolicitudes($sql);         
          return $result;
   }
  
    public function getSolicitudById($id){
       if($id != null && $id != '' ){
       $sql= " where s.id = {$id}; ";
       }else{
        $sql = null;   
       }
      $req = array();
      $result = $this->getSolicitudes($sql);
      $req = $result[0];
      return $req;
  }
  
      public function getSolicitudByEquipoIdSolicitudActiva($id){
       $sql= " where s.equipo_id = {$id} and (s.estatus_id = 3 or s.estatus_id = 1) order by id desc; ";

      $result = $this->getSolicitudes($sql);
      return $result;
  }
  
  
  public function getSolicitudesByFechaSolucionFinalizadas($fechaIni=null, $fechaFin=null){   
      $result = array();
      if($fechaIni != null && $fechaFin != null){      
              $sql = " where s.fecha_solucion >= '{$fechaIni}' and s.fecha_solucion <= '{$fechaFin}' and s.estatus_id = 5 order by s.id desc;";   
      
         $result = $this->getSolicitudes($sql); 
      }
          return $result;
  }
  
    public function getSolicitudesByFolioUsuarioFechas($folio=null, $usuario = null, $fechaIni=null, $fechaFin=null){
      if($folio != null){
       $sql = " where s.folio like '%{$folio}%' order by s.id desc;";  
       }else if ($usuario != null && $fechaIni == null && $fechaFin == null){
       $sql = " where s.usuario_id = '{$usuario}' order by s.id desc;";   
      }else if($usuario != null && $fechaIni != null && $fechaFin == null){
        $sql = " where s.usuario_id = '{$usuario}' and s.fecha_solicitud >= '{$fechaIni}' order by s.id desc;";     
      }else if($usuario != null && $fechaIni != null && $fechaFin != null){      
        $sql = " where s.usuario_id = '{$usuario}' and s.fecha_solicitud between '{$fechaIni}' and '{$fechaFin}' order by s.id desc;";     
      }else if($usuario != null && $fechaIni == null && $fechaFin != null){      
        $sql = " where s.usuario_id = '{$usuario}' and s.fecha_solicitud  <= '{$fechaFin}' order by s.id desc;";     
      }else if($usuario == null && $fechaIni != null && $fechaFin != null){
        $sql = " where s.fecha_solicitud between '{$fechaIni}' and '{$fechaFin}' order by s.id desc;";     
      }else if($usuario == null && $fechaIni == null && $fechaFin != null){
        $sql = " where s.fecha_solicitud <= '{$fechaFin}' order by s.id desc;";     
      }else if($usuario == null && $fechaIni != null && $fechaFin == null){
        $sql = " where s.fecha_solicitud >= '{$fechaIni}' order by s.id desc;";     
      }else{
          $sql=null;
      }
         $result = $this->getSolicitudes($sql); 
          return $result;
  }

    public function deleteSolicitud() {
          $sql = "update sistemas_solicitudes_servicio set estatus_id = {$this->getEstatusId()} where id = {$this->getId()}";
          $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
}
