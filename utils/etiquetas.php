<?php

require_once base.'/composer/vendor/autoload.php';

class Etiquetas{
    
    public static function GenerarEtiquetaServicio(){
     $etiqueta = new Picqer\Barcode\BarcodeGeneratorJPG(); 
     
    echo $etiqueta->getBarcode('081231723897', $generator::TYPE_CODE_128);
}


    
    
    
}