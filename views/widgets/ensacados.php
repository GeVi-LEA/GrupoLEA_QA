<?php
include 'js/ensacados_js.php';
?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/daterangepicker/daterangepicker.css">
<div class='card sombra h-100'>
    <div class='card-content'>
        <div class='card-body p-0'>
            <h4 class='card-title'>Ensacados</h4>
            <h6 class='card-subtitle text-muted'>Servicios de ensacado por cliente</h6>
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
                        <label for="cmbClientes" class="form-label">Clientes</label>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <select id='cmbClientes' name='cmbClientes' class="form-select h-100" name='clientessel[]' multiple='multiple' aria-hidden='true'></select>
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-9 col-12'>
                        <div id='chart_clientes' style='min-height:300px;'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>