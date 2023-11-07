<?php

require_once base.'/composer/vendor/autoload.php';
class PDF{
  
    public static function crearPdfRequisicion($r, $doc, $mostrar = false){   
        $empresa = empresas[intval($r['empresa'])];
        
            if ($r['firmas'] != null) {
                $firmas = array();
                $firmas = json_decode($r['firmas'], TRUE);
            }else{
                 $firmas = array(
                    "firma1" => 0,
                    "firma2" => 0,
                    "firma3" => 0
                );
            }
        $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L','tempDir' => '/tmp']);
        ob_start();
        require_once views_root.'compras/formato_req_imprimir.php';

        $html = ob_get_clean();

        ob_end_clean();
        $pdf->writeHTML($html);
        if (!is_dir(views_root . 'compras/requisiciones')) {
            mkdir(views_root . 'compras/requisiciones', 0777, true);
        }
        if (file_exists(views_root . 'compras/requisiciones/' . $r['folio'] . '.pdf')) {
            unlink(views_root . 'compras/requisiciones/' . $r['folio'] . '.pdf');
        }
        $pdf->Output(views_root . 'compras/requisiciones/' . $r['folio'] . '.pdf');
        if($mostrar){
          $pdf->output($r['folio'].'.pdf', 'I');
        }
    }
    
        public static function crearPdfOrdenCompra($r, $oc, $doc, $cli, $mostrar = false){   
        $empresa = empresas[intval($r['empresa'])];
        $moneda = monedas [intval($r['moneda'])];
        require_once utils_root .'num2String/num2String.php';
        $totalLetra = Num2String::moneyToString(Utils::quitarComas($oc->total), $moneda);
        $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter','tempDir' => '/tmp']);
        ob_start();
        require_once views_root.'compras/formato_orden_imprimir.php';
        $html = ob_get_clean();

        ob_end_clean();
        $pdf->writeHTML($html);
        if (!is_dir(views_root . 'compras/ordenesCompra')) {
            mkdir(views_root . 'compras/ordenesCompra', 0777, true);
        }
        if (file_exists(views_root . 'compras/ordenesCompra/' . $oc->folio . '.pdf')) {
            unlink(views_root . 'compras/ordenesCompra/' . $oc->folio . '.pdf');
        }
        $pdf->Output(views_root . 'compras/ordenesCompra/' . $oc->folio . '.pdf');
        if($mostrar){
        $pdf->output($oc->folio.'.pdf', 'I');
        }
    }
    
        public static function crearPdfEvaluacionProveedor($prov, $eval, $fechaInicio, $fechaFinal, $doc){   

           $pregunta1 = 0;
           $pregunta2 = 0;
           $pregunta3 = 0;
           $pregunta4 = 0;
           $evaluaciones = count($eval);
           foreach ($eval as $e){
           $arrayEval = json_decode($e->evaluacion);
       
           $pregunta1 += ($arrayEval->pregunta1);
           $pregunta2 += ($arrayEval->pregunta2);
           $pregunta3 += ($arrayEval->pregunta3);
           $pregunta4 += ($arrayEval->pregunta4);
           }
           
           $prom1 = round($pregunta1/$evaluaciones);
           $prom2 = round($pregunta2/$evaluaciones);
           $prom3 = round($pregunta3/$evaluaciones);
           $prom4 = round($pregunta4/$evaluaciones);
           
           $suma = $prom1 + $prom2 +$prom3 + $prom4;
           
           $promedio = $suma/4;
           $calificacion = $promedio * 20;
   
        $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter','tempDir' => '/tmp']);
        ob_start();
        require_once views_root.'catalogos/formato_eval_prov_transporte_imprimir.php';
        $html = ob_get_clean();
        ob_end_clean();
        $pdf->writeHTML($html);

        $pdf->output();
    }
    
        public static function crearPdfSolictudServicio($s, $doc){   
        $empresa = empresas[intval($s['empresa'])];
        
        
        $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L','tempDir' => '/tmp']);
        ob_start();
        require_once views_root.'sistemas/formato_solicitud_servicio_imprimir.php';

        $html = ob_get_clean();

        ob_end_clean();
        $pdf->writeHTML($html);
        $pdf->output($s['folio'].'.pdf', 'I');
        }
        
     public static function crearPdfServicio($s, $mostrar = false){   
        $empresa = empresas[intval(1)];
  
        $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L','tempDir' => '/tmp']);
        ob_start();
        require_once views_root.'servicios/formato_servicio.php';

        $html = ob_get_clean();

        ob_end_clean();
        $pdf->writeHTML($html);
        
        if($mostrar){
          $pdf->output($s->folio.'.pdf', 'I');
        }
    }
}
