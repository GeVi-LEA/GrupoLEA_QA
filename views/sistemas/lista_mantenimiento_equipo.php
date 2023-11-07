
<div class="row mt-1 req-estados">
    <div class="col-12 text-center"><h5>Mantenimientos de equipos</h5></div>
</div>

<section class="sec-tabla text-center">
    <?php if (!empty($equipos)): ?>
        <table class="table table-condensed tabla-registros" id="tablaRegistros">
            <thead>
            <th>Modelo</th>
            <th>Tipo equipo</th>
            <th>Marca</th>
            <th>Num. serie</th>
            <th>Asignado a</th>
            <th>Departamento</th>
            <th>Fecha mantenimiento</th>
            <th></th>
            </thead>
            <tbody>
              
                <?php foreach ($equipos as $e): ?>
                    <?php if($e->usuario_id == $_SESSION['usuario']->id || Utils::isSistemas()):?>
                    <tr class="tr">
                        <td hidden id="idEquipo"><?= $e->id; ?></td>
                        <td ><?= $e->modelo; ?></td>
                        <td ><?= equipos_sistemas[$e->tipo_equipo]; ?></td>
                        <td ><?= marcas_sistemas[$e->marca]; ?></td>
                        <td ><?= $e->numero_serie; ?></td>
                        <td ><?= $e->usuario; ?></td>
                        <td ><?= $e->departamento; ?></td>
                        <td><?= $e->fecha_mantenimiento == '' ? '' : date('d/m/Y', strtotime($e->fecha_mantenimiento))?></td>
                        <td> 
                            <div class="text-right">
                                 <?php if(Utils::isSistemas()):?>
                                    <?php if($e->solicitud):?>
                                    <span class="far fa-calendar-check  material-icons i-excel mr-4" title="Folio solicitud de servicio <?= $e->folio;?>"></span>
                                  <?php else :?>
                                    <span class="fas fa-exclamation-triangle material-icons i-edit mr-4" id="btnMantenimiento" title="Realizar solicitud de servicio"></span>
                                  <?php endif ;?>
                                 <?php endif ;?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <span>No hay equipos pendientes por mantenimiento.</span>                   
    <?php endif; ?>
</section>
           
 <script src="../sistemas/assets/js/sistemas.js"></script> 