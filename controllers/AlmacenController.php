<?php
require_once utils_root.'utilsHelp.php';
require_once utils_root.'error_log.php';
require_once models_root.'compras/embarque.php';
require_once models_root.'almacen/movimiento_embarque.php';
require_once models_root.'catalogos/carro_tanque.php';

class almacenController {
   
    public function almacenBasicos(){
       Utils::noLoggin();
       $embarque= new Embarque();
       $idEst = null;
       if(isset($_GET['idEst'])){
           $idEst = (int)$_GET['idEst'];
       }
       $embarques = $embarque->getAlmacen($idEst);
       require_once views_root.'almacen/almacen_basicos.php';
     }
     
    public function buscarAlmacen(){
      Utils::noLoggin();
       $emb = new Embarque();
            $aduana = isset($_POST['aduana']) && $_POST['aduana'] != '' ? $_POST['aduana'] : null;
            $fechaInicio = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaInicio']))) : null;
            $fechaFinal = isset($_POST['fechaFin']) && $_POST['fechaFin'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaFin']))) : null;
            $proveedor = isset($_POST['proveedor']) && $_POST['proveedor'] != '' ? $_POST['proveedor'] : null;
            $producto = isset($_POST['producto']) && $_POST['producto'] != '' ? $_POST['producto'] : null;

        $embarques = $emb->getEmbarqueByFechasProdProv($proveedor, $producto, $fechaInicio, $fechaFinal, $aduana, true);
         $idEst = null;
        require_once views_root.'almacen/almacen_basicos.php';
      }
      
    public function exportarAlmacenExcel(){
      Utils::noLoggin();
            $pdf = $_POST['pdf'] == 1 ? true : false;
            $aduana = isset($_POST['aduanaExp']) && $_POST['aduanaExp'] != '' ? $_POST['aduanaExp'] : null;
            $fechaInicio = isset($_POST['fechaInicioExp']) && $_POST['fechaInicioExp'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaInicioExp']))) : null;
            $fechaFinal = isset($_POST['fechaFinExp']) && $_POST['fechaFinExp'] != '' ? date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaFinExp']))) : null;
            $proveedor = isset($_POST['proveedorExp']) && $_POST['proveedorExp'] != '' ? $_POST['proveedorExp'] : null;
            $producto = isset($_POST['productoExp']) && $_POST['productoExp'] != '' ? $_POST['productoExp'] : null;
            $emb = new Embarque();
             require_once utils_root . 'toExcel/excel.php';
            
              $embarques = $emb->getEmbarqueByFechasPedimentoProdProv($proveedor, $producto, $fechaInicio, $fechaFinal, $aduana, true);
              Excel::reporteAlmacenTransito($embarques, $pdf);

      }
      
    public function guardarUbicacionTransito(){
          if(isset( $_POST['id']) && $_POST['id'] != "" &&  $_POST['ubicacion'] != "" && isset( $_POST['ubicacion'])){
          $idEmb =  $_POST['id'];
          $ubicacion = $_POST['ubicacion'];
          $movimiento = new MovimientoEmbarque();
          $movimiento->setEmbarqueId($idEmb);
          $movimiento->setUbicacion($ubicacion);
          $result = $movimiento->save();
           if($result){
              $embarque = new Embarque();
              $embarque->setId($idEmb);
              $emb = $embarque->getById();
              $embarque->setIdEstatus(8); // Transito;
              $embarque->setFechaTransito($emb->fecha_transito);
              $embarque->embarqueEnTransito();
               if($emb->carro_tanque_id != null){
                    $carro = new CarroTanque();
                    $carro->setId($emb->carro_tanque_id);
                    $carro->setIdEstatus(8);
                    $result = $carro->updateEstatus();
                }
             }
            echo $result;
          }
      }
      
    public function elminarMovimientoEmbarque(){
        if(isset( $_POST['idMov']) && $_POST['idMov'] != ""){
            $idMov =  $_POST['idMov'];
            $movimiento = new MovimientoEmbarque();
            $movimiento->setId($idMov);
            $m = $movimiento->getById();
            $movimiento->delete();
            $movs = $movimiento->getMovimientosByEmbarqueId($m->embarque_id);
            $ubicacion = $movs[0]->ubicacion;
            
            $embarque = new Embarque();
            $embarque->setId($m->embarque_id);
            $e=$embarque->getById();
            if($ubicacion == 7 || $ubicacion == 8 || $ubicacion == 9){
                $embarque->setFechaLlegada($e->fecha_llegada);
                $result = $embarque->embarqueEnTerminal();
            }else if($ubicacion == 10){
                $embarque->setFechaModificacion($e->fecha_modificacion);
                $result = $embarque->liberarEmbarque();
            }else{
                $embarque->setFechaTransito($e->fecha_transito);
                $result = $embarque->embarqueEnTransito();
            }
            echo json_encode($result);
            }
     }
     
         public function embarqueEnTerminal(){
          if(isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['fecha']) && $_POST['fecha'] != '' ){
              $id = $_POST['id'];
              $ubicacion = isset($_POST['ubicacion']) && $_POST['ubicacion'] != '' ? $_POST['ubicacion'] : null;
              $fechaFin = UtilsHelp::covertDatetoDateSql($_POST['fecha']);
              $embarque = new Embarque();
              $embarque->setId($id);
              if($ubicacion != null){
                 if($ubicacion == 10){
                     $estatusCarro = 6;
                    $embarque->setFechaModificacion(date('Y-m-d', strtotime($fechaFin)));
                    $result = $embarque->liberarEmbarque();
                    }else{
                    $estatusCarro = 11;
                    $embarque->setFechaLlegada(date('Y-m-d', strtotime($fechaFin)));
                    $result = $embarque->embarqueEnTerminal();
                    }
                      if($result){
                        $emb = $embarque->getById();
                        if($emb->carro_tanque_id != null){
                            $carro = new CarroTanque();
                            $carro->setId($emb->carro_tanque_id);
                            $carro->setIdEstatus($estatusCarro); // Disponible
                            $result = $carro->updateEstatus();
                        }
                     }
                      $movimiento = new MovimientoEmbarque();
                      $movimiento->setEmbarqueId($id);
                      $movimiento->setUbicacion($ubicacion);
                      $movimiento->setFecha(date('Y-m-d', strtotime($fechaFin)));
                      $result = $movimiento->save();    
              
                    }
            }
             print_r($result);
         }
      
             public function consultaKansas(){
                 $w = "https://201.151.252.116:9105/ConsultaManifestacionImpl/ConsultaManifestacionService?wsdl";
              $client = new SoapClient($w);
              print_r($client->__getFunctions());
   
             }
}