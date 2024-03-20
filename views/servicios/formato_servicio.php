<style>
@page {
    margin-top: .5cm;
    margin-bottom: .5cm;
    margin-left: 1.5cm;
    margin-right: 1.5cm;
    font-family: Arial;
}

.contenedor {
    width: 1200px;
    height: 900px;
}

p {
    font-size: 13px;
    padding: 0;
    margin: 0;
}

strong {
    font-family: Arial;
}

span {
    font-family: Arial;
}
</style>

<div style="font-family: Arial; text-align:center; margin: 0" class="contenedor">
    <table style="width:100%; margin-left:20px; border-radius:20px; height:90px; border-top:2px solid; border-bottom:2px solid; border-left:2px solid; border-right: 2px solid; border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:20%; padding-left:30px;">
                    <div><img style="height:80px; opacity: .8;" src="<?= root_url ?>/assets/img/default.jpg" /></div>
                </td>
                <td style="width:80%; font-family: Arial; text-align: center;">
                    <!-- <strong style="font-size: 18px; font-weight: bold"><?= isset($empresa) ? $empresa['nombre'] : '' ?></strong> -->
                    <strong style="font-size: 18px; font-weight: bold">LEADER DE LUBRICANTES DE MÉXICO S. DE R.L. DE C.V.</strong>
                </td>
                <!-- <td style="width:20%; height:90px;"></td> -->
            </tr>
    </table>
    <br />
    <table style="margin-left:20px; width:100%; height:400px; font-family:Arial; border-collapse:collapse; border-left:2px solid; border-top:2px solid; border-bottom:2px solid; border-right:2px solid;">
        <tbody>
            <tr style="width:100%; height:35px; font-size:16px;">
                <td colspan=5 style="text-align: center; height:35px; border-bottom:2px solid"><strong>DATOS CONTROL</strong></td>
            </tr>
            <tr style="width:100%; height:25px; font-size:16px;">
                <td style="width:25%; height:25px; border-right:1px solid; border-left:1px solid; text-align:left; padding-left:10px; border-bottom:1px solid;"><strong style="font-size:12px;">Cliente:</strong></td>
                <td colspan=4 style="width:85%; height:25px; text-align: left; padding-left:10px; border-bottom:1px solid;"> <span style="font-size:12px;"><?= isset($s) && $s->cliente != '' ? $s->cliente : ''; ?></span>
                </td>
            </tr>
            <tr style="width:100%; height:25px;">
                <td style="height:25px; border-bottom:1px solid; border-right:1px solid; text-align:center;"><strong style="font-size:12px;">No. Carro:</strong></td>
                <td style="height:25px; border-bottom:1px solid; text-align: center;"> <strong style="font-size:12px;">Fecha entrada:</strong></td>
                <td style="height:25px; border-bottom:1px solid; border-right:1px solid; border-left:1px solid; text-align:center;"><strong style="font-size:12px;">Fecha salida:</strong></td>
                <td style="height:25px; border-bottom:1px solid; text-align: center;"> <strong style="font-size:12px;">Vigente:</strong></td>
                <td style="height:25px; border-bottom:1px solid; border-left:1px solid; text-align:center; "><strong style="font-size:12px;">Días transcurridos:</strong></td>
            </tr>
            <tr style="width:100%; height:25px;">
                <td style="height:25px;  border-bottom:2px solid; border-right:1px solid; text-align:center;"><span style="font-size:12px;"><?= isset($s) && $s->unidad != '' ? $s->unidad : ''; ?></span></td>
                <td style="height:25px;  border-bottom:2px solid; border-right:1px solid; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->unidad != '' ? ($s->fechaEntrada) : ''; ?></span></td>
                <td style="height:25px;  border-bottom:2px solid; border-right:1px solid; text-align:center;"><span style="font-size:12px;"><?= isset($s) && $s->fechaSalida != '' ? UtilsHelp::fechaHora($s->fechaSalida) : ''; ?></span></td>
                <td style="height:25px;  border-bottom:2px solid; border-right:1px solid; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->fechaSalida != '' ? 'NO' : 'SI'; ?></span></td>
                <td style="height:25px;  border-bottom:2px solid; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->transcurridos != '' ? $s->transcurridos : ''; ?></span></td>
            </tr>
            <tr style="width:100%; height:35px; font-size:16px;">
                <td colspan=5 style="text-align: center; height:35px; border-bottom:2px solid"><strong>REPORTE DE ENSACADO</strong></td>
            </tr>
            <tr style="width:100%; height:25px; font-size:16px;">
                <td colspan=2 style="width:50%; height:25px; border-right:1px solid; border-left:1px solid; text-align:left; padding-left:10px; border-bottom:1px solid;"></td>
                <td style="width:25%; height:25px; border-right:1px solid; border-left:1px solid; text-align:left; padding-left:10px; border-bottom:1px solid;"><strong style="font-size:12px;">Fecha:</strong></td>
                <td colspan=3 style="width:25%; height:25px; text-align: left; padding-left:10px; border-bottom:1px solid;"> <span style="font-size:12px;"><?= isset($s) && $s->fecha_programacion != '' ? UtilsHelp::formatoFecha($s->fecha_programacion) : ''; ?></span></td>
            </tr>
            <tr style="width:100%; height:25px;">
                <td style="height:25px; border-bottom:1px solid; border-right:1px solid; text-align:center;"><strong style="font-size:12px;">Tipo:</strong></td>
                <td style="height:25px; border-bottom:1px solid; text-align: center;"> <strong style="font-size:12px;">Lote:</strong></td>
                <td style="height:25px; border-bottom:1px solid; border-right:1px solid; border-left:1px solid; text-align:center;"><strong style="font-size:12px;">Tarimas:</strong></td>
                <td style="height:25px; border-bottom:1px solid; text-align: center;"> <strong style="font-size:12px;">Bultos:</strong></td>
                <td style="height:25px; border-bottom:1px solid; border-left:1px solid; text-align:center; "><strong style="font-size:12px;">Total: KG.</strong></td>
            </tr>
            <tr style="width:100%; height:25px;">
                <td style="height:25px; border-right:1px solid; text-align:center;"><span style="font-size:12px;"><?= isset($s) && $s->nombre_producto != '' ? $s->nombre_producto : ''; ?></span></td>
                <td style="height:25px; border-right:1px solid; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->lote != '' ? $s->lote : ''; ?></span></td>
                <td style="height:25px; border-right:1px solid; text-align:center;"><span style="font-size:12px;"><?= isset($s) && $s->tarimas != '' ? $s->tarimas : ''; ?></span></td>
                <td style="height:25px; border-right:1px solid; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->bultos != '' ? $s->bultos : ''; ?></span></td>
                <td style="height:25px; text-align: center;"> <span style="font-size:12px;"><?= isset($s) && $s->total_ensacado != '' ? UtilsHelp::numero2Decimales($s->total_ensacado) : ''; ?></span></td>
            </tr>
        </tbody>
    </table>
    </tbody>
</div>