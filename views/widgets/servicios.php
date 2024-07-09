<?php
include 'js/servicios_js.php';
?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/daterangepicker/daterangepicker.css">
<div class='card sombra h-100 mt-5 mb-5'>
    <div class='card-content'>
        <div class='card-body p-0'>
            <h4 class='card-title'>Servicios</h4>
            <h6 class='card-subtitle text-muted'>Servicios por cliente</h6>
            <div class='card-body' style=" ">
                <div class='row'>
                    <div class='col-4'>
                        <label for="rangoFechas" class="form-label">Rango de Fechas</label>
                        <div class="input-group mb-3">
                            <input type="hidden" id="fechas-startend">
                            <div class="input-group mb-3">
                                <input type='text' name="rangoFechas" id="rangoFechas" class="form-control shawCalRanges" />
                                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='col-8'>
                        <label for="cmbClientes_servicios" class="form-label">Clientes</label>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <select id='cmbClientes_servicios' name='cmbClientes_servicios' class="form-select h-100" name='clientessel[]' multiple='multiple' aria-hidden='true'></select>
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-users"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class='row'>
                    <div class='col-8'>
                        <div id='chart_servicios' style='min-height:300px;'></div>
                    </div>
                    <div class='col-4'>
                        <div class='row' id="cartas_serv" style="font-size: xx-small;">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<select hidden id='cmbTipoServicios' name='cmbTipoServicios' class="form-select h-100" name='tiposerviciossel[]'></select>