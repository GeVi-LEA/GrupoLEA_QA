<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/material-icons/css/material-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= root_url ?>views/compras/assets/css/formatos.css" />
    <link rel="stylesheet" href="<?= root_url ?>assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= root_url ?>assets/css/jquery-confirm.css">
    <script src="<?= root_url ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= root_url ?>assets/js/jquery-confirm.js"></script>
    <script src="<?= root_url ?>views/compras/assets/js/formatos.js"></script>
    <title>Requisición</title>
</head>

<body>
    <div class="contenedor">
        <div class="titulo-empresa">
            <div>
                <img src="<?= root_url ?>assets/img/default.jpg" />
            </div>
            <div>
                <strong><?= isset($empresa) ? $empresa['nombre'] : '' ?></strong>
                <p><?= isset($empresa) ? $empresa['direccion'] : '' ?></p>
                <p><?= isset($empresa) ? $empresa['estado'] . ' C.P. ' . $empresa['cp'] : '' ?></p>
                <p>R.F.C.: <?= isset($empresa) ? $empresa['rfc'] : '' ?></p>
                <p>TEL/FAX.- <?= isset($empresa) ? $empresa['tel'] : '' ?></p>
            </div>
            <div class="menu-iconos">
                <span id="imprimirReq" title="Imprimir requisición" class="material-icons i-print">print</span>
            </div>
        </div>
        <div class="div-folio-titulo">
            <div class="div-folio">
                <strong>Folio:</strong>
                <span><?= isset($r) && $r['folio'] != '' ? $r['folio'] : ''; ?></span>
            </div>
            <div class="titulo-doc">
                <strong>REQUISICIÓN DE MATERIALES Y/O SERVICIOS</strong>
            </div>
        </div>
        <div class="datos-doc">
            <div class="fila-datos">
                <div class="border-r-db border-b-db">
                    <label class="pt-10 pl-10">PROVEEDOR SELECCIONADO:</label>
                </div>
                <div class="celda-datos border-r-db border-b-db">
                    <div class="border-r w-50"><label class="pt-10 pl-10">O.C. ASIGNADA:</label></div>
                    <div class="w-50"><span class="pt-10 pl-10"><?= isset($r) && $r['folio_oc'] != '' ? $r['folio_oc'] : ''; ?></span></div>
                </div>
                <div class="celda-datos border-b-db">
                    <div class="w-20 border-r"><label class="pt-2 pl-3">FECHA DE SOLICITUD:</label></div>
                    <div class="w-30 border-r"><span class="pt-10 pl-10"><?= isset($r) && $r['fecha_solicitud'] != '' ? date('d/m/Y', strtotime($r['fecha_solicitud'])) : ''; ?></span></div>
                    <div class="w-20 border-r"><label class="pt-2 pl-3">FECHA REQUERIDA:</label></div>
                    <div class="w-30"><span class="pt-10 pl-10"><?= isset($r) && $r['fecha_requerida'] != '' ? date('d/m/Y', strtotime($r['fecha_requerida'])) : ''; ?></span></div>
                </div>
            </div>
            <div class="fila-datos">
                <div class="border-r-db border-b-db"><span class="pt-10 pl-10"><?= isset($r) ? $r['proveedor'] : ''; ?></span></div>
                <div class="celda-datos border-r-db border-b-db">
                    <div class="border-r w-50"><label class="pt-10 pl-10">DEPARTAMENTO:</label></div>
                    <div class="w-50"><span class="pt-10 pl-10"><?= isset($r) ? $r['departamento'] : ''; ?></span></div>
                </div>
                <div class="celda-datos border-b-db">
                    <div class="w-20 border-r"><label class="pl-3">ASIGNADO A(NOMBRE):</label></div>
                    <div><span class="pt-10 pl-10"><?= isset($r) ? $r['usuario'] : ''; ?></span></div>
                </div>
            </div>
            <div class="fila-datos">
                <div class=" celda-datos border-r-db ">
                    <div class="w-40"><label class="pt-10 pl-10">COMPRA URGENTE:</label></div>
                    <div class="w-10 border-r"><label class="pt-10 pl-15">SI</label></div>
                    <div class="w-10 border-r"><span class="pt-10 pl-15"><?= (isset($r) && $r['urgente'] == 'S' ? 'X' : ''); ?></span></div>
                    <div class="w-10 border-r"><label class="pt-10 pl-10">NO</label></div>
                    <div class="w-10 border-r"><span class="pt-10 pl-15"><?= (isset($r) && $r['urgente'] == 'N' ? 'X' : ''); ?></span></div>
                </div>
                <div class="celda-datos border-r-db">
                    <div class="border-r w-50"><label class="pt-10 pl-10">N° PROYECTO:</label></div>
                    <div class="w-50"><span class="pt-10 pl-10"><?= isset($r) ? $r['num_proyecto'] : ''; ?></span></div>
                </div>
                <div class="celda-datos">
                    <div class="w-20 border-r"><label class="pt-3 pl-3">NOMBRE PROYECTO:</label></div>
                    <div><span class="pt-10 pl-10"><?= isset($r) ? $r['proyecto'] : ''; ?></span></div>
                </div>
            </div>
        </div><!-- datos -->
        <div class="titulos-detalles">
            <div class="border-r"><label>DESCRIPCION DEL MATERIAL, EQUIPO Y/O SERVICIO:</label></div>
            <div class="border-r"><label>UNIDAD</label></div>
            <div class="border-r"><label>CANTIDAD SOLICITADA</label></div>
            <div><label>PRECIO UNITARIO MAS IVA(Cuando sea necesario)</label></div>
        </div>
        <div class="detalles-doc">
            <?php if (isset($r)): ?>
            <?php foreach ($r['detalle'] as $d): ?>
            <div class="border-b fila-detalle">
                <div class="border-r"><span><?= $d['descripcion']; ?></span></div>
                <div class="border-r"><span><?= Utils::getNombreUnidad(intval($d['unidad_id'])); ?></span></div>
                <div class="border-r"><span><?= UtilsHelp::numero2Decimales($d['cantidad']); ?></span></div>
                <div class=""><span><?= UtilsHelp::numero2Decimales($d['precio_unitario'], true) ?> <?= (($r['moneda'] === '1') ? 'MXN' : 'USD') ?></span></div>
            </div>
            <?php endforeach ?>
            <?php for ($i = 1; $i <= 11 - count($r['detalle']); $i++): ?>
            <div class="border-b fila-detalle">
                <div class="border-r"></div>
                <div class="border-r"></div>
                <div class="border-r"></div>
                <div class=""></div>
            </div>
            <?php endfor; ?>
            <div class="observaciones-doc">
                <div class="border-r d-flex"><label>OBSERVACIONES:</label></div>
                <div><span><?= (isset($r) ? $r['observaciones'] : ''); ?> </span></div>
            </div>
            <?php else: ?>
            <?php for ($i = 1; $i <= 11; $i++): ?>
            <div class="border-b fila-detalle">
                <div class="border-r"></div>
                <div class="border-r"></div>
                <div class="border-r"></div>
                <div class=""></div>
            </div>
            <?php endfor; ?>
            <div class="observaciones-doc">
                <div class="border-r d-flex"><label>OBSERVACIONES:</label></div>
                <div><span></span></div>
            </div>
            <?php endif; ?>
        </div>
        <input type="hidden" id="estatusReq" value="<?= isset($r) ? $r['estatus_id'] : ''; ?>">
        <div class="firmas-doc">
            <div><span class="pl-15">Nota: Solicitud que no se apegue a este formato no se tramitará.</span> </div>
            <form method="POST" action="<?= root_url ?>?controller=Compras&action=firmarReqisicion">
                <input type="hidden" id="idReq" name="idReq" value=" <?= isset($r) ? $r['id'] : ''; ?>" />
                <div class="firmas" id="firmas">
                    <div class="firma">
                        <?php if (isset($firmas) && $firmas['firma1'] == 0): ?>
                        <div>
                            <input type="radio" name="firmas" value="1" id="firmas1" /> <label for="firmas1">Agregar firma</label>
                            <input type="hidden" name="firma1" value="0" />
                        </div>
                        <?php else: ?>
                        <div hidden id="radioFirma" class="img-firma">
                            <input type="radio" name="firmas" value="1" id="firmas1" /> <label for="firmas1">Agregar firma</label>
                            <input type="hidden" name="firma1" value="0" />
                        </div>
                        <span class="material-icons i-clear icons" id="clear" title='Eliminar firma'>clear</span>
                        <div id="imgFirma"><img class="img-firma" src="<?= root_url ?>/views/catalogos/uploads/imgFirmasUsuarios/<?= Utils::getFirmaUser($firmas['firma1']) ?>" /></div>
                        <input id="valorFirma" type="hidden" name="firma1" value="<?= $firmas['firma1'] ?>" />
                        <p id="NombreFirma">
                            <?php echo Utils::getUsuarioNombre($firmas['firma1'])->nombrecompleto; ?>
                        </p>
                        <?php endif ?>
                        <p class="border-t">Nombre y firma</p>
                        <p>Solicitante</p>
                    </div>
                    <div class="firma">
                        <?php if (isset($firmas) && $firmas['firma2'] == 0 && Utils::isFirmas()): ?>
                        <div>
                            <input type="radio" name="firmas" value="2" id="firmas2" /> <label for="firmas2">Agregar firma</label>
                            <input type="hidden" name="firma2" value="0" />
                        </div>
                        <?php else: ?>
                        <div hidden id="radioFirma" class="img-firma">
                            <input type="radio" name="firmas" value="2" id="firmas2" /> <label for="firmas2">Agregar firma</label>
                            <input type="hidden" name="firma2" value="0" />
                        </div>
                        <?php if (Utils::isFirmas()): ?>
                        <span class="material-icons i-clear icons" id="clear" title='Eliminar firma'>clear</span>
                        <?php endif; ?>
                        <div id="imgFirma">
                            <?php if ($firmas['firma2'] != 0): ?>
                            <img class="img-firma" src="<?= root_url ?>views/catalogos/uploads/imgFirmasUsuarios/<?= Utils::getFirmaUser($firmas['firma2']) ?>" />
                            <?php endif; ?>
                        </div>
                        <input id="valorFirma" type="hidden" name="firma2" value="<?= $firmas['firma2'] ?>" />
                        <p id="NombreFirma">
                            <?php echo Utils::getUsuarioNombre($firmas['firma2'])->nombrecompleto; ?>
                        </p>
                        <?php endif ?>
                        <p class="border-t">Nombre y firma</p>
                        <p>Compras</p>
                    </div>
                    <div class="firma">
                        <?php if (isset($firmas) && $firmas['firma3'] == 0 && Utils::isGerente()): ?>
                        <div>
                            <input type="radio" name="firmas" value="3" id="firmas3" /> <label for="firmas3">Agregar firma</label>
                            <input type="hidden" name="firma3" value="0" />
                        </div>
                        <?php else: ?>
                        <div hidden id="radioFirma" class="img-firma">
                            <input type="radio" name="firmas" value="3" id="firmas3" /> <label for="firmas3">Agregar firma</label>
                            <input type="hidden" name="firma3" value="0" />
                        </div>
                        <?php if (Utils::isGerente()): ?>
                        <span class="material-icons i-clear icons" id="clear" title='Eliminar firma'>clear</span>
                        <?php endif; ?>
                        <div id="imgFirma">
                            <?php if ($firmas['firma3'] != 0): ?>
                            <img class="img-firma" src="<?= root_url ?>views/catalogos/uploads/imgFirmasUsuarios/<?= Utils::getFirmaUser($firmas['firma3']) ?>" />
                            <?php endif; ?>
                        </div>
                        <input id="valorFirma" type="hidden" name="firma3" value="<?= $firmas['firma3'] ?>" />
                        <p id="NombreFirma">
                            <?php echo Utils::getUsuarioNombre($firmas['firma3'])->nombrecompleto; ?>
                        </p>
                        <?php endif; ?>
                        <p class="border-t">Nombre y firma</p>
                        <p>Gerente general</p>
                    </div>
                    <?php if (!($r['estatus_id'] == 5)): ?>
                    <div class="firma">
                        <input class="btn-firma" id="btnFirma" type="submit" value="Firmar" />
                    </div>
                    <?php endif; ?>
                </div>
            </form>
            <div class="clave-doc"><span><?= $doc != null ? $doc->codigo . ' / Ver. ' . $doc->revision : 'Documento sin registrar' ?></span></div>
        </div>
    </div>
</body>

</html>