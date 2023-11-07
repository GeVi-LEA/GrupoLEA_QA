<?php

class errorController {

    public function index() {
        echo "<h1> La pagina no existe </h1>";
    }

    public function noLoggin() {
        $inicio = root_url;
     require_once views_root.'errores/noLoggin.php' ;
    }
    
    public function errorNoEvaluacionesProveedores() {
     require_once views_root.'errores/no_evaluaciones_proveedor.php' ;
    }

}
