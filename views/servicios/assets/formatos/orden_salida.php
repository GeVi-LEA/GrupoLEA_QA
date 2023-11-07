<?php
include_once views_root . 'servicios/assets/formatos/orden_salida.css.php';
// print_r('<pre>');
// print_r($registro);
// print_r('</pre>');
?>
<link rel="stylesheet" href="<?php echo root_url; ?>/assets/libs/datatables/datatables.min.css">
<link rel="stylesheet" href="<?php echo root_url; ?>/assets/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo root_url; ?>/assets/css/bootstrap/bootstrap-extended.min.css">
<script src="../../assets/libs/datatables/datatables.min.js"></script>
<div class='contenido'>
      <div class='row'>
            <div class='col-2 logolea'>
                  <img src="<?php echo root_url; ?>/assets/img/logo_lea_only_azul.png" alt="" style="height: 80px; padding-left:5%;">
            </div>
            <div class='col-10 nombrelea'>
                  <h1>GRUPO LEA DE MÉXICO, S. DE R.L. DE C.V.</h1>
                  <!-- <table class='table' style='width:100%; border:none;'>
                        <tr>
                              <td></td>
                              <td>
                                    
                              </td>
                        </tr>
                  </table> -->

            </div>
      </div>
      <div class='row mt-3'>
            <div class='col-9' style="text-align: center;">
                  <h2>ORDEN DE SALIDA</h2>
            </div>
            <div class='col-3'>
                  <div class='row'>
                        <div class='col-6'>
                              <strong>FOLIO NÚM:</strong>
                        </div>
                        <div class='col-6'>
                              <?php echo 'folio'; ?>
                        </div>
                  </div>
                  <div class='row'>
                        <div class='col-6'>
                              <strong>FECHA:</strong>
                        </div>
                        <div class='col-6'>
                              <?php echo date('d/m/Y'); ?>
                        </div>
                  </div>
            </div>
      </div>
      <div class='grupo'>
            <div class='row mt-3'>
                  <div class='col-2'>
                        <strong>CLIENTE:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['nombreCliente']; ?>
                  </div>
            </div>
            <div class='row'>
                  <div class='col-2'>
                        <strong>DIRECCIÓN:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['direccion_cliente']; ?>
                  </div>
            </div>
      </div>
      <div class='grupo'>
            <div class='row mt-3'>
                  <div class='col-2'>
                        <strong>TRANSPORTISTA:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['transportista']; ?>
                  </div>
            </div>
            <div class='row'>
                  <div class='col-2'>
                        <strong>CONDUCTOR:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['chofer']; ?>
                  </div>
            </div>
            <div class='row'>
                  <div class='col-2'>
                        <strong>PLACAS:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['numUnidad']; ?>
                  </div>
            </div>
      </div>
      <div class='grupo'>


      </div>
      <div class='grupo'>
            <div class='row mt-3' style="text-align: center; border-top: 2px solid;">
                  <table id="tabla" class='table table-bordered' style='width: 100%;font-size: 0.7rem;'>
                        <thead>
                              <th><b>FOLIO</b></th>
                              <th><b>PRODUCTO</b></th>
                              <th><b>LOTE</b></th>
                              <th><b>NUM TOLVA</b></th>
                              <th><b>CANTIDAD</b></th>
                              <!-- <th><b>TOTAL KG</b></th> -->
                              <th><b>TARMIAS</b></th>
                              <th><b>PARCIAL</b></th>
                        </thead>
                        <tbody>
                              <?php for ($x = 0; $x < count($registro['servicio']); $x++) { ?>
                              <tr>
                                    <td><?= $registro['servicio'][$x]['folio'] ?></td>
                                    <td><?= $registro['servicio'][$x]['alias'] ?></td>
                                    <td><?= $registro['servicio'][$x]['lote'] ?></td>
                                    <td><?= $registro['servicio'][$x]['folio'] ?></td>
                                    <td><?= number_format((float) $registro['servicio'][$x]['cantidad'], 3, '.', '') ?></td>
                                    <!-- <td><?= $registro['servicio'][$x]['bultos'] ?></td> -->
                                    <td><?= $registro['servicio'][$x]['tarimas'] ?></td>
                                    <td><?= $registro['servicio'][$x]['parcial'] ?></td>
                              </tr>
                              <?php } ?>
                        </tbody>
                  </table>



            </div>

      </div>
      <div class='grupo'>
            <div class='row mt-4' style="border-top:2px solid">
                  <div class='col-2'>
                        <strong>SELLOS NÚM:</strong>
                  </div>
                  <div class='col-10'>
                        <?php echo $registro['sello1'] . ' ' . $registro['sello2'] . ' ' . $registro['sello3'] . ' '; ?>
                  </div>
            </div>
      </div>
      <div class='row mt-5'>
      </div>
      <div class='grupo' style="text-align: center; min-height:50px;">
            <div class='row mt-3'>
                  <div class='col'>
                        <strong>RECIBIÓ:</strong>
                  </div>
                  <div class='col'>
                        <strong>AUTORIZÓ:</strong>
                  </div>
            </div>
            <div class='row' style="min-height:50px;">
                  <div class='col'>
                        <p></p>
                        <p> </p>
                  </div>
                  <div class='col'>
                        <p></p>
                  </div>
            </div>

      </div>
      <div class='row mt-5'>
            <p>OBSERVACIONES:</p>
            <p>ESTE PRODUCTO VIAJA POR CUENTA Y RIESGO DEL CLIENTE.</p>
            <p>EL CLIENTE ACEPTA LAS CONDICIONES DEL PRODUCTO EMBARCADO AL SALIR DE PLANTA.</p>
            <p>NO SE ACEPTAN RECLAMOS DESPUÉS DE TRES DÍAS DE RECIBIDO EL PRODUCTO.</p>

      </div>

</div>