<script src='<?php echo URL; ?>assets/js/charts/echarts/echarts.js' type='text/javascript'></script>

<div class='row'>
    <div class='col-6'>
        <div class='row'>
            <div class='col-12'>
                <?php require_once views_root . 'widgets/entradas_patio.php'; ?>
            </div>

            <div class='col-12'>
                <?php require_once views_root . 'widgets/ensacados.php'; ?>
            </div>
        </div>

    </div>
    <div class='col-6'>
        <div class='row'>
            <div class='col-12'>
                <?php require_once views_root . 'widgets/almacenaje_naves.php'; ?>
            </div>
            <div class='col-12'>
                <?php require_once views_root . 'widgets/ordenes_compra.php'; ?>
            </div>
            <div class='col-12'>
                <?php require_once views_root . 'widgets/facturacion.php'; ?>
            </div>
        </div>

    </div>
</div>