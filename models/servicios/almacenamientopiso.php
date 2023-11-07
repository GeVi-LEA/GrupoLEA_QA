<?php

class InventarioProductos
{
    private $id;
    private $fecha_entrada;
    private $status;
    private $ubicacion;
    private $user_id_alta;
    private $id_producto;
    private $id_cliente;
    private $cantidad;
    private $lote;
    private $tolva;
    private $tarimas;
    private $bultos;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /* GETS */
    function getId()
    {
        return $this->id;
    }

    function getFecha_entrada()
    {
        return $this->fecha_entrada;
    }

    function getStatus()
    {
        return $this->status;
    }

    function getUbicacion()
    {
        return $this->ubicacion;
    }

    function getUser_Id_Alta()
    {
        return $this->user_id_alta;
    }

    function getId_Producto()
    {
        return $this->id_producto;
    }

    function getId_Cliente()
    {
        return $this->id_cliente;
    }

    function getCantidad()
    {
        return $this->cantidad;
    }

    function getLote()
    {
        return $this->lote;
    }

    function getTolva()
    {
        return $this->tolva;
    }

    function getTarimas()
    {
        return $this->tarimas;
    }

    function getBultos()
    {
        return $this->bultos;
    }

    /* SETS */
    function setId($id): void
    {
        return $this->id = $id;
    }

    function setFecha_Entrada($fecha_entrada): void
    {
        return $this->fecha_entrada = $fecha_entrada;
    }

    function setStatus($status): void
    {
        return $this->status = $status;
    }

    function setUbicacion($ubicacion): void
    {
        return $this->ubicacion = $ubicacion;
    }

    function setUser_Id_Alta($user_id_alta): void
    {
        return $this->user_id_alta = $user_id_alta;
    }

    function setId_Producto($id_producto): void
    {
        return $this->id_producto = $id_producto;
    }

    function setId_Cliente($id_cliente): void
    {
        return $this->id_cliente = $id_cliente;
    }

    function setCantidad($cantidad): void
    {
        return $this->cantidad = $cantidad;
    }

    function setLote($lote): void
    {
        return $this->lote = $lote;
    }

    function setTolva($tolva): void
    {
        return $this->tolva = $tolva;
    }

    function setTarimas($tarimas): void
    {
        return $this->tarimas = $tarimas;
    }

    function setBultos($bultos): void
    {
        return $this->bultos = $bultos;
    }

    /* OPERACIONES */
    function save()
    {
        $sql  = 'insert into almacen_inventario_productos values(';
        $pasa = 1;
        if ($this->getUser_Id_Alta() == null) {
            $pasa = 0;
        }
        if ($this->getUbicacion() == null) {
            $sql .= " '',  ";
        } else {
            $sql .= " '{$this->getUbicacion()}',  ";
        }
        if ($this->getId_Producto() == null) {
            $pasa = 0;
        }
        if ($this->getId_Cliente() == null) {
            $pasa = 0;
        }
        if ($this->getCantidad() == null) {
            $pasa = 0;
        }
        if ($this->getLote() == null) {
            $pasa = 0;
        }
        if ($this->getTolva() == null) {
            $pasa = 0;
        }
        if ($this->getTarimas() == null) {
            $sql .= " '',  ";
        } else {
            $sql .= " '{$this->getTarimas()}',  ";
        }
        if ($this->getBultos() == null) {
            $sql .= " '',  ";
        } else {
            $sql .= " '{$this->getBultos()}',  ";
        }
        $sql   .= ')';
        $result = false;
        if ($pasa == 1) {
            $save = $this->db->query($sql);

            if ($save) {
                $result = true;
            }
        }
        return $result;
    }

    function delete()
    {
        $sql    = "delete from almacen_inventario_productos where id = {$this->getId()}";
        $delete = $this->db->query($sql);
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    function desactivar()
    {
        $sql    = "update almacen_inventario_productos set status = 0 where id = {$this->getId()}";
        $delete = $this->db->query($sql);
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    function getById()
    {
        $sql    = "select * from almacen_inventario_productos where id = {$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    function getMovimientosById_Cliente($id_cliente)
    {
        $result = array();
        $sql    = "select m.* from almacen_inventario_productos m where m.id_cliente = {$id_cliente} ans status = 1 order by m.fecha_entrada desc";
        $movs   = $this->db->query($sql);
        while ($m = $movs->fetch_object()) {
            array_push($result, $m);
        }
        return $result;
    }
}