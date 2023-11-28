<?php

class ServicioLubricante
{
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getLotesCliente($clienteId)
    {
        $result = array();
        $sql    = "/*SELECT distinct 
                        clientes.nombre
                        ,prod.nombre
                            
                        #,req.* 
                        FROM 
                        compras_requisiciones req
                        inner join catalogo_productos prod on prod.id = req.producto_id
                        inner join catalogo_clientes clientes on clientes.id = req.cliente_id
                        WHERE producto_id is not null
                        and cliente_id = '{$clienteId}'*/
                        SELECT 
                        distinct
                        id,
                        nombre 
                        FROM catalogo_productos
                        order by nombre
                        ";

        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getInfoLote($lote)
    {
        $result    = array();
        $sql       = "
                              select 
                              se.lote, max(se.producto_id)producto_id, max(cat_prod.nombre) producto, max(se.alias) alias 
                              ,get_disponibleByLote(max(se.lote),max(ent.cliente_id)) disponible
                              from servicios_ensacado se 
                              inner join catalogo_productos_resinas_liquidos cat_prod on cat_prod.id = se.producto_id
                              inner join servicios_entradas ent on ent.id = se.entrada_id

                              where se.lote like '%{$lote}%' group by se.lote";
        $ensacados = $this->db->query($sql);
        if ($ensacados != null) {
            foreach ($ensacados->fetch_all(MYSQLI_ASSOC) as $e) {
                array_push($result, $e);
            }
        }
        return $result;
    }

    public function getByLote()
    {
        $result    = array();
        $sql       = "select serEnt.producto_id as producto, serEnt.lote as lote, serEnt.alias as alias,  
                 (select sum(servEns.total_ensacado) from servicios_ensacado servEnt
                 left join servicios_ensacado servEns on servEns.entrada_id = servEnt.id 
                 inner join catalogo_servicios serv on servEns.servicio_id = serv.id where servEnt.lote like '%$lote%' and serv.clave not like '%CARGA%' and serv.clave not like '%AJUSTE%' and servEns.estatus_id = 5) as descargas,
                 where SerEnt.lote like '%$lote%'  group by serEnt.lote;";
        $servicios = $this->db->query($sql);
        while ($c = $servicios->fetch_object()) {
            array_push($result, $c);
        }
        return $result;
    }
}
