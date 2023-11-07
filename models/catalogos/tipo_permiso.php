<?php

class TipoPermiso {

    private $id;
    private $nombre;
    private $clave;
    private $descripcion;
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

    function getClave() {
        return $this->clave;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
    }

    function setClave($clave): void {
        $this->clave = $this->db->real_escape_string(strtoupper($clave));
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc != null ? $desc : "S/D";
    }

    public function save() {
        $id = (int) $this->getIdUltimoPer() + 1;
        $sql = "insert into catalogo_tipos_permisos values({$id}, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_tipos_permisos set "
                 . "nombre = '{$this->getNombre()}', clave= '{$this->getClave()}',  descripcion = '{$this->getDescripcion()}'"
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
        $permisos = $this->db->query("select * from catalogo_tipos_permisos order by id asc");
        while($p = $permisos->fetch_object()){
            array_push($result, $p);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_tipos_permisos where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }
    
    public function getIdUltimoPer(){
    $sql = "SELECT MAX(id)as id FROM catalogo_tipos_permisos";
    $query = $this->db->query($sql);
    $id = $query->fetch_object()->id;
    return $id;
     }
   
    public function getById($id) { 
    $result = $this->db->query("select * from catalogo_tipos_permisos where id={$id}");   
    return $result->fetch_object();
    }

}
