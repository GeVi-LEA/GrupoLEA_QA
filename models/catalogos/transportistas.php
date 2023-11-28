<?php

class CatTransportistas
{
    private $id;
    private $nombre;
    private $comentarios;
    private $fecha_alta;
    private $usuario_alta;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getComentarios()
    {
        return $this->comentarios;
    }

    function getFecha_Alta()
    {
        return $this->fecha_alta;
    }

    function getUsuario_Alta()
    {
        return $this->usuario_alta;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setNombre($nombre): void
    {
        $this->nombre = $this->db->real_escape_string(UtilsHelp::fixString($nombre));
    }

    function setComentarios($comentarios): void
    {
        $this->comentarios = $this->db->real_escape_string(UtilsHelp::fixString($comentarios));
    }

    public function save()
    {
        $sql    = "insert into catalogo_transportistas_clientes values
        (
            null
        , '{$this->getNombre()}'
        , '{$this->getComentarios()}'
        , now()
        , {$_SESSION['usuario']->id}
        )";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function edit()
    {
        $sql    = "update catalogo_transportistas_clientes set 
        nombre = '{$this->getNombre()}' 
        , comentarios= '{$this->getComentarios()}'
         where id={$this->getId()}";
        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll()
    {
        $result      = array();
        $Transportes = $this->db->query('select * from catalogo_transportistas_clientes order by nombre asc');
        while ($t = $Transportes->fetch_object()) {
            array_push($result, $t);
        }
        return $result;
    }

    public function getById($id)
    {
        $tipoTransportes = $this->db->query("select * from catalogo_transportistas_clientes where id= {$id}");
        return $tipoTransportes->fetch_object();
    }

    public function delete()
    {
        $delete = $this->db->query("delete from catalogo_transportistas_clientes where id={$this->id}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getByNombre($nombre)
    {
        $tipoTransportes = $this->db->query("select * from catalogo_transportistas_clientes where nombre = '{$nombre}'");
        return $tipoTransportes->fetch_object();
    }
}
