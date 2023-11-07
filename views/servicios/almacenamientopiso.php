<?php
include 'assets/js/almacenamientopiso_js.php';
?>

<script src='<?php echo URL; ?>assets/js/charts/echarts/echarts.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/libs/datatables/datatables.min.css">
<script src="<?php echo URL; ?>assets/libs/datatables/datatables.min.js"></script>
<style>
.tablaexport {
    visibility: hidden;
}
</style>

<script>
eltitulo = 'Inventario de productos';
menusel = 'almacenamientoPiso';
</script>
<br />
<div class='row'>
    <div class='col-12'>
        <div class='card sombra'>
            <!-- <div class = 'card-header'>
<h4 class = 'card-title'>Inventarios</h4>
</div> -->
            <div class='card-content'>
                <div class='card-body'>
                    <!-- <p>Seleccione el filtro de inventario segun su necesidad </p> -->
                    <div class='row'>
                        <div class='col-6'>
                            <label for='cmbClientes'>
                                Seleccione los clientes deseados
                                <select id='cmbClientes' name='clientessel[]' multiple='multiple' aria-hidden='true' style='width: 75%'>

                                </select>
                            </label>
                        </div>
                        <div class='col-md-6 col-12'>
                            <!-- class = 'mt-4 btn btn-success btn-min-width mr-1 mb-1' -->
                            <button type='button' id='btnExcelInventario' class='mt-4 btn btnExcel' onclick="$('.buttons-excel').trigger('click')" data-toggle='tooltip' data-placement='top'
                                title='Exportar Inventario a Excel'>
                                Excel</button>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-12'>

                            <ul class='nav nav-tabs nav-pills nav-fill' id='InventariosTab' role='tablist'>
                                <li class='nav-item'>
                                    <a class='nav-link active' id='productos-tab' data-toggle='tab' href='#productos' role='tab' aria-controls='productos' aria-selected='true'>Por Productos</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' id='lotes-tab' data-toggle='tab' href='#lotes' role='tab' aria-controls='lotes' aria-selected='false'>Por Lotes</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' id='naves-tab' data-toggle='tab' href='#naves' role='tab' aria-controls='naves' aria-selected='false'>Por Nave</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class='tab-content'>
                                <div class='tab-pane active' id='productos' role='tabpanel' aria-labelledby='productos-tab'>
                                    <div id='chart_productos' style='min-height:400px;'></div>
                                </div>
                                <div class='tab-pane' id='lotes' role='tabpanel' aria-labelledby='lotes-tab'>
                                    <div id='chart_lotes' style='min-height:400px;'></div>
                                </div>
                                <div class='tab-pane' id='naves' role='tabpanel' aria-labelledby='naves-tab'>
                                    <div id='chart_nave' style='min-height:400px;'></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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