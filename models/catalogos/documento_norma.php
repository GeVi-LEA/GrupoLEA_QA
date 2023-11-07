<?php

class DocumentoNorma {

    private $id;
    private $usuarioId;
    private $estatusId;
    private $codigo;
    private $revision;
    private $nombre;
    private $descripcion;
    private $fechaLiberacion;
    private $fechaAlta;
    private $fechaModificacion;
    private $formato;
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

    function getEstatusId() {
        return $this->estatusId;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getRevision() {
        return $this->revision;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFechaLiberacion() {
        return $this->fechaLiberacion;
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFormato() {
        return $this->formato;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setUsuarioId($usuarioId): void {
        $this->usuarioId = $usuarioId;
    }

    function setEstatusId($estatusId): void {
        $this->estatusId = $estatusId;
    }

    function setCodigo($codigo): void {
        $this->codigo = $this->db->real_escape_string(trim(strtoupper($codigo)));
    }

    function setRevision($revision): void {
        $this->revision = $revision;
    }

    function setNombre($nombre): void {
           $this->nombre = $this->db->real_escape_string(UtilsHelp::capitalizeString(trim($nombre)));
    }

    function setDescripcion($descripcion): void {
        $desc = $this->db-> real_escape_string(UtilsHelp::fixString($descripcion));
        $this->descripcion = $desc;
    }

    function setExtension($extension): void {
        $this->extension = $extension;
    }

    function setFechaLiberacion($fechaLiberacion): void {
        $this->fechaLiberacion = $fechaLiberacion;
    }

    function setFechaAlta($fechaAlta): void {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaModificacion($fechaModificacion): void {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFormato($formato): void {
        $this->formato = $formato;
    }

    
    public function save() {

        $sql = "insert into catalogo_documentos_norma values(null, {$this->getUsuarioId()}, {$this->getEstatusId()}, '{$this->getCodigo()}', {$this->getRevision()},'{$this->getNombre()}', '{$this->getDescripcion()}', "
                . "'{$this->getFechaLiberacion()}', curdate(), curdate() , '{$this->getFormato()}');";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function edit() {
        $sql = "update catalogo_documentos_norma  set usuario_id = {$this->getUsuarioId()}, estatus_id = {$this->getEstatusId()}, codigo= '{$this->getCodigo()}', "
                . "nombre = '{$this->getNombre()}', revision = '{$this->getRevision()}', descripcion = '{$this->getDescripcion()}', "
                . "fecha_liberacion = '{$this->getFechaLiberacion()}', fecha_alta='{$this->getFechaAlta()}', fecha_modificacion = curdate() ";
        if ($this->getFormato() != null) {
            $sql = $sql . ", formato = '{$this->getFormato()}' ";
        }
        $sql = $sql . " where id = {$this->getId()};";

        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $result = array();
        $sql = "SELECT doc.*, concat(u.nombres,' ', u.apellidos) as usuario, e.nombre as estatus, e.clave as estatusClave FROM catalogo_documentos_norma doc inner join catalogo_usuarios u on u.id = doc.usuario_id "
                . "inner join catalogo_estatus e on e.id = doc.estatus_id order by doc.nombre asc";
        $documentos = $this->db->query($sql);

        while ($d = $documentos->fetch_object()) {
            array_push($result, $d);
        }
        return $result;
    }

    public function delete() {
        $delete = $this->db->query("delete from catalogo_documentos_norma where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getByCodigo($codigo) {
        $doc = $this->db->query("select * from catalogo_documentos_norma where codigo='{$codigo}'");
        return $doc->fetch_object();
    }

       public function getById($id) {
        $doc = $this->db->query("select * from catalogo_documentos_norma where id={$id}");
        return $doc->fetch_object();
    }

}
