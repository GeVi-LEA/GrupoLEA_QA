<?php
include 'assets/js/lista_servicios_js.php';
?>

<script src='<?php echo URL; ?>assets/js/charts/echarts/echarts.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/datatables/datatables.min.css">
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/select2/css/select2.min.css">
<script src="<?php echo URL; ?>assets/libs/datatables/datatables.min.js"></script>

<style>
.tablaexport {
    visibility: hidden;
}

.bg-gradient-directional-danger {
    background-image: linear-gradient(45deg, #FF394F, #FF8090);
    background-repeat: repeat-x;
}

.bg-gradient-directional-info {
    background-image: linear-gradient(45deg, #168DEE, #62BCF6);
    background-repeat: repeat-x;
    border: none;
}
</style>

<script>
eltitulo = 'Listado de Servicios';
menusel = 'lista_servicios';
</script>



<div class='row sombra mt-3'>
    <div class='col-12'>
        <div class='row'>
            <!-- <div class='col-md-3 col-12'> -->
            <div class='row'>
                <div class='col-md-4 col-12'>
                    <label for="rangoFechas" class="form-label">Rango de Fechas</label>
                    <div class="input-group mb-3">
                        <input type="hidden" id="fechas-startend">
                        <div class="input-group mb-3">
                            <input type='text' name="rangoFechas" id="rangoFechas" class="form-control shawCalRanges" />
                            <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!-- <div class='row'> -->
                <div class='col-md-4 col-12'>
                    <label for="cmbClientes" class="form-label">Clientes</label>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <select id='cmbClientes' name='cmbClientes' class="form-select h-100" name='clientessel[]' multiple='multiple' aria-hidden='true'></select>
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-users"></i></span>
                        </div>
                    </div>
                </div>
                <div class='col-md-4 col-12'>
                    <label for="cmbTipoServicios" class="form-label">Tipos de servicio</label>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <select id='cmbTipoServicios' name='cmbTipoServicios' class="form-select h-100" name='tiposerviciossel[]' multiple='multiple' aria-hidden='true'></select>
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-users"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- </div> -->



        </div>

    </div>
</div>
<div class='row mt-3'>
    <!-- <div class='col-12'>
        <div id='chart_clientes' style='min-height:400px;'></div>
    </div> -->
    <div class='col-6'>
        <div class='row tar_clientes' hidden>

        </div>
        <div id='chart_servicios' style='min-height:300px;'></div>
        <!-- <div id='chart_servicios_grupos' style='min-height:300px;'></div> -->
    </div>
    <div class='col-md-6 col-12'>
        <div class='row' id="cartas_serv">

        </div>
    </div>
</div>

<div class='row mt-3'>
    <div class='col-12'>
        <table class='display table' id='tableServicios' style="width:100%">
            <thead>
                <th>FOLIO</th>
                <th>TIPO SERV.</th>
                <th>NUM UNIDAD</th>
                <th>CLIENTE</th>
                <th>LOTE</th>
                <th>PRODUCTO</th>
                <th>ROTULO</th>
                <th>CANTIDAD</th>
                <th>FECHA INICIO</th>
                <th>USUARIO INICIO</th>
                <th>FECHA FIN</th>
                <th>USUARIO FIN</th>
                <th>TIEMPO INVERTIDO</th>
                <th>TARIMAS</th>
                <th>PARCIAL</th>
                <th>BARREDURA SUCIA</th>
                <th>BARREDURA LIMPIA</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>