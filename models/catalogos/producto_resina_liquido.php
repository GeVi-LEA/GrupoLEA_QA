<?php

class ProductoResinaLiquido {

    private $id;
    private $nombre;
    private $tipoProductoId;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function setId($id): void {
        $this->id = $id;
    }
    
    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(strtoupper(trim($nombre)));
    }
    
    public function getTipoProductoId() {
        return $this->tipoProductoId;
    }

    public function setTipoProductoId($tipoProductoId): void {
        $this->tipoProductoId = $tipoProductoId;
    }

        public function save() {
        $sql = "insert into catalogo_productos_resinas_liquidos values(null, '{$this->getNombre()}', {$this->getTipoProductoId()})";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_productos_resinas_liquidos set "
                 . " nombre= '{$this->getNombre()}', tipo_producto_id = {$this->getTipoProductoId()}"
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
        $productos = $this->db->query("select p.*, tp.nombre as tipoProducto from catalogo_productos_resinas_liquidos p, catalogo_tipos_productos_resinas_liquidos tp "
                . " where p.tipo_producto_id = tp.id order by p.nombre asc");
            while($p = $productos->fetch_object()){
            array_push($result, $p);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_productos_resinas_liquidos where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
}
