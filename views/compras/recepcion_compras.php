<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/bootstrap/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/compras/assets/css/recepcion.css" />
        <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
        <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script> 
        <script src="<?= root_url ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?= root_url ?>views/compras/assets/js/recepcion.js"></script>
        <script src="<?= root_url ?>assets/js/bootstrap/bootstrap.min.js"></script> 
        <title>Recepción compras</title>
    </head>
    <body>
        <div class="contenedor">
            <header class='d-flex'>
                <div>
                    <img class="img" src="<?= root_url ?>assets/img/logo_lea_260.png" alt="Logo LEA" />
                </div>
                <div class="text-center w-75 mt-4">
                    <h4>RECEPCION DE COMPRA DE MATERIALES Y/O SERVICIOS</h4>
                </div>
            </header>
                   <div class="div-datos">
                <span class="titulo-div">Datos orden de compra</span>
                <div class="datos-recepcion datos mb-2 mt-1">
                    <div><strong class="mr-1">Proveedor:</strong> <span class="mr-5"><?= isset($r) ? $r['proveedor'] : ""; ?></span></div>   
                    <div><strong class="mr-1">Tipo de compra:</strong><span><?= $r['solicitud']. ' - '. $r['compra']; ?></span></div>
                    <div><strong class="mr-1">Orden compra:</strong><span><?= isset($oc) ? $oc->folio : "" ?></span></div>
                </div>
                <div class="datos-recepcion datos">
                    <div><strong class="mr-1">Solicitado por:</strong><span><span><?=isset($r)? $r['usuario'] : "";?></span></div>
                    <div><strong class="mr-1">Departamento:</strong><span><span><?=isset($r)? $r['departamento'] : "";?></span></div>
                    <div><strong class="mr-1">Fecha solicitada:</strong><span><span><?= isset($r) && $r['fecha_solicitud'] != "" ? date('d/m/Y', strtotime($r['fecha_solicitud'])) : ""; ?></span></div>                     
                   </div>

            <?php if($r['solicitud'] == "Transporte"):          
                $carroTanque = Utils::getCarroTanque()->id;
                $recepcion = new RecepcionFlete();
                $recepcion->setIdRequisicion($r['id']);
                $rt = $recepcion->getByRequisicion();
                $embarque = new Embarque();
                $embarque->setIdRequisicionFlete($r['id']);
                $embs = $embarque->getByRequisicionFlete();
                if($rt !=null){
                $evaluacion = json_decode($rt->evaluacion, true);
                }else{
                   if($carroTanque != $r['transporte_id']){
                          $evaluacion = array(
                           "pregunta1" => 0,
                           "pregunta2" => 0,
                           "pregunta3" => 0,
                           "pregunta4" => 0
                       );   
                   }else{
                        $evaluacion = array(
                           "pregunta1" => 4,
                           "pregunta2" => 4,
                           "pregunta3" => 4,
                           "pregunta4" => 1
                            );
                   }
                }
                require_once 'recepcion_fletes.php'; ?>
         <?php endif; ?>
        </div>
        <!-- Documento modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDocumento">
            <div class="modal-dialog m-dialog">
                <div class="modal-content m-content" id="viewDoc">
                    <div class="modal-header m-header">
                        <h5 class="modal-title" id="tituloDocumento"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>