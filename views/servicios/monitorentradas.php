<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/js/scripts/ui/jquery-ui-1.13/jquery-ui.min.css" id="app-style">

<script src="<?php echo URL;?>assets/js/scripts/ui/jquery-ui-1.13/jquery-ui.min.js" type="text/javascript"></script>

<?php include "assets/js/monitorentradas_js.php";?>

<style>
.card_unidad {
      background-color: #e4ad3a;
      border-radius: 10px;
      border: solid 2px #d1971d;
      /* width: 100%; */
      min-height: 150px;
      margin: 10px;
      z-index: 100;
      font-size: 0.8rem;

}

.entransito {}

.droppper,
.droppper.row {

      /* display: grid; */
      /* grid-template-columns: repeat(1, 1); */
      /* grid-gap: 10px; */
      /* grid-auto-rows: minmax(100px, auto); */
      min-height: 70vh;
}

.itemunidad {
      border: solid 1px #a1a1a170;
      border-radius: 10px;
      padding: 5px;
      margin: 2px;
      background-color: antiquewhite;
      font-size: 0.8rem;
}
</style>

<script>
eltitulo = "Monitor de Entradas";
menusel = "monitorEntradas";
</script>
<br />
<div class='row'>
      <div class='col-12'>
            <div class='row'>
                  <div class='col-md-4 col-12'>
                        <div class='card sombra text-center'>
                              <div class='card-content'>
                                    <div class='card-body p-0'>
                                          <h4 class='card-title'>En terminal</h4>
                                          <h6 class='card-subtitle text-muted'></h6>
                                          <div class='card-body enterminal droppper h-100 ui-widget-content'>
                                                <div class='row unidades  h-100'>


                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class='col-md-4 col-12'>
                        <div class='card sombra text-center'>
                              <div class='card-content'>
                                    <div class='card-body p-0'>
                                          <h4 class='card-title'>Programado</h4>
                                          <h6 class='card-subtitle text-muted'></h6>
                                          <div class='card-body programado droppper h-100 ui-widget-content'>
                                                <div class='row unidades h-100'>
                                                      <div id="unidad2" class='col-md-5 col-12 card_unidad selector'>
                                                            <div class=''>
                                                                  <h8>La unidad2</h8>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class='col-md-4 col-12'>
                        <div class='card sombra text-center'>
                              <div class='card-content'>
                                    <div class='card-body p-0'>
                                          <h4 class='card-title'>Por Salir</h4>
                                          <h6 class='card-subtitle text-muted'></h6>
                                          <div class='card-body porsalir droppper h-100 ui-widget-content'>
                                                <div class='row unidades  h-100'></div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>