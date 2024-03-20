<?php

class ServicioMovimientoAlmacen
{
    private $idServicio;
    private $cantidad;
    private $almacen;
    private $operacion;
    private $fecha;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getIdServicio()
    {
        return $this->idServicio;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getAlmacen()
    {
        return $this->almacen;
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function setIdServicio($idServicio): void
    {
        $this->idServicio = $idServicio;
    }

    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function setAlmacen($almacen): void
    {
        $this->almacen = $almacen;
    }

    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    public function save()
    {
        // $sql = "insert into servicios_movimientos_almacen values({$this->getIdServicio()}, {$this->getAlmacen()}, {$this->getCantidad()}, '{$this->getOperacion()}', NOW())";
        $sql = 'insert IGNORE  into servicios_movimientos_almacen values(
            ' . $this->getIdServicio() . '
            , ' . $this->getAlmacen() . '
            , ' . $this->getCantidad() . '
            , get_OperacionByEnsacado(' . $this->getIdServicio() . ')
            , NOW()
            , (select lote from servicios_ensacado se where se.id = ' . $this->getIdServicio() . '))';
        try {
            $save = $this->db->query($sql);
        } catch (\Throwable $th) {
            // print_r($th->message);
        }

        // print_r('<pre>');
        // print_r($save);
        // print_r('</pre>');
        // $result = false;
        // if ($save) {
        $result = true;
        // }
        return $result;
    }

    public function delete()
    {
        $delete = $this->db->query("delete from servicios_clientes where id={$this->getId()}");
        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }

    public function getInventarios($clientes)
    {
        $result          = array();
        $get_inventarios = $this->db->query("CALL get_inventarios('{$clientes}');");
        // $get_inventarios->fetch_all( MYSQLI_ASSOC );
        foreach ($get_inventarios->fetch_all(MYSQLI_ASSOC) as $e) {
            array_push($result, $e);
        }

        return $result;
    }

    public function getInventarios_detalle($cliente, $lote, $producto, $almacen)
    {
        $result          = array();
        $get_inventarios = $this->db->query("CALL get_detalle_inventario('{$cliente}', '{$lote}', '{$producto}', '{$almacen}');");
        // $get_inventarios->fetch_all( MYSQLI_ASSOC );
        foreach ($get_inventarios->fetch_all(MYSQLI_ASSOC) as $e) {
            array_push($result, $e);
        }

        return $result;
    }

    public function setTransfer($almacen_id_from, $almacen_id_to, $cantidad, $lote)
    {
        /* genera salida */
        $this->db->query("insert into servicios_movimientos_almacen(servicio_id,almacen_id,cantidad,operacion,lote) values('0', '{$almacen_id_from}', '{$cantidad}', 'ST','{$lote}');");

        /* genera entrada */
        $this->db->query("insert into servicios_movimientos_almacen(servicio_id,almacen_id,cantidad,operacion,lote) values('0', '{$almacen_id_to}', '{$cantidad}', 'ET','{$lote}');");

        /* guarda log */
        $this->db->query("insert into servicios_log_movimientos(usuario,comentario) values('{$_SESSION['usuario']->id}', 'Realizó transferencia de {$cantidad}kg al almacen_id {$almacen_id_to} desde el almacen_id {$almacen_id_from}');");
    }
}
