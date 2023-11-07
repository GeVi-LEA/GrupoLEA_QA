<?php
// include_once( '/assets/app.min.css' );
require_once views_root . 'home/assets/app.css.php';
require_once views_root . 'home/assets/app.js.php';
require_once views_root . 'home/assets/permisos.js.php';

?>
<!-- <script src = '../servicios/assets/js/servicios.js'></script> -->

<div class='row menuflex'>
    <div class='col-12'>
        <?php if (Utils::permisosVigilancia()): ?>
        <div class='row grupo guardia'>
            <div class='col col-6 '>
                <div class='card sombra btn-Alta'>
                    <div class='card-content'>
                        <div class='card-body p-0'>
                            <div class='row'>
                                <div class='col-12'>
                                    <i id='entradaSalida1' title='Entrada / Salida' class='i-clip material-icons fa-solid fa-file-circle-plus'></i>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-12'>
                                    <span>Alta</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col col-6 '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=listaUnidades&idEst=1'>
                    <div class='card sombra btn-Transito'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Transito_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0' style='color:yellow'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='fa-solid fa-arrow-right-arrow-left material-icons i-transit btn-icon pr-1 mr-1'></span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Tránsito</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class='col col-6 '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=listaUnidades&idEst=8'>
                    <div class='card sombra btn-Ingresar'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Ingresar_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='fa-solid fa-truck-arrow-right material-icons i-iniciar btn-icon pr-1'></span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Ingresar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class='col col-6 '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=listaUnidades&idEst=15'>
                    <div class='card sombra btn-Liberacion'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Liberacion_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='fa-solid fa-truck-arrow-right rotarHorizontal material-icons i-liberacion btn-icon  pr-1'></span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Liberación</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endif ?>
        <?php if (Utils::permisosBascula()): ?>
        <div class='row grupo bascula'>
            <div class='col col-6 '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=listaUnidades&idEst=11&PesoPend=1'>
                    <div class='card sombra btn-Pesaje'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Pesaje_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <!-- <i id = 'entradaSalida' title = 'Entrada / Salida' class = 'i-clip material-icons fa-solid fa-file-circle-plus'></i> -->
                                        <i class='fa-solid fa-weight-scale material-icons'></i>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Pesaje</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endif ?>
        <?php if (Utils::permisosAlmacen()): ?>
        <div class='row grupo almacen'>
            <div class='col col-6  '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=appEnsacado'>
                    <div class='card sombra btn-Ensacado'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Ensacado_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <i class='mdi mdi-sack material-icons'></i>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Descarga</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class='col col-6  '>
                <a href='<?= principalUrl ?>?controller=Servicios&action=appCargas'>
                    <div class='card sombra btn-Carga'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Carga_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='material-symbols-outlined material-icons'>
                                            forklift
                                        </span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Carga</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class='col col-6  ' style="display:none;">
                <a href='<?= principalUrl ?>?controller=Servicios&action=listaUnidades&idEst=14'>
                    <div class='card sombra btn-Salida'>
                        <span class="badge buttonAnimation" data-animation="jello" id="Salida_badge"></span>
                        <div class='card-content'>
                            <div class='card-body p-0'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='fa-solid fa-truck-arrow-right rotarHorizontal material-icons i-salida btn-icon  pr-1'></span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span>Finalizar Servicios</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <?php endif ?>
    </div>
</div>