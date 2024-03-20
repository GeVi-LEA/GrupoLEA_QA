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

tr:nth-child(even) {
    background-color: #D6EEEE;
}

td {
    padding: 5px;
}


th {
    padding: 10px;
    background-color: #3a57e8;
    border: solid #3a57e8;
    color: white;
    border-radius: 10px;
    padding: auto;
}

tr {
    border-bottom: 1px solid #ddd;
}
</style>

<div style="font-family: Arial; text-align:center; margin: 0" class="contenedor">
    <table style="width:100%; margin-left:10px; height:90px; border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:20%; padding-left:30px;">
                    <div><img style="height:80px; opacity: .8;" src="<?= root_url ?>/assets/img/default.jpg" /></div>
                </td>
                <td style="width:90%; font-family: Arial; text-align: center;">
                    <strong style="font-size: 28px; font-weight: bold">LEADER DE LUBRICANTES DE MÉXICO S. DE R.L. DE C.V.</strong>
                </td>
                <!-- <td style="width:20%; height:90px;"></td> -->
            </tr>
    </table>
    <br />
    <table style='margin-left:10px; width:100%; '>
        <tr style='border:solid 2px; border-radius:20px; '>
            <th>FOLIO</th>
            <th>NUM UNIDAD</th>
            <th style="width:200px;">CLIENTE</th>
            <th>LOTE</th>
            <th>PRODUCTO</th>
            <th>ROTULO</th>
            <th>CANTIDAD</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>TARIMAS</th>
            <th>PARCIAL</th>
            <th>BARREDURA SUCIA</th>
            <th>BARREDURA LIMPIA</th>
        </tr>
        <!-- <tbody> -->
        <?php
            for ($x = 0; $x < count($s); $x++) {
                // print_r('<pre>');
                // print_r($s[$x]);
                // print_r('</pre>');
                echo '<tr>';
                echo '<td>' . $s[$x]['folio'] . '</td>';
                echo '<td>' . $s[$x]['numUnidad'] . '</td>';
                echo '<td nowrap>' . $s[$x]['nom_cliente'] . '</td>';
                echo '<td>' . $s[$x]['lote'] . '</td>';
                echo '<td>' . $s[$x]['nom_prod'] . '</td>';
                echo '<td>' . $s[$x]['alias'] . '</td>';
                echo '<td>' . $s[$x]['cantidad'] . '</td>';
                echo '<td nowrap>' . $s[$x]['fecha_inicio'] . '</td>';
                echo '<td nowrap>' . $s[$x]['fecha_fin'] . '</td>';
                echo '<td>' . $s[$x]['tarimas'] . '</td>';
                echo '<td>' . $s[$x]['parcial'] . '</td>';
                echo '<td>' . $s[$x]['barredura_sucia'] . '</td>';
                echo '<td>' . $s[$x]['barredura_limpia'] . '</td>';
                // echo '<td>' . $s[$x]['numUnidad'] . '</td>';
                echo '</tr>';
            }

        ?>
        <!-- </tbody> -->
    </table>

</div>