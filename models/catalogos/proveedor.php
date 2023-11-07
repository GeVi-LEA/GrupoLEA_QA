<?php

class Proveedor {

    private $id;
    private $tipoSolicitudId;
    private $ciudadId;
    private $nombre;
    private $contacto;
    private $direccion;
    private $codigoPostal;
    private $telefono;
    private $celular;
    private $correo;
    private $correo1;
    private $correo2;
    private $correo3;
    private $rfc;
    private $cuenta;
    private $clasificacion;
    private $certificacion;
    private $fechaAlta;
    private $fechaEvaluacion;
    private $calificacion;
    private $fechaModificacion;
    private $fechaBaja;
    private $fechaProxEvaluacion;
    private $activo;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getTipoSolicitudId() {
        return $this->tipoSolicitudId;
    }

    function getCiudadId() {
        return $this->ciudadId;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getContacto() {
        return $this->contacto;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCodigoPostal() {
        return $this->codigoPostal;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getCorreo() {
        return $this->correo;
    }
    function getCorreo1() {
        return $this->correo1;
    }

    function getCorreo2() {
        return $this->correo2;
    }

    function getCorreo3() {
        return $this->correo3;
    }

    function getRfc() {
        return $this->rfc;
    }

    function getCuenta() {
        return $this->cuenta;
    }

    function getClasificacion() {
        return $this->clasificacion;
    }

    function getCertificacion() {
        return $this->certificacion;
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function getFechaEvaluacion() {
        return $this->fechaEvaluacion;
    }

    function getCalificacion() {
        return $this->calificacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function getFechaProxEvaluacion() {
        return $this->fechaProxEvaluacion;
    }

    function getActivo() {
        return $this->activo;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setTipoSolicitudId($tipoSolicitudId): void {
        $this->tipoSolicitudId = $tipoSolicitudId;
    }

    function setCiudadId($ciudadId): void {
        $this->ciudadId = $ciudadId;
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($nombre)));
    }

    function setContacto($contacto): void {
        $this->contacto = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($contacto)));
    }

    function setDireccion($direccion): void {
       $this->direccion = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($direccion)));
    }

    function setCodigoPostal($codigoPostal): void {
        $this->codigoPostal = trim($codigoPostal);
    }

    function setTelefono($telefono): void {
        $this->telefono = trim($telefono);
    }

    function setCelular($celular): void {
        $this->celular = trim($celular);
    }

    function setCorreo($correo): void {
        $this->correo = strtolower(trim($correo));
    }
    
    function setCorreo1($correo1): void {
        $this->correo1 =  strtolower(trim($correo1));
    }

    function setCorreo2($correo2): void {
        $this->correo2 =  strtolower(trim($correo2));
    }

    function setCorreo3($correo3): void {
        $this->correo3 =  strtolower(trim($correo3));
    }

    function setRfc($rfc): void {
        $this->rfc = strtoupper(trim($rfc));
    }

    function setCuenta($cuenta): void {
        $this->cuenta = trim($cuenta);
    }

    function setClasificacion($clasificacion): void {
        $this->clasificacion = $clasificacion;
    }

    function setCertificacion($certificacion): void {
        $this->certificacion = $certificacion;
    }

    function setFechaAlta($fechaAlta): void {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaEvaluacion($fechaEvaluacion): void {
        $this->fechaEvaluacion = $fechaEvaluacion;
    }

    function setCalificacion($calificacion): void {
        $this->calificacion = trim($calificacion);
    }

    function setFechaModificacion($fechaModificacion): void {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaBaja($fechaBaja): void {
        $this->fechaBaja = $fechaBaja;
    }

    function setFechaProxEvaluacion($fechaProxEvaluacion): void {
        $this->fechaProxEvaluacion = $fechaProxEvaluacion;
    }

    function setActivo($activo): void {
        $this->activo = $activo;
    }

    public function save() {        
        $sql = "insert into catalogo_proveedores values(null, {$this->getTipoSolicitudId()}, {$this->getCiudadId()}, '{$this->getNombre()}', '{$this->getContacto()}', '{$this->getDireccion()}', "
                . "'{$this->getCodigoPostal()}', '{$this->getTelefono()}', '{$this->getCelular()}', '{$this->getCorreo()}',  '{$this->getCorreo1()}', '{$this->getCorreo2()}',  '{$this->getCorreo3()}',"
                . "'{$this->getRfc()}', '{$this->getCuenta()}', '{$this->getClasificacion()}', "
                . "'{$this->getCertificacion()}', '{$this->getFechaAlta()}', '{$this->getFechaEvaluacion()}', {$this->getCalificacion()}, null, null,'{$this->getFechaProxEvaluacion()}', '{$this->getActivo()}');";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        var_dump($this->db->error);
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_proveedores set tipo_solicitud_id = {$this->getTipoSolicitudId()}, ciudad_id = {$this->getCiudadId()}, nombre= '{$this->getNombre()}', "
                . "contacto = '{$this->getContacto()}',direccion = '{$this->getDireccion()}', codigo_postal = '{$this->getCodigoPostal()}', "
                . "telefono = '{$this->getTelefono()}', celular= '{$this->getCelular()}', correo= '{$this->getCorreo()}',  correo1= '{$this->getCorreo1()}',  correo2= '{$this->getCorreo2()}', "
                . "correo3= '{$this->getCorreo3()}', rfc= '{$this->getRfc()}', "
                . "cuenta='{$this->getCuenta()}', clasificacion= '{$this->getClasificacion()}', certificacion= '{$this->getCertificacion()}', "
                . "fecha_alta='{$this->getFechaAlta()}', fecha_evaluacion='{$this->getFechaEvaluacion()}', calificacion={$this->getCalificacion()}, fecha_modificacion = curdate(), "
                . "fecha_proxima_evaluacion = '{$this->getFechaProxEvaluacion()}' ";
        if ($this->getActivo() == 'N') {
            $sql = $sql . ", fecha_baja = curdate(), activo= '{$this->getActivo()}' ";
        }
     
        $sql = $sql . "where id = {$this->getId()};";
   
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $result = array();
        $sql = "SELECT pr.*, ts.tipo as tipo_servicio, c.ciudad_completa FROM catalogo_proveedores pr
                    inner join catalogo_tipos_solicitudes ts on ts.id = pr.tipo_solicitud_id
                    inner join view_ciudades c on c.id = pr.ciudad_id
                    order by pr.nombre asc";
        $proveedores = $this->db->query($sql);

        while ($p = $proveedores->fetch_object()) {
            array_push($result, $p);
        }
        return $result;
    }
    
        public function delete() {
        $delete = $this->db->query("delete from catalogo_proveedores where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    
       public function proveedoresByServicio($servicioId) {
        $result = array();
        $sql = "SELECT pr.*, ts.tipo as tipo_servicio FROM catalogo_proveedores pr
                    inner join catalogo_tipos_solicitudes ts on ts.id = pr.tipo_solicitud_id
                    where pr.tipo_solicitud_id='{$servicioId}'
                    order by pr.nombre asc";
        $proveedores = $this->db->query($sql);

        while ($p = $proveedores->fetch_object()) {
            array_push($result, $p);
        }
        return $result;
    }
    
        public function getTransportistas() {
        $result = array();
        $sql = "SELECT pr.*, ts.tipo as tipo_servicio FROM catalogo_proveedores pr
                    inner join catalogo_tipos_solicitudes ts on ts.id = pr.tipo_solicitud_id
                    where ts.tipo = 'Transporte'
                    order by pr.nombre asc";
        $proveedores = $this->db->query($sql);

        while ($p = $proveedores->fetch_object()) {
            array_push($result, $p);
        }
        return $result;
    }
    
        public function getByNmobre($nombre) {
        $sql = "select * from catalogo_proveedores where nombre like '%{$nombre}%'";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function getEvaluaciones($idProveeedor, $fechaIni, $fechaFin) {
        $result = array();
        $sql = "select rt.evaluacion from compras_requisiciones r
               inner join compras_recepciones_fletes rt on rt.requisicion_id = r.id
                inner join compras_ordenes_compra o on o.requisicion_id = r.id
               where r.proveedor_id = {$idProveeedor} and o.estatus_id = 5 and rt.fecha_recepcion between '{$fechaIni}' and '{$fechaFin}';";

        $evaluaciones = $this->db->query($sql);
        if ($evaluaciones->num_rows > 0) {
            while ($e = $evaluaciones->fetch_object()) {
                array_push($result, $e);
            }
            return $result;
        }
    }
    
        public function getById() {
        $sql = "select p.nombre as proveedor, p.contacto as contacto, p.direccion as direccion, p.telefono as telefono, p.contacto as contacto, "
                . "p.correo as correo, c.ciudad_completa as ciudad from catalogo_proveedores p"
                . " inner join view_ciudades c on c.id = p.ciudad_id where p.id = {$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }
    
    public function updateEvaluacion($calificacion, $fechaEvaluacion) {
        $sql = "update catalogo_proveedores set fecha_evaluacion= curdate(), calificacion={$calificacion},  "
                . "fecha_proxima_evaluacion = '{$fechaEvaluacion}' ";     
        $sql = $sql . "where id = {$this->getId()};";
   
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}
