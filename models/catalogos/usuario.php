<?php

class Usuario {

    private $id;
    private $permiso;
    private $departamento;
    private $puesto;
    private $nombres;
    private $apellidos;
    private $correo;
    private $extension;
    private $telefono;
    private $user;
    private $password;
    private $fechaAlta;
    private $fechaModificacion;
    private $fechaBaja;
    private $imagen;
    private $firma;
    private $activo;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getPermiso() {
        return $this->permiso;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getExtension() {
        return $this->extension;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getUser() {
        return $this->user;
    }

    function getPassword() {
          return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getFirma() {
        return $this->firma;
    }

    function getActivo() {
        return $this->activo;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setPermiso($permiso): void {
        $this->permiso = $permiso;
    }

    function setDepartamento($departamento): void {
        $this->departamento = $departamento;
    }

    function setPuesto($puesto): void {
        $this->puesto = $this->db->real_escape_string(UtilsHelp::fixString($puesto));;
    }

    function setNombres($nombres): void {
         $this->nombres = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($nombres)));
    }

    function setApellidos($apellidos): void {
       $this->apellidos = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($apellidos)));
    }

    function setCorreo($correo): void {
        $this->correo = $this->db->real_escape_string(strtolower(trim($correo)));
    }

    function setExtension($extension): void {
        $this->extension = $extension;
    }

    function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    function setUser($user): void {
            $this->user = $this->db->real_escape_string(strtolower(trim($user)));
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setFechaAlta($fechaAlta): void {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaModificacion($fechaModificacion): void {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaBaja($fechaBaja): void {
        $this->fechaBaja = $fechaBaja;
    }

    function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

    function setFirma($firma): void {
        $this->firma = $firma;
    }

    function setActivo($activo): void {
        $this->activo = $activo;
    }

    public function save() {

        $sql = "insert into catalogo_usuarios values(null, '{$this->getPermiso()}', {$this->getDepartamento()}, '{$this->getPuesto()}', '{$this->getNombres()}', '{$this->getApellidos()}', "
                . "'{$this->getCorreo()}', '{$this->getExtension()}', '{$this->getTelefono()}', '{$this->getUser()}', '{$this->getPassword()}', '{$this->getFechaAlta()}', null, "
                . "null, '{$this->getImagen()}', '{$this->getFirma()}','{$this->getActivo()}');";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function edit($cambioPass) {
  
        $sql = "update catalogo_usuarios set permisos = '{$this->getPermiso()}', departamento_id = {$this->getDepartamento()}, puesto= '{$this->getPuesto()}', "
                . "nombres = '{$this->getNombres()}', apellidos = '{$this->getApellidos()}', correo = '{$this->getCorreo()}', "
                . "telefono = '{$this->getTelefono()}', extension= '{$this->getExtension()}', user= '{$this->getUser()}', "
                . "fecha_alta='{$this->getFechaAlta()}', fecha_modificacion = curdate() ";
        if ($this->getActivo() == 'N') {
            $sql = $sql . ", fecha_baja = curdate(), activo= '{$this->getActivo()}' ";
        } else {
            $sql = $sql . ", fecha_baja = null, activo= '{$this->getActivo()}' ";
        }
        if ($this->getImagen() != null) {
            $sql = $sql . ", imagen = '{$this->getImagen()}' ";
        }
        if ($this->getFirma() != null) {
            $sql = $sql . ", firma= '{$this->getFirma()}' ";
        }
        if($cambioPass){
        $sql = $sql .", password= '{$this->getPassword()}' ";
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
        $sql = "SELECT u.*, concat(u.nombres,' ', u.apellidos) as nombreCompleto, d.nombre as departamento FROM catalogo_usuarios as u "
                . "inner join catalogo_departamentos d on d.id = u.departamento_id order by u.nombres asc";
        $usuarios = $this->db->query($sql);
        while ($u = $usuarios->fetch_object()) {
            array_push($result, $u);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_usuarios where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getById($id) {
        $usuario = $this->db->query("SELECT u.*, d.nombre as departamento FROM catalogo_usuarios u "
                . "inner join catalogo_departamentos d on d.id = u.departamento_id  where u.id='{$id}'");
        return $usuario->fetch_object();
    }
    
        public function getUsuariosByDepartamento($idDepartamento) {
        $result = array();
        $usuario = $this->db->query("SELECT u.*, d.nombre as departamento FROM catalogo_usuarios u "
                . "inner join catalogo_departamentos d on d.id = u.departamento_id where d.id='{$idDepartamento}' and u.activo='S'");
         while ($u = $usuario->fetch_object()) {
            array_push($result, $u);
        }
        return $result;
    }
    
    public function getByUser($user) {
     $usuario = $this->db->query("select * from catalogo_usuarios where user='{$user}'");
     return $usuario;
    }
    
    public function updatePass(){
        $result = false;
        $sql = "update catalogo_usuarios set password= '{$this->getPassword()}' where user='{$this->getUser()}';";
        $update = $this->db->query($sql);
        
        if($update){
            $result = true;   
        }
        return $result;
    }
    
    public function eliminarImagen($id) {
        $sql = "update catalogo_usuarios set fecha_modificacion = curdate(), imagen = '' where id={$id}";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = 'Se elimino imagen';
        }
        return $result;
    }
    
    public function eliminarFirma($id) {
    $sql = "update catalogo_usuarios set fecha_modificacion = curdate(), firma = '' where id={$id}";

    $save = $this->db->query($sql);
    $result = false;
        if ($save) {
            $result = 'Se elimino firma';
        }
        return $result;
    }
}
