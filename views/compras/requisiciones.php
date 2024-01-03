<?php
include 'assets/js/requisiciones_js.php';
?>

<script src='<?php echo URL; ?>assets/js/charts/echarts/echarts.js' type='text/javascript'></script>
<!-- <link rel="stylesheet" href="<?php echo URL; ?>assets/libs/datatables/datatables.min.css"> -->
<!-- <script src="<?php echo URL; ?>assets/libs/datatables/datatables.min.js"></script> -->
<style>
.tablaexport {
    visibility: hidden;
}
</style>

<br />
<div class='row'>
    <div class='col-12'>
        <div class='card sombra'>
            <div class='card-content'>
                <div class='card-body'>
                    <!-- <p>Seleccione el filtro de inventario segun su necesidad </p> -->
                    <div class='row'>
                        <div class='col-3' style="display:none">
                            <label for='cmbClientes'>
                                Seleccione los clientes deseados
                                <select id='cmbClientes' name='clientessel[]' multiple='multiple' aria-hidden='true' style='width: 75%'>

                                </select>
                            </label>
                        </div>
                        <div class='col-5'>
                            <label for='cmbProveedores'>
                                Seleccione los proveedores deseados
                                <select id='cmbProveedores' name='proveedoressel[]' multiple='multiple' aria-hidden='true' style='width: 100%'>

                                </select>
                            </label>
                        </div>
                        <div class='col-4'>
                            <div class='row'>
                                <div class="col-12">
                                    <label for="fechaReporteF">Rango de fechas</label>
                                    <div class='row'>
                                        <div class='col'>
                                            <div class="mb-3 row">
                                                <!-- <label for="fechaReporteF" class="col-2 col-form-label">Desde:</label> -->
                                                <div class="col-10">
                                                    <div class="input-group mb-3" style="width: 150px;">
                                                        <input type="text" id="fechaReporteF" name="fechaReporteF" class="form-control" placeholder="Desde">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col'>
                                            <div class="mb-3 row">
                                                <!-- <label for="fechaReporteT" class="col-sm-2 col-form-label">Hasta:</label> -->
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-3" style="width: 150px;">
                                                        <input type="text" id="fechaReporteT" name="fechaReporteT" class="form-control" placeholder="Hasta">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class='col-md-1 col-12'>
                            <button type="button" class="btn btn-success mt-4" data-toggle="tooltip" title="Nueva Requisición">
                                <i class="fa-solid fa-circle-plus" data-toggle="tooltip" title="Nueva Requisición" onclick="viewReq()"></i>
                            </button>
                        </div>
                        <div class='col-md-2 col-12' style="display:none">
                            <!-- class = 'mt-4 btn btn-success btn-min-width mr-1 mb-1' -->
                            <button type='button' id='btnExcelInventario' class='mt-4 btn btnExcel' onclick="$('.buttons-excel').trigger('click')" data-toggle='tooltip' data-placement='top'
                                title='Exportar Inventario a Excel'>
                                Excel</button>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-5'>
                            <div class='tab-pane container active' style='' id='requisiciones' role='tabpanel' aria-labelledby='requisiciones-tab'>
                                <div id='chart_requisiciones' style='min-height:80vh;  padding:50px'></div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <div class='row'> -->
                        <div class='col-7'>
                            <h1 id="tituloestatus" style="border-radius: 10px; text-align: center; padding: 10px;"></h1>
                            <div id="div_tabla">
                                <table id="tabla_estatus" class='stripe' style='width:100%'>
                                    <thead>
                                        <th hidden>id</th>
                                        <th>FOLIO</th>
                                        <th>PROVEEDOR</th>
                                        <th>ESTATUS</th>
                                        <th>FECHA REQUERIDA</th>
                                        <th>FIRMAS</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>











<!-- Cotización modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalCotizacion">
    <div class="modal-dialog m-dialog">
        <div class="modal-content m-content" id="viewCot">
            <div class="modal-header m-header">
                <h5 class="modal-title" id="tituloCotizacion"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class='row tablaexport' hidden>
    <table class='table' id='tableInventario'>
        <thead>
            <th>Nombre del Cliente</th>
            <th>Almacen</th>
            <th>Producto</th>
            <th>Lote</th>
            <th>Cant. Disponible</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>