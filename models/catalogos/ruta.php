<?php

class Ruta {

    private $id;
    private $proveedorId;
    private $ciudadOrigen;
    private $ciudadDestino;
    private $tipoTransporte;
    private $precio;
    private $descripcion;
    private $fechaVencimiento;
    private $moneda;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getProveedorId() {
        return $this->proveedorId;
    }

    function getCiudadOrigen() {
        return $this->ciudadOrigen;
    }

    function getCiudadDestino() {
        return $this->ciudadDestino;
    }

    function getTipoTransporte() {
        return $this->tipoTransporte;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setProveedorId($proveedorId): void {
        $this->proveedorId = $proveedorId;
    }

    function setCiudadOrigen($ciudadOrigen): void {
        $this->ciudadOrigen = $ciudadOrigen;
    }

    function setCiudadDestino($ciudadDestino): void {
        $this->ciudadDestino = $ciudadDestino;
    }

    function setTipoTransporte($tipoTransporte): void {
        $this->tipoTransporte = $tipoTransporte;
    }

    function setPrecio($precio): void {
        $this->precio = $precio;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }
    
    function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    function setFechaVencimiento($fechaVencimiento): void {
        $this->fechaVencimiento = $fechaVencimiento;
    }
    
    function getMoneda() {
        return $this->moneda;
    }

    function setMoneda($moneda): void {
        $this->moneda = $moneda;
    }

    
        
    public function save() {
        $sql = "insert into catalogo_rutas values(null, {$this->getProveedorId()}, {$this->getCiudadOrigen()}, {$this->getCiudadDestino()}, {$this->getTipoTransporte()}, "
                . "{$this->getPrecio()}, '{$this->getDescripcion()}','{$this->getFechaVencimiento()}', {$this->getMoneda()});";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
        $sql = "update catalogo_rutas set proveedor_id = '{$this->getProveedorId()}', ciudad_origen = {$this->getCiudadOrigen()}, ciudad_destino= '{$this->getCiudadDestino()}', "
                . "tipo_transporte = '{$this->getTipoTransporte()}', precio = {$this->getPrecio()}, descripcion = '{$this->getDescripcion()}', "
                . " fecha_vencimiento = '{$this->getFechaVencimiento()}', moneda={$this->getMoneda()} where id = {$this->getId()};";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll($where = null) {
        $result = array();
        $sql = "SELECT r.*,(select concat(c.nombre,',',c.clave_estado,',',c.clave_pais) from view_ciudades c WHERE c.id=r.ciudad_origen) as ciudad_or, "
                . "(select concat(c.nombre,',',c.clave_estado,',',c.clave_pais) from view_ciudades c WHERE c.id=r.ciudad_destino) as ciudad_des, p.nombre as proveedor, t.nombre as transporte"
                . " FROM catalogo_rutas as r inner join catalogo_proveedores p on p.id = r.proveedor_id "
                . "inner join catalogo_tipos_transportes t on t.id = r.tipo_transporte ";
        if($where != null){
            $sql.= $where;
        }
        $sql.= " order by proveedor_id desc, ciudad_origen asc";
        
        $rutas = $this->db->query($sql);
        if($rutas-> num_rows > 0 ){
        while ($r = $rutas->fetch_object()) {
            array_push($result, $r);
        }
        }
        return $result;
    }
    
      public function rutaById($idRuta) {
        $where = "where r.id={$idRuta}";
       return $this->getAll($where);
    }
    
     public function getRutasCarroTanques($id) {
     $where = "where r.tipo_transporte={$id}";
     return $this->getAll($where);
    }
    
    public function rutasByProveedor($idProv, $idTransporte) {
        $where = "where p.id={$idProv} and tipo_transporte = {$idTransporte}";
       return $this->getAll($where);
    }
   
    public function delete() {
        $delete = $this->db->query("delete from catalogo_rutas where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }   
}
