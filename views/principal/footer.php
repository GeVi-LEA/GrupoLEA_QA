         </div>
         
                     <!-- Directorio modal -->
            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDirectorio">
                <div class="modal-dialog m-dialog">
                    <div class="modal-content m-content">
                        <div class="modal-header m-header">
                            <h3 class="modal-title"><i class="fas fa-address-book icono-directorio i-catalogo"></i>Directorio</h3>
                            <button type="button" class="close i-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="border-modal modal-body">
                            <form class="d-flex flex-column align-items-center">
                                <div class="input-group form-group w-75">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text iconos"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" maxlength="30"  placeholder="Buscar nombre..." id="buscarDirectorio">
                                </div>
                            </form>
                           <div class="d-flex flex-column align-items-center">
                            <div class="sec-tabla-modal wdt-90 ">
                            <table class="table tabla-directorio" id="tablaDirectorio">
                              <thead class="text-left">
                               <th>Nombre</th>
                               <th>Correo</th>
                               <th>Telefono</th>
                               </thead>
                                  <?php
                                    $directorio = Utils::getDirectorio();
                                    if (!empty($directorio)):
                                        foreach ($directorio as $contacto):
                                            ?>
                                    <tr><td><?=$contacto->nombre?></td><td><?=$contacto->correo?></td><td><?=$contacto->telefono?></td></tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                           </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
                     

<footer class="footer justify-self-end">
    <p>
        <span>&copy; <?php echo date('Y') ?> Grupo LEA de M&eacute;xico</span> <span> <a href="http://leademexico.com" target="_blank"> leademexico.com</a></span> <span>Todos los derechos reservados.</span>
    </p>
</footer>
        </div>
    </body>
        <script src="../../assets/js/popper.min.js"></script>
        <script src="../../assets/js/funciones.js"></script>
</html>

