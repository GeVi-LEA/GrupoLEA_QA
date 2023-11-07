<?php
      require_once views_root . 'servicios/assets/css/lista_unidades.css.php';
      require_once views_root . 'servicios/assets/js/lista_unidades.js.php';
      
      
      
?>
<link rel="stylesheet" href="../../assets/libs/datatables/datatables.min.css">
<script src="../../assets/libs/datatables/datatables.min.js"></script>
<input type="text" id="idEtapa" value="<?php echo $idEst;?>" hidden>
<div class='contenido'>


      <div class='row'>
            <div class='col-12'>
                  <a href='<?= principalUrl ?>?controller=Home&action=index'><button type='button' class='btn btn-info btnRegresar'>Regresar</button></a>
            </div>
      </div>
      <div class='row'>
            <div class='col-12'>
                  <table id="tableUnidades" class='table table-striped ' style="width:100%">
                        <thead>
                              <th>FT/AT</th>
                              <th>#Unidad</th>
                              <th>Cliente</th>
                        </thead>
                        <tbody>
                        </tbody>
                  </table>
            </div>
      </div>
</div>