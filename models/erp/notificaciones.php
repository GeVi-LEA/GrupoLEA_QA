<?php

class Notificaciones
{
    private $id;
    private $user_id;
    private $fecha_creacion;
    private $titulo;
    private $mensaje;
    private $status;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId()
    {
        return $this->id;
    }

    function getUserId()
    {
        return $this->user_id;
    }

    function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    function getTitulo()
    {
        return $this->titulo;
    }

    function getMensaje()
    {
        return $this->mensaje;
    }

    function getStatus()
    {
        return $this->status;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    function setFechaCreacion($fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    function setMensaje($mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    function setStatus($status): void
    {
        $this->status = $status;
    }

    function save()
    {
        $sql = "insert into erp_notificaciones(user_id,titulo,mensaje) values({$this->getUserId()}, ";

        if ($this->getTitulo() == null) {
            $sql .= " 'Mensaje del sistema', ";
        } else {
            $sql .= " '{$this->getTitulo()}',  ";
        }

        if ($this->getMensaje() == null) {
            $sql .= " 'Mensaje del sistema', ";
        } else {
            $sql .= " '{$this->getMensaje()}',  ";
        }

        $save   = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    function setAsRead()
    {
        $sql    = "update erp_notificaciones set status = 1 where id = {$this->getId()}";
        $delete = $this->db->query($sql);
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    function delete()
    {
        $sql    = "update erp_notificaciones set status = 0 where id = {$this->getId()}";
        $delete = $this->db->query($sql);
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    function getById()
    {
        $sql    = "select * from erp_notificaciones where id = {$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    function getNotificacionesByUserId($user_id)
    {
        $result = array();
        $sql    = "select * from erp_notificaciones where user_id = {$user_id} and status > 0 order by fecha_creacion desc;";
        // print_r($sql);
        $movs = $this->db->query($sql);
        while ($m = $movs->fetch_object()) {
            array_push($result, $m);
        }
        return $result;
    }

    function sendNotificacionesByCveNoti($cve_noti)
    {
        $result = array();
        $sql    = "SELECT * FROM catalogo_tipo_notificaciones tiponoti inner join erp_usuarios_notificaciones usrnoti on usrnoti.id_tipo_notificacion = tiponoti.id where clave_notificacion = '{$cve_noti}';";
        // print_r($sql);
        $users = $this->db->query($sql);
        while ($u = $users->fetch_object()) {
            $queryins = 'INSERT INTO erp_notificaciones
                        (
                        user_id,
                        titulo,
                        mensaje)
                        VALUES(
                        ' . $u->user_id . ",
                        '" . $u->titulo . "',
                        '" . $u->mensaje . "'
                        );";
            $this->db->query($queryins);
        }
        return $result;
    }
}