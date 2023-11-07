<?php

class Cliente {

    private $id;
    private $ciudadId;
    private $nombre;
    private $contacto;
    private $direccion;
    private $codigoPostal;
    private $telefono;
    private $correo;
    private $rfc;
    private $fechaAlta;
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

    function getCorreo() {
        return $this->correo;
    }

    function getRfc() {
        return $this->rfc;
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function setId($id): void {
        $this->id = $id;
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

    function setCorreo($correo): void {
        $this->correo = trim($correo);
    }

    function setRfc($rfc): void {
        $this->rfc = strtoupper(trim($rfc));
    }

    function setFechaAlta($fechaAlta): void {
        $this->fechaAlta = $fechaAlta;
    }

    public function save() {
          
        $sql = "insert into catalogo_clientes values(null, {$this->getCiudadId()}, '{$this->getNombre()}', '{$this->getContacto()}', '{$this->getDireccion()}', '{$this->getCodigoPostal()}',  "
                . "'{$this->getTelefono()}', '{$this->getCorreo()}', '{$this->getRfc()}', '{$this->getFechaAlta()}');";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_clientes set ciudad_id = {$this->getCiudadId()}, nombre= '{$this->getNombre()}', "
                . "contacto = '{$this->getContacto()}', direccion = '{$this->getDireccion()}', codigo_postal = '{$this->getCodigoPostal()}', "
                . "telefono = '{$this->getTelefono()}', correo= '{$this->getCorreo()}', rfc= '{$this->getRfc()}', "
                . "fecha_alta='{$this->getFechaAlta()}' where id = {$this->getId()};";
   
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll($id = null) {
        $result = array();
        $sql = "select cl.*, c.ciudad_completa FROM catalogo_clientes cl
                    inner join view_ciudades c on c.id = cl.ciudad_id ";
                
         if ($id != null){
          $sql .= "where cl.id= {$id}";   
         }       
         
         $sql .= " order by cl.nombre asc";
        $clientes = $this->db->query($sql);

        while ($c = $clientes->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }
    
        public function getClienteConServiciosEnsacado() {
        $result = array();
        $sql = "select distinct c.id, cl.*, c.ciudad_completa FROM catalogo_clientes cl "
                . "inner join servicios_clientes sc on sc.cliente_id = cl.id "
                . "inner join view_ciudades c on c.id = cl.ciudad_id "
                . "order by cl.nombre asc;";
        
        $clientes = $this->db->query($sql);

        while ($c = $clientes->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }
    
    
    
        public function delete() {
        $delete = $this->db->query("delete from catalogo_clientes where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
    
    public function getClienteById() {
        $cliente = $this->getAll($this->getId());
        return $cliente;
    }
        
}
