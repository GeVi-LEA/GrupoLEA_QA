<?php
class Requisicion {

    private $id;
    private $provedorId;
    private $usuarioId;
    private $estatusId;
    private $folio;
    private $empresa;
    private $numProyecto;
    private $proyecto;
    private $urgente;
    private $observaciones;
    private $fechaSolicitud;
    private $fechaRequerida;
    private $fechaModificacion;
    private $fechaAta;
    private $fechaBaja;
    private $cotizacion;
    private $firmas;
    private $cliente;
    private $ruta;
    private $aduana;
    private $producto;
    private $transporteId;
    private $tipoFlete;
    private $cantidadFlete;
    private $moneda;
    private $db;
    private $detalles;

    public function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getProvedorId() {
        return $this->provedorId;
    }

    function getUsuarioId() {
        return $this->usuarioId;
    }

    function getEstatusId() {
        return $this->estatusId;
    }

    function getFolio() {
        return $this->folio;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getNumProyecto() {
        return $this->numProyecto;
    }

    function getProyecto() {
        return $this->proyecto;
    }

    function getUrgente() {
        return $this->urgente;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaSolicitud() {
        return $this->fechaSolicitud;
    }

    function getFechaRequerida() {
        return $this->fechaRequerida;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFechaAta() {
        return $this->fechaAta;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setProvedorId($provedorId): void {
        $this->provedorId = $provedorId;
    }

    function setUsuarioId($usuarioId): void {
        $this->usuarioId = $usuarioId;
    }

    function setEstatusId($estatusId): void {
        $this->estatusId = $estatusId;
    }

    function setFolio($folio): void {
        $this->folio = $folio;
    }

    function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }

    function setNumProyecto($numProyecto): void {
        $this->numProyecto = $this->db->real_escape_string(trim($numProyecto));
    }

    function setProyecto($proyecto): void {
        $this->proyecto = $this->db->real_escape_string(UtilsHelp::fixString($proyecto));
    }

    function setUrgente($urgente): void {
        $this->urgente = $urgente;
    }

    function setObservaciones($observaciones): void {
        $this->observaciones = $this->db-> real_escape_string(UtilsHelp::fixString($observaciones));
    }

    function setFechaSolicitud($fechaSolicitud): void {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    function setFechaRequerida($fechaRequerida): void {
        $this->fechaRequerida = $fechaRequerida;
    }

    function setFechaModificacion($fechaModificacion): void {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaAta($fechaAta): void {
        $this->fechaAta = $fechaAta;
    }

    function setFechaBaja($fechaBaja): void {
        $this->fechaBaja = $fechaBaja;
    }
    function getDetalles() {
        return $this->detalles;
    }

    function setDetalles($detalles): void {
        $this->detalles = $detalles;
    }
    function getCotizacion() {
        return $this->cotizacion;
    }

    function getFirmas() {
        return $this->firmas;
    }
    
    function setCotizacion($cotizacion): void {
        $this->cotizacion = $cotizacion;
    }

    function setFirmas($firmas): void {
        $this->firmas = $firmas;
    }
    
    function getCliente() {
        return Utils::getNullString($this->cliente);
    }

    function getRuta() {
        return Utils::getNullString($this->ruta);
    }
    
    function getMoneda() {
        return $this->moneda;
    }

    function setCliente($cliente): void {
        $this->cliente = $cliente;
    }

    function setRuta($ruta): void {
        $this->ruta = $ruta;
    }
    
    function setMoneda($moneda): void {
        $this->moneda = $moneda;
    }
    function getProducto() {
        return Utils::getNullString($this->producto);
    }

    function setProducto($producto): void {
        $this->producto = $producto;
    }
    
    function getTransporteId() {
        return Utils::getNullString($this->transporteId);
    }

    function getTipoFlete() {
        return Utils::getNullString($this->tipoFlete);
    }

    function getCantidadFlete() {
        return Utils::getNullString($this->cantidadFlete);
    }

    function setTransporteId($transporteId): void {
        $this->transporteId = $transporteId;
    }

    function setTipoFlete($tipoFlete): void {
        $this->tipoFlete = $tipoFlete;
    }

    function setCantidadFlete($cantidadFlete): void {
        $this->cantidadFlete = $cantidadFlete;
    }
    
    function getAduana() {
        return Utils::getNullString($this->aduana);
    }

    function setAduana($aduana): void {
        $this->aduana = $aduana;
    }

    public function save(){
        $sql = "insert into compras_requisiciones values(null, {$this->getProvedorId()}, {$this->getUsuarioId()}, {$this->getEstatusId()},"
        . "'{$this->getFolio()}', {$this->getEmpresa()}, '{$this->getNumProyecto()}', '{$this->getProyecto()}', '{$this->getUrgente()}','{$this->getObservaciones()}',"
        . "'{$this->getFechaSolicitud()}', '{$this->getFechaRequerida()}', null, curdate(), null, '{$this->getCotizacion()}', "
        . "null, {$this->getRuta()}, {$this->getAduana()}, {$this->getCliente()}, {$this->getMoneda()}, {$this->getProducto()}, {$this->getTransporteId()}, "
        . "{$this->getCantidadFlete()}, {$this->getTipoFlete()})";
            
        $save = $this->db->query($sql);    
        $result = false;
        if ($save) {
            $saveDetalles = $this->saveDetalles();
            if ($saveDetalles) {
                $result = true;
            }
        }else{
           $result = false;
        }
        return $result;
    }
    
    public function saveDetalles($idReq = null){ 
    if($idReq == null){
    $idReq = $this->getIdUltimaReq();
    }
    foreach ($this->getDetalles() as $detalle){
       $desc = $this->db->real_escape_string($detalle['descripcion']);
       $precio = $detalle['precioUnitario'];
       $cantidad = $detalle['cantidad'];
       $unidad = $detalle['unidad'];
       $precioTotal = $detalle['precio'];
     if($detalle['idDetalle'] == "" || $detalle['idDetalle'] == null){
         $sql = "insert into compras_detalles_requisiciones values(null, {$idReq}, {$unidad}, '{$desc}', '{$cantidad}',"
           . "'{$precio}', '0', {$precioTotal});";      
     }else{
           $sql = "update compras_detalles_requisiciones set requisicion_id = {$idReq}, unidad_id = {$unidad}, descripcion = '{$desc}', "
           . "cantidad = '{$cantidad}', precio_unitario = '{$precio}', precio={$precioTotal} where id = {$detalle['idDetalle']};";
     }
            $save = $this->db->query($sql);
    }
     $result = false;
      if ($save) {
          $result = true;
      }
      return $result;
    }

    public function edit(){
      $sql = "update compras_requisiciones set proveedor_id = {$this->getProvedorId()},"
      . " num_proyecto = '{$this->getNumProyecto()}', proyecto = '{$this->getProyecto()}', "
      . " urgente = '{$this->getUrgente()}', observaciones = '{$this->getObservaciones()}',"
      . " fecha_solicitud = '{$this->getFechaSolicitud()}', fecha_requerida = '{$this->getFechaRequerida()}', "
      . " ruta_id = {$this->getRuta()}, aduana_id = {$this->getAduana()}, cliente_id = {$this->getCliente()}, moneda={$this->getMoneda()}, producto_id = {$this->getProducto()}, "
      . " transporte_id = {$this->getTransporteId()}, cantidad_flete = {$this->getCantidadFlete()}, flete = {$this->getTipoFlete()}, fecha_modificacion = curdate() ";

      if($this->getCotizacion() != null){
          $sql.=  ", cotizacion = '{$this->getCotizacion()}'";
      }

      $sql.=(" where id = {$this->getId()};");
      $save = $this->db->query($sql);
      $saveDetalle = $this->saveDetalles($this->getId());
      $result = false;
      if ($save && $saveDetalle) {
          $result = true;
      }
      return $result;
  }

    public function deleteDetalle($idReq) {
      $sql = "delete from compras_detalles_requisiciones where id = {$idReq}";
        $delete = $this->db->query($sql);
      $result = false;
      if ($delete) {
          $result = true;
      }
      return $result;        
  }

    public function editDescuento($descuentos) {
    foreach ($descuentos as $detalle) {
            $desc = $detalle['descuento'];
            $id = $detalle['idDetalle'];   
            $sql = "update compras_detalles_requisiciones set descuento = {$desc} where id = {$id};";
            $save = $this->db->query($sql);
        }
        $result = $sql;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function getIdUltimaReq(){
    $sql = "SELECT MAX(id)as id FROM compras_requisiciones";
    $query = $this->db->query($sql);
    $idReq = $query->fetch_object()->id;
    return $idReq;
   }
   
    public function getUltimaReq(){
    $sql = "SELECT * FROM compras_requisiciones ORDER BY id DESC LIMIT 1";
    $query = $this->db->query($sql);
    $req = $query->fetch_object();
    return $req;
   }
   
     public function getEstatusReq($id){
    $sql = "SELECT estatus_id as estatus FROM compras_requisiciones where id= {$id};";
    $query = $this->db->query($sql);
    $idReq = $query->fetch_object()->estatus;
    return $idReq;
}

    public function getRequiciones($where=null) {
      $result = array();
      $sql = "select r.*, p.nombre as proveedor, p.correo as correo_proveedor, p.direccion as direccion, p.rfc as rfc_provedor, p.telefono as tel_provedor, 
          p.contacto as contacto, p.tipo_solicitud_id as solicitud_id,
          concat(u.nombres,' ', u.apellidos) as usuario, u.correo as correoUsuario, 
              (select d.nombre from catalogo_departamentos d where d.id = u.departamento_id) as departamento,
              (select ts.tipo from catalogo_tipos_solicitudes ts where ts.id = p.tipo_solicitud_id) as solicitud,
              (select oc.folio from compras_ordenes_compra oc where oc.requisicion_id = r.id) as folio_oc,
              e.clave as clave, e.nombre as estatus, e.descripcion as descEstatus,
               (select cu.ciudad_completa from view_ciudades cu where cu.id = p.ciudad_id) as ciudad,
              (select c.tipo from catalogo_tipos_compras c inner join catalogo_tipos_solicitudes ts on c.id = ts.tipo_compra_id
              where ts.id = p.tipo_solicitud_id) as compra from compras_requisiciones r
              inner join catalogo_proveedores p on p.id = r.proveedor_id
              inner join catalogo_usuarios u on u.id = r.usuario_id
              inner join catalogo_estatus e on e.id = r.estatus_id";
        if($where != null){
              $sql .= $where;
        }
      else{
         $sql .= " where r.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by r.id desc";
      }      
      $requisiciones = $this->db->query($sql);   
      if ($requisiciones != null) {
          foreach ($requisiciones->fetch_all(MYSQLI_ASSOC) as $req) {
              $sql_detalle = "select * from compras_detalles_requisiciones where requisicion_id = {$req['id']} order by id desc";
              $detalles = $this->db->query($sql_detalle);
              $d = $detalles->fetch_all(MYSQLI_ASSOC);
              $req['detalle'] = $d;
              array_push($result, $req);
          }
      }    
      return $result;
  }

    public function getByEstatusId($idEst){
        if($idEst != null && $idEst != ''){ 
            if($idEst == 5){
               $sql = " where estatus_id = {$idEst} and r.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by r.id desc";
            }else{
                  $sql = " where estatus_id = {$idEst} order by r.id desc";
            }
        }else{
            $sql = null;
        }
          $result = $this->getRequiciones($sql);         
          return $result;
   }
  
    public function getReqById($id){
       if($id != null && $id != '' ){
       $sql= " where r.id = {$id}; ";
       }else{
        $sql = null;   
       }
      $req = array();
      $result = $this->getRequiciones($sql);
      $req = $result[0];
      return $req;
  }
  
  public function getRequisicionByFolioFechasProv($folio=null,  $proveedor=null, $solicitud=null, $fechaIni=null, $fechaFin=null){
      if($folio != null){
       $sql = " where r.folio like '%{$folio}%' order by r.id desc;";  
       }else if ($solicitud != null && $proveedor == null && $fechaIni == null && $fechaFin == null){
       $sql = " where p.tipo_solicitud_id = '{$solicitud}' order by r.id desc;"; 
       }else if ($solicitud != null && $proveedor != null && $fechaIni == null && $fechaFin == null){
       $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} order by r.id desc;";   
      }else if($solicitud != null && $proveedor != null && $fechaIni != null && $fechaFin == null){
        $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and r.fecha_alta >= '{$fechaIni}' order by r.id desc;";     
      }else if($solicitud != null && $proveedor != null && $fechaIni != null && $fechaFin != null){      
        $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and r.fecha_alta between '{$fechaIni}' and '{$fechaFin}' order by r.id desc;";     
      }else if($solicitud != null && $proveedor != null && $fechaIni == null && $fechaFin != null){      
        $sql = " where p.tipo_solicitud_id = '{$solicitud}' and r.proveedor_id = {$proveedor} and r.fecha_alta <= '{$fechaFin}' order by r.id desc;";     
      }else if($solicitud == null && $proveedor == null && $fechaIni != null && $fechaFin != null){
        $sql = " where r.fecha_alta between '{$fechaIni}' and '{$fechaFin}' order by r.id desc;";     
      }else if($solicitud == null && $proveedor == null && $fechaIni == null && $fechaFin != null){
        $sql = " where r.fecha_alta <= '{$fechaFin}' order by r.id desc;";     
      }else if($solicitud == null && $proveedor == null && $fechaIni != null && $fechaFin == null){
        $sql = " where r.fecha_alta >= '{$fechaIni}' order by r.id desc;";     
      }else{
          $sql=null;
      }
         $result = $this->getRequiciones($sql); 
          return $result;
  }
  
  public function getUltimasRequisiciones(){
      $sql = " where r.fecha_alta >= DATE_ADD(curdate(), INTERVAL -1 month) order by r.id desc limit 6";
        $result = $this->getRequiciones($sql); 
          return $result;
  }

    public function deleteCotizacionReq($id) {
    $sql = "update compras_requisiciones set cotizacion = '' where id = {$id}";
    $query = $this->db->query($sql);
    $result = false;
          if($query){
              $result = true;
          }
          return $$result;
  }

    public function deleteRequision($idReq) {
          // Estatus 2 = cancelada
          $idEst = 2;
          $sql = "update compras_requisiciones set estatus_id = {$idEst}, fecha_baja = curdate() where id = {$idReq}";
          $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
  public function updateFirmas(){
      $sql = "update compras_requisiciones set firmas = '{$this->getFirmas()}', estatus_id={$this->getEstatusId()} where id = {$this->getId()}";
      $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
  public function updateEstatus($idEst ,$id){
      $sql = "update compras_requisiciones set estatus_id={$idEst} where id = {$id}";
      $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
  public function editObservaciones($observacion ,$id){
      $sql = "update compras_requisiciones set observaciones='{$observacion}' where id = {$id}";
      $query = $this->db->query($sql);    
          $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }
  
      public function elimninarBdRequisicion($idReq) {
          $sql = "delete from compras_detalles_requisiciones where requisicion_id = {$idReq}";
          $query = $this->db->query($sql);    
          $result = false;
          if($query){
               $delete = $this->db->query("delete from compras_requisiciones where id = {$idReq}");
               if($delete){
                      $result = true;
               }
          }
          return $result;
  }
    
}
