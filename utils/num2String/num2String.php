<?php

require_once base.'/composer/vendor/autoload.php';
use Luecano\NumeroALetras\NumeroALetras;

class Num2String {
    
    
    public static function moneyToString($number, $moneda){
        $string = new NumeroALetras();
        $string->conector = $moneda['nomMayus'];
        return $string->toInvoice($number, 2, $moneda['letra']);
    }
}
