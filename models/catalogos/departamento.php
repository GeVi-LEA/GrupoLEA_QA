<?php

class Departamento {

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
        $sql = "insert into catalogo_departamentos values(null, '{$this->getNombre()}', '{$this->getClave()}', '{$this->getDescripcion()}')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit() {
         $sql = "update catalogo_departamentos set "
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
        $departamentos = $this->db->query("select * from catalogo_departamentos order by nombre asc");
        while($d = $departamentos->fetch_object()){
            array_push($result, $d);
        }
        return $result;
    }
    
    public function delete(){
       $delete  = $this->db->query("delete from catalogo_departamentos where id={$this->id}");
       $result = false;
       if($delete){
           $result = true;
       }
       return $result;
    }

}
